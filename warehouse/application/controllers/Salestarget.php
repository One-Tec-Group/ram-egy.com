<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Salestarget extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('sales_model');
		$this->load->model('customer_model');
		$this->load->model('purchase_model');
		$this->load->model('biller_model');
		$this->load->model('receipt_model');
		$this->load->model('credit_debit_note_model');
		$this->load->model('log_model');
		$this->load->model('ion_auth_model');
		$this->load->model('sms_setting_model');
		$this->load->helper('sms_helper');
	}
	public function index(){
		// get all sales to display list
		// $data['data'] = $this->sales_model->getSales();
		// $data['billers'] = $this->biller_model->getBillers();

		// echo '<pre>';
		// print_r($data);
		// exit;
		$this->load->view('salestarget/index');
	} 
	
}
?>