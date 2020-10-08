<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('payment_model');
		$this->load->model('log_model');
		$this->load->model('receipt_model');
		$this->load->model('branch_model');

		if ( ! $this->session->userdata('loggedin'))
        {
            redirect('auth/login');
        }
	}
	public function index(){
		$data['data'] = $this->payment_model->getPayment();
		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('payment/list',$data);
	}
	public function add(){
		$data['invoice'] = $this->payment_model->getReceipt();
		$data['branch'] = $this->branch_model->getBranch();
		$data['p_reference_no'] = $this->receipt_model->generateReferenceNo();
		$this->load->view('payment/add',$data);
	}
	/*

	*/
	public function getAmount($id){
		$data = $this->payment_model->getAmount($id);
		echo json_encode($data);
	}
}
