<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_setup extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('email_setup_model');
		$this->load->model('log_model');
		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){
		$data['data'] = $this->email_setup_model->getEmailSetup();
		$this->load->view('email_setup/add',$data);
	}
	public function add(){

		$data = array(
				'email_protocol' => $this->input->post('email_protocol'),
				'email_encription' => $this->input->post('email_encription'),
				'smtp_host' => $this->input->post('smtp_host'),
				'smtp_port' => $this->input->post('smtp_port'),
				'smtp_email' => $this->input->post('smtp_email'),
				'from_address' => $this->input->post('from_address'),
				'from_name' => $this->input->post('from_name'),
				'smtp_username' => $this->input->post('smtp_username'),
				'smtp_password' => $this->input->post('smtp_password')
			);

		if($this->email_setup_model->add($data)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => 0,
					'message'  => 'Email Setup Updated'
				);
			$this->log_model->insert_log($log_data);
			$this->session->set_flashdata('fail', 'Email Setup Successfully Updated.');
			redirect('email_setup','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Error in Update Email Setup.');
			redirect('email_setup','refresh');
		}
	}
}
?>