<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Statement extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('statement_model');
		$this->load->model('customer_model');
		$this->load->model('purchase_model');
		$this->load->model('log_model');
	}
	public function index(){
		//$data['data'] = $this->statement_model->getStatement();
		$data['customers'] = $this->customer_model->getCustomer();
		$data['company'] = $this->purchase_model->getCompany();
		$this->load->view('statement/list',$data);
	}
	public function getStatements(){
		$this->form_validation->set_rules('year','Year','trim|required|numeric');
		$this->form_validation->set_rules('customer','Customer','trim|required|numeric');
		if($this->form_validation->run()==FALSE){
			$this->index();
		}
		else{
			$year = $this->input->post('year');
			$customer = $this->input->post('customer');
			$data['year'] = $year;
			$data['data'] = $this->statement_model->getStatementData($year,$customer);
			$data['invoice_data'] = $this->statement_model->getInvoiceData($year,$customer);
			$data['invoice_delete_data'] = $this->statement_model->getInvoiceDeleteData($year,$customer);
			/*echo "<pre>";
			print_r($data['data']);
			exit;*/
			$data['payment_data'] = $this->statement_model->getPaymentData($year,$customer);
			$data['credit_note'] = $this->statement_model->getCreditNoteData($year,$customer);
			$data['customers'] = $this->customer_model->getCustomer();
			$data['customer_data'] = $this->customer_model->getCustomerData($customer);
			$data['company'] = $this->purchase_model->getCompany();
			/*echo "<pre>";
			print_r($data['credit_note']);
			exit;*/
			$this->load->view('statement/list',$data);
		}
	} 
}