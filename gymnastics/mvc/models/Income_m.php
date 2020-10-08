<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Income_m extends MY_Model {

	protected $_table_name = 'income';
	protected $_primary_key = 'incomeID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "incomeID desc";

	public function __construct() {
		parent::__construct();
	}

	public function get_income($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

	public function get_order_by_income($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	public function get_single_income($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	public function insert_income($array) {
		$error = parent::insert($array);
		return TRUE;
	}

	public function update_income($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_income($id){
		parent::delete($id);
	}

	public function get_income_order_by_date($array) {
		$this->db->select('*');
		$this->db->from($this->_table_name);
		$this->db->where('date >=',$array['fromdate']);
		$this->db->where('date <=',$array['todate']);
		$this->db->where('schoolyearID',$array['schoolyearID']);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_income_order_by_with_date_schoolyear($array) {
		$this->db->select_sum('amount');
		$this->db->from($this->_table_name);
		if(isset($array['fromdate']) && isset($array['todate'])) {
			$this->db->where('date >=',$array['fromdate']);
			$this->db->where('date <=',$array['todate']);
		}
		if(isset($array['schoolyearID'])) {
			$this->db->where('schoolyearID',$array['schoolyearID']);
		}
		$query = $this->db->get();
		return $query->row();
	}
}