<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Location_model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	/**************************************************************************/

	public function getCountries(){
		$data = $this->db->get_where('countries',array('delete_status'=>0))->result();
		return $data;
	}
	public function getStates($country_id = NULL){
		$data = $this->db->get_where('states',array('delete_status'=>0,'country_id'=>$country_id))->result();
		return $data;
	}
	public function getCities($state_id){
		$data = $this->db->get_where('cities',array('delete_status'=>0,'state_id'=>$state_id));
		return $data->result();
	}

	/**************************************************************************/

	public function addCountryModel($data){
		if($this->db->insert('countries',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}

	public function addStateModel($data){
		if($this->db->insert('states',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}

	public function addCityModel($data){
		if($this->db->insert('cities',$data)){
			return  $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}

	/**************************************************************************/
	
	public function getCountryRecord($id){
		return $this->db->get_where('countries',array('id'=>$id))->row();
	}
	public function getStateRecord($id){
		return $this->db->get_where('states',array('id'=>$id))->row();
	}
	public function getCityRecord($id){
		return $this->db->get_where('cities',array('id'=>$id))->row();
	}

	/**************************************************************************/
	
	public function editCountryModel($data,$id){
		$this->db->where('id',$id);
		if($this->db->update('countries',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function editStateModel($data,$id){
		$this->db->where('id',$id);
		if($this->db->update('states',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	public function editCityModel($data,$id){
		$this->db->where('id',$id);
		if($this->db->update('cities',$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	/**************************************************************************/
	
	public function deleteCountryModel($id){	
		$this->db->where('id',$id);
		if($this->db->update('countries',array('delete_status'=>1))){
			$states = $this->getStates($id);
			foreach ($states as $state) {
				$this->deleteCityModelByStateId($state_id);
			}
			$this->deleteStateModelByCountryId($id);

			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function deleteStateModel($id){	
		$this->db->where('id',$id);
		if($this->db->update('states',array('delete_status'=>1))){
			$this->deleteCityModelByStateId($id);
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function deleteStateModelByCountryId($country_id){	
		$this->db->where('country_id',$country_id);
		if($this->db->update('states',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function deleteCityModel($id){	
		$this->db->where('id',$id);
		if($this->db->update('cities',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function deleteCityModelByStateId($state_id){	
		$this->db->where('state_id',$state_id);
		if($this->db->update('cities',array('delete_status'=>1))){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

}
?>