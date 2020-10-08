<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchaser_model extends CI_Model
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
		return all data of biller 
	*/
	public function getBillers(){
		$data = $this->db->select('b.*,c.name as cname,ct.name as ctname')
		                 ->from('biller b')
		                 ->join('countries c','c.id = b.country_id')
		                 ->join('cities ct','ct.id = b.city_id')
		                 ->where('b.delete_status',0)
		                 ->get()
		                 ->result();
		return $data;
	}
	public function getusers()
    {
        $this->db->select('*');
        $this->db->from('users');
        //$this->db->where('delete_status',0);
        $data=$this->db->get();
        return $users=$data->result();
    }

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
	public function getCustomer(){
		$data = $this->db->select('b.*,c.name as cname,ct.name as ctname')
		                 ->from('customer b')
		                 ->join('countries c','c.id = b.country_id')
		                 ->join('cities ct','ct.id = b.city_id')
		                 ->where('delete_status',0)
		                 ->get()
		                 ->result();
		return $data;
	}
	/* 
		return branch id and name  
	*/
	public function getBranch(){
		$this->db->select('branch_id,branch_name');
		$query = $this->db->get_where('branch',array('delete_status'=>0));
		$data = $query->result();
		return $data;
	}
	/*public function getUsers_data($id)
	{
		
        $this->db->where('biller_id',$id);        
        $this->db->from('biller');
        $data=$this->db->get();
        $result=$data->result();
		$u_id=$result[0]->user_id;

		$this->db->where('id',$u_id);        
        $this->db->from('users');
        $data=$this->db->get();
       	return $users=$data->result();

		
	}*/
	/* 
		add new Users record in databse
	*/
	public function addUsers($users){
		if($this->db->insert('users',$users)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		add new Users record in databse
	*/
	public function addUsers_groups($users_groups)
	{
		if($this->db->insert('users_groups',$users_groups)){
			return  TRUE;
		}
		else{
			return FALSE;
		}
	}

	/* 
		add new biller record in databse
	*/
	public function addModel($data){
		if($this->db->insert('biller',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return specified record 
	*/
	public function getRecord($id){		

		$data=$this->db->query("
                                SELECT b . * , u.id, u.password
								FROM biller AS b
								INNER JOIN users AS u ON b.biller_id = u.id
								WHERE b.biller_id = $id
            ");                
        return $data->result();  
	}
	/*  
		edit record user
	*/
	public function editUser($users,$u_id)
	{
		$this->db->where('id',$u_id);
		if($this->db->update('users',$users)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/* 
		return warehouse detail use drop down 
	*/
	public function getWarehouseList(){
		
		if($this->session->userdata('type') == "admin"){
		
		$this->db->select('w.*,wm.user_id as user_id,b.branch_name as branch_name,bl.biller_name as biller_name')
				 ->from('warehouse w')
				 ->join('branch b','w.branch_id = b.branch_id')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('biller bl','bl.user_id = u.id')
				 ->where('w.delete_status',0);

			return $this->db->get()->result();
		}
		else{

			$this->db->select('w.*,wm.user_id as user_id,b.branch_name as branch_name,bl.biller_name as biller_name')
					 ->from('warehouse w')
					 ->join('branch b','w.branch_id = b.branch_id')
					 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
					 ->join('users u','wm.user_id = u.id')
					 ->join('biller bl','bl.user_id = u.id')
					 ->where('wm.user_id',$this->session->userdata('user_id'))
					 ->where('w.delete_status',0);


			return $this->db->get()->result();
		}
		
	}

	/* 
		return warehouse detail use drop down 
	*/
	public function getWarehouse(){
		
		
		
		$this->db->select('w.*,b.branch_name as branch_name')
				 ->from('warehouse w')
				 ->join('branch b','w.branch_id = b.branch_id')
				 ->where('w.delete_status',0);

			return $this->db->get()->result();
		
		
	}
	/*  
		edit record specified id 
	*/
	public function editModel($data,$id){
		$this->db->where('biller_id',$id);
		if($this->db->update('biller',$data)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function deleteUsers($users,$id)
	{
		
        $this->db->where('biller_id',$id);        
        $this->db->from('biller');
        $data=$this->db->get();
        $result=$data->result();
		$u_id=$result[0]->user_id;

		$this->db->where('id',$u_id);
		if($this->db->update('users',$users))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}

		
	}
	/*
    	delete biller from databse 
    */

	public function deleteModel($id){
		$this->db->where('biller_id',$id);
		if($this->db->update('biller',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
		return state code
	*/
	public function getStateCode($id){
		$this->db->where('state_id',$id);
		return $this->db->get('state_code')->row()->tin_number;
	}

	/*
		return warehouse for assigning to purchaser
	*/
	public function getWarehouseForPurchaser($id){
		$this->db->select('w.*, b.*, cs.name as city_name, s.name as state_name, c.name as country_name, b.branch_name as branch_name ')
				 ->from('warehouse w')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('cities cs','cs.id = b.city_id')
				 ->join('states s','s.id = cs.state_id')
				 ->join('countries c','c.id = s.country_id')
				 ->where('w.delete_status',0);	
			return $this->db->get()->result();
	}

	/* 
		return warehouse detail use drop down 
	*/
	public function getPurchaserWarehouse(){
		
		$users_id = $this->db->select('u.id')
							 ->from('users u')
							 ->join('warehouse_management wm','wm.user_id = u.id')
							 ->join('users_groups ug','ug.user_id = u.id')
							 ->join('groups g','g.id = ug.group_id')
							 ->where('g.id !=',2)
							 ->get()
							 ->result();	
		
		$user_id_array = array();
		
		foreach($users_id as $user_id){
			$user_id_array[] = $user_id->id;
		}

	
		$purchase_user_id = $this->db->select('w.*,wm.user_id as user_id,b.branch_name as branch_name')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where_not_in('u.id',$user_id_array)
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();
		return $purchase_user_id;
		
		
		
		
	}

	/*
		return assigned warehouse list for purchaser
	*/
	public function getAssignedWarehouseToPurchaser(){
		$this->db->select('w.warehouse_name,w.warehouse_id,u.id as user_id,b.branch_name as branch_name')
				 ->from('warehouse_management wm')
				 ->join('warehouse w','w.warehouse_id = wm.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('users u','u.id = wm.user_id')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('g.id',2)
				 ->where('w.delete_status',0);	
			return $this->db->get()->result();
	}

	/*
		return not assigned warehouse list for purchaser
	*/
	public function getNotAssignedWarehouseToPurchaser($assigned_warehouse){
		if(empty($assigned_warehouse)){
			$this->db->select('w.*, b.*, cs.name as city_name, s.name as state_name, c.name as country_name, b.branch_name as branch_name')
				 ->from('warehouse w')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('cities cs','cs.id = b.city_id')
				 ->join('states s','s.id = cs.state_id')
				 ->join('countries c','c.id = s.country_id')
				 ->where('w.delete_status',0);	
			return $this->db->get()->result();
		}else{
			$this->db->select('w.*, b.*, cs.name as city_name, s.name as state_name, c.name as country_name, b.branch_name as branch_name')
				 ->from('warehouse w')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('cities cs','cs.id = b.city_id')
				 ->join('states s','s.id = cs.state_id')
				 ->join('countries c','c.id = s.country_id')
				 ->where_not_in('warehouse_id',$assigned_warehouse)
				 ->where('w.delete_status',0);	
			return $this->db->get()->result();
		}

		
	}
	
}
?>