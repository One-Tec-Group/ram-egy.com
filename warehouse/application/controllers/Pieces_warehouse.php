<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pieces_warehouse extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('pieces_warehouse_model');
		$this->load->model('branch_model');
		$this->load->model('log_model');
	}
	public function index(){
		// get all warehouse to display list

		$data['title'] = "Pieces Warehouse";
		$data['data'] = $this->pieces_warehouse_model->getWarehouse();
		$data['no_of_branch'] = sizeof($this->branch_model->getBranchCount());

		$this->load->view('pieces_warehouse/list',$data);
	}
	/*
		call add view to add warehouse record
	*/
	public function add(){
		$data= $this->getBranch();
		$data['warehouse_count'] = $this->getWarehouseCount();

		$this->load->view('pieces_warehouse/add',$data);
	}
	/*
		this function is used to get all branch to select
	*/
	public function getBranch(){
		$data['data'] = $this->pieces_warehouse_model->getBranch();
		return $data;
	}

	/*
		this function is used to count the number of warehouses
	*/
	public function getWarehouseCount(){
		return sizeof($this->pieces_warehouse_model->getWarehouseCount());
	}

	/*
		this function is used to change warehouse type
	*/
	public function changeWarehouseType(){

		return $this->pieces_warehouse_model->makeWarehouseSecondary();
	}



	/*
		this function is add warehouse in database using ajax
	*/
	public function add_warehouse_ajax(){
		$data = array(
			"Pwarehouse_name" => $this->input->post('warehouse_name'),
			"branch_id"      => $this->input->post('branch'),
			"user_id"        => $this->session->userdata('user_id')
		);

		$id = $this->pieces_warehouse_model->addModel($data);
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Warehouse Inserted'
			);
		$this->log_model->insert_log($log_data);
		$data['data'] = $this->pieces_warehouse_model->getWarehouse();
		$data['id'] = $id;
		echo json_encode($data);

	}
	/*
		this function is add warehouse in database
	*/
	public function addWarehouse(){
		$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
		$this->form_validation->set_rules('warehouse_name', 'Warehouse Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
		if($this->input->post('primary_warehouse') == null){
			$primary_warehouse = 0;
		}else{
			$primary_warehouse = 1;
		}

		$no_of_warehouse = sizeof($this->pieces_warehouse_model->getWarehouseCount());

		if(($primary_warehouse == 0) && ($no_of_warehouse == 0)){
			$primary_warehouse = 1;
		}

		/*echo $primary_warehouse."dafkdj";
		exit;*/
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
					"Pwarehouse_name" 	=> $this->input->post('warehouse_name'),
					"primary_Pwarehouse" => $primary_warehouse,
					"branch_id"      	=> $this->input->post('branch'),
					"user_id"        	=> $this->session->userdata('user_id')
				);



			if($id = $this->pieces_warehouse_model->addModel($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Warehouse Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('pieces_warehouse','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Warehouse can not be Inserted.');
				redirect("pieces_warehouse",'refresh');
			}
		}

	}
	/*
		call edit view to edit warehouse record
	*/
	public function edit($id){
		$data['branch'] =  $this->pieces_warehouse_model->getBranch();;
		$data['data'] = $this->pieces_warehouse_model->getRecord($id);
		$data['warehouse_count'] = $this->getWarehouseCount();

		/*echo '<pre>';
		print_r($data);
		exit;*/
		$this->load->view('pieces_warehouse/edit',$data);
	}
	/*
		this function is used to save edited warehouse record
	*/
	public function editWarehouse(){
		$id =  $this->input->post('id');

		$this->form_validation->set_rules('branch', 'Branch', 'trim|required');
		$this->form_validation->set_rules('warehouse_name', 'Warehouse Name', 'trim|required|min_length[3]|callback_alpha_dash_space');

		/*echo $this->input->post('primary_warehouse');
		exit;*/

		$primary_warehouse ;
		if($this->input->post('primary_warehouse')== null){
			$primary_warehouse = 0;
		}else{
			$primary_warehouse = 1;
		}
/*
		if($this->pieces_warehouse_model->isPrimaryWarehouse($id)){
			echo 'yes this is primary warehouse';
			exit;
		}
*/
		if($this->pieces_warehouse_model->isPrimaryWarehouse($id)){
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
					"Pwarehouse_name" => $this->input->post('warehouse_name'),
					"primary_Pwarehouse" => $primary_warehouse,
					"user_id"        => $this->session->userdata('user_id')
				);

			if($this->pieces_warehouse_model->editModel($data,$id)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Warehouse Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('pieces_warehouse');
			}
			else{
				$this->session->set_flashdata('fail', 'Warehouse can not be Updated.');
				redirect("pieces_warehouse",'refresh');
			}
		}
	}
	/*
		this function is used to delete warehouse record in database
	*/
	public function delete($id){

		if($this->pieces_warehouse_model->isPrimaryWarehouse($id)){

			$this->session->set_flashdata('fail', 'Primary warehouse can not be Deleted.');
			redirect("pieces_warehouse",'refresh');

		}else{
			if($this->pieces_warehouse_model->deleteModel($id)){
				$log_data = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $id,
							'message'  => 'Warehouse Deleted'
						);
					$this->log_model->insert_log($log_data);
					$this->session->set_flashdata('success', 'Warehouse is successfully deleted');
				redirect('pieces_warehouse','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Warehouse can not be Deleted.');
				redirect("pieces_warehouse",'refresh');
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
