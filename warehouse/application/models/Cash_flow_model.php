<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cash_flow_model extends CI_Model
{
	public function getData(){
		return  $this->db->query('
									SELECT  
										th.*,
										l.title as to_account,
										ll.title as from_account 
									FROM transaction_header th 
									INNER JOIN ledger l ON l.id = th.to_account
									INNER JOIN ledger ll ON ll.id = th.from_account
								'
								)->result();
	}
	public function getDataSort($start_date,$end_date){
		return  $this->db->query('
									SELECT  
										th.*,
										l.title as to_account,
										ll.title as from_account 
									FROM transaction_header th 
									INNER JOIN ledger l ON l.id = th.to_account
									INNER JOIN ledger ll ON ll.id = th.from_account
									WHERE 
										(th.transaction_date >= ? OR ? IN ("",NULL))
									AND
										(th.transaction_date <= ? OR ? IN ("",NULL))
								',
									array(
											$start_date,
											$start_date,
											$end_date,
											$end_date
										)
								)->result();
	}
	public function getDataCSV($start_date,$end_date){
		return  $this->db->query('
									SELECT  
										l.title as "To Account",
										ll.title as "From Account",
										th.amount as "Amount"
									FROM transaction_header th 
									INNER JOIN ledger l ON l.id = th.to_account
									INNER JOIN ledger ll ON ll.id = th.from_account
									WHERE 
										(th.transaction_date >= ? OR ? IN ("",NULL))
									AND
										(th.transaction_date <= ? OR ? IN ("",NULL))
								',
									array(
											$start_date,
											$start_date,
											$end_date,
											$end_date
										)
								);
	}
}