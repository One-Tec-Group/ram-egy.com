<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pieces_alert extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('pieces_alert_model');
		$this->load->model('log_model');

		if ( ! $this->session->userdata('loggedin'))
        {
            redirect('auth/login');
        }
	}
	public function index(){
		$data['data'] = $this->pieces_alert_model->getPiecesAlert();
		$this->load->view('pieces_alert/list',$data);
	}

	public function create_pdf(){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => 0,
				'message'  => 'Pieces Alert PDF Generated'
			);
		$this->log_model->insert_log($log_data);
		ob_start();
		$html = ob_get_clean();
		$html = utf8_encode($html);

		$data['data'] = $this->pieces_alert_model->getPiecesAlert();
		$this->load->view('pieces_alert/list',$data);
		$html = $this->load->view('pieces_alert/pdf',$data,true);

		include(APPPATH.'third_party/mpdf/mpdf.php');
        $mpdf = new mPDF();
        $mpdf->allow_charset_conversion = true;
        $mpdf->charset_in = 'UTF-8';
        $mpdf->WriteHTML($html);
        $mpdf->Output('alert_quantity.pdf','I');
	}
	public function create_csv(){
		$log_data = array(
				'user_id'  => $this->session->userdata('user_id'),
				'table_id' => 0,
				'message'  => 'Pieces Alert CSV Generated'
			);
		$this->log_model->insert_log($log_data);
		ob_start();
		$this->load->dbutil();
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "pieces_alert.csv";
        $result = $this->pieces_alert_model->getCsvData();
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
	}
}
?>
