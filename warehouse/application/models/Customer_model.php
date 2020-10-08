<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer_model extends CI_Model
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
		return all customer details to dispaly list
	*/
	public function getCustomer(){
		// $data = $this->db->select('b.*,c.name as cname,ct.name as ctname')
		//                  ->from('customer b')
		//                  ->join('countries c','c.id = b.country_id')
		//                  ->join('cities ct','ct.id = b.city_id')
		//                  ->where('delete_status',0)
		//                  ->get()
		//                  ->result();
	  $data = $this->db->select('*')
			               ->from('customer')
								 		 ->where('delete_status',0)
								 		 ->get()
								 		 ->result();
		return $data;
	}
	/*
		insert new customer record in databse
	*/
	public function addModel($data){
		if($this->db->insert('customer',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/*
		return specific customer record
	*/
	public function getRecord($id){
		$this->db->where('customer_id',$id);
		if($query = $this->db->get('customer')){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}

	public function getCustomerRecord($id){
		$this->db->where('customer_id',$id);
		if($query = $this->db->get('customer')){
			return $query->row();
		}
		else{
			return FALSE;
		}
	}

	/*
		ge
	*/
	public function getCustomerData($id){
		return $this->db->select('c.*,cu.name as country_name,st.name as state_name,ct.name as city_name,ct.state_id as shipping_state_id')
		                 ->from('customer c')
		                 ->join('countries cu','cu.id = c.country_id')
		                 ->join('states st','st.id = c.state_id')
		                 ->join('cities ct','ct.id = c.city_id')
		                 ->where('customer_id',$id)
		                 ->get()
		                 ->row();
	}


	/*
		save edited customer record in databse
	*/
	public function editModel($data,$id){
		$this->db->where('customer_id',$id);
		if($this->db->update('customer',$data)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
		delete customer record in databse
	*/
	public function deleteModel($id){
		$this->db->where('customer_id',$id);
		if($this->db->update('customer',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*

	*/
	public function getCityName($id){
		return  $this->db->get_where('cities',array('id'=>$id))->row()->name;
	}
	/*

	*/
	public function getStateName($id){
		return $this->db->get_where('states',array('id'=>$id))->row()->name;
	}
	/*

	*/
	public function getCountryName($id){
		return $this->db->get_where('countries',array('id'=>$id))->row()->name;
	}
}
?>
