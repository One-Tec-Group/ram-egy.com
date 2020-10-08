<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_setting extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->model('sms_setting_model');
		$this->load->model('log_model');
	}
	public function index(){
		$data['data'] = $this->sms_setting_model->getSmsSetting();
		// echo '<pre>';
		// print_r($data);
		

		// exit;
		$this->load->view('sms_setting/index',$data);
	}
	public function updateSmsSetting(){

		$data = array(
				'bhash_api_url' => $this->input->post('bhash_api_url'),
				'default_gateway' => $this->input->post('default_gateway'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'api_url' => $this->input->post('api_url'),
				'sender' => $this->input->post('sender'),
				'sender_b' => $this->input->post('sender_b'),
				'route' => $this->input->post('route'),
				'auth_key' => $this->input->post('auth_key'),
				'unicode' => $this->input->post('unicode'),
				'country' => $this->input->post('country')
			);

		if($this->sms_setting_model->update($data)){
			
			$this->session->set_flashdata('fail', 'SMS Setting successfully Updated.');
			redirect('sms_setting','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Error in Update SMS Setting.');
			redirect('sms_setting','refresh');
		}
	}

	public function history(){

		$data['sms_history'] = $this->sms_setting_model->getHistory();		
		$this->load->view('sms_setting/sms_history',$data);
	}


}
?>