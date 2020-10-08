<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Biller extends CI_Controller
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
		
	}
	public function index(){

		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();

		if($data['user_group'][0]->name == "admin"){
			
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

		}else{

			$data['customer'] = $this->biller_model->getCustomer();	
			/*echo '<pre>';
			print_r($data['customer']);
			exit;*/
			$this->load->view('biller/customer_list',$data);

		}
		
		/*echo '<pre>';
		print_r($data);
		exit;*/

		
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
		
		//$data['branch']= $this->biller_model->getBranch(); 
		$data['warehouse'] = $this->purchaser_model->getWarehouse();
		$data['country']  = $this->biller_model->getCountry();
		/*echo '<pre>';
		print_r($data);
		exit;*/
		$this->load->view('biller/add',$data);
	}
	public function accountant(){
		$this->load->view('biller/accountant');
	}
	
	/* 
		Add New Biller in database 
	*/
	public function addBiller(){ 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('biller_name','Biller Name','trim|required|min_length[3]');
		//$this->form_validation->set_rules('gstid', 'GSTID', 'trim|required');
		$this->form_validation->set_rules('warehouse','Warehouse','trim|required');
		$this->form_validation->set_rules('company_name','Company Name','trim|required|min_length[3]');
		$this->form_validation->set_rules('address','Address','required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country','Country','trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		/*$this->form_validation->set_rules('fax','Fax','trim|required|numeric|callback_fax');*/
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
		//$this->form_validation->set_rules('telephone','Telephone','trim|required|numeric|callback_tel');
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
			// echo '<pre>';
			// print_r($ledger_data);
			
			$ledger_id = $this->ledger_model->addLedger($ledger_data);
			// echo '<pre>';
			// print_r($ledger_data);
			// echo $ledger_id;
			// exit;

			$password=$this->input->post('password');
				$options = array(
				    		'cost' => 12,
							);
		 	$password =	password_hash($password, PASSWORD_BCRYPT, $options);
			$users = array(
						"username"			=>  $this->input->post('email'),
						"password"   		=>  $password,	
						"email"				=>  $this->input->post('email'),			
						'api_key'    		=> 	md5(uniqid(rand(), true)),
						'active'			=> 	1,
						'first_name'		=>  $this->input->post('biller_name'),	
					);
			
			if($id = $this->biller_model->addUsers($users)){

				$users_groups = array(
							"user_id"		=>  $id,
							"group_id"  	=>  3,												
							);

				$this->biller_model->addUsers_groups($users_groups);

				$warehouse_id = $this->input->post('warehouse');
				$branch_id = $this->biller_model->getBranchIdFromWarehouse($warehouse_id);


					$data = array(
						"branch_id"     =>  $branch_id,
						"warehouse_id"  =>  $warehouse_id,
						"user_id"     	=>  $id,
						"biller_name"   =>  $this->input->post('biller_name'),
						"company_name"  =>  $this->input->post('company_name'),
						"address"       =>  $this->input->post('address'),
						"city_id"		=>  $this->input->post('city'),
						"state_id"		=>  $this->input->post('state'),
						"state_code"	=>  $this->input->post('state_code'),
						"country_id"	=>  $this->input->post('country'),
						"zipcode"		=>  $this->input->post('zipcode'),
						"fax"			=>  $this->input->post('fax'),
						"mobile"		=>  $this->input->post('mobile'),
						"email"			=>  $this->input->post('email'),
						"telephone"		=>  $this->input->post('telephone'),
						"ledger_id"		=>  $ledger_id,
						"gstid"			=>  $this->input->post('gstid')
					);
					
					
					$warehouse_management = array(
							"user_id"     	=>  $id,
							"warehouse_id"  =>  $warehouse_id
						);
					if(($biller_id = $this->biller_model->addModel($data)) && $warehouse_assignment_id = $this->assign_warehouse_model->assignWarehouse($warehouse_management))
					{
						$log_data = array(
								'user_id'  => $this->session->userdata('user_id'),
								'table_id' => $biller_id,
								'message'  => 'Biller Inserted'
							);
						$this->log_model->insert_log($log_data);
						$this->session->set_flashdata('success', 'Biller Successfully Inserted.'); 
						redirect('biller','refresh');
					}
					else{
						$this->session->set_flashdata('fail', 'Biller can not be Inserted.');				
						redirect("biller",'refresh');
					}
			}
			// else{
			// 	$error = $this->db->error();
			// 	if ($error['code'] == 1062) {

			// 		$biller_id = $this->biller_model->getRecordByEmail($this->input->post('email'))->biller_id;

			// 		$this->session->set_flashdata('fail', '"'.$name.'" is already exist. please <a href="'.base_url().'/biller/edit/"'.$biller_id);
			// 		redirect("biller",'refresh');

			// 	}
			// }			
			
		}
	}
	

	/* 
		call view editr Biller 
	*/
	public function edit($id){ 

		$data['biller'] = $this->biller_model->getRecord($id);
		$data['country']  = $this->biller_model->getCountry();
		$data['state'] = $this->biller_model->getState($data['biller'][0]->country_id);
		$data['city'] = $this->biller_model->getCity($data['biller'][0]->state_id);
		$data['warehouse'] = $this->purchaser_model->getWarehouse();
		
		
		$data['user_warehouse'] = $this->db->select('wm.warehouse_id,w.warehouse_name,b.branch_name as branch_name')
										   ->from('users u')
										   ->join('warehouse_management wm','wm.user_id = u.id')
										   ->join('warehouse w','w.warehouse_id = wm.warehouse_id')
										   ->join('branch b','b.branch_id = w.branch_id')
										   ->where('wm.user_id',$data['biller'][0]->user_id)
										   ->get()
										   ->result();
        //echo $this->db->last_query();								
	/*	
 		echo '<pre>';
		print_r($data);
		exit;*/
		//get Branch Name and Id
		/*$data['branch'] =  $this->biller_model->getBranch();*/

		//$data['users'] =  $this->biller_model->getUsers_data($id);
		// get Biller record in database.
		$this->load->view('biller/edit',$data);
	}
	/*  
		Edit Biller in Database  
	*/
	public function editBiller(){ 
		$this->load->library('form_validation');
		//$id = $this->input->post('id');
		$biller_id = $this->input->post('biller_id');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('biller_name','Biller Name','trim|required|min_length[3]');
		
		//$this->form_validation->set_rules('branch','Branch','trim|required');
		$this->form_validation->set_rules('company_name','Company Name','trim|required|min_length[3]|callback_alpha_dash_space');
		$this->form_validation->set_rules('address','Address','required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country','Country','trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		//$this->form_validation->set_rules('warhouse','Warhouse','trim|required');
		/*$this->form_validation->set_rules('fax','Fax','trim|required|numeric|callback_fax');*/
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('telephone','Telephone','trim|required|numeric');

		

		if($this->form_validation->run()==false){

			$this->edit($biller_id);
		}
		else
		{
			$u_id = $this->input->post('u_id');
			
			$password=$this->input->post('password');
			if($password !=null) 
			{
				$options = array( 'cost' => 12, );						
				//print_r($options);
				$password =password_hash($password, PASSWORD_BCRYPT, $options);			 
				/*print_r($password);
				exit();*/
				$users = array(
					"username"			=>  $this->input->post('email'),
					"password"   		=>  $password,
					"email"				=>  $this->input->post('email'),
					'first_name'		=>  $this->input->post('biller_name'),					
				);
			}
			else{
				$users = array(
					"username"			=>  $this->input->post('email'),						
					"email"				=>  $this->input->post('email'),
					'first_name'		=>  $this->input->post('biller_name'),					
				);				
			}			
			$this->biller_model->editUser($users,$u_id);

			$warehouse_id = $this->input->post('warehouse');
			$current_warehouse_id = $this->input->post('current_warehouse'); 
			$data = array();
			if($warehouse_id!=null){

				//echo $warehouse_id;
				
				$branch_id = $this->biller_model->getBranchIdFromWarehouse($warehouse_id);

				// echo $branch_id[0]->branch_id;
				// exit;
				$data = array(
							"warehouse_id"	=>	$warehouse_id,
							"branch_id"		=>  $branch_id,
							"biller_name"	=>	$this->input->post('biller_name'),
							"company_name"	=>	$this->input->post('company_name'),
							"address"		=>	$this->input->post('address'),
							"city_id"		=>	$this->input->post('city'),
							"state_id"		=>	$this->input->post('state'),
							"state_code"	=>	$this->input->post('state_code'),
							"country_id"	=>	$this->input->post('country'),
							"zipcode"		=>  $this->input->post('zipcode'),
							"fax"			=>	$this->input->post('fax'),
							"mobile"		=>	$this->input->post('mobile'),
							"email"			=>	$this->input->post('email'),
							"telephone"		=>	$this->input->post('telephone'),
							"gstid"			=>	$this->input->post('gstid'),
						);
				// echo '<pre>';
				// print_r($data);
				//exit;
			}else{
				$branch_id = $this->biller_model->getBranchIdFromWarehouse($current_warehouse_id);
				$data = array(
							"warehouse_id"	=>	$current_warehouse_id,
							"branch_id"		=>  $branch_id[0]->branch_id,
							"biller_name"	=>	$this->input->post('biller_name'),
							"company_name"	=>	$this->input->post('company_name'),
							"address"		=>	$this->input->post('address'),
							"city_id"		=>	$this->input->post('city'),
							"state_id"		=>	$this->input->post('state'),
							"state_code"	=>	$this->input->post('state_code'),
							"country_id"	=>	$this->input->post('country'),
							"fax"			=>	$this->input->post('fax'),
							"mobile"		=>	$this->input->post('mobile'),
							"email"			=>	$this->input->post('email'),
							"telephone"		=>	$this->input->post('telephone'),
							"gstid"			=>	$this->input->post('gstid')
						);
				// echo '<pre>';
				// print_r($data);
				
			}
			
			if($this->biller_model->editModel($data,$biller_id)){

				$assigned_warehouse_update = array();
				if($warehouse_id !=''){

					$assign_warehouse_update = array(
						"warehouse_id"  =>  $warehouse_id,
						"user_id"		=>  $u_id
					);

					/*echo '<pre>assign_warehouse_update 1';
					print_r($assign_warehouse_update);
					exit;*/

				}else{
					$assign_warehouse_update = array(
						"warehouse_id"  =>  $current_warehouse_id,
						"user_id"		=>  $u_id
					);

					/*echo '<pre>assign_warehouse_update';
					print_r($assign_warehouse_update);
					exit;*/
				}
				
				if($this->assign_warehouse_model->updateAssignWarehouse($assign_warehouse_update)){
					$log_data_warehouse_assign = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $biller_id,
							'message'  => 'Assign Warehouse Updated'
						);
					$log_data_biller = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $biller_id,
							'message'  => 'Biller Updated'
						);
					$this->log_model->insert_log($log_data_warehouse_assign);
					$this->log_model->insert_log($log_data_biller);
					//$this->session->set_flashdata('fail', 'Biller Updated Successfully.');
					//redirect('biller','refresh');
					
					$this->session->set_flashdata('success', 'Biller and Warehouse updated successfully.'); 			
					redirect('biller','refresh');
				}else{
					$this->session->set_flashdata('fail', 'Biler warehouse not updated.'); 			
					redirect('biller','refresh');
				}
				
				$this->session->set_flashdata('success', 'Biller Successfully Updated but Warehouse is not assigned to biller. Kindly check '); 
				redirect('biller','refresh');
				
			}

			
		}
	
	}

	/*
		
		return branch id from warehouse

	*/
	public function getBranchIdFromWarehouse($warehouse_id){

		return $this->biller_model->getBranchIdFromWarehouse($warehouse_id);
		
	}

	/*	
		return biller id from warehouse
	*/
	public function getBillerIdFromWarehouse($warehouse_id){

		return $this->biller_model->getBillerIdFromWarehouse($warehouse_id);

	}

	/*	
		return biller id from warehouse
	*/
	public function getBillerIdFromWarehouseAjax($warehouse_id){

		return $this->biller_model->getBillerIdFromWarehouse($warehouse_id);

	}

	/*	
		return biller id from biller
	*/
	public function getBillerStateIdFromBiller($biller_id){

		
		return $this->biller_model->getBillerStateIdFromBiller($biller_id);
		

	}

	/*	
		return biller id from users_id
	*/
	public function getBillerIdFromUser($user_id){
		//echo '<pre>';
		return $this->biller_model->getBillerIdFromUser($user_id);
		//exit;
	}

	/* 
		Delete Biller in Database 
	*/
	public function delete($id){

		$users = array(				
						'active' => 0			
					);
		if($this->biller_model->deleteUsers($users,$id)){
	
			$this->biller_model->deleteModel($id);
			$log_data = array(
							'user_id'  => $this->session->userdata('user_id'),
							'table_id' => $id,
							'message'  => 'Biller deleted'
						);
			$this->log_model->insert_log($log_data);
			$this->session->set_flashdata('fail', 'Biller deleted successfully.');
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