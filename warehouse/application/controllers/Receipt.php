<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('receipt_model');
        $this->load->model('purchase_model');
        $this->load->model('biller_model');
        $this->load->model('branch_model');
        $this->load->model('log_model');
        $this->load->model('customer_model');
        $this->load->model('supplier_model');
        $this->load->model('ion_auth_model');
        $this->load->model('sales_model');
        $this->load->model('sms_setting_model');
        $this->load->model('ledger_model');
        $this->load->model('payment_method_model');
        $this->load->helper('sms_helper');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if (!$this->session->userdata('loggedin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['data'] = $this->receipt_model->getReceipt();
        $this->load->view('receipt/list', $data);
    }

    public function add() {
        $data['ledger'] = $this->receipt_model->getLedger();
        $data['invoice'] = $this->receipt_model->getInvoice();
        $data['company'] = $this->purchase_model->getCompany();
        $data['branch'] = $this->branch_model->getBranch();
        $data['payment_method'] = $this->payment_method_model->payUserData();
        $data['p_reference_no'] = $this->receipt_model->generateReferenceNo();
        $this->load->view('receipt/add', $data);
    }

    public function getAccount($id) {
        $data = $this->receipt_model->getAccount($id);
        echo json_encode($data);
    }

    public function getAmount($id) {
        $data = $this->receipt_model->getAmount($id);
        echo json_encode($data);
    }

    public function getAccountGroupID($id) {
        echo $this->receipt_model->getAccountGroupID($id);
    }

    public function addReceipt() {
        $id = $this->input->post('id');
        $paying_by = $this->input->post('paying_by');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('reference_no', 'Reference No', 'trim|required');
        $this->form_validation->set_rules('branch', 'Branch', 'trim|required');
        $this->form_validation->set_rules('from_ac', 'From A/C', 'trim');
        $this->form_validation->set_rules('to_ac', 'To A/C', 'trim');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('paying_by', 'Paying By', 'trim|required');
        if ($paying_by == "Cheque") {
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|callback_alpha_dash_space');
            $this->form_validation->set_rules('cheque_no', 'Cheque No', 'trim|required|numeric');
            $this->form_validation->set_rules('cheque_date', 'Cheque Date', 'trim|required');
        }
        if ($this->form_validation->run() == false) {
            $this->add();
        } else {
            $invoice = $this->input->post('invoice');
            $amount = $this->input->post('amount');
            $sms_setting = $this->sms_setting_model->getSmsSetting();
            $company_name = $this->db->get('company_settings')->row()->name;
            $company_phone = $this->db->get('company_settings')->row()->phone;
            if ($this->input->post('cheque_date') == '') {
                $cheque_date = null;
            } else {
                $cheque_date = $this->input->post('cheque_date');
            }
            $data = array(
                "transaction_date" => date('Y-m-d'),
                "type" => $this->input->post('type'),
                "amount" => $amount,
                "voucher_no" => $this->input->post('reference_no'),
                "voucher_date" => $this->input->post('date'),
                "mode" => $this->input->post('paying_by'),
                "cheque_no" => $this->input->post('cheque_no'),
                "cheque_date" => $cheque_date,
                "bank_name" => $this->input->post('bank_name'),
                "from_account" => $this->input->post('from_ac'),
                "to_account" => $this->input->post('to_ac'),
                "narration" => $this->input->post('description'),
                "voucher_status" => 1
            );
            if ($this->input->post('type') == 'P') {
                $data['receipt_id'] = $invoice;
                $data['invoice_id'] = null;
            } else if ($this->input->post('type') == 'R') {
                $data['invoice_id'] = $invoice;
                $data['receipt_id'] = null;
            }
            if ($this->input->post('type') == "R") {
                if ($id = $this->receipt_model->addReceipt($data)) {
                    $log_data = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'table_id' => $id,
                        'message' => 'Receipt Generated'
                    );
                    $this->log_model->insert_log($log_data);
                    $from_user = $this->getLedgerUserDetails($this->input->post('from_ac'));
                    if ($from_user[0] == 2) {
                        $mobile = $company_phone;
                    } else {
                        $mobile = $from_user[1];
                    }
                    $message = "We have received your payment of " . $amount . " .Thank you visting our store. " . $company_name;
                    $response = send_sms($sms_setting, $mobile, $message);
                    $sms_history_data = array(
                        'mobile' => $mobile,
                        'message' => $message,
                        'response' => $response
                    );
                    $this->sms_setting_model->addSmsHistroy($sms_history_data);
                    redirect('receipt', 'refresh');
                } else {
                    redirect("receipt", 'refresh');
                }
            } else {
                if ($id = $this->receipt_model->addReceipt($data)) {
										$pData = array(
			                "payment_amount" => $amount,
			                "branch_id" => $this->input->post('branch'),
			                "invoice_no" => $this->input->post('invoice'),
			                "payment_voucher_date" => $this->input->post('date'),
			                "mode_of_payment" => $this->input->post('paying_by'),
			                "cheque_no" => $this->input->post('cheque_no'),
			                "bank_name" => $this->input->post('bank_name'),
			                "description" => $this->input->post('description'),
										);
										$this->db->insert("account_payments", $pData);
										$log_data = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'table_id' => $id,
                        'message' => 'Payment Completed'
                    );
                    $this->log_model->insert_log($log_data);
                    $to_user = $this->getLedgerUserDetails($this->input->post('to_ac'));
                    if ($to_user[0] == 2) {
                        $message = "We have made your payment of " . $amount . " .Thank you for doing business with us. " . $company_name;
                        $mobile = $company_phone;
                    } else {
                        $message = "We have made your payment of " . $amount . " .Thank you for doing business with us. " . $company_name;
                        $mobile = $to_user[1];
                    }
                    $response = send_sms($sms_setting, $mobile, $message);
                    $sms_history_data = array(
                        'mobile' => $mobile,
                        'message' => $message,
                        'response' => $response
                    );
                    $this->sms_setting_model->addSmsHistroy($sms_history_data);
                    redirect('payment', 'refresh');
                } else {
                    redirect("payment", 'refresh');
                }
            }
        }
    }
    public function edit($id) {
        $data['data'] = $this->category_model->getRecord($id);
        $this->load->view('category/edit', $data);
    }

    public function editCategory() {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = array(
                "category_name" => $this->input->post('category_name')
            );
            if ($this->category_model->editModel($data, $id)) {
                $log_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'table_id' => $id,
                    'message' => 'Category Updated'
                );
                $this->log_model->insert_log($log_data);
                redirect('category', 'refresh');
            } else {
                $this->session->set_flashdata('fail', 'Category can not be Updated.');
                redirect("category", 'refresh');
            }
        }
    }

    public function delete($id) {
        if ($this->category_model->deleteModel($id)) {
            $log_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'table_id' => $id,
                'message' => 'Category Deleted'
            );
            $this->log_model->insert_log($log_data);
            redirect('category');
        } else {
            $this->session->set_flashdata('fail', 'Category can not be Deleted.');
            redirect("category", 'refresh');
        }
    }

    public function getLedgerUserDetails($ledger_id) {
        $user = array();
        if ($biller_id = $this->ledger_model->getBillerLedgerDetail($ledger_id)) {
            $user[] = 0;
            $user[] = $this->biller_model->getRecord($biller_id)->mobile;
            $user[] = $this->biller_model->getRecord($biller_id)->biller_name;
            $user[] = $biller_id;
        } else if ($customer_id = $this->ledger_model->getCustomerLedgerDetails($ledger_id)) {
            $user[] = 1;
            $user[] = $this->customer_model->getCustomerRecord($customer_id)->mobile;
            $user[] = $this->customer_model->getCustomerRecord($customer_id)->customer_name;
            $user[] = $customer_id;
        } else if ($this->ledger_model->getBankLedgerDetails($ledger_id)) {
            $user[] = 2;
        } else if ($user_id = $this->ledger_model->getPurchaserLedgerDetails($ledger_id)) {
            $user[] = 3;
            $user[] = $this->ion_auth_model->user($user_id)->phone;
            $user[] = $this->ion_auth_model->user($user_id)->first_name . " " . $this->ion_auth_model->user($user_id)->last_name;
            $user[] = $user_id;
        } else if ($supplier_id = $this->ledger_model->getSuppliersLedgerDetails($ledger_id)) {
            $user[] = 4;
            $user[] = $this->supplier_model->getSupplierRecord($supplier_id)->mobile;
            $user[] = $this->supplier_model->getSupplierRecord($supplier_id)->supplier_name;
            $user[] = $supplier_id;
        }
        return $user;
    }

    function alpha_dash_space($str) {
        if (!preg_match("/^([-a-zA-Z ])+$/i", $str)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha, spaces and dashes.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

?>
