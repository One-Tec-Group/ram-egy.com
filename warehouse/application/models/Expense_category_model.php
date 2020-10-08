<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Expense_category_model extends CI_Model
{
	/* 
		return all category data 
	*/
	public function getExpenseCategory(){
		$data = $this->db->get_where('expense_category',array('delete_status'=>0));
		return $data->result();
	}
	/* 
		insert new categoty record in Database 
	*/
	public function addModel($data){
		if($this->db->insert('expense_category',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return selected id record use in edit page 
	*/
	public function getRecord($id){
		if($query = $this->db->get_where('expense_category',array('id'=>$id))){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}
	/* 
		this function is used to save edited record in database 
	*/
	public function editModel($data,$id){
		$this->db->where('id',$id);
		return $this->db->update('expense_category',$data);
	}
	/* 
		this function delete category from database  
	*/
	public function deleteModel($id){	
		$this->db->where('id',$id);
		return $this->db->update('expense_category',array('delete_status'=>1));
	}
}
?>