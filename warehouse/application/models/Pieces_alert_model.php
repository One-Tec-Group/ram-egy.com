<?php
defined("BASEPATH") OR exit('No direct script access allowed');
class Pieces_alert_model extends CI_Model
{
	public function getPiecesAlert(){
		$this->db->select('p1.*')
				 ->from('pieces p1')
				 ->join('pieces p2',"p1.piece_id = p2.piece_id")
				 ->where('p1.alert_quantity > p2.quantity')
				 ->where('p1.delete_status',0);
		return $this->db->get()->result();
	}
	public function getCsvData(){
		$this->db->select('p1.code as Code,p1.name as Name,p1.cost as Cost,p1.price as Price,p1.unit as Unit,p1.quantity as Quantity,p1.alert_quantity as Alert Quantity')
				 ->from('pieces p1')
				 ->join('pieces p2',"p1.piece_id = p2.piece_id")
				 ->where('p1.alert_quantity > p2.quantity');
		return $this->db->get();
	}
}
?>
