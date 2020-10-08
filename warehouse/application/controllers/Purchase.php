<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('purchase_model');
		$this->load->model('customer_model');
		$this->load->model('receipt_model');
		$this->load->model('sales_model');
		$this->load->model('assign_warehouse_model');
		$this->load->model('purchase_return_model');
		$this->load->model('supplier_model');
		$this->load->model('log_model');
		$this->load->model('company_setting_model');
		$this->load->model('payment_method_model');

		if ( ! $this->session->userdata('loggedin'))
        {
            redirect('auth/login');
        }
	}

	public function index(){
		// get all purchase record and display list
		$data['data'] = $this->purchase_model->getPurchase();
		$this->load->view('purchase/list',$data);
	}
	/*
		call add purchase view to add purchase
	*/
	public function add(){
		$data['company'] = $this->purchase_model->getCompany();
		$data['product'] = $this->purchase_model->getProduct();
		// $this->purchase_model->checkPurchaserForPrimaryWarehouse();
		if($this->purchase_model->checkPurchaserForPrimaryWarehouse()){
			$data['warehouse'] = $this->purchase_model->getPurchaserWarehouse();
		}else{
			$this->session->set_flashdata('no_purchaser', 'Kindly create purchaser for primary warhouse');
			redirect('purchase','refresh');
		}

		if($this->purchase_model->getPurchaserWarehouse() != null){
			$data['warehouse'] = $this->purchase_model->getPurchaserWarehouse();
		}else{
			$this->session->set_flashdata('no_purchaser', 'Purchaser is not created yet. Kindly create the Purchaser');
			redirect('purchase','refresh');
		}
		$data['warehouse'] = $this->purchase_model->getPurchaserWarehouse();
		$data['biller'] = $this->sales_model->getBiller();
		$data['supplier'] = $this->purchase_model->getSupplier();
		$data['discount'] = $this->purchase_model->getDiscount();
		$data['reference_no'] = $this->purchase_model->createReferenceNo();
		$data['user'] = $this->assign_warehouse_model->getUser();
		$data['no_of_purchaser'] = $this->purchase_model->getPurchaserCount();
		$data['no_of_purchaser_assignment'] = $this->purchase_model->getPurchaserAssignmentCount();


		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('purchase/add',$data);

	}
	/*
		this function is used when product add in purchase table
	*/
	public function getProductAjax($id){
		$data = $this->purchase_model->getProductAjax($id);
		$data['discount'] = $this->purchase_model->getDiscount();
		$data['tax'] = $this->purchase_model->getTax();
	    echo json_encode($data);
		//print_r($data);
	}
	/*
		This function is used to search product code / name in database
	*/
	public function getAutoCodeName($code,$search_option){
          //$code = strtolower($code);
		  $p_code = $this->input->post('p_code');
		  $p_search_option = $this->input->post('p_search_option');
          $data = $this->purchase_model->getProductCodeName($p_code,$p_search_option);
          if($search_option=="Code"){
          	$list = "<ul class='auto-product'>";
          	foreach ($data as $val){
          		$list .= "<li value=".$val->code.">".$val->code."</li>";
          	}
          	$list .= "</ul>";
          }
          else{
          	$list = "<ul class='auto-product'>";
          	foreach ($data as $val){
          		$list .= "<li value=".$val->piece_id.">".$val->name."</li>";
          	}
          	$list .= "</ul>";
          }

          echo $list;
          //echo json_encode($data);
          //print_r($list);
	}
	/*
		This function is used to add purchase in database
	*/
	public function addPurchase(){

		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		if($this->form_validation->run()==false){

			$this->add();
		}
		else
		{
			$pay = $this->input->post('pay');
			$warehouse_id = $this->input->post('warehouse');
			$data = array(
						"date" 				   => 	$this->input->post('date'),
						"reference_no"		   =>	$this->input->post('reference_no'),
						"supplier_id" 		   =>	$this->input->post('supplier'),
						"warehouse_id"		   => 	$warehouse_id,
						"biller_id"		   	   => 	$this->input->post('biller'),
						"rack_no" 			   =>	$this->input->post('rack_no'),
						"total" 			   =>	$this->input->post('grand_total'),
						"tax_value" 		   =>  	$this->input->post('total_tax'),
						"note" 				   => 	$this->input->post('note'),
						"supplier_ref"         =>  	$this->input->post('supplier_ref'),
						"buyer_order"          =>  	$this->input->post('buyer_order'),
						"dispatch_document_no" =>  	$this->input->post('dispatch_document_no'),
						"delivery_note_date"   =>  	$this->input->post('delivery_note_date'),
						"dispatch_through"     =>  	$this->input->post('dispatch_through'),
						"user"			       =>  	$this->session->userdata('user_id')
					);

			$invoice = array(
				"invoice_no" => $this->purchase_model->generateInvoiceNo(),
				"receipt_amount" => $this->input->post('grand_total'),
				"receipt_voucher_date" => date('Y-m-d'),
				"branch_id" => $this->purchase_model->getBranchIdOfWarehouse($warehouse_id)
			);

			//echo $warehouse_id;

			// echo '<pre>';
			// print_r($data);
			// print_r($invoice);
			// exit;
			if($purchase_id = $this->purchase_model->addModel($data,$invoice)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $purchase_id,
						'message'  => 'Purchase Inserted'
					);
				$this->log_model->insert_log($log_data);
				$purchase_item_data = $this->input->post('table_data');
				$js_data = json_decode($purchase_item_data);
				$sizeof_purchase_item = sizeof($js_data);

				$purchase_item = 0 ;

				foreach ($js_data as $key => $value) {

					if($value==null){
					}
					else{
						$piece_id = $value->piece_id;
						$quantity = $value->quantity;
						$data = array(
							"piece_id" => $value->piece_id,
							"quantity" => $value->quantity,
							"gross_total" => $value->total,
							"cost" => $value->cost,
							"purchase_id" => $purchase_id
							);
						$warehouse_data = array(
							"piece_id" => $value->piece_id,
							"warehouse_id" => $warehouse_id,
							"quantity" => $value->quantity
							);

						/*echo '<pre>';
						print_r($data);*/
						$this->purchase_model->addProductInWarehouse($piece_id,$quantity,$warehouse_id,$warehouse_data);
						if($this->purchase_model->addPurchaseItem($data)){
							$purchase_item++;
						}
					}
				}
				if($purchase_item == sizeof($js_data))
				{
					if ($pay != 'pay')
					{

						redirect('purchase/view/'.$purchase_id);
					}
					else
					{
						redirect('purchase/payment/'.$purchase_id);
					}
				}
			}
			redirect('purchase');
		}
	}
	/*
		This function is used to call view  edit purchase
	*/
	public function edit($id){
		//$data['biller'] = $this->sales_model->getBiller();
		$data['company'] = $this->purchase_model->getCompany();
		$data['product'] = $this->purchase_model->getProduct();
		$data['warehouse'] = $this->purchase_model->getPurchaserWarehouse();
		$data['supplier'] = $this->purchase_model->getSupplier();
		$data['data'] = $this->purchase_model->getRecord($id);
		$data['user'] = $this->assign_warehouse_model->getUser();
		$data['tax'] = $this->purchase_model->getTax();
/*		echo "<pre>";
		print_r($data['data']);
		exit();*/
		foreach ($data['data'] as $key) {
			$purchase_id = $key->purchase_id;
			$warehouse_id = $key->warehouse_id;
		}
		$warehouse_id;

		$data['items'] = $this->purchase_model->getPurchaseItems($purchase_id,$warehouse_id);
		$data['warehouse_details'] = $this->purchase_model->getWarehouesDetails($warehouse_id);

		// echo "<pre>";
		// print_r($data);
		// exit();
		$this->load->view('purchase/edit',$data);
	}
	/*
		This function is used to delete discount record in databse
	*/
	public function delete($id){
		if($this->purchase_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Purchase Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('purchase','refresh');
		}
		else{
			redirect('purchase','refresh');
		}
	}
	/*
		This function is to edit purchase record in database
	*/
	public function editPurchase(){
		$id = $this->input->post('purchase_id');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		if($this->form_validation->run()==false){

			$this->edit($id);
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			$data = array(
						"date" 				  =>  $this->input->post('date'),
						"reference_no" 		  =>  $this->input->post('reference_no'),
						"supplier_id" 		  =>  $this->input->post('supplier'),
						"warehouse_id" 		  =>  $this->input->post('warehouse'),
						"rack_no" 			  =>  $this->input->post('rack_no'),
						"total"				  =>  $this->input->post('grand_total'),
						"tax_value" 		  =>  $this->input->post('total_tax'),
						"note" 				  =>  $this->input->post('note'),
						"supplier_ref"        =>  $this->input->post('supplier_ref'),
						"buyer_order"         =>  $this->input->post('buyer_order'),
						"dispatch_document_no"=>  $this->input->post('dispatch_document_no'),
						"delivery_note_date"  =>  $this->input->post('delivery_note_date'),
						"dispatch_through"    =>  $this->input->post('dispatch_through')
					);

			$js_data = json_decode($this->input->post('table_data1'));
			$php_data = json_decode($this->input->post('table_data'));
			// echo '<pre>';
			// echo 'js data';
			// print_r($js_data);
			// echo 'php data';
			// print_r($php_data);
			// exit;
			if($this->purchase_model->editModel($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Purchase Updated'
					);
				$this->log_model->insert_log($log_data);
				// echo '<pre>';
				// print_r($js_data);
				// exit;
				if($js_data!=null){
					foreach ($js_data as $key => $value) {

						if($value=='delete'){
							// echo " delete".$key;

							$piece_id =  $php_data[$key];
							// echo $piece_id;
							// exit;
							if($this->purchase_model->deletePurchaseItems($id,$piece_id,$warehouse_id)){
								//echo " 1.Dsuccess";
							}
						}
						else if($value==null){
							//echo " Null".$key;
						}else{
							//echo " array";
							$piece_id = $value->piece_id;
							$quantity = $value->quantity;
							if(isset($value->tax_type)){
								$tax_type = $value->tax_type;
							}else{
								$tax_type = '';
							}
							$data = array(
									"piece_id" => $value->piece_id,
									"quantity" => $value->quantity,
									"gross_total" => $value->total,
									"cost" => $value->cost,
									"purchase_id" => $id
								);
							// echo '<pre>';
							// print_r($data);
							// exit;
							$warehouse_data = array(
								"piece_id" => $value->piece_id,
								"warehouse_id" => $warehouse_id,
								"quantity" => $value->quantity
								);

							if($this->purchase_model->addUpdatePurchaseItem($id,$piece_id,$warehouse_id,$quantity,$warehouse_data,$data)){
								//echo " 1 Asuccess add";
							}
							else{

							}
						}
					}
					// exit;

				}
				redirect('purchase/view/'.$id);
			}
		}
	}
	/*
		view purchase details
	*/
	public function view($id){
		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();

		// echo '<pre>';
		// print_r($data);
		// exit;

		$this->load->view('purchase/view',$data);
	}
	/*
		generate pdf
	*/
	public function pdf($id){

		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();

		// echo '<pre>';
		// print_r($data);
		// exit;
		$html = $this->load->view('purchase/pdf',$data,true);

		include(APPPATH.'third_party/mpdf60/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['data'][0]->reference_no.'pdf','I');
	}

	public function save_pdf($id){

		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();

		// echo '<pre>';
		// print_r($data);
		// exit;
		$html = $this->load->view('purchase/pdf',$data,true);

		include(APPPATH.'third_party/mpdf60/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output(realpath(dirname(dirname(__DIR__)) . '/assets/uploads')."/".$data['data'][0]->reference_no.'.pdf','F');

	}
	/*
		send email
	*/
	public function email($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => 0,
				'message'  => 'Purchase Receipt Email Send'
			);
		$this->log_model->insert_log($log_data);
		$data = $this->purchase_model->getSupplierEmail($id);
		$company = $this->purchase_model->getCompany();
		$email = $this->purchase_model->getSmtpSetup();
		$this->load->view('class.phpmailer.php');
		$this->save_pdf($id);
		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->Host = $email->smtp_host;

		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Port = $email->smtp_port;
		$mail->Username = $email->smtp_username;
		$mail->Password = $email->smtp_password;

		$mail->From = $email->from_address;
		$mail->FromName = $email->from_name;
		$mail->AddAddress($data[0]->email);
		//$mail->AddReplyTo("mail@mail.com");

		$mail->IsHTML(true);

		$mail->Subject = "Purchase order No : ".$data[0]->reference_no." From ".$company[0]->name;
		$mail->Body = "Date : ".$data[0]->date."<br>Total : ".$data[0]->total;
		$mail->AddAttachment(realpath(dirname(dirname(__DIR__)) . '/assets/uploads')."/".$data[0]->reference_no.'.pdf');

		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

		if(!$mail->Send())
		{
			$message =  "Email could not be sent";
		}
		else{
			$message =  "Email has been sent";
		}
		$this->session->set_flashdata('message', $message);
		redirect('purchase','refresh');
	}
	/*
		view payment
	*/
	/*public function payment($id){
		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$data['ledger'] = $this->purchase_model->getLedger();
		$data['p_reference_no'] = $this->purchase_model->generateReferenceNo();
		$this->load->view('purchase/payment',$data);
	}*/
	/*
		add payment
	*/
	public function paymentAdd($id){
		$data['data'] = $this->purchase_model->getDetails($id);
		$data['items'] = $this->purchase_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		$data['payment_method'] = $this->payment_method_model->payUserData();
		$data['p_reference_no'] = $this->purchase_model->generateReferenceNo();
		$this->load->view('purchase/payment/add',$data);
	}
	/*
		get Discount value for AJAX
	*/
	public function getDiscountValue($id){
		$data = $this->purchase_model->getDiscountValue($id);
		echo json_encode($data);
	}
	/*
		get Tax value for AJAX
	*/
	public function getTaxValue($id){
		$data = $this->purchase_model->getTaxValue($id);
		echo json_encode($data);
	}
	/*
		get payment details to view and send to model
	*/
	public function addPayment(){
		$id = $this->input->post('id');
		$paying_by = $this->input->post('paying_by');
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('paying_by','Paying By','trim|required');
		if($paying_by == "Cheque"){
			$this->form_validation->set_rules('bank_name','Bank Name','trim|required');
			$this->form_validation->set_rules('cheque_no','Cheque No','trim|required|numeric');
		}
		if($this->form_validation->run()==false){
			$this->payment($id);
		}
		else
		{
			if($paying_by == "Cheque"){
				$bank_name = $this->input->post('bank_name');
				$cheque_no = $this->input->post('cheque_no');
			}
			else{
				$bank_name = "";
				$cheque_no = "";
			}
			$data = array(
					"purchase_id"     => $id,
					"payment_voucher_date"         => $this->input->post('date'),
					"invoice_no" => $this->input->post('reference_no'),
					"payment_ledger" => $this->input->post('ledger'),
					"payment_amount"       => $this->input->post('amount'),
					"mode_of_payment"    => $this->input->post('paying_by'),
					"bank_name"    => $bank_name,
					"cheque_no"    => $cheque_no,
					"description"  => $this->input->post('note')
				);

			if($this->purchase_model->addPayment($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Purchase Payable'
					);
				$this->log_model->insert_log($log_data);
				redirect('purchase','refresh');
			}
			else{
				redirect("purchase",'refresh');
			}
		}
	}
	/*
		return barcode product
	*/
	public function getBarcodepieces($term){
		$data = $this->purchase_model->getBarcodepieces($term);
		echo json_encode($data);
	}
	public function getNameProducts($term){
		$data = $this->purchase_model->getNameProducts($term);
		echo json_encode($data);
	}
	/*
		return product details
	*/
	public function getPiecesUseCode($piece_id){
		$data = $this->purchase_model->getProductUseCode($piece_id);
		$data['discount'] = $this->purchase_model->getDiscount();
		// echo '<pre>';
		// print_r($data);
		echo json_encode($data);
	}
	/*
		payment	 view
	*/
	public function payment($id){
		$data['data'] = $this->purchase_model->getDetails($id);
		$data['to_ledger'] = $this->purchase_model->getToLedger($data['data'][0]->supplier_id);
		$data['from_ledger'] = $this->purchase_model->getLedger();
		$data['company'] = $this->purchase_model->getCompany();
		$data['p_reference_no'] = $this->receipt_model->generateReferenceNo();
		$data['payment_method'] = $this->payment_method_model->payUserData();



		$this->load->view('purchase/payment',$data);
	}
	/*
		return customer details
	*/
	public function getSuppliersData($id){
		$data['data'] = $this->supplier_model->getSuppliersData($id);
		$data['company'] = $this->purchase_model->getCompany();
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data']->country_id);
		$data['city'] = $this->customer_model->getCity($data['data']->state_id);
		echo json_encode($data);
	}
	/*
		return customer details
	*/
	public function getSupplierData($id){
		$data['data'] = $this->purchase_model->getSupplierData($id);
		$data['company_setting'] = $this->company_setting_model->getData();
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data']->country_id);
		$data['city'] = $this->customer_model->getCity($data['data']->state_id);
		echo json_encode($data);
	}
	/*
		return biller details
	*/
	public function getBillerState($id){
		$data['state'] =  $this->purchase_return_model->getBillerState($id);
		$data['warehouse'] =  $this->purchase_model->getBillerWarehouse($id);
		echo json_encode($data);
	}

	/*
		return warehouse address details
	*/
	public function getWarehouseState($id){

		$data['warehouse_address'] = $this->purchase_return_model->getWarehouseAddress($id);
		$data['billing_address'] =  $this->company_setting_model->getCompanyAddress();
		$data['countries'] =  $this->customer_model->getCountry();
		$data['states'] =  $this->customer_model->getState($data['warehouse_address'][0]->warehouse_country_id);
		$data['cities'] = $this->customer_model->getCity($data['warehouse_address'][0]->warehouse_state_id);

		// echo '<pre>';
		// print_r($data);
		echo json_encode($data);
	}
	/*
		return biller details
	*/
	public function getSupplierState($id){
		// echo '<pre>';
		// echo $this->purchase_model->getSupplierState($id);
		// exit;
		echo $this->purchase_model->getSupplierState($id);
	}
}
?>
