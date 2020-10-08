<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Payment_model extends CI_Model
{
	public function getPayment(){

		return $this->db->select('th.*,ar.invoice_no,ar.purchase_id')
						 ->from('transaction_header th')
						 ->join('account_receipts ar','ar.receipt_voucher_no = th.receipt_id','left')
						 ->where('th.type','P')
						 ->get()
						 ->result();
	}
	/*

	*/
	public function getReceipt(){
		return $this->db->get('account_receipts')->result();
	}
	/*
		return invoice total
	*/
	public function getAmount($id){
		return $this->db->select('ar.*,su.supplier_name,(ar.receipt_amount-ar.paid_amount) as amount')
						->from('account_receipts ar')
						->join('purchases p','p.purchase_id = ar.purchase_id')
						->join('suppliers su','su.supplier_id = p.supplier_id')
						->where('ar.receipt_voucher_no',$id)
						->get()
						->row();
	}
}
