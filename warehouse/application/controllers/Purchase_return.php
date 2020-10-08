<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase_return extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('purchase_return_model');
		$this->load->model('assign_warehouse_model');
		$this->load->model('purchase_model');
		$this->load->model('sales_model');
		$this->load->model('log_model');
		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
		
	public function index(){
		//get purchase return to display list
		$data['data'] = $this->purchase_return_model->getPurchaseReturn();
		$this->load->view('purchase_return/list',$data);
	} 
	/* call add view to add purchase return   */
	public function add(){
		//$data['product'] = $this->purchase_model->getProduct();
		$data['warehouse'] = $this->purchase_return_model->getWarehouse(); 
		//$data['biller'] = $this->sales_model->getBiller();
		$data['supplier'] = $this->purchase_return_model->getSupplier();
		$data['user'] = $this->assign_warehouse_model->getUser();
		$data['reference_no'] = $this->purchase_return_model->createReferenceNo();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('purchase_return/add',$data);

	}
	/* get single product */
	public function getProduct($product_id,$warehouse_id){
		$data = $this->purchase_return_model->getProduct($product_id,$warehouse_id);
		$data['discount'] = $this->purchase_model->getDiscount();
		$data['tax'] = $this->purchase_model->getTax();
	    echo json_encode($data);
		//print_r($data);
	}
	/* get all product warehouse wise */
	public function getProducts($warehouse_id){
		$data = $this->purchase_return_model->getProducts($warehouse_id);
	    echo json_encode($data);
		//print_r($data);
	}
	/* This function is used to search product code / name in database */
	public function getAutoCodeName($code,$search_option,$warehouse){
          //$code = strtolower($code);
		  $p_code = $this->input->post('p_code');
		  $p_search_option = $this->input->post('p_search_option');
          $data = $this->purchase_return_model->getProductCodeName($p_code,$p_search_option,$warehouse);
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
          //print_r($list);
	}
	/* This function is used to add purchase return in database */
	public function addPurchaseReturn(){
		$this->form_validation->set_rules('date','Date','trim|required');
		$this->form_validation->set_rules('reference_no','Reference No','trim|required');
		//$this->form_validation->set_rules('supplier_id','Supplier ID','trim|required');
		//$this->form_validation->set_rules('warehouse_id','Warehouse ID','trim|required');
		if($this->form_validation->run()==false){

			$this->add();
		}
		else
		{
			$warehouse_id = $this->input->post('warehouse');
			$data = array(
						"date" 			=> 	$this->input->post('date'),
						"reference_no" 	=> 	$this->input->post('reference_no'),
						"supplier_id" 	=>	$this->input->post('supplier'),
						"biller_id"		   => 	$this->input->post('biller'),
						"warehouse_id" 	=>	$warehouse_id,
						"total" 		=> 	$this->input->post('grand_total'),
						"flat_discount" =>  $this->input->post('discount'),
						"discount_value"=>  $this->input->post('total_discount'),
						"tax_value" 	=>  $this->input->post('total_tax'),
						"note" 			=> 	$this->input->post('note'),
						"user"			=>	$this->session->userdata('user_id')
					);	

			if($id = $this->purchase_return_model->addModel($data)){
				$purchase_item_data = $this->input->post('table_data');
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Purchase Return Inserted'
					);
				$this->log_model->insert_log($log_data);
				$js_data = json_decode($purchase_item_data);
				foreach ($js_data as $key => $value) {
					if($value==null){
					}
					else{
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
							"product_id" => $value->product_id,
							"quantity" => $value->quantity,
							"gross_total" => $value->total,
							"discount_id" => $value->discount_id,
							"discount_value" => $value->discount_value,
							"tax_type" => $value->tax_type,
							"discount" => $value->discount,
							"igst" => $value->igst,
							"igst_tax" => $value->igst_tax,
							"cgst" => $value->cgst,
							"cgst_tax" => $value->cgst_tax,
							"sgst" => $value->sgst,
							"sgst_tax" => $value->sgst_tax,
							"cost" => $value->price,
							"purchase_return_id" => $id
							);
						$warehouse_data = array(
							"product_id" => $value->product_id,
							"warehouse_id" => $warehouse_id,
							"quantity" => $value->quantity
							);
						$this->purchase_return_model->addProductInWarehouse($product_id,$quantity,$warehouse_id,$warehouse_data);
						if($this->purchase_return_model->addPurchaseItem($data)){
						}
						else{

						}
					}
				}
				redirect('purchase_return','refresh');
			}
			else{
			}
		}
	}
	/* This function is used to call view  edit purchase return */
	public function edit($id){
		$data['warehouse'] = $this->purchase_return_model->getWarehouse(); 
		//$data['biller'] = $this->sales_model->getBiller();
		$data['user'] = $this->assign_warehouse_model->getUser();
		$data['supplier'] = $this->purchase_return_model->getSupplier();
		$data['data'] = $this->purchase_return_model->getRecord($id);
		$data['product'] = $this->purchase_return_model->getProducts($data['data'][0]->warehouse_id);
		$data['discount'] = $this->purchase_model->getDiscount();
		$data['tax'] = $this->purchase_model->getTax();
		$data['items'] = $this->purchase_return_model->getPurchaseReturnItems($data['data'][0]->id,$data['data'][0]->warehouse_id);
		$data['supplier_state_id'] = $this->purchase_model->getSupplierState($data['data'][0]->supplier_id);
		$data['warehouse_details']  = $this->purchase_model->getWarehouesDetails($data['data'][0]->warehouse_id);
		$data['warehouse_state_id'] = $data['warehouse_details'][0]->warehouse_state_id;
			

		// echo '<pre>';
		// print_r($data);
		// exit;

		$this->load->view('purchase_return/edit',$data);
	}
	/* This function is used to delete discount record in databse */
	public function delete($id){
		if($this->purchase_return_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Purchase Return Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('purchase_return','return');
		}
		else{
			redirect('purchase_return','return');
		}
	}
	/* This function is to edit purchase return record in database */
	public function editPurchaseReturn(){
		$id = $this->input->post('purchase_return_id');
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
						"date" 			=> $this->input->post('date'),
						"reference_no"	=>$this->input->post('reference_no'),
						"supplier_id" 	=> $this->input->post('supplier'),
						"warehouse_id" 	=> $this->input->post('warehouse'),
						"total" 		=> $this->input->post('grand_total'),
						"biller_id"		   => 	$this->input->post('biller'),
						"flat_discount" =>  $this->input->post('discount'),
						"discount_value"=>  $this->input->post('total_discount'),
						"tax_value" 	=>  $this->input->post('total_tax'),
						"note" 			=> $this->input->post('note'),
						"user"			=> $this->session->userdata('user_id')
					);
			
			//$id = $this->input->post('purchase_return_id');
			$js_data = json_decode($this->input->post('table_data1'));
			$php_data = json_decode($this->input->post('table_data'));
			if($this->purchase_return_model->editModel($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Purchase Return Updated'
					);
				$this->log_model->insert_log($log_data);
				if($js_data !=null){
				foreach ($js_data as $key => $value) {
					if($value=='delete'){
						//echo " delete".$key;
						$product_id =  $php_data[$key];
						if($this->purchase_return_model->deletePurchaseReturnItems($id,$product_id,$warehouse_id)){
							//echo " 1.Dsuccess";
						}
					}
					else if($value==null){
						//echo " Null".$key;
					}
					else{
						//echo " array";
						$product_id = $value->product_id;
						$quantity = $value->quantity;
						$data = array(
								"product_id" => $value->product_id,
								"quantity" => $value->quantity,
								"gross_total" => $value->total,
								"discount_id" => $value->discount_id,
								"discount_value" => $value->discount_value,
								"discount" => $value->discount,
								"tax_type" => $value->tax_type,
								"igst" => $value->igst,
								"igst_tax" => $value->igst_tax,
								"cgst" => $value->cgst,
								"cgst_tax" => $value->cgst_tax,
								"sgst" => $value->sgst,
								"sgst_tax" => $value->sgst_tax,
								"cost" => $value->price,
								"purchase_return_id" => $id
							);
						$warehouse_data = array(
							"product_id" => $value->product_id,
							"warehouse_id" => $warehouse_id,
							"quantity" => $value->quantity
							);
						if($this->purchase_return_model->addUpdatePurchaseItem($id,$product_id,$warehouse_id,$quantity,$data,$warehouse_data)){
							//echo " 1 Asuccess add";
						}
						else{

						}
					}
				}
				}
				redirect('purchase_return');
			}
		}
	}
	/*
		return barcode product
	*/
	public function getBarcodeProducts($term,$warehouse_id){
		/*echo $term." ".$warehouse_id;
		exit;	*/
		$data = $this->purchase_return_model->getBarcodeProducts($term,$warehouse_id);
		echo json_encode($data);
	}
	public function getNameProducts($term,$warehouse_id){
		$data = $this->purchase_return_model->getNameProducts($term,$warehouse_id);
		echo json_encode($data);
	}
	/*
		return product details
	*/
	public function getProductUseCode($product_id,$warehouse_id){
		$data = $this->purchase_return_model->getProductUseCode($product_id,$warehouse_id);
		$data['discount'] = $this->purchase_return_model->getDiscount();
		/*echo '<pre>';
		print_r($data);
		exit;*/
		echo json_encode($data);
	}
	/*
		return biller details
	*/
	public function getBillerState($id){
		echo $this->purchase_return_model->getBillerState($id);
	}
	/*
		return customer details
	*/
	public function getCustomerState($id){
		echo $this->purchase_return_model->getCustomerState($id);
	}
}
?>