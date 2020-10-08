<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supplier_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	/*
		return country
	*/
	public function getCountry(){
		return $this->db->get('countries')->result();
	}
	/*
		return state
	*/
	public function getState($id){	
		return $this->db->select('s.*')
		                 ->from('states s')
		                 ->join('countries c','c.id = s.country_id')
		                 ->where('s.country_id',$id)
		                 ->get()
		                 ->result();
	}
	/*
		return city 
	*/
	public function getCity($id){
		return $this->db->select('c.*')
		                 ->from('cities c')
		                 ->join('states s','s.id = c.state_id')
		                 ->where('c.state_id',$id)
		                 ->get()
		                 ->result();
	}
	/* 
		return supplier details to display list 
	*/ 
	public function getSuppliers(){
		$data = $this->db->select('s.*,c.name as cname,ct.name as ctname')
		                 ->from('suppliers s')
		                 ->join('countries c','c.id = s.country_id')
		                 ->join('cities ct','ct.id = s.city_id')
		                 ->where('s.delete_status',0)
		                 ->get()
		                 ->result();
		return $data;
	}
	/* 
		add new rwcord in database 
	*/
	public function addModel($data){		if($this->db->insert('suppliers',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return record to edit record 
	*/
	public function getRecord($id){
		$this->db->where('supplier_id',$id);
		if($query = $this->db->get('suppliers')){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	public function getSupplierRecord($id){
		$this->db->where('supplier_id',$id);
		if($query = $this->db->get('suppliers')){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}
	/* 	
		save editd record in database 
	*/
	public function editModel($data,$id){
		$this->db->where('supplier_id',$id);
		if($this->db->update('suppliers',$data)){
			return TRUE;
		}
		else{
			return FALSE;
		}
		//exit();
	}
	/* 	
		delete record in database 
	*/
	public function deleteModel($id){
		$this->db->where('supplier_id',$id);
		if($this->db->update('suppliers',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function getSuppliersData($id){
		return $this->db->select('s.*,cu.name as country_name,st.name as state_name,ct.name as city_name')
		                 ->from('suppliers s')
		                 ->join('countries cu','cu.id = s.country_id')
		                 ->join('states st','st.id = s.state_id')
		                 ->join('cities ct','ct.id = s.city_id')
		                 ->where('supplier_id',$id)
		                 ->get()
		                 ->row();
	}

	public function getSupplierStateId($id){
		return $this->db->select('s.*,st.id as customer_state_id')
		                 ->from('suppliers s')
		                 ->join('countries cu','cu.id = s.country_id')
		                 ->join('states st','st.id = s.state_id')
		                 ->join('cities ct','ct.id = s.city_id')
		                 ->where('supplier_id',$id)
		                 ->get()->row()->customer_state_id;
	}
}
?>