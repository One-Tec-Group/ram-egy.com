<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Biller_model extends CI_Model
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
		$sql = "SELECT b.*,c.name as cname,ct.name as ctname, w.warehouse_name as warehouse_name,b.biller_name as biller_name FROM biller b JOIN countries c ON c.id = b.country_id JOIN cities ct ON ct.id = b.city_id JOIN warehouse w ON w.warehouse_id = b.warehouse_id WHERE b.delete_status = 0";
		$query = $this->db->query($sql);
		$data = $query->result();
		return $data;
	}

	/* 
		return biller id from warehouse 
	*/
	public function getBillerIdFromWarehouse($warehouse_id){
		
			//return $this->db->get_where('biller',array('warehouse_id' =>$warehouse_id))->row()->warehouse_id;
			
			$user_id = $this->db->select('b.user_id,b.user_id')
								->from('warehouse_management wm')
								->join('users u','wm.user_id = u.id')
								->join('biller b','u.id = b.user_id')
								->where('wm.warehouse_id',$warehouse_id)
								->where('wm.user_id',$warehouse_id)
								->get()
								->row()->biller_id;


/*			$data = $this->db->select('b.biller_id')
			 ->from('biller b')
			 ->where('b.warehouse_id',$warehouse_id)
			 ->get()->result();
			
			 if($data != null){
		 		return $data[0]->biller_id;
			 }else{
			 	return 0;
			 }*/
	}
	/* 
		return biller id from warehouse 
	*/
	public function getBillerIdFromWarehouseSales($warehouse_id){
		
			//return $this->db->get_where('biller',array('warehouse_id' =>$warehouse_id))->row()->warehouse_id;
			
			$user_id = $this->db->select('b.user_id,b.user_id')
								->from('warehouse_management wm')
								->join('users u','wm.user_id = u.id')
								->join('users_groups ug','ug.user_id = u.user_id')
								->join('groups g','g.id = ug.group_id')
								->join('biller b','u.id = b.user_id')
								->where('wm.warehouse_id',$warehouse_id)
								->where('wm.user_id',$warehouse_id)
								->get()
								->row()->biller_id;


/*			$data = $this->db->select('b.biller_id')
			 ->from('biller b')
			 ->where('b.warehouse_id',$warehouse_id)
			 ->get()->result();
			
			 if($data != null){
		 		return $data[0]->biller_id;
			 }else{
			 	return 0;
			 }*/
	}


	/*	
		return the biller details based on user id 
	*/

	public function getBillerDetails($user_id){
		$data = $this->db->select('b.*, w.warehouse_name as warehouse_name,bh.state_id as biller_state_id')
		                 ->from('biller b')
		                 ->join('warehouse w','w.warehouse_id = b.warehouse_id')
		                 ->join('branch bh','bh.branch_id = w.branch_id')
		                 ->where('b.delete_status',0)
		                 ->where('b.user_id',$user_id)
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
		                 ->where('b.delete_status',0)
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

		// $this->db->insert('biller',$data);
		// echo $this->db->last_query();
		// exit;
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
                                SELECT b.* , u.id, u.password
								FROM biller AS b
								INNER JOIN users AS u ON b.user_id = u.id
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
	public function getWarehouseForBiller($id){
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
		return assigned warehouse list for purchaser
	*/
	public function getAssignedWarehouseToBiller(){
		return $this->db->select('w.warehouse_name,w.warehouse_id,u.id as user_id,b.branch_name as branch_name')
				 ->from('warehouse_management wm')
				 ->join('warehouse w','w.warehouse_id = wm.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('users u','u.id = wm.user_id')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('g.id',3)
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();

		 /*echo '<pre>';
		 echo $this->db->last_query();
		 print_r($data);
		 exit;*/
	}

	/*
		return not assigned warehouse list for purchaser
	*/
	public function getNotAssignedWarehouseToBiller($assigned_warehouse){
		if(empty($assigned_warehouse)){
			$this->db->select('w.warehouse_id,b.branch_name,w.warehouse_name')
				 ->from('warehouse w')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->where('w.delete_status',0);
			return $this->db->get()->result();	
		}else{
			$this->db->select('w.warehouse_id,b.branch_name,w.warehouse_name')
				 ->from('warehouse w')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->where_not_in('w.warehouse_id',$assigned_warehouse)
				 ->where('w.delete_status',0);
			return $this->db->get()->result();	
		}
		
	}

	
	/*
		return biller state id from biller
	*/
	public function getBillerStateIdFromBiller($biller_id){
		
		//	return $this->db->get_where('biller',array('biller_id' =>$biller_id))->row()->state_id;
			/*return $this->db->select('b.state_id')
				 ->from('biller b')
				 ->where('b.biller_id',$biller_id)
				 ->get()->result();*/
			
			$data = $this->db->select('br.state_id')
				 ->from('biller b')
				 ->join('warehouse w','w.warehouse_id = b.warehouse_id')
				 ->join('branch br','br.branch_id = w.branch_id')
				 ->where('b.biller_id',$biller_id)
				 ->get()->result();
			
			// echo '<pre>';
			// print_r($data);
			// exit;

			if($data != null){
				return $data[0]->state_id;
			}else{
				return $this->db->get('company_settings')->row()->state_id;
			}
			
			
	}

	/*
		return branch id from warehouse
	*/
	public function getBranchIdFromWarehouse($warehouse_id){
		
			//return $this->db->get_where('biller',array('warehouse_id' =>$warehouse_id))->row()->warehouse_id;
			$data = $this->db->select('branch_id')
				 ->from('warehouse')
				 ->where('warehouse_id',$warehouse_id)
				 ->get()->result();

		 	
			/*echo '<pre>';
			echo $data[0]->branch_id;
			exit;*/
			return $data[0]->branch_id;	 
			
			
	}
	/*
		return biller id from user
	*/
	public function getBillerIdFromUser($user_id){

			return $this->db->get_where('biller',array('user_id' =>$user_id))->row();

	}
	
}
?>