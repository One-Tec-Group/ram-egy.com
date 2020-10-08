<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cash_flow extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('cash_flow_model');
		$this->load->model('log_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){
		$data['data'] = $this->cash_flow_model->getData();
		$this->load->view('cash_flow/list',$data);
	}
	/*

	*/
	public function getCashFlow(){
		$start_date =  $this->input->post('start_date');
		$end_date =  $this->input->post('end_date');
		if($this->input->post('submit') == "Submit"){
			$data['data'] = $this->cash_flow_model->getDataSort($start_date,$end_date);
			$this->load->view('cash_flow/list',$data);
		}
		else if($this->input->post('submit') == "PDF"){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => 0,
					'message'  => 'Cash Flow PDF Generated'
				);
			$this->log_model->insert_log($log_data);
			ob_start();
			$html = ob_get_clean();
			$html = utf8_encode($html);

			$data['data'] = $this->cash_flow_model->getDataSort($start_date,$end_date);
			$html = $this->load->view('cash_flow/cash_flow_pdf',$data,true);

			include(APPPATH.'third_party/mpdf60/mpdf.php');
	        $mpdf = new mPDF();
	        $mpdf->allow_charset_conversion = true;
	        $mpdf->charset_in = 'UTF-8';
	        $mpdf->WriteHTML($html);
	        $mpdf->Output('cash-flow.pdf','I');
		}
		else if($this->input->post('submit') == "CSV"){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => 0,
					'message'  => 'Cash Flow CSV Generated'
				);
			$this->log_model->insert_log($log_data);
			ob_start();
			$this->load->dbutil();
			$delimiter = ",";
	        $newline = "\r\n";
	        $filename = "cash-flow.csv";
			$data = $this->cash_flow_model->getDataCSV($start_date,$end_date);
			$data = $this->dbutil->csv_from_result($data, $delimiter, $newline);
        	force_download($filename, $data);
		}
		else{
			redirect('cash_flow','refresh');
		}
	} 
	
}
?>