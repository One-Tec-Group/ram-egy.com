<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Credit_debit_note extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('credit_debit_note_model');
		$this->load->model('log_model');
		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
	}
	public function index(){
		$data['data'] = $this->credit_debit_note_model->getData();
		$this->load->view('credit_debit_note/list',$data);
	}
	public function add(){
		$data['invoice'] = $this->credit_debit_note_model->getInvoice();
/*		echo "<pre>";
		print_r($data);
		exit;*/
		$this->load->view('credit_debit_note/add',$data);
	}
	public function addCreditDebitNote(){
		$this->form_validation->set_rules('invoice', 'Invoice', 'trim|required');
		$this->form_validation->set_rules('r_v_no', 'Note/Refund Voucher Number', 'trim|required');
		$this->form_validation->set_rules('r_v_date', 'Note/Refund Voucher Value', 'trim|required');
		$this->form_validation->set_rules('r_v_value', 'Note/Refund Voucher Value', 'trim|required');
		$this->form_validation->set_rules('document', 'Document Type', 'trim|required');
		$this->form_validation->set_rules('reason', 'Reason for Issue Document', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
        	$data = array(
					"invoice_id"=>$this->input->post('invoice'),
					"note_or_refund_voucher_no"=>$this->input->post('r_v_no'),
					"note_or_refund_voucher_date"=>$this->input->post('r_v_date'),
					"note_or_refund_voucher_value"=>$this->input->post('r_v_value'),
					"document_type"=>$this->input->post('document'),
					"reason_for_issue_document"=>$this->input->post('reason'),
					"pre_gst"=>$this->input->post('pre_gst')
				);
			if($id = $this->credit_debit_note_model->addModel($data)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Credit/Debit Note Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('credit_debit_note','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Credit/Debit Note can not be Inserted.');
				redirect("credit_debit_note",'refresh');
			}
        }
	}
	public function edit($id){
		$data['invoice'] = $this->credit_debit_note_model->getInvoice();
		$data['data'] = $this->credit_debit_note_model->getRecord($id);
		$this->load->view('credit_debit_note/edit',$data);
	}
	public function editCreditDebitNote(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('invoice', 'Invoice', 'trim|required');
		$this->form_validation->set_rules('r_v_no', 'Note/Refund Voucher Number', 'trim|required');
		$this->form_validation->set_rules('r_v_date', 'Note/Refund Voucher Value', 'trim|required');
		$this->form_validation->set_rules('r_v_value', 'Note/Refund Voucher Value', 'trim|required');
		$this->form_validation->set_rules('document', 'Document Type', 'trim|required');
		$this->form_validation->set_rules('reason', 'Reason for Issue Document', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {
        	$data = array(
					"invoice_id"=>$this->input->post('invoice'),
					"note_or_refund_voucher_no"=>$this->input->post('r_v_no'),
					"note_or_refund_voucher_date"=>$this->input->post('r_v_date'),
					"note_or_refund_voucher_value"=>$this->input->post('r_v_value'),
					"document_type"=>$this->input->post('document'),
					"reason_for_issue_document"=>$this->input->post('reason'),
					"pre_gst"=>$this->input->post('pre_gst')
				);
			if($this->credit_debit_note_model->editModel($id,$data)){ 
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Credit/Debit Note Updated'
					);
				$this->log_model->insert_log($log_data);
				redirect('credit_debit_note','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Credit/Debit Note can not be Update.');
				redirect("credit_debit_note",'refresh');
			}
        }
	}
	/* 
		Delete selected  Category Record 
	*/
	public function delete($id){
		if($this->credit_debit_note_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Credit/Debit Note Deleted'
				);
			$this->log_model->insert_log($log_data);
			redirect("credit_debit_note",'refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Credit/Debit Note can not be Deleted.');
			redirect("credit_debit_note",'refresh');
		}
	}
}
?>