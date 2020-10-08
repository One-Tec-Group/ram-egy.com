<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Subcategory extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('subcategory_model');
		$this->load->model('product_model');
		$this->load->model('log_model');
	}
	public function index(){
		$data['data'] = $this->subcategory_model->getSubcategory();
		$this->load->view('subcategory/list',$data);
	} 
	/*  
		call add subcategory view to add subcategory 
	*/
	public function add(){
		$data= $this->getCategory();
		$this->load->view('subcategory/add',$data);
	} 
	/* 
		this function is  used to get category list to select 
	*/
	public function getCategory(){
		$data['data'] = $this->subcategory_model->getCategory();
		return $data;
	}
	/*
		add subcategory using ajax
	*/
	public function add_subcategory_ajax(){
		//echo json_encode($this->input->post('subcategory_name'));
		$subcategory_code = $this->subcategory_model->getMaxId();
		$data = array(
					"category_id"      => $this->input->post('category_id_model'),
					"sub_category_code"=>$subcategory_code,
					"sub_category_name"=>$this->input->post('subcategory_name')
				);
		$id = $this->subcategory_model->addModel($data);
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Subcategory Inserted(Product)'
			);
		$this->log_model->insert_log($log_data);
		$data['data'] = $this->product_model->selectSubcategory($this->input->post('category_id_model'));
		$data['subcategory_id'] = $id;
		echo json_encode($data);
	}
	/* 
		this function is used to add subcategory record in database 
	*/
	public function addSubcategory(){
		$this->form_validation->set_rules('subcategory_name', 'Subcategory Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
		$this->form_validation->set_rules('category', 'Category', 'trim|required|greater_than[0]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
			$subcategory_code = $this->subcategory_model->getMaxId();
			$data = array(
					"category_id"        => $this->input->post('category'),
					"sub_category_code"  => $subcategory_code,
					"sub_category_name"  => $this->input->post('subcategory_name')
				);

			if($id = $this->subcategory_model->addModel($data)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Subcategory Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('subcategory');	
			}
			else{
				$this->session->set_flashdata('fail', 'Subcategory can not be Inserted.');
				redirect("subcategory",'refresh');
			}
		}
	}
	/* 
		call edit view to edit record  
	*/
	public function edit($id){
		$data['category']  = $this->subcategory_model->getCategory1();
		$data['data'] = $this->subcategory_model->getRecord($id);
		$this->load->view('subcategory/edit',$data);
	}
	/* 
		this function is used to save edited record in database 
	*/
	public function editSubcategory(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('subcategory_name', 'Subcategory Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
		$this->form_validation->set_rules('category', 'Category', 'trim|required|greater_than[0]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
			$data = array(
					"category_id"        => $this->input->post('category'),
					"sub_category_name"  => $this->input->post('subcategory_name')
				);
			if($this->subcategory_model->editModel($data,$id)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Subcategory Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('subcategory');
			}
			else{
				$this->session->set_flashdata('fail', 'Subcategory can not be Updated.');
				redirect("subcategory",'refresh');
			}
		}
	}
	/* 
		This function is to delete subcategory from database  
	*/
	public function delete($id){
		if($this->subcategory_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Subcategory Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('subcategory','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Subcategory can not be Deleted.');
			redirect("subcategory",'refresh');
		}
	}
	function alpha_dash_space($str) {
		if (! preg_match("/^([-a-zA-Z ])+$/i", $str))
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