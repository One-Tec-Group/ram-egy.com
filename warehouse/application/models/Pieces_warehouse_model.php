<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pieces_warehouse_model extends CI_Model
{
	function __construct() {
		parent::__construct();

	}
	public function index(){

	}
	/* return warehouse details to display list*/
	public function getWarehouse(){
		return $this->db->select('w.Pwarehouse_id,w.Pwarehouse_name,b.branch_name,primary_Pwarehouse,u.first_name,u.last_name')
				 ->from('Pwarehouse w')
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

	/* return warehouse count */
	public function getWarehouseCount(){
		$this->db->select('*');
		$query = $this->db->get_where('Pwarehouse',array('delete_status'=>0));
		// $data = $query->result();

		// if($data != null){
		// 	return sizeof($data);
		// }else{
		// 	return 0;
		// }
		return $query->result();

	}


	/* add new record in databse */
	public function addModel($data){

		/*if($data['primary_warehouse']==1){
			$this->makeWarehouseSecondary($this->getCurrentPrimaryWarehouse());
		}*/

		$sql = "insert into Pwarehouse (Pwarehouse_name,primary_Pwarehouse,branch_id,user_id) values(?,?,?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('warehouse',$data)){*/
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* return record to edit record */
	public function getRecord($id){
		$sql = "select * from Pwarehouse where Pwarehouse_id = ?";
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

		/*if($data['primary_warehouse']==1){
			$this->makeWarehouseSecondary($this->getCurrentPrimaryWarehouse());
		}*/

		$sql = "update Pwarehouse set branch_id = ?,Pwarehouse_name = ?,user_id = ?, primary_Pwarehouse = ? where Pwarehouse_id = ?";
		if($this->db->query($sql,array($data['branch_id'],$data['Pwarehouse_name'],$data['user_id'],$data['primary_Pwarehouse'],$id))){
		/*$this->db->where('warehouse_id',$id);
		if($this->db->update('warehouse',$data)){*/

			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/* make other warehouse secondary */
	public function makeWarehouseSecondary(){

			$data = $this->db->select('*')
					 ->from('Pwarehouse')
					 ->where('delete_status',0)
					 ->get()
					 ->result();
			if($data != null){
				$secondary_warehouse_sql = "update Pwarehouse set primary_Pwarehouse = 0";
				$this->db->query($secondary_warehouse_sql,array($this->getCurrentPrimaryWarehouse()));
			}


	}

	/* get warehouse id of current primary warehouse */
	public function getCurrentPrimaryWarehouse(){

		$sql = "select Pwarehouse_id from Pwarehouse where primary_Pwarehouse = 1";
		if($query = $this->db->query($sql)){
			/*$this->db->where('warehouse_id',$data);
			if($query = $this->db->get('warehouse')){*/
			$data = $query->result();
			return $data[0]->warehouse_id;
			//return $data->warehouse_id;
		}
		else{
			return FALSE;
		}
	}

	/* check warehouse if primary or not */
	public function isPrimaryWarehouse($warehouse_id){

		$sql = "select primary_Pwarehouse from Pwarehouse where Pwarehouse_id = ?";
		if($query = $this->db->query($sql,array($warehouse_id))){
			/*$this->db->where('warehouse_id',$data);
			if($query = $this->db->get('warehouse')){*/
			$data = $query->result();
			if($data[0]->primary_warehouse == 1){
				return TRUE;
			}else{
				return FALSE;
			}

			//return $data->warehouse_id;
		}
		else{
			return FALSE;
		}
	}

	/* delete record in database */
	public function deleteModel($id){
		/*$sql = "delete from warehouse where warehouse_id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('Pwarehouse_id',$id);
		if($this->db->update('Pwarehouse',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}
?>
