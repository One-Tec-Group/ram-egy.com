<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Assign_warehouse_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	public function getAssignWarehouse(){
		return $this->db->select('w.warehouse_name,m.id,u.first_name,u.last_name')
                   ->from('warehouse w')
                   ->join('warehouse_management m','m.warehouse_id = w.warehouse_id')
                   ->join('users u','u.id = m.user_id')
                   ->get()
                   ->result();
	}
	/* 
		return all data users table 
	*/
	public function getUser(){
		/*$where = "g.name = 'purchaser' OR g.name = 'sales_person' OR g.name = 'manager' ";
		$where1 = "wm.user_id = u.id";
		$this->db->select('u.first_name,u.last_name,u.id')
				 ->from('users u')
				 ->join('users_groups ug','u.id = ug.user_id')
				 ->join('groups g','g.id = ug.group_id')
				 ->join('warehouse_management wm','wm.user_id = u.id')
				 ->where($where)
				 ->get(); 
		echo $this->db->last_query();
		exit;
		return $this->db->get()->result();*/
		$data = $this->db->query("SELECT `u`.`first_name`, `u`.`last_name`, `u`.`id`, `g`.`name` FROM `users` `u` JOIN `users_groups` `ug` ON `u`.`id` = `ug`.`user_id` JOIN `groups` `g` ON `g`.`id` = `ug`.`group_id` WHERE `g`.`name` = 'purchaser' OR `g`.`name` = 'sales_person' OR `g`.`name` = 'manager'")->result();
        return $data;
	}
	/* 
		return all warehouse data  
	*/
	public function getWarehouse($id){
	$data = $this->db->query('
	                            SELECT * 
	                            FROM warehouse
	                            WHERE warehouse_id NOT IN
	                                                  (
	                                                    SELECT warehouse_id 
	                                                    FROM warehouse_management
	                                                    WHERE user_id = ?
	                                                  ) 
                            ',
                            	array($id)
                            )->result();
        return $data;
	}
	/* 
		insert record in warehouse_management table 
	*/
	public function assignWarehouse($data){
		$sql = "insert into warehouse_management (user_id,warehouse_id) values(?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('warehouse_management',$data)){*/
			return  $this->db->insert_id();
		}
		else{
			return false;
		}
	}


	public function updateAssignWarehouse($data){
		$sql = "update warehouse_management set warehouse_id = ? where user_id = ?";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('warehouse_management',$data)){*/
			return true;
		}
		else{
			return false;
		}
	}
	public function deleteModel($id){
		/*$sql = "delete from warehouse_management where id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('id',$id);
		if($this->db->delete('warehouse_management')){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>