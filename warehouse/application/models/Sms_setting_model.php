<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sms_setting_model extends CI_Model
{
	public function getSmsSetting(){

		return $this->db->get('sms_setting')->row();
		
	}
	public function update($data){
		
		return $this->db->update('sms_setting',$data);	
		
	}

	public function addSmsHistroy($data){
		
		return $this->db->insert('sms_history',$data);	
		
	}
	public function getHistory(){
		
		return $this->db->get('sms_history')->result();	
		
	}
}
?>