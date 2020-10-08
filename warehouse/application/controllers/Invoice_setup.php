<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_setup extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('invoice_setup_model');
		$this->load->model('log_model');
		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){
		$data['data'] = $this->invoice_setup_model->getInvoiceSetup();
		$this->load->view('invoice_setup/add',$data);
	}
	public function add(){

		if($this->invoice_setup_model->invoice_setup($this->input->post('id'))){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $this->input->post('id'),
					'message'  => 'Invoice Setup Updated'
				);
			$this->log_model->insert_log($log_data);
			$this->session->set_flashdata('fail', 'Invoice Setup Successfully Updated.');
			redirect('invoice_setup','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Error in Update Invoice Setup.');
			redirect('invoice_setup','refresh');
		}
	}
}
?>