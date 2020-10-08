<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accountant extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('biller_model');
		$this->load->model('log_model');
		$this->load->model('company_setting_model');
		$this->load->model('ledger_model');
		$this->load->model('accountant_model');
		$this->load->model('assign_warehouse_model');

		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){

		$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
		$data=$this->data;

		$data['data'] = $this->biller_model->getBillers();		
		$data['suppliers'] = $this->biller_model->getSuppliers(); 
		$data['customer'] = $this->biller_model->getCustomer();
		$this->load->view('biller/list',$data);
	} 
	/*
		get all state of country
	*/
	public function getState($id){
		$data = $this->biller_model->getState($id);
		echo json_encode($data);
	}
	/*
		get all city of state
	*/
	public function getCity($id){
		$data = $this->biller_model->getCity($id);
		echo json_encode($data);
	}
	/*
		return state code
	*/
	public function getStateCode($id,$country){
		if($country == 101){
			$data = $this->biller_model->getStateCode($id);
			echo $data;
		}
		else{
			echo "";
		}
	}
	public function getBranch(){
		//get Branch name and Id
		$data = $this->biller_model->getBranch(); 
		return $data;
	}
	/* 
		get Branch name and Id  
	*/
	
	public function add(){
		
		$this->load->view('accountant/add');
	}
	
	public function addAccountant(){ 
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('firstname','first name','required');
		$this->form_validation->set_rules('lastname','last name','required');
		$this->form_validation->set_rules('company','company','required');		
		$this->form_validation->set_rules('phone', 'phone', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('password_confirm', 'password Confirmation','required|matches[password]');

		if($this->form_validation->run()==false){
			$this->add();
		}
		else
		{
			$ledger_data = array(
					'title' 			=> strtoupper($this->input->post('biller_name')),
					'accountgroup_id' 	=> 28
			);
			$ledger_id = $this->ledger_model->addLedger($ledger_data);

			$options = array(
			    'cost' => 12,
						);
			$password_user = $this->input->post('password'); 
			$password = password_hash($password_user, PASSWORD_BCRYPT, $options);
			$users = array(
				"username"			=> $this->input->post('email'),
				"password"   		=> $password,	
				'first_name' 		=> $this->input->post('firstname'),
                'last_name'  		=> $this->input->post('lastname'),
                'company'    		=> $this->input->post('company'),
                'phone'      		=> $this->input->post('phone'),	
                "email"				=> $this->input->post('email'),		
				'api_key'    		=> md5(uniqid(rand(), true)),
				'active'			=> 1			
			);
			if($id = $this->accountant_model->addUsers($users)){
				$users_groups = array(
						"user_id"		=>  $id,
						"group_id"  	=>  5,												
					);
				$this->accountant_model->addUsers_groups($users_groups);
					
				$this->session->set_flashdata('success', 'Accountant Successfully Inserted.'); 
				redirect('biller','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Accountant is not created.');				
				redirect("biller",'refresh');
			}
		}
	}
	


	/* 
		call view editr Biller 
	*/
	public function edit($id){ 

		// get the user list
		$users = $this->ion_auth->users()->result();
		$edit_user = null;
		$data = array();
		/*echo '<pre>';*/

		// get the accontant detail
		foreach($users as $value){
			if($value->id == $id)
			$edit_user = $value;
		}
		/*$data['data'] = $this->biller_model->getRecord($id);
		$data['country']  = $this->biller_model->getCountry();
		$data['state'] = $this->biller_model->getState($data['data'][0]->country_id);
		$data['city'] = $this->biller_model->getCity($data['data'][0]->state_id);*/
		//get Branch Name and Id
		/*$data['branch'] =  $this->biller_model->getBranch();*/

		//$data['users'] =  $this->biller_model->getUsers_data($id);
		// get Biller record in database.
		$data['user'] = $edit_user;
		/*echo '<pre>';
		print_r($data);
		exit;*/
		$this->load->view('accountant/edit',$data);
	}
	/*  
		Edit Biller in Database  
	*/
	public function editAccountant(){ 
		$this->load->library('form_validation');
		$id = $this->input->post('user_id');
		$this->load->library('form_validation');
		//$this->form_validation->set_rules('biller_name','Biller Name','trim|required|min_length[3]|callback_alpha_dash_space');
		
		
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		//$this->form_validation->set_rules('telephone','Telephone','trim|required|numeric|callback_tel');

		

		if($this->form_validation->run()==false){

			$this->edit($id);
		}
		else
		{
			
			$password=$this->input->post('password');
			if ($password !=null) 
			{

				$options = array( 'cost' => 12, );						
				//print_r($options);
				$password =password_hash($password, PASSWORD_BCRYPT, $options);			 
				/*print_r($password);
				exit();*/
				$users = array(
					'username'			=>  $this->input->post('email'),
					'password'   		=>  $password,
					'email'				=>  $this->input->post('email'),
					'first_name'		=>  $this->input->post('firstname'),					
					'last_name'			=>  $this->input->post('lastname'),	
					'company'			=>	$this->input->post('company'),				
					'phone'				=>	$this->input->post('mobile'),				
				);
				/*echo '<pre>';
				print_r($users);
				exit;*/
				if($this->accountant_model->editUser($users,$id)){
					$log_data = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $id,
							'message'  => 'Accountant Updated'
						);
					$this->log_model->insert_log($log_data);
					$this->session->set_flashdata('success', 'Accountant Updated Successfully.');
					redirect('biller','refresh');
				}
				else{
					$this->session->set_flashdata('fail', 'Accountant is not updated.');
					redirect("biller",'refresh');
				}
			}
			else{
				$users = array(
						'username'			=>  $this->input->post('email'),
						'email'				=>  $this->input->post('email'),
						'first_name'		=>  $this->input->post('firstname'),					
						'last_name'			=>  $this->input->post('lastname'),	
						'company'			=>	$this->input->post('company'),				
						'phone'				=>	$this->input->post('mobile'),									
					);
				/*echo '<pre>';	
				print_r($users);
				exit;*/
				if($this->accountant_model->editUser($users,$id)){
					$log_data = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $id,
							'message'  => 'Accountant Updated'
						);
					$this->log_model->insert_log($log_data);
					$this->session->set_flashdata('success', 'Accountant Updated Successfully.');
					redirect('biller','refresh');
				}
				else{
					$this->session->set_flashdata('fail', 'Accountant is not updated.');
					redirect("biller",'refresh');
				}			
			}			
			
			
			
		}
	
	}

	/* 
		Delete Biller in Database 
	*/
	public function delete($id){

		$users = array(				
				'active'			=> 0			
			);
			if($this->biller_model->deleteUsers($users,$id)){
	
			$this->biller_model->deleteModel($id);
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Biller deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect('biller','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Biller can not be Deleted.');
			redirect("biller",'refresh');
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
	function alpha_dash_space1($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space1', 'The %s field may only contain alpha and spaces.');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
	function mobile($str) {
		if (! preg_match("/^[6-9][0-9]{9}$/", $str))
	    {
	        $this->form_validation->set_message('mobile', 'The %s field may only contain Numeric and 10 digit(Ex.9898767654)');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
	function fax($str) {
		if (! preg_match("/^[1-9][0-9]{6}$/", $str))
	    {
	        $this->form_validation->set_message('fax', 'The %s field may only contain Numeric and 7 digit (Ex.2199876)');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
	function tel($str) {
		if (! preg_match("/^[1-9][0-9]{5}$/", $str))
	    {
	        $this->form_validation->set_message('tel', 'The %s field may only contain Numeric and 6 digit(Ex.294910)');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
	function generateRandomString($length) {
	    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
?>