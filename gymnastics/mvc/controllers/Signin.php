<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends Admin_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/
	function __construct() {
		parent::__construct();
		$this->load->model("signin_m");
		$data = array(
			"lang" => $this->data["siteinfos"]->language,
		);
		$this->session->set_userdata($data);
		$language = $this->session->userdata('lang');
		$this->lang->load('signin', $language);
		if(!isset($this->data["siteinfos"]->captcha_status)) {
			$this->data["siteinfos"]->captcha_status = 1;
		}
	}

	protected function rules() {
		$rules = array(
				 array(
					'field' => 'username',
					'label' => "Username",
					'rules' => 'trim|required|max_length[40]|xss_clean'
				),
				array(
					'field' => 'password',
					'label' => "Password",
					'rules' => 'trim|required|max_length[40]|xss_clean'
				)
			);

		if($this->data["siteinfos"]->captcha_status == 0) {
			$rules[] = array(
				'field' => 'g-recaptcha-response',
				'label' => "captcha",
				'rules' => 'trim|required'
			);
		}
		return $rules;
	}

	protected function rules_cpassword() {
		$rules = array(
				array(
					'field' => 'old_password',
					'label' => $this->lang->line('old_password'),
					'rules' => 'trim|required|max_length[40]|min_length[4]|xss_clean|callback_old_password_unique'
				),
				array(
					'field' => 'new_password',
					'label' => $this->lang->line('new_password'),
					'rules' => 'trim|required|max_length[40]|min_length[4]|xss_clean'
				),
				array(
					'field' => 're_password',
					'label' => $this->lang->line('re_password'),
					'rules' => 'trim|required|max_length[40]|min_length[4]|matches[new_password]|xss_clean'
				)
			);
		return $rules;
	}

	public function index() {
		if($this->data['siteinfos']->captcha_status == 0) {
			$this->load->library('recaptcha');
			$this->data['recaptcha'] = array(
	            'widget' => $this->recaptcha->getWidget(),
	            'script' => $this->recaptcha->getScriptTag(),
	        );
		}
        
		$this->signin_m->loggedin() == FALSE || redirect(base_url('dashboard/index'));

		$this->data['form_validation'] = 'No';
		if($_POST) {
			$rules = $this->rules();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data['form_validation'] = validation_errors();
				$this->data["subview"] = "signin/index";
				$this->load->view('_layout_signin', $this->data);
			} else {
				$checkArray = $this->signin_m->signin();
				if($checkArray['return'] == TRUE) {
					redirect(base_url('dashboard/index'));
				} else {
					$this->session->set_flashdata("errors", $checkArray['message']);
					$this->data['form_validation'] = $checkArray['message'];
					$this->data["subview"] = "signin/index";
					$this->load->view('_layout_signin', $this->data);
				}
			}
		} else {
			$this->data["subview"] = "signin/index";
			$this->load->view('_layout_signin', $this->data);
			$this->session->sess_destroy();
		}
	}

	public function cpassword() {
		$this->load->library("session");
		if($_POST) {
			$rules = $this->rules_cpassword();
			$this->form_validation->set_rules($rules);
			if ($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "signin/cpassword";
				$this->load->view('_layout_main', $this->data);
			} else {
				redirect(base_url('signin/cpassword'));
			}
		} else {
			$this->data["subview"] = "signin/cpassword";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function old_password_unique() {
		if($this->signin_m->change_password() == TRUE) {
			return TRUE;
		} else {
			$this->form_validation->set_message("old_password_unique", "%s does not match");
			return FALSE;
		}
	}

	public function signout() {
		$this->signin_m->signout();
		if($this->data["siteinfos"]->frontendorbackend === 'YES') {
			redirect(base_url('frontend/index'));
		} else {
			redirect(base_url("signin/index"));
		}
	}
}