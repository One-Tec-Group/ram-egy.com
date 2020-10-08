<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email_setup_model extends CI_Model
{
	public function getEmailSetup(){
		return $this->db->get('email_setup')->result();
	}
	public function add($data){
		$d = $this->db->get('email_setup')->result();
		if($d != null){
			return $this->db->update('email_setup',$data);
		}
		else{
			return $this->db->insert('email_setup',$data);	
		}
		
	}
}
?>