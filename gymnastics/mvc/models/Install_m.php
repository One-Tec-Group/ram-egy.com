<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install_m extends CI_Model{

	function __construct() {
		parent::__construct();			
		$this->load->database();
	}

	public function insert_setting($data) {
		$this->db->insert('setting', $data);
		return TRUE;
	}

	public function select_setting() {
		$this->db->select('*');
		$query = $this->db->get('setting');
		return $query->result();
	}


	function insertorupdate($arrays) {
		foreach ($arrays as $key => $array) {
			$this->db->query("INSERT INTO setting (fieldoption, value) VALUES ('".$key."', '".$array."') ON DUPLICATE KEY UPDATE fieldoption='".$key."' , value='".$array."'");
		}
		return TRUE;
	}

	public function hash($string) {
		return hash("sha512", $string . config_item("encryption_key"));
	}
	
	public function use_sql_string($getsql) {
		$sql = trim($getsql);
		$link = @mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);		
		mysqli_multi_query($link, $sql);		
	}
}	
?>