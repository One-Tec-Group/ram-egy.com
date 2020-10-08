<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchaser extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('biller_model');
		$this->load->model('log_model');
		$this->load->model('company_setting_model');
		$this->load->model('ledger_model');
		$this->load->model('assign_warehouse_model');
		$this->load->model('purchaser_model');
		
		
		

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
		get Branch name and Id  
	*/
	/*public function add(){
		$data['country']  = $this->biller_model->getCountry();
		$data['branch']= $this->biller_model->getBranch(); 
		$this->load->view('biller/add',$data);
	}*/
	public function accountant(){
		$this->load->view('biller/accountant');
	}

	public function add(){

		$data['warehouse'] = $this->purchaser_model->getWarehouse();
		$this->load->view('purchaser/add',$data);
	}
	
	public function addPurchaser(){ 
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('firstname','first name','required');
		$this->form_validation->set_rules('lastname','last name','required');
		$this->form_validation->set_rules('company','company','required');		
		$this->form_validation->set_rules('phone', 'phone', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('password_confirm', 'password Confirmation','required|matches[password]');
		$this->form_validation->set_rules('warehouse_id','Warehouse','required');
		
		if($this->form_validation->run()==false){
			
			$this->add();
		}
		else
		{
			$ledger_data = array(
					'title' 			=> strtoupper($this->input->post('firstname')." ".$this->input->post('lastname')),
					'accountgroup_id' 	=> 28
			);
			$ledger_id = $this->ledger_model->addLedger($ledger_data);

			$options = array(
			    'cost' => 12,
						);
			$user_password = $this->input->post('password');
			$password = password_hash($user_password, PASSWORD_BCRYPT, $options);
			$users = array(
				"username"			=> $this->input->post('email'),
				"password"   		=> $password,	
				'first_name' 		=> $this->input->post('firstname'),
                'last_name'  		=> $this->input->post('lastname'),
                'company'    		=> $this->input->post('company'),
                'phone'      		=> $this->input->post('phone'),	
                "email"				=> $this->input->post('email'),		
				'api_key'    		=> md5(uniqid(rand(), true)),
				'ledger_id'    		=> $ledger_id,
				'active'			=> 1			
			);
			// echo '<pre>';
			// print_r($users);
			// exit;
			$warehouse_id = $this->input->post('warehouse_id');

			if($id = $this->biller_model->addUsers($users)){

				$users_groups = array(
					"user_id"		=>  $id,
					"group_id"  	=>  2,												
				);
				$this->biller_model->addUsers_groups($users_groups);
				
				$assign_warehouse_new = array(
					"user_id"		=>  $id,
					"warehouse_id"  =>  $warehouse_id,												
				);
				
				if($id = $this->assign_warehouse_model->assignWarehouse($assign_warehouse_new)){
					$log_data = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $id,
							'message'  => 'Assign Warehouse Inserted'
						);
					$this->log_model->insert_log($log_data);
					//redirect('assign_warehouse','refresh');
				}
				$this->session->set_flashdata('success', 'Purchaser Successfully Created.'); 
				redirect('biller','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Purchaser failed to created.');				
				redirect("biller",'refresh');
			}
		}
	}

	/*

		edit purchaser

	*/

	public function editPurchaser(){ 
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('firstname','first name','required');
		$this->form_validation->set_rules('lastname','last name','required');
		$this->form_validation->set_rules('company','company','required');		
		$this->form_validation->set_rules('phone', 'phone', 'trim|required|numeric');
		//$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		
		$this->form_validation->set_rules('password', 'password');
		$this->form_validation->set_rules('password_confirm', 'password Confirmation');
		//$this->form_validation->set_rules('warehouse_id','Warehouse','required');
		
		if($this->form_validation->run()==false){
			
			$this->edit($this->input->post('user_id'));
		}
		else
		{
			$user_id = $this->input->post('user_id');
			$warehouse_id = $this->input->post('warehouse_id');

			if($this->input->post('password')){
				$options = array(
						    'cost' => 12,
							);
				$user_password = $this->input->post('password');
				$password = password_hash($user_password, PASSWORD_BCRYPT, $options);
				$users = array(
							"username"			=> $this->input->post('email'),
							"password"   		=> $password,	
							'first_name' 		=> $this->input->post('firstname'),
			                'last_name'  		=> $this->input->post('lastname'),
			                'company'    		=> $this->input->post('company'),
			                'phone'      		=> $this->input->post('phone')	
			                
						);	
				$this->purchaser_model->editUser($users,$user_id);
			}else{
				$users = array(
							'username'			=> $this->input->post('email'),
							'first_name' 		=> $this->input->post('firstname'),
			                'last_name'  		=> $this->input->post('lastname'),
			                'company'    		=> $this->input->post('company'),
			                'phone'      		=> $this->input->post('phone'),	
			                'email'				=> $this->input->post('email')
						);	
				$this->purchaser_model->editUser($users,$user_id);
			}
			
			
			
			$warehouse_id = $this->input->post('warehouse_id');
			if($warehouse_id !=''){
				$warehouse_id = $this->input->post('warehouse_id');
				$assign_warehouse_update = array(
						"user_id"		=>  $user_id,
						"warehouse_id"  =>  $warehouse_id,
					);
					
					if($id = $this->assign_warehouse_model->assignWarehouse($assign_warehouse_update)){
						$log_data = array(
								'user_id'  => $this->session->userdata('user_id'),
								'table_id' => $id,
								'message'  => 'Assign Warehouse Updated'
							);
						$this->log_model->insert_log($log_data);
						$this->session->set_flashdata('success', 'Purchaser warehouse updated successfully.'); 			
						redirect('biller','refresh');
					}else{
						$this->session->set_flashdata('fail', 'Purchaser warehouse not updated.'); 			
						redirect('biller','refresh');
					}
			}
			$this->session->set_flashdata('success', 'Purchaser Successfully Updated.'); 
			redirect('biller','refresh');
		
				
			
			
		}
	}
	/* 
		call view editr purchaser 
	*/
	public function edit($id){ 

		// get the user list
		$data1 = $this->ion_auth->users()->result();
		$edit_user = null;
		/*echo '<pre>';*/

		// get the single user data
		foreach($data1 as $value){
			if($value->id == $id)
			$edit_user = $value;
		}
		 
		$data['user'] = $edit_user;
		//$data['assigned_warehouse'] = $this->purchaser_model->getAssignedWarehouseToPurchaser();
		$data['warehouse'] = $this->purchaser_model->getWarehouseList();
		
		// $assigned_warehouse_array = array();
		
		// for($a = 0; $a < sizeof($data['assigned_warehouse']); $a++){
		// 	$assigned_warehouse_array[] = $data['assigned_warehouse'][$a]->warehouse_id;
		// }

		// $data['not_assigned_warehouse'] = $this->purchaser_model->getNotAssignedWarehouseToPurchaser($assigned_warehouse_array);
		$data['user_warehouse'] = $this->db->select('wm.warehouse_id,w.warehouse_name')
										   ->from('users u')
										   ->join('warehouse_management wm','wm.user_id = u.id')
										   ->join('warehouse w','w.warehouse_id = wm.warehouse_id')
										   ->where('u.id',$id)
										   ->get()
										   ->result();
 		
		


		// echo '<pre>';
		// print_r($data);
		// exit;

	  	/*$data['data'] = $this->biller_model->getRecord($id);
		$data['country']  = $this->biller_model->getCountry();
		$data['state'] = $this->biller_model->getState($data['data'][0]->country_id);
		$data['city'] = $this->biller_model->getCity($data['data'][0]->state_id);*/
		//get Branch Name and Id
		/*$data['branch'] =  $this->biller_model->getBranch();*/

		//$data['users'] =  $this->biller_model->getUsers_data($id);
		// get Biller record in database.
		$this->load->view('purchaser/edit',$data);
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