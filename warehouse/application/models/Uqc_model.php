<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Uqc_model extends CI_Model
{
	public function getUQc(){
		return $this->db->get_where('uqc',array('delete_status'=>0))->result();
	}
	/* 
		insert new uqc record in Database 
	*/
	public function addModel($data){
		if($this->db->insert('uqc',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/*
		return single data
	*/
	public function getRecord($id){
		return $this->db->get_where('uqc',array('id'=>$id))->row();
	}
	/* 
		this function is used to save edited record in database 
	*/
	public function editModel($id,$data){
		$this->db->where('id',$id);
		return $this->db->update('uqc',$data);
	}
	/* 
		this function delete category from database  
	*/
	public function deleteModel($id){	
		$this->db->where('id',$id);
		return $this->db->update('uqc',array('delete_status'=>1));
	}
}
?>