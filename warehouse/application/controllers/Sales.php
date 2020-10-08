<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('sales_model');
		$this->load->model('customer_model');
		$this->load->model('purchase_model');
		$this->load->model('biller_model');
		$this->load->model('receipt_model');
		$this->load->model('credit_debit_note_model');
		$this->load->model('log_model');
		$this->load->model('ion_auth_model');
		$this->load->model('sms_setting_model');
		$this->load->model('payment_method_model');
		$this->load->helper('sms_helper');
		$this->load->dbforge();
	}
	public function index(){
		// get all sales to display list
		$data['data'] = $this->sales_model->getSales();
		$data['billers'] = $this->biller_model->getBillers();

		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('sales/list',$data);
	} 
	/* 
		call add view to add sales record 
	*/
	public function add(){

		if($this->sales_model->checkBillerForPrimaryWarehouse()){
			$data['warehouse'] = $this->sales_model->getSalesWarehouse();	
		}else{
			$this->session->set_flashdata('no_sales_person', 'Kindly create Saler Person / Biller  for primary warhouse');
			redirect('sales','refresh');
		}


		if($this->sales_model->getSalesWarehouse() != null){
			$data['warehouse'] = $this->sales_model->getWarehouse();
		}else{
			$this->session->set_flashdata('no_sales_person', 'Sales Person or Biller is not created yet. Kindly create the Sales Person');
			redirect('sales','refresh');
		}
		
		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
		//$data['biller'] =  $this->biller_model->getBillerDetails($data['user']->id);

		if($data['user_group'][0]->name =="sales_person"){
			//$data['biller'] =  $this->biller_model->getBillerDetails($data['user']->id);
			$data['warehouse_products'] = $this->sales_model->getWarehouseProductsFromWarehouse($data['warehouse'][0]->warehouse_id); 			
		}else{
			$data['warehouse_products'] = $this->sales_model->getWarehouseProducts(); 			
		}

		$data['warehouse_products'] = $this->sales_model->getWarehouseProducts(); 
		$data['biller'] = $this->sales_model->getBiller();
		$data['customer'] = $this->sales_model->getCustomer(); 
		$data['discount'] = $this->sales_model->getDiscount();
		$data['reference_no'] = $this->sales_model->createReferenceNo();
		
		// echo '<pre>';	
		// // echo $data['user_group'][0]->name."<br/>";
		// print_r($data);
		// exit;

		$this->load->view('sales/add',$data);
	}
	/* 
		this function is used to get discount data when discount is change 
	*/
	public function getDiscountAjax($id){
		$data = $this->sales_model->getDiscountAjax($id);
		echo json_encode($data);
	}
	/* get all product warehouse wise */
	public function getProducts($warehouse_id){
		$data = $this->sales_model->getProducts($warehouse_id);
	    echo json_encode($data);
	}
	/* get single product */
	public function getProduct($product_id,$warehouse_id){
		$data = $this->sales_model->getProduct($product_id,$warehouse_id);
		$data['discount'] = $this->sales_model->getDiscount();
		$data['tax'] = $this->sales_model->getTax();
	    echo json_encode($data);
		//print_r($data);
	}

	/*
		get biller and warehouse details from warehouse
	*/

	public function getBillerWarehouseDetails($user_id){
		return $this->sales_model->getBillerWarehouseDetails($user_id);
	}


	/*
		get biller and warehouse details from warehouse using ajax
	*/

	public function getBillerWarehouseDetailsAjax($user_id){
		// echo '<pre>';
		// print_r($this->sales_model->getBillerWarehouseDetails($user_id));
		// exit;
		echo json_encode($this->sales_model->getBillerWarehouseDetails($user_id));
	}

	/* 
		this function is used to search product name / code in auto complite 
	*/
	public function getAutoCodeName($code,$search_option,$warehouse){
          //$code = strtolower($code);
		  $p_code = $this->input->post('p_code');
		  $p_search_option = $this->input->post('p_search_option');
          $data = $this->sales_model->getProductCodeName($p_code,$p_search_option,$warehouse);
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
          		$list .= "<li value=".$val->product_id.">".$val->name."</li>";
          	}
          	$list .= "</ul>";
          }
          
          echo $list;
          //echo json_encode($data);
          //print_r($data);
	}
	/* 
		this fucntion is used to add sales record in database 
	*/
	public function addSales(){
		
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		//$this->form_validation->set_rules('discount_id','Discount ID','trim|required');
		//$this->form_validation->set_rules('biller_id','Biller ID','trim|required');
		if($this->form_validation->run()==false){

			$this->add();
		}
		else
		{
			if(!$this->sales_model->isFieldExist("shipping_postal_code")){
				$this->db->query('ALTER TABLE `sales` ADD `shipping_postal_code` VARCHAR(20) NULL AFTER `shipping_address`');
			}

			if(!$this->sales_model->isFieldExist("trans_mode")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_mode` VARCHAR(20) NULL AFTER `shipping_address`');
			}

			if(!$this->sales_model->isFieldExist("trans_distance")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_distance` VARCHAR(20) NULL AFTER `trans_mode`');
			}

			if(!$this->sales_model->isFieldExist("transporter_name")){
				$this->db->query('ALTER TABLE `sales` ADD `transporter_name` VARCHAR(20) NULL AFTER `trans_mode`');
			}
			if(!$this->sales_model->isFieldExist("transporter_id")){
				$this->db->query('ALTER TABLE `sales` ADD `transporter_id` VARCHAR(20) NULL AFTER `transporter_name`');
			}
			if(!$this->sales_model->isFieldExist("trans_doc_no")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_doc_no` VARCHAR(20) NULL AFTER `transporter_id`');
			}
			if(!$this->sales_model->isFieldExist("trans_doc_date")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_doc_date` DATE NULL AFTER `trans_doc_no`');
			}
			if(!$this->sales_model->isFieldExist("vehicle_no")){
				$this->db->query('ALTER TABLE `sales` ADD `vehicle_no` VARCHAR(20) NULL AFTER `trans_doc_date`');
			}
			if(!$this->sales_model->isFieldExist("vehicle_type")){
				$this->db->query('ALTER TABLE `sales` ADD `vehicle_type` VARCHAR(20) NULL AFTER `vehicle_no`');
			}
			if(!$this->sales_model->isFieldExist("supply_type")){
				$this->db->query('ALTER TABLE `sales` ADD `supply_type` VARCHAR(20) NULL AFTER `vehicle_type`');
			}
			if(!$this->sales_model->isFieldExist("sub_supply_type")){
				$this->db->query('ALTER TABLE `sales` ADD `sub_supply_type` VARCHAR(20) NULL AFTER `supply_type`');
			}
			
			$customer_id = $this->input->post('customer');

			$company_name = $this->db->get('company_settings')->row()->name;
			$sms_setting = $this->sms_setting_model->getSmsSetting();

			$customer = $this->customer_model->getRecord($customer_id);
			$mobile = $customer[0]->mobile;
			$customer_name = $customer[0]->customer_name;			

			$pay = $this->input->post('pay');
			$warehouse_id = $this->input->post('warehouse');

			if($this->input->post('shipping_charge') ==""){
				$shipping_charge = 0;
			}else{
				$shipping_charge = $this->input->post('shipping_charge');
			}

			if($this->input->post('shipping_bill_date') ==""){
				$shipping_bill_date = null;
			}else{
				$shipping_bill_date = $this->input->post('shipping_bill_date');
			
			}

			if($this->input->post('discount') == ""){
				$flat_discount = 0.00;
			}else{
				$flat_discount = $this->input->post('discount');
			
			}

			 			
			$data = array(
						"date" 				  =>  $this->input->post('date'),
						"reference_no" 		  =>  $this->input->post('reference_no'),
						"warehouse_id" 		  =>  $this->input->post('warehouse'),
						"customer_id" 		  =>  $customer_id,
						"biller_id" 		  =>  $this->input->post('biller'),
						"total" 			  =>  $this->input->post('grand_total')-$this->input->post('discount')+$this->input->post('shipping_charge'),
						"flat_discount" 	  =>  $flat_discount,
						"discount_value"	  =>  $this->input->post('total_discount'),
						"tax_value" 		  =>  $this->input->post('total_tax'),
						"note" 				  =>  $this->input->post('note'),
						"shipping_city_id"    =>  $this->input->post('city'),
						"shipping_state_id"   =>  $this->input->post('state'),
						"shipping_country_id" =>  $this->input->post('country'),
						"shipping_address"    =>  $this->input->post('address'),
						"shipping_postal_code"=>  $this->input->post('postal_code'),
						"shipping_charge"     =>  $shipping_charge,
						"internal_note"       =>  $this->input->post('internal_note'),
						"gst_payable"         =>  $this->input->post('gst_payable'),
						"sales_invoice"       =>  $this->input->post('sales_invoice'),
						"sales_type"          =>  $this->input->post('sales_type'),
						"port_code"           =>  $this->input->post('port_code'),
						"shipping_bill_no"    =>  $this->input->post('shipping_bill_no'),
						"shipping_bill_date"  =>  $shipping_bill_date,
						"supplier_ref"        =>  $this->input->post('supplier_ref'),
						"buyer_order"         =>  $this->input->post('buyer_order'),
						"dispatch_document_no"=>  $this->input->post('dispatch_document_no'),
						"delivery_note_date"  =>  $this->input->post('delivery_note_date'),
						"dispatch_through"    =>  $this->input->post('dispatch_through'),
						"supply_type"         =>  $this->input->post('supply_type'),
						"sub_supply_type"     =>  $this->input->post('sub_supply_type'),
						"trans_mode"       	  =>  $this->input->post('trans_mode'),
						"transporter_name"    =>  $this->input->post('transporter_name'),
						"transporter_id"	  =>  $this->input->post('transporter_id'),
						"trans_doc_no"        =>  $this->input->post('trans_doc_no'),
						"trans_doc_date"      =>  $this->input->post('trans_doc_date'),
						"vehicle_no"          =>  $this->input->post('vehicle_no'),
						"vehicle_type"        =>  $this->input->post('vehicle_type'),						
						"user"			      =>  $this->session->userdata('user_id')
					);

			// echo '<pre>';
			// print_r($data);
			// exit;

			$sales_total = $this->input->post('grand_total')-$this->input->post('discount')+$this->input->post('shipping_charge');
			
			$invoice = array(
				"invoice_no" => $this->sales_model->generateInvoiceNo(),
				"sales_amount" => $sales_total,
				"invoice_date" => date('Y-m-d')
			);
			// echo 'invoce no :<br/>';
			// print_r($invoice);


			if($sales_id = $this->sales_model->addModel($data,$invoice)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $sales_id,
						'message'  => 'Sales Inserted'
					);
				$this->log_model->insert_log($log_data);
				$sales_item_data = $this->input->post('table_data');
				$js_data = json_decode($sales_item_data);
				foreach ($js_data as $key => $value) {
					if($value==null){
					}
					else{

						if(isset($value->tax_type)){
							$tax_type = $value->tax_type;
						}else{
							$tax_type = "";
						}

						$product_id = $value->product_id;
						$quantity = $value->quantity;	
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"price" => $value->price,
							"gross_total" => $value->total,
							"discount_id" => $value->discount_id,
							"discount_value" => $value->discount_value,
							"discount" => $value->discount,
							"igst" => $value->igst,
							"igst_tax" => $value->igst_tax,
							"cgst" => $value->cgst,
							"cgst_tax" => $value->cgst_tax,
							"sgst" => $value->sgst,
							"sgst_tax" => $value->sgst_tax,
							"sales_id" => $sales_id,
							"tax_type" => $tax_type
							);
						if($this->sales_model->addSalesItem($data,$product_id,$warehouse_id,$quantity)){
							
						}
						else{

						}
					}
				}

				$message = "Dear ".$customer_name.", Invoice no is genrated worth amount of ".$sales_total.", ".$company_name;
				$response = send_sms($sms_setting, $mobile, $message);

				$sms_history_data = array(
								'mobile' => $mobile,
								'message' => $message,
								'response' => $response	
							);
				$this->sms_setting_model->addSmsHistroy($sms_history_data);


				if ($pay != 'pay') 
				{					
					redirect('sales/view/'.$sales_id);
				}
				else
				{
					redirect('sales/receipt/'.$sales_id);
				}	
			}
			else{
				redirect('sales','refresh');
			}
		}
	}
	
	/* 
		call edit view to edit sales record 
	*/
	public function edit($id){
		$data['data'] = $this->sales_model->getRecord($id);
		if($data['data'] == null){
			redirect('sales','refresh');			
		}
		$data['warehouse'] =  $this->sales_model->getSalesWarehouse();
		$data['biller'] = $this->sales_model->getBiller();
		$data['customer'] = $this->sales_model->getCustomer(); 
		$data['discount'] = $this->sales_model->getDiscount();
		$data['tax'] = $this->sales_model->getTax();
		
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data'][0]->shipping_country_id);
		$data['city'] = $this->customer_model->getCity($data['data'][0]->shipping_state_id);
		$data['product'] = $this->sales_model->getProducts($data['data'][0]->warehouse_id);
		$data['items'] = $this->sales_model->getSalesItems($data['data'][0]->sales_id,$data['data'][0]->warehouse_id);
		$data['biller_id'] = $data['data'][0]->biller_id;
		$data['biller_state_id'] = $this->sales_model->getBillerStateIdFromBiller($data['data'][0]->biller_id);
		$data['customer_data'] = $this->customer_model->getCustomerData($id);
		$data['shipping_state_id'] =  $data['data'][0]->shipping_state_id;
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('sales/edit',$data);
	}
	/*  
		this fucntion is to edit sales record and save in database 
	*/
	public function editSales(){
		$id = $this->input->post('sales_id');
		$this->form_validation->set_rules('date','Date','trim|required');
		//$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		//$this->form_validation->set_rules('discount_id','Discount ID','trim|required');
		//$this->form_validation->set_rules('biller_id','Biller ID','trim|required');
		if($this->form_validation->run()==false){

			$this->edit($id);
		}
		else
		{

			if(!$this->sales_model->isFieldExist("shipping_postal_code")){
				$this->db->query('ALTER TABLE `sales` ADD `shipping_postal_code` VARCHAR(20) NULL AFTER `shipping_address`');
			}

			if(!$this->sales_model->isFieldExist("trans_mode")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_mode` VARCHAR(20) NULL AFTER `shipping_address`');
			}

			if(!$this->sales_model->isFieldExist("trans_distance")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_distance` VARCHAR(20) NULL AFTER `trans_mode`');
			}

			if(!$this->sales_model->isFieldExist("transporter_name")){
				$this->db->query('ALTER TABLE `sales` ADD `transporter_name` VARCHAR(20) NULL AFTER `trans_mode`');
			}
			if(!$this->sales_model->isFieldExist("transporter_id")){
				$this->db->query('ALTER TABLE `sales` ADD `transporter_id` VARCHAR(20) NULL AFTER `transporter_name`');
			}
			if(!$this->sales_model->isFieldExist("trans_doc_no")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_doc_no` VARCHAR(20) NULL AFTER `transporter_id`');
			}
			if(!$this->sales_model->isFieldExist("trans_doc_date")){
				$this->db->query('ALTER TABLE `sales` ADD `trans_doc_date` DATE NULL AFTER `trans_doc_no`');
			}
			if(!$this->sales_model->isFieldExist("vehicle_no")){
				$this->db->query('ALTER TABLE `sales` ADD `vehicle_no` VARCHAR(20) NULL AFTER `trans_doc_date`');
			}
			if(!$this->sales_model->isFieldExist("vehicle_type")){
				$this->db->query('ALTER TABLE `sales` ADD `vehicle_type` VARCHAR(20) NULL AFTER `vehicle_no`');
			}
			if(!$this->sales_model->isFieldExist("supply_type")){
				$this->db->query('ALTER TABLE `sales` ADD `supply_type` VARCHAR(20) NULL AFTER `vehicle_type`');
			}
			if(!$this->sales_model->isFieldExist("sub_supply_type")){
				$this->db->query('ALTER TABLE `sales` ADD `sub_supply_type` VARCHAR(20) NULL AFTER `supply_type`');
			}
			
			$warehouse_id = $this->input->post('warehouse');
			$old_warehouse_id = $this->input->post('old_warehouse_id');
			$warehouse_change = $this->input->post('warehouse_change');

			if($this->input->post('shipping_bill_date') == ""){
				$shipping_bill_date = null;
			}else{
				$shipping_bill_date = $this->input->post('shipping_bill_date');
			}

			
			$data = array(
						"date" 			      =>  $this->input->post('date'),
						/*"reference_no" 	      =>  $this->input->post('reference_no'),*/
						"warehouse_id"	      =>  $this->input->post('warehouse'),
						"customer_id" 	      =>  $this->input->post('customer'),
						"biller_id" 	      =>  $this->input->post('biller'),
						"total" 			  =>  $this->input->post('grand_total')-$this->input->post('discount')+$this->input->post('shipping_charge'),
						"flat_discount" 	  =>  $this->input->post('discount'),
						"discount_value"      =>  $this->input->post('total_discount'),
						"tax_value" 	      =>  $this->input->post('total_tax'),
						"note" 			      =>  $this->input->post('note'),
						"shipping_city_id"    =>  $this->input->post('city'),
						"shipping_state_id"   =>  $this->input->post('state'),
						"shipping_country_id" =>  $this->input->post('country'),
						"shipping_address"    =>  $this->input->post('address'),
						"shipping_postal_code"=>  $this->input->post('postal_code'),
						"shipping_charge"     =>  $this->input->post('shipping_charge'),
						"internal_note"       =>  $this->input->post('internal_note'),
						"gst_payable"         =>  $this->input->post('gst_payable'),
						"sales_invoice"       =>  $this->input->post('sales_invoice'),
						"sales_type"          =>  $this->input->post('sales_type'),
						"port_code"           =>  $this->input->post('port_code'),
						"shipping_bill_no"    =>  $this->input->post('shipping_bill_no'),
						"shipping_bill_date"  =>  $shipping_bill_date,
						"supplier_ref"        =>  $this->input->post('supplier_ref'),
						"buyer_order"         =>  $this->input->post('buyer_order'),
						"dispatch_document_no"=>  $this->input->post('dispatch_document_no'),
						"delivery_note_date"  =>  $this->input->post('delivery_note_date'),						
						"dispatch_through"    =>  $this->input->post('dispatch_through'),
						"supply_type"         =>  $this->input->post('supply_type'),
						"sub_supply_type"     =>  $this->input->post('sub_supply_type'),
						"trans_mode"       	  =>  $this->input->post('trans_mode'),
						"trans_distance"      =>  $this->input->post('trans_distance'),
						"transporter_name"    =>  $this->input->post('transporter_name'),
						"transporter_id"	  =>  $this->input->post('transporter_id'),
						"trans_doc_no"        =>  $this->input->post('trans_doc_no'),
						"trans_doc_date"      =>  $this->input->post('trans_doc_date'),
						"vehicle_no"          =>  $this->input->post('vehicle_no'),
						"vehicle_type"        =>  $this->input->post('vehicle_type')	
					);
			// echo "<pre>";
			// echo "simple data";
			// print_r($data);
			
			$js_data = json_decode($this->input->post('table_data1'));
			$php_data = json_decode($this->input->post('table_data'));

			// echo "<pre>";
			// echo "js_data";
			// print_r($js_data);
			// echo "php_data";
			// print_r($php_data);
			// exit;
			if($this->sales_model->editModel($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Sales Updated'
					);
				$this->log_model->insert_log($log_data);	
				if($js_data!=null){
					foreach ($js_data as $key => $value) {

						// echo '<pre>';
						// print_r($value);
						// exit;
						if($value=='delete'){
							//echo " delete".$key;
							$product_id =  $php_data[$key];
							if($this->sales_model->deleteSalesItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
								//echo " 1.Dsuccess";
							}
						}
						else if($value==null){
							if($warehouse_id != $old_warehouse_id AND $php_data[$key] !=null){
								$product_id =  $php_data[$key];
								if($this->sales_model->changeWarehouseDeleteSalesItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
									//echo " 1.Dsuccess";
								}
							}
							else if($warehouse_change == "yes"){
								$product_id =  $php_data[$key];
								if($this->sales_model->changeWarehouseDeleteSalesItems($id,$product_id,$warehouse_id,$old_warehouse_id)){
									//echo " 1.Dsuccess";
								}
							}
						}
						else{
							$product_id = $value->product_id;
							$quantity = $value->quantity;
							if(isset($value->tax_type)){
								$tax_type = $value->tax_type;
							}else{
								$tax_type = '';
							}
							$data = array(
									"product_id" => $value->product_id,
									"quantity" => $value->quantity,
									"price" => $value->price,
									"gross_total" => $value->total,
									"discount_id" => $value->discount_id,
									"discount_value" => $value->discount_value,
									"discount" => $value->discount,
									"igst" => $value->igst,
									"igst_tax" => $value->igst_tax,
									"cgst" => $value->cgst,
									"cgst_tax" => $value->cgst_tax,
									"sgst" => $value->sgst,
									"sgst_tax" => $value->sgst_tax,
									"sales_id" => $id,
									"tax_type" => $tax_type
								);
							// echo '<pre>';
							// echo 'od qty ='.$this->sales_model->checkProductInSales($id,$product_id);
							// print_r($data);
							// exit;
							if($old_quantity = $this->sales_model->checkProductInSales($id,$product_id)){
								$this->sales_model->updateQuantity($id,$product_id,$warehouse_id,$quantity,$old_quantity,$data);
							}
							else{
								if($this->sales_model->addSalesItem($data,$product_id,$warehouse_id,$quantity)){
									//echo " 1 Asuccess add";
								}
								else{

								}
							}
						}
					}
				}
				redirect('sales','refresh');
			}
			else{
				redirect('sales','refresh');
			}
		}
	}
	/* 
		this function is used to delete sales record from database 
	*/
	public function delete($id){
		if($this->sales_model->deleteModel($id)){
			$data['sales'] = $this->sales_model->getRecord($id);
			$data['sales_item'] = $this->sales_model->getSalesItemsForDelete($id);
			foreach ($data['sales_item'] as $row) {
				$this->sales_model->restoreQuantity($id,$row->product_id,$data['sales'][0]->warehouse_id,$row->quantity);
			}
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Sales Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('sales','refresh');
		}
		else{
			redirect('sales','refresh');
		}
	}
	/*
		display data in dashboard calendar
	*/
	public function calendar(){
		log_message('debug', print_r($this->db->get('category')->result(), true));
		$data = $this->sales_model->getCalendarData();
		$total = 0;
		foreach ($data as $value) {
			$date = Date('Y-m-d');
			if($date == $value->date){
				$total += $value->total;
			}
			$temp = array(
					"title" => $total,
					"start" => "2017-04-05T00:01:00+05:30"
				);
		}
		 echo json_encode($temp);
	}
	/*
		view Sales details
	*/
	public function view($id){
		//echo $id;

		$data['data'] = $this->sales_model->getDetails($id);
		if($data['data'] == null){
			redirect('sales','refresh');
		}

		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		// echo '<pre>';
		// print_r($data);
		// exit; 
		$this->load->view('sales/view',$data);
	}
	/*
		generate pdf
	*/
	public function pdf($id){

		// $data['data'] = $this->sales_model->getDetails($id);
		// $data['items'] = $this->sales_model->getItems($id);
		// $data['company'] = $this->purchase_model->getCompany();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Invoice Generated'
			);
		$this->log_model->insert_log($log_data);
		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$pdf_page = $this->sales_model->getPDFPage();
		if($pdf_page=="invoice-1"){
			$html = $this->load->view('sales/pdf',$data,true);
		}
		else{
			$html = $this->load->view('sales/pdf2',$data,true);
		}

		include(APPPATH.'third_party/mpdf60/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['data'][0]->reference_no.'.pdf','I');
	}

	public function ewaybill($id){

		// $data['data'] = $this->sales_model->getDetails($id);
		// $data['items'] = $this->sales_model->getItems($id);
		// $data['company'] = $this->purchase_model->getCompany();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Invoice Generated'
			);
		$this->log_model->insert_log($log_data);
		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$pdf_page = $this->sales_model->getPDFPage();
		// if($pdf_page=="invoice-1"){
		$html = $this->load->view('sales/ewaybill',$data,true);
		// }
		// else{
		// 	$html = $this->load->view('sales/pdf2',$data,true);
		// }

		include(APPPATH.'third_party/mpdf60/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output("ewaybill-".$data['data'][0]->reference_no.'.pdf','I');
	}
	
	public function pos($id){		

		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'POS Generated'
			);
		$this->log_model->insert_log($log_data);
		
		
		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
		

		$this->load->view('sales/pos_new',$data);		
	}
	public function print1($id){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Invoice Printed'
			);
		$this->log_model->insert_log($log_data);
		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();
	
		$this->load->view('sales/pdf',$data);
	}

	public function save_pdf($id){

		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->sales_model->getDetails($id);
		$data['items'] = $this->sales_model->getItems($id);
		$data['company'] = $this->purchase_model->getCompany();

		// echo '<pre>';
		// print_r($data);
		// exit;
		$html = $this->load->view('sales/pdf',$data,true);

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
				'message'  => 'Invoice Email Send'
			);
		$this->save_pdf($id);
		$this->log_model->insert_log($log_data);
		$email = $this->sales_model->getSmtpSetup();

		$data = $this->sales_model->getCustomerEmail($id);
		$company = $this->purchase_model->getCompany();
		
		$this->load->view('class.phpmailer.php');

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

		$mail->Subject = "Sales order No : ".$data[0]->reference_no." From ".$company[0]->name;
		$mail->Body = "Date : ".$data[0]->date."   \nTotal : ".$total." \n\n\nComapany Name : ".$company[0]->name."\nAddress : ".$company[0]->street." ".$company[0]->country_name."\nMobile No :".$company[0]->phone;
		$mail->AddAttachment(realpath(dirname(dirname(__DIR__)) . '/assets/uploads')."/".$data[0]->reference_no.'.pdf');
		//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";

		if(!$mail->Send())
		{
			$message =  "Email could not be sent";
		}
		else{
			$message =  "Email has been sent";
		}
		// $total = $data[0]->total+$data[0]->shipping_charge;
  //        $this->load->library('email'); 
   
  //        $this->email->from($email->from_address ,$email->from_name); 
  //        $this->email->to($data[0]->email);
  //        $this->email->subject("Sales order No : ".$data[0]->reference_no." From ".$company[0]->name); 
  //        $this->email->message("Date : ".$data[0]->date."   \nTotal : ".$total." \n\n\nComapany Name : ".$company[0]->name."\nAddress : ".$company[0]->street." ".$company[0]->country_name."\nMobile No :".$company[0]->phone); 
  //        //Send mail 
  //        if($this->email->send()) 
  //        $message = "Email sent successfully.";
  //        else 
  //        $message = "Error in sending Email."; 

		$this->session->set_flashdata('message', $message);
		redirect('sales','refresh');
	}
	/*
		receipt	 view
	*/
	public function receipt($id){
		$data['data'] = $this->sales_model->getDetailsReceipt($id);
		$data['to_ledger'] = $this->sales_model->getToLedger($data['data'][0]->biller_id);
		$data['from_ledger'] = $this->sales_model->getFromLedger($data['data'][0]->customer_id);
		$data['company'] = $this->purchase_model->getCompany();
		$data['payment_method'] = $this->payment_method_model->payUserData();
		$data['p_reference_no'] = $this->receipt_model->generateReferenceNo();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('sales/receipt',$data);
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
			$this->form_validation->set_rules('bank_name','Bank Name','trim|required|callback_alpha_dash_space');
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
					"sales_id"     => $id,
					"date"         => $this->input->post('date'),
					"reference_no" => $this->input->post('reference_no'),
					"amount"       => $this->input->post('amount'),
					"paying_by"    => $this->input->post('paying_by'),
					"bank_name"    => $bank_name,
					"cheque_no"    => $cheque_no,
					"description"  => $this->input->post('note')
				);

			if($this->sales_model->addPayment($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Sales Payable'
					);
				$this->log_model->insert_log($log_data);
				redirect('sales','refresh');
			}
			else{
				redirect("sales",'refresh');
			}
		}
	}
	/*
		generate invoice
	*/
	public function invoice(){
		$data['data'] = $this->sales_model->invoice();
		$this->load->view('sales/invoice',$data);
	}
	/*
		return customer details
	*/
	public function getCustomerData($id){
		$data['data'] = $this->customer_model->getCustomerData($id);
		$data['country']  = $this->customer_model->getCountry();
		$data['state'] = $this->customer_model->getState($data['data']->country_id);
		$data['city'] = $this->customer_model->getCity($data['data']->state_id);
		// echo '<pre>';
		// print_r($data);
		// exit;
		echo json_encode($data);
	}

	/*
		return customer details
	*/
	public function getCustomerStateIdAjax($customer_id){
		
		echo json_encode($this->sales_model->getCustomerStateId($customer_id));
	}
	/*
		return customer details
	*/
	public function customerView($customer_id){
		$data['data'] = $this->sales_model->getCustomerWithAllData($customer_id);
		$this->load->view('sales/customer_view',$data);
	}
	/*
		return biller details
	*/
	public function billerView($biller_id){
		$data['data'] = $this->sales_model->getBillerWithAllData($biller_id);
		$this->load->view('sales/biller_view',$data);
	}
	/*

	*/
	public function credit_note($id){
		$data['data'] = $this->sales_model->getSalesForCreditNote($id);
		$this->load->view('sales/credit_note',$data);
	}
	/*

	*/
	public function addCreditNote(){
		$this->form_validation->set_rules('r_v_no', 'Note/Refund Voucher Number', 'trim|required');
		$this->form_validation->set_rules('r_v_date', 'Note/Refund Voucher Value', 'trim|required');
		$this->form_validation->set_rules('r_v_value', 'Note/Refund Voucher Value', 'trim|required');
		$this->form_validation->set_rules('reason', 'Reason for Issue Document', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
        	$data = array(
					"invoice_id"=>$this->input->post('invoice'),
					"note_or_refund_voucher_no"=>$this->input->post('r_v_no'),
					"note_or_refund_voucher_date"=>$this->input->post('r_v_date'),
					"note_or_refund_voucher_value"=>$this->input->post('r_v_value'),
					"document_type"=>'C',
					"reason_for_issue_document"=>$this->input->post('reason'),
					"pre_gst"=>$this->input->post('pre_gst')
				);

        	$fromTo = $this->sales_model->getFromToAccount($this->input->post('sales'));
        	
			if($id = $this->credit_debit_note_model->addModel($data)){ 
				$credit_note_data = array(
					"transaction_date" => date('Y-m-d'),
					"credit_debit_note_id" => $id,
					"receipt_id"	   => null,
					"invoice_id"	   => null,
					"type"             => 'C',
					"amount"           => $this->input->post('r_v_value'),
					"voucher_no"       => $this->input->post('r_v_no'),
					"voucher_date"     => $this->input->post('r_v_date'),
					"mode"             => 'Cash',
					"from_account"     => $fromTo->from_account,
					"to_account"       => $fromTo->to_account,
					"voucher_status"   => 1
				);
				$transaction_id = $this->receipt_model->addReceipt($credit_note_data,$this->input->post('invoice'));
				$this->delete($this->input->post('sales'));
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $transaction_id,
						'message'  => 'Credit Note Generated'
					);
				$this->log_model->insert_log($log_data);
				redirect('sales','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Credit Note can not be Generated.');
				redirect("sales",'refresh');
			}
        }
	}

	/*
		check character and space validation 
	*/
	function alpha_dash_space($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha and spaces');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
}
?>