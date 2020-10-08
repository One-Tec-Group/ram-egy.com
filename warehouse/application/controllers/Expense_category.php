<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Expense_category extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('expense_category_model');
		$this->load->model('log_model');
		$this->load->model('ledger_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){
		$data['data'] = $this->expense_category_model->getExpenseCategory();
		$this->load->view('expense_category/list',$data);
	} 
	/* 
		call Add view to add category  
	*/
	public function add(){
		$this->load->view('expense_category/add');
	} 
	/* 
		This function used to store category record in database  
	*/
	public function addExpenseCategory(){
        $this->form_validation->set_rules('category_name', 'Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
        	$ledger_data = array(
					'title' 			=> strtoupper($this->input->post('category_name')),
					'accountgroup_id' 	=> 10
			);
			$ledger_id = $this->ledger_model->addLedger($ledger_data);
			$data = array(
						"name"=>$this->input->post('category_name'),
						"ledger_id"=> $ledger_id
					);

			if($id = $this->expense_category_model->addModel($data)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Expense Category Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('expense_category','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Expense Category can not be Inserted.');
				redirect("expense_category",'refresh');
			}
        }	
		
	}
	/* 
		call edit view to edit Category Record 
	*/
	public function edit($id){
		$data['data'] = $this->expense_category_model->getRecord($id);
		$this->load->view('expense_category/edit',$data);
	}
	/* 
		This function is used to edit category record in database 
	*/
	public function editExpenseCategory(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]|callback_alpha_dash_space');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
			$data = array(
						"name" => $this->input->post('category_name')
						);
			if($this->expense_category_model->editModel($data,$id)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Expense Category Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('expense_category','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Expense Category can not be Updated.');
				redirect("expense_category",'refresh');
			}
		}
	}
	/* 
		Delete selected  Category Record 
	*/
	public function delete($id){
		if($this->expense_category_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Expense Category Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('expense_category');
		}
		else{
			$this->session->set_flashdata('fail', 'Expense Category can not be Deleted.');
			redirect("expense_category",'refresh');
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