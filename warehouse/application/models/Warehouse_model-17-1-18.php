<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Warehouse_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	public function index(){
		
	} 
	/* return warehouse details to display list*/
	public function getWarehouse(){
		return $this->db->select('w.warehouse_id,w.warehouse_name,b.branch_name,u.first_name,u.last_name')
				 ->from('warehouse w')
				 ->join('branch b ','w.branch_id = b.branch_id')
				 ->join('users u','u.id = w.user_id')
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();
	}
	/* return branch detalis */
	public function getBranch(){
		$this->db->select('*');
		$query = $this->db->get_where('branch',array('delete_status'=>0));
		return $query->result();
		
	}
	/* add new record in databse */
	public function addModel($data){
		/*$sql = "insert into warehouse (warehouse_name,branch_id,user_id) values(?,?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('warehouse',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* return record to edit record */
	public function getRecord($id){
		$sql = "select * from warehouse where warehouse_id = ?";
		if($query = $this->db->query($sql,array($id))){
		/*$this->db->where('warehouse_id',$data);
		if($query = $this->db->get('warehouse')){*/
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* save edited record in database */
	public function editModel($data,$id){
		/*$sql = "update warehouse set branch_id = ?,warehouse_name = ?,user_id = ? where warehouse_id = ?";
		if($this->db->query($sql,array($data['branch_id'],$data['warehouse_name'],$data['user_id'],$id))){*/
		$this->db->where('warehouse_id',$id);
		if($this->db->update('warehouse',$data)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/* delete record in database */
	public function deleteModel($id){
		/*$sql = "delete from warehouse where warehouse_id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('warehouse_id',$id);
		if($this->db->update('warehouse',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>