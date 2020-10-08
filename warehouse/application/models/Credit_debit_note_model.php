<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Credit_debit_note_model extends CI_Model
{
	public function getData(){
		return $this->db->select('cd.*,i.invoice_no')
						->from('credit_debit_note cd')
						->join('invoice i','i.id = cd.invoice_id')
						->where('cd.delete_status',0)
						->get()
						->result();
	}
	public function getInvoice(){
		return $this->db->select('i.*')
					    ->from('invoice i')
					    ->join('sales s','s.sales_id = i.sales_id')
					    ->where('s.delete_status',0)
					    ->get()
					    ->result();
	}
	/* 
		insert new  record in Database 
	*/
	public function addModel($data){
		if($this->db->insert('credit_debit_note',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/*

	*/
	public function getRecord($id){
		return $this->db->get_where('credit_debit_note',array('id'=>$id))->row();
	}
	/*

	*/
	public function editModel($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('credit_debit_note',$data);
	}
	/* 
		this function delete category from database  
	*/
	public function deleteModel($id){	
		$this->db->where('id',$id);
		if($this->db->update('credit_debit_note',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>