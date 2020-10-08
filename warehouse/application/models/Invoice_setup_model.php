<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Invoice_setup_model extends CI_Model
{
	public function getInvoiceSetup(){
		return $this->db->get('multiple_invoice')->result();
	}
	public function invoice_setup($id){
		$this->db->update('multiple_invoice',array('active'=>0));
		$this->db->where('id',$id);
		return $this->db->update('multiple_invoice',array('active'=>1));
	}
}
?>