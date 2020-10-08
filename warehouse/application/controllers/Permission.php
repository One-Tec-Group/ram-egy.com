<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','ion_auth'));
        $this->load->model('permission_model');
	}
	public function index(){

		$data['group']	=	$this->permission_model->getGroup();
		/*echo "<pre>";
		print_r($data);
		exit();*/
		$this->load->view('permission/list_group',$data);
	}

	/*
		display User group page
	*/
	public function add_group()
	{
		$data['permission'] = $this->permission_model->getPermission();
		//$data['group'] = $this->permission_model->getAdmin();
		/*echo "<pre>";
		print_r($data);exit();*/
		$this->load->view('permission/new_group',$data);
	}


	/*
		Add new user group
	*/
	function add()
	{
		$this->form_validation->set_rules('rolename','Role Name','required');
		$this->form_validation->set_rules('description','Description','required');

		$permission = $this->input->post('permission');	

		if($this->form_validation->run() == true)
		{
			$data['name']=$this->input->post('rolename');
			$data['description']=$this->input->post('description');

			$role_id = $this->permission_model->addRole($data);

			$permission_role=array();
			if(isset($role_id)){
				$i=0;
				
				foreach ($permission as $value) {
					$permission_role[$i]=array(
						'permission_id' => $value,
						'role_id'       => $role_id
					);
					$i++;
				}			
			}
			else
			{
				$this->session->set_flashdata('fail', 'Failed to add new group.');
	        	redirect("permission",'refresh');
			}

			$this->permission_model->addPermissionRole($permission_role);
			redirect('permission','referesh');
		}
	}

	/*
		load edit group data
	*/
	function edit_group($id)
	{
		$name = $this->permission_model->isAdmin($id);
		
		if(isset($name))
		{
			if($name == "admin")
			{
				redirect("permission","refresh");
			}
		}

		$data['role']=$this->permission_model->getRole($id);
		$data['roles']=$this->permission_model->getRoles($id);
		$data['permission'] = $this->permission_model->getPermission();

		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('permission/edit_group',$data);
	}

	/*
		update users group data
	*/
	function edit()
	{
		$id=$this->input->post('role_id');
		$this->form_validation->set_rules('rolename','Role Name','required');
		$this->form_validation->set_rules('description','Description','required');

		$permission = $this->input->post('permission');	
		$database_id = "";
		$form_id = "";

		$data= $this->permission_model->getPermissionRole($id);

		foreach ($data as $value) {
			$database_id .= $value->permission_id.',';
		}
		foreach ($permission as $value) {
			$form_id.= $value.',';
		}

		if($this->form_validation->run() == true)
		{
			$group_data['name']=$this->input->post('rolename');
			$group_data['description']=$this->input->post('description');
			$group_data['id']=$id;

			if($this->permission_model->updateRole($group_data))
			{
				if($form_id == $database_id){
					redirect('Permission','referesh');	
				}
				else{
					$permission_role=array();
					if(isset($id)){
						$i=0;
						
						foreach ($permission as $value) {
							$permission_role[$i]=array(
								'permission_id' => $value,
								'role_id'       => $id
							);
							$i++;
						}			
					}
					if($this->permission_model->deletePermissionRole($id))
					{
						$this->permission_model->addPermissionRole($permission_role);	
						redirect('permission','referesh');
					}
				}	
			}
		}
	}
	
	/*
		This method is call when quotation data is deleted.
	*/

	function delete($id)
	{
		if(!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
		
		$data=array(
			'delete_status' => 1,
			'delete_date' => date('Y-m-d'),
			'id' => $id
		);

		if($this->permission_model->deleteRoles($data))
		{
			if($this->permission_model->deletePermissionRole($id)){
				$this->session->set_flashdata('success', 'Roles Deleted successfully.');
	            redirect("permission",'refresh');
        	}
		}
		else{
			$this->session->set_flashdata('fail', 'Failed to Deleted Roles.');
	        redirect("permission",'refresh');
		}
	}
}