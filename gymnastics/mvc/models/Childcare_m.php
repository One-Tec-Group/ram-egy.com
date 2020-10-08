<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Childcare_m extends MY_Model {

	protected $_table_name = 'childcare';
	protected $_primary_key = 'childcareID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "childcareID desc";

	function __construct() {
		parent::__construct();
	}

	public function get_childcare($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

	public function get_join_childcare_all($schoolyearID = NULL, $id = NULL) {
        $this->db->select('childcare.*,student.name, classes.classes');
        $this->db->from('childcare');
        $this->db->join('classes', 'classes.classesID = childcare.classesID', 'LEFT');
        $this->db->join('student', 'student.studentID = childcare.userID', 'LEFT');
        if ((int)$id) {
            $this->db->where("childcare.childcareID", $id);
        }

        if((int)$schoolyearID) {
        	$this->db->where('childcare.schoolyearID', $schoolyearID);
        }

        $this->db->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->result();
	}

	public function get_order_by_childcare($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	public function get_single_childcare($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}

	public function insert_childcare($array) {
		$id = parent::insert($array);
		return $id;
	}

	public function update_childcare($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_childcare($id){
		parent::delete($id);
	}
}