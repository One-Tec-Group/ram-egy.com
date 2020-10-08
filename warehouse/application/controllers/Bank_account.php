<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Bank_account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','ion_auth'));
		$this->load->model('bank_account_model');
		$this->load->model('log_model');

		$this->load->model('ledger_model');

		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	/*
		View list of Bank Account data
	*/
	public function index()
	{
		$data['data'] = $this->bank_account_model->getBankAccount();
		$this->load->view('bank_account/list',$data);
	}

	/*
		View Add new account bank form
	*/
	public function add()
	{
		$this->load->view('bank_account/add');	
	}

	/*
		Add new bank account
	*/
	public function addBankAccount()
	{
			
		$this->form_validation->set_rules('account_name','Account Name','trim|required');
		$this->form_validation->set_rules('type','Account Type','trim|required');
		$this->form_validation->set_rules('account_number','Account Number','trim|required');
		$this->form_validation->set_rules('bank_name','Bank Name','trim|required');
		$this->form_validation->set_rules('balance','Opening Balance','trim|required');
		$this->form_validation->set_rules('address','Bank Address','trim|required');
		
		if($this->form_validation->run()==FALSE){

			$this->add();
		}
		else
		{
			$ledger_data = array(
					'title' 			=> strtoupper($this->input->post('bank_name')),
					'opening_balance'   => $this->input->post('balance'),
					'closing_balance'   => $this->input->post('balance'),
					'accountgroup_id' 	=> 1
			);
			$ledger_id = $this->ledger_model->addLedger($ledger_data);
			$data = array(
							'account_name'=>$this->input->post('account_name'),					
							'account_type'=>$this->input->post('type'),
							'account_no'=>$this->input->post('account_number'),
							'bank_name'=>$this->input->post('bank_name'),
							'bank_address'=>$this->input->post('address'),
							'opening_balance'=>$this->input->post('balance'),
							'default_account'=>$this->input->post('default'),
							'ledger_id'=> $ledger_id
						);
			if($id = $this->bank_account_model->addModel($data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Bank Account Inserted'
					);
				$this->log_model->insert_log($log_data);
				
				$this->session->set_flashdata('success', 'Bank Account Add successfully.');
	           	redirect("bank_account",'refresh');
			}
			else
			{
				$this->session->set_flashdata('success', 'Bank Account Add Failed.');
	           	redirect("bank_account",'refresh');
			}
		}
	}

	/*
		View edit form with data
	*/
	public function edit($id){
		$data['data']=$this->bank_account_model->getRecord($id);
		$this->load->view('bank_account/edit',$data);	
	}

	/*
		Update bank account data
	*/
	public function editBankAccount()
	{
		$id = $this->input->post('id');
		$this->form_validation->set_rules('account_name','Account Name','trim|required');
		$this->form_validation->set_rules('type','Account Type','trim|required');
		$this->form_validation->set_rules('account_number','Account Number','trim|required');
		$this->form_validation->set_rules('bank_name','Bank Name','trim|required');
		$this->form_validation->set_rules('balance','Opening Balance','trim|required');
		$this->form_validation->set_rules('address','Bank Address','trim|required');
		
		if($this->form_validation->run()==FALSE){

			$this->edit($id);
		}
		else
		{
			$data = array(
							'account_name'=>$this->input->post('account_name'),					
							'account_type'=>$this->input->post('type'),
							'account_no'=>$this->input->post('account_number'),
							'bank_name'=>$this->input->post('bank_name'),
							'bank_address'=>$this->input->post('address'),
							'opening_balance'=>$this->input->post('balance'),
							'default_account'=>$this->input->post('default')
						);

			if($this->bank_account_model->editBankAccount($id,$data)){
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Bank Account Updated'
					);
				$this->log_model->insert_log($log_data);
				$this->session->set_flashdata('success', 'Bank Account Updated successfully.');
	           	redirect("bank_account",'refresh');
			}
			else
			{
				$this->session->set_flashdata('success', 'Bank Account Updated Failed.');
	           	redirect("bank_account",'refresh');
			}
		}
	}


	/*
		Delete bank account data delete_status=1
	*/
	public function delete($id)
	{
       if($this->bank_account_model->delete($id))
       {     	
       		$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Bank Account Deleted'
				);
			$this->log_model->insert_log($log_data);
           	$this->session->set_flashdata('success', 'Bank Account Deleted successfully.');
           	redirect("bank_account",'refresh');
	   }
	   else
		{
			$this->session->set_flashdata('success', 'Failed to delete Record.');
            redirect("bank_account",'refresh');	
		}	
	}
}