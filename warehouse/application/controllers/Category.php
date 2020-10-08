<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('log_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){
		//get All Category  to display list
		$data['data'] = $this->category_model->getCategory();
		$this->load->view('category/list',$data);
		
	} 
	
	/* 
		call Add view to add category  
	*/
	public function add(){
		$this->load->view('category/add');
	}

	/* 
		this function is used to count the number of category 
	*/
	public function getCategoryCount(){
		return sizeof($this->category_model->getCategoryCount());
	}

	/*
		add category using ajax
	*/
	public function add_category_ajax(){
		$category_code = $this->category_model->getMaxId();
		$data = array(
					"category_code"=>$category_code,
					"category_name"=>$this->input->post('category_name')
				);
		$id = $this->category_model->addModel($data);
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => $id,
				'message'  => 'Category Inserted(Subcategory)'
			);
		$this->log_model->insert_log($log_data);
		$data['data'] = $this->category_model->getCategory();
		$data['id'] = $id;
		echo json_encode($data);
	} 
	/* 
		This function used to store category record in database  
	*/
	public function addCategory(){
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
			$category_code = $this->category_model->getMaxId();
			$data = array(
						"category_code"=>$category_code,
						"category_name"=>$this->input->post('category_name')
					);

			if($id = $this->category_model->addModel($data)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Category Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('category','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Category can not be Inserted.');
				redirect("category",'refresh');
			}
        }	
		
	}
	/* 
		call edit view to edit Category Record 
	*/
	public function edit($id){
		$data['data'] = $this->category_model->getRecord($id);
		$this->load->view('category/edit',$data);
	}
	/* 
		This function is used to edit category record in database 
	*/
	public function editCategory(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
			$data = array(
						"category_name" => $this->input->post('category_name')
						);
			if($this->category_model->editModel($data,$id)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Category Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('category','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Category can not be Updated.');
				redirect("category",'refresh');
			}
		}
	}
	/* 
		Delete selected  Category Record 
	*/
	public function delete($id){
		if($this->category_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Category Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('category');
		}
		else{
			$this->session->set_flashdata('fail', 'Category can not be Deleted.');
			redirect("category",'refresh');
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