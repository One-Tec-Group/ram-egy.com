<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Warehouse extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('warehouse_model');
		$this->load->model('branch_model');
		$this->load->model('log_model');
	}

	public function index(){
		$data['data'] = $this->warehouse_model->getWarehouse();
		$data['no_of_branch'] = sizeof($this->branch_model->getBranchCount());
		$this->load->view('warehouse/list',$data);
	}

	public function add(){
		$data= $this->getBranch();
		$data['warehouse_count'] = $this->getWarehouseCount();
		$this->load->view('warehouse/add',$data);
	}

	public function getBranch(){
		$data['data'] = $this->warehouse_model->getBranch();
		return $data;
	}

	public function getWarehouseCount(){
		return sizeof($this->warehouse_model->getWarehouseCount());
	}

	public function changeWarehouseType(){

		return $this->warehouse_model->makeWarehouseSecondary();
	}

	public function add_warehouse_ajax(){
		$data = array(
			"warehouse_name" => $this->input->post('warehouse_name'),
			"branch_id"      => $this->input->post('branch'),
			"user_id"        => $this->session->userdata('user_id')
		);

		$id = $this->warehouse_model->addModel($data);
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Warehouse Inserted'
			);
		$this->log_model->insert_log($log_data);
		$data['data'] = $this->warehouse_model->getWarehouse();
		$data['id'] = $id;
		echo json_encode($data);

	}

	public function addWarehouse(){
		$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
		$this->form_validation->set_rules('warehouse_name', 'Waarehouse Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
		if($this->input->post('primary_warehouse') == null){
			$primary_warehouse = 0;
		}else{
			$primary_warehouse = 1;
		}

		$no_of_warehouse = sizeof($this->warehouse_model->getWarehouseCount());

		if(($primary_warehouse == 0) && ($no_of_warehouse == 0)){
			$primary_warehouse = 1;
		}

		if($primary_warehouse == 1){
			$this->changeWarehouseType();
		}

		if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {

			$data = array(
					"warehouse_name" 	=> $this->input->post('warehouse_name'),
					"primary_warehouse" => $primary_warehouse,
					"branch_id"      	=> $this->input->post('branch'),
					"user_id"        	=> $this->session->userdata('user_id')
				);



			if($id = $this->warehouse_model->addModel($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Warehouse Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('warehouse','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Warehouse can not be Inserted.');
				redirect("warehouse",'refresh');
			}
		}

	}

	public function edit($id){
		$data['branch'] =  $this->warehouse_model->getBranch();;
		$data['data'] = $this->warehouse_model->getRecord($id);
		$data['warehouse_count'] = $this->getWarehouseCount();

		$this->load->view('warehouse/edit',$data);
	}

	public function editWarehouse(){
		$id =  $this->input->post('id');

		$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
		$this->form_validation->set_rules('warehouse_name', 'Warehouse Name', 'trim|required|min_length[3]|callback_alpha_dash_space');

		$primary_warehouse ;
		if($this->input->post('primary_warehouse')== null){
			$primary_warehouse = 0;
		}else{
			$primary_warehouse = 1;
		}

		if($this->warehouse_model->isPrimaryWarehouse($id)){
			$primary_warehouse = 1;
		}else{
			$this->changeWarehouseType();
		}

		if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
			$data = array(
					"branch_id"      => $this->input->post('branch'),
					"warehouse_name" => $this->input->post('warehouse_name'),
					"primary_warehouse" => $primary_warehouse,
					"user_id"        => $this->session->userdata('user_id')
				);

			if($this->warehouse_model->editModel($data,$id)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Warehouse Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('warehouse');
			}
			else{
				$this->session->set_flashdata('fail', 'Warehouse can not be Updated.');
				redirect("warehouse",'refresh');
			}
		}
	}
	
	public function delete($id){

		if($this->warehouse_model->isPrimaryWarehouse($id)){

			$this->session->set_flashdata('fail', 'Primary warehouse can not be Deleted.');
			redirect("warehouse",'refresh');

		}else{
			if($this->warehouse_model->deleteModel($id)){
				$log_data = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $id,
							'message'  => 'Warehouse Deleted'
						);
					$this->log_model->insert_log($log_data);
					$this->session->set_flashdata('success', 'Warehouse is successfully deleted');
				redirect('warehouse','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Warehouse can not be Deleted.');
				redirect("warehouse",'refresh');
			}
		}

	}

	function alpha_dash_space($str) {
		if (! preg_match("/^([a-zA-Z\-0-9 ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha, spaces and dashes.');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
}
?>
