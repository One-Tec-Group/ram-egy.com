<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class setting extends Admin_Controller {
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

		$this->load->model("setting_m");
		$this->load->model("markpercentage_m");
		$this->load->model("schoolyear_m");
		$this->load->model("idmanager_m");
		$this->load->model('themes_m');
		$this->load->model('classes_m');
		$this->load->model("mailandsmstemplate_m");
		$this->load->helper('frontenddata');
		$language = $this->session->userdata('lang');
		$this->lang->load('setting', $language);
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'sname',
				'label' => $this->lang->line("setting_school_name"),
				'rules' => 'trim|required|xss_clean|max_length[128]'
			),
			array(
				'field' => 'phone',
				'label' => $this->lang->line("setting_school_phone"),
				'rules' => 'trim|required|xss_clean|max_length[25]'
			),
			array(
				'field' => 'email',
				'label' => $this->lang->line("setting_school_email"),
				'rules' => 'trim|required|valid_email|max_length[40]|xss_clean'
			),
			array(
				'field' => 'automation',
				'label' => $this->lang->line("setting_school_day"),
				'rules' => 'trim|max_length[5]|xss_clean|callback_unique_day'
			),
			array(
				'field' => 'auto_invoice_generate',
				'label' => $this->lang->line("setting_school_auto_invoice_generate"),
				'rules' => 'trim|required|max_length[5]|xss_clean'
			),
			array(
				'field' => 'note',
				'label' => $this->lang->line("setting_school_note"),
				'rules' => 'trim|required|max_length[5]|xss_clean'
			),
			array(
				'field' => 'google_analytics',
				'label' => $this->lang->line("setting_school_google_analytics"),
				'rules' => 'trim|max_length[50]|xss_clean'
			),
			array(
				'field' => 'currency_code',
				'label' => $this->lang->line("setting_school_currency_code"),
				'rules' => 'trim|required|max_length[11]|xss_clean'
			),
			array(
				'field' => 'currency_symbol',
				'label' => $this->lang->line("setting_school_currency_symbol"),
				'rules' => 'trim|required|max_length[3]|xss_clean'
			),
			array(
				'field' => 'footer',
				'label' => $this->lang->line("setting_school_footer"),
				'rules' => 'trim|required|max_length[200]|xss_clean'
			),
			array(
				'field' => 'address',
				'label' => $this->lang->line("setting_school_address"),
				'rules' => 'trim|required|max_length[200]|xss_clean'
			),
			array(
				'field' => 'frontendorbackend',
				'label' => $this->lang->line("setting_school_frontend"),
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'language',
				'label' => $this->lang->line("setting_school_lang"),
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'attendance',
				'label' => $this->lang->line("setting_school_default_attendance"),
				'rules' => 'trim|required|xss_clean|callback_unique_attendance'
			),
			array(
				'field' => 'school_year',
				'label' => $this->lang->line("setting_school_default_school_year"),
				'rules' => 'trim|required|xss_clean|callback_unique_schoolyear'
			),
			array(
				'field' => 'photo',
				'label' => $this->lang->line("setting_school_photo"),
				'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
			),
			array(
				'field' => 'captcha_status',
				'label' => $this->lang->line("setting_school_disable_captcha"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'language_status',
				'label' => $this->lang->line("setting_school_disable_language"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'attendance_notification',
				'label' => $this->lang->line("setting_attendance_notification"),
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'attendance_smsgateway',
				'label' => $this->lang->line("setting_attendance_smsgateway"),
				'rules' => 'trim|required|xss_clean|callback_check_attendance_smsgateway'
			),
			array(
				'field' => 'attendance_notification_template',
				'label' => $this->lang->line("setting_attendance_notification_template"),
				'rules' => 'trim|required|xss_clean|callback_check_attendance_notification_template'
			),
			array(
				'field' => 'weekends[]',
				'label' => $this->lang->line("setting_weekends"),
				'rules' => 'trim|xss_clean|callback_unique_weekends'
			),
			array(
				'field' => 'ex_class',
				'label' => $this->lang->line("setting_graduate_class"),
				'rules' => 'trim|xss_clean|numeric'.($this->input->post('auto_invoice_generate') ? '|callback_unique_ex_class' : '')
			),
			array(
				'field' => 'profile_edit',
				'label' => $this->lang->line("setting_school_profile_edit"),
				'rules' => 'trim|required|xss_clean|numeric'
			),
			array(
				'field' => 'time_zone',
				'label' => $this->lang->line("setting_school_time_zone"),
				'rules' => 'trim|required|xss_clean|callback_unique_time_zone'
			),
			array(
				'field' => 'auto_update_notification',
				'label' => $this->lang->line("setting_auto_update_notification"),
				'rules' => 'trim|required|xss_clean'
			)
		);

		$markpercentages = $this->markpercentage_m->get_markpercentage();
		if(count($markpercentages)) {
		    foreach ($markpercentages as $key => $markpercentage) {
		        $rules[] = array(
	        		'field' => 'mark_'. str_replace(' ', '',$markpercentage->markpercentageID),
	        		'label' => $markpercentage->markpercentagetype,
	        		'rules' => 'trim|xss_clean|max_length[11]'

	        	);
		    }
		}

		if($this->input->post('captcha_status') == '0') {
			$rules[] = array(
				'field' => 'recaptcha_site_key',
				'label' => $this->lang->line("setting_school_recaptcha_site_key"),
				'rules' => 'trim|required|xss_clean|max_length[255]'
			);

			$rules[] = array(
				'field' => 'recaptcha_secret_key',
				'label' => $this->lang->line("setting_school_recaptcha_secret_key"),
				'rules' => 'trim|required|xss_clean|max_length[255]'
			);
		}

		return $rules;
	}

	public function photoupload() {
		$setting = $this->setting_m->get_setting(1);
		$new_file = "site.png";
		if($_FILES["photo"]['name'] !="") {
			$file_name = $_FILES["photo"]['name'];
			$random = random19();
	    	$makeRandom = hash('sha512', $random.config_item("encryption_key"));
			$file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
	            $new_file = $file_name_rename.'.'.end($explode);
				$config['upload_path'] = "./uploads/images";
				$config['allowed_types'] = "gif|jpg|png";
				$config['file_name'] = $new_file;
				$config['max_size'] = '1024';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload("photo")) {
					$this->form_validation->set_message("photoupload", $this->upload->display_errors());
	     			return FALSE;
				} else {
					$this->upload_data['file'] =  $this->upload->data();
					return TRUE;
				}
			} else {
				$this->form_validation->set_message("photoupload", "Invalid file");
	     		return FALSE;
			}
		} else {
			if(count($setting)) {
				$this->upload_data['file'] = array('file_name' => $setting->photo);
				return TRUE;
			} else {
				$this->upload_data['file'] = array('file_name' => $new_file);
			return TRUE;
			}
		}
	}

	public function index() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/select2/select2.js'
			)
		);

		$usertype = $this->session->userdata("usertype");
		$this->data['setting'] = $this->setting_m->get_setting(1);

		$this->data['settingarray'] = $this->setting_m->get_setting_array();
		$this->data['markpercentages'] = $this->markpercentage_m->get_markpercentage();

		$this->data['schoolyears'] = $this->schoolyear_m->get_order_by_schoolyear(array('schooltype' => $this->data['setting']->school_type));

		$this->data['idmanagers'] = $this->idmanager_m->get_order_by_idmanager(array('schooltype' => $this->data['setting']->school_type));

		$this->data['themes'] = $this->themes_m->get_order_by_themes(array('backend' => 1));
		$this->data['classes'] = $this->classes_m->general_get_classes();

		if($this->data['setting']) {
			if($_POST) {
				$this->data['captcha_status'] = $this->input->post('captcha_status');
				$this->data['attendance_notification'] = $this->input->post('attendance_notification');
				$this->data['attendance_notification_templates'] = $this->templateSeter($this->input->post('attendance_notification'));

				$rules = $this->rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data["subview"] = "setting/index";
					$this->load->view('_layout_main', $this->data);
				} else {

					// if(config_item('demo') == FALSE) {
					// 	if($this->scode($this->data['setting']->purchase_code, $this->data['setting']->purchase_username, config_item('ini_version')) == FALSE) {
					// 		redirect(base_url('setting/index'));
					// 	}
					// }

					$array = array();
					for($i=0; $i<count($rules); $i++) {
						if($this->input->post($rules[$i]['field']) == false) {
							$array[$rules[$i]['field']] = 0;
						} else {
							$array[$rules[$i]['field']] = $this->input->post($rules[$i]['field']);
						}
					}

					if($this->input->post('weekends')) {
						$weekendsArray = $this->input->post('weekends');
						$weekends = implode(',', $weekendsArray);
						$array['weekends'] = $weekends;
						unset($array['weekends[]']);
					} else {
						unset($array['weekends[]']);
						$array['weekends'] = '';
					}

					$array['google_analytics'] = $this->input->post('google_analytics');

					if(!count($this->get_setting_mark_percentage($array))) {
						$array['mark_1'] = 1;
					}

					if(isset($array['language'])) {
						$this->session->set_userdata('lang',$array['language']);
					}

					if(isset($array['school_year'])) {
						$this->session->set_userdata('defaultschoolyearID',$array['school_year']);
					}

					$array['photo'] = $this->upload_data['file']['file_name'];

					$this->setting_m->insertorupdate($array);
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));

					frontendData::get_backend_delete();
                    frontendData::get_backend();
					redirect(base_url("setting/index"));
				}
			} else {
				$this->data['captcha_status'] = $this->data['setting']->captcha_status;
				$this->data['attendance_notification'] = $this->data['setting']->attendance_notification;
				$this->data['attendance_notification_templates'] = $this->templateSeter($this->data['setting']->attendance_notification);


				$this->data["subview"] = "setting/index";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	private function templateSeter($type) {
		return $this->mailandsmstemplate_m->get_order_by_mailandsmstemplate(array('type' => $type, 'usertypeID' => 3));
	}

	private function get_setting_mark_percentage($inputArrays) {
		$markpercentagesSettings = $this->setting_m->get_markpercentage();
		$array = array();
		if(count($markpercentagesSettings)) {
			foreach ($markpercentagesSettings as $key => $markpercentagesSetting) {
				if(array_key_exists($markpercentagesSetting->fieldoption, $inputArrays)) {
					if($inputArrays[$markpercentagesSetting->fieldoption] !=0) {
						$array[] = $inputArrays[$markpercentagesSetting->fieldoption];
					}
				}

			}
		}
		return $array;
	}

	public function unique_day() {
		$day = $this->input->post('automation');
		if((int)$day) {
			if($day < 0 || $day > 28) {
				$this->form_validation->set_message("unique_day", "%s already exists");
				return FALSE;
			}
			return TRUE;
		} else {
			$this->form_validation->set_message("unique_day", "%s already exists");
			return FALSE;
		}
	}

	// private function scode($pcode, $pusername, $version) {
	//
	// 	$email = trim($this->input->post('email'));
	//
  //       $apiCurl = actionVarifyValidUser($email);
	//
	// 	if($apiCurl->status == FALSE) {
	// 		$this->session->set_flashdata('error', $apiCurl->message);
	// 		return FALSE;
	// 	} else {
	// 		return TRUE;
	// 	}
	// }

	public function unique_attendance() {
		if($this->input->post('attendance') === "0") {
			$this->form_validation->set_message("unique_attendance", "The %s field is required");
			 	return FALSE;
		}
		return TRUE;
	}

	public function unique_schoolyear() {
		if($this->input->post('school_year') === "0") {
			$this->form_validation->set_message("unique_schoolyear", "The %s field is required");
			 	return FALSE;
		}
		return TRUE;
	}

	public function backendtheme() {
		$themesID = htmlentities(escapeString($this->input->post('id')));
		$themeName = 'default';
		if((int) $themesID) {
			$theme = $this->themes_m->get_single_themes(array('themesID' => $themesID));
			if(count($theme)) {
				$themeName = strtolower(str_replace(' ', '', $theme->themename));
			}
		}

		$this->setting_m->update_setting('backend_theme', $themeName);
		echo $themeName;
	}

	public function getTemplate() {

		$attendance_notification_template = $this->data["siteinfos"]->attendance_notification_template;

		$value = $this->input->post('value');
		$emailTemplates = $this->mailandsmstemplate_m->get_order_by_mailandsmstemplate(array('type' => $value, 'usertypeID' => 3));
		echo "<option value='0'>", $this->lang->line("setting_select_template"),"</option>";
		foreach ($emailTemplates as $template) {
			if ($template->mailandsmstemplateID == $attendance_notification_template) {
				echo "<option selected=\"selected\" value=\"$template->mailandsmstemplateID\">",$template->name,"</option>";
			} else {
				echo "<option value=\"$template->mailandsmstemplateID\">",$template->name,"</option>";
			}
		}
	}

	public function check_attendance_smsgateway() {
		$attendance_notification = $this->input->post('attendance_notification');
		$attendance_smsgateway = $this->input->post('attendance_smsgateway');
		if($attendance_notification =='sms' && $attendance_smsgateway == '0') {
			$this->form_validation->set_message("check_attendance_smsgateway", "The %s field is required");
			return false;
		}
		return true;
	}

	public function check_attendance_notification_template() {
		$attendance_notification = $this->input->post('attendance_notification');
		$attendance_notification_template = $this->input->post('attendance_notification_template');
		if($attendance_notification =='sms' && $attendance_notification_template == '0') {
			$this->form_validation->set_message("check_attendance_notification_template", "The %s field is required");
			return false;
		} elseif($attendance_notification =='email' && $attendance_notification_template == '0') {
			$this->form_validation->set_message("check_attendance_notification_template", "The %s field is required");
			return false;
		}
		return true;
	}

	public function unique_weekends() {
		$weekends = $this->input->post('weekends');
		if(count($weekends)) {
			foreach ($weekends as $weekend) {
				if($weekend < 0 || $weekend > 6) {
					$this->form_validation->set_message('unique_weekends', 'The %s data is unvalid.');
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	public function unique_ex_class($data) {
		$ex_class = $this->input->post('ex_class');
		if((int)$ex_class) {
			return TRUE;
		} else {
			$this->form_validation->set_message('unique_ex_class', 'The %s field is required.');
			return FALSE;
		}
	}

	public function unique_time_zone($data) {
		$timezone = $this->input->post('time_zone');
		if($timezone == 'none') {
			$this->form_validation->set_message('unique_time_zone', 'The %s field is required.');
			return FALSE;
		} else {
			if(isset($this->data['settingarray']['time_zone']) && ($this->data['settingarray']['time_zone'] != $this->input->post('time_zone'))) {
				$timeZone = $this->input->post('time_zone');
				$indexPath = getcwd()."/index.php";
				@chmod($indexPath, 0777);
				$filecontent = "date_default_timezone_set('". $timeZone ."');";
				$fileArray = array(2 => $filecontent);
				$this->replace_lines($indexPath, $fileArray);
				@chmod($indexPath, 0644);
			}
			return TRUE;
		}
		return TRUE;
	}

	private function replace_lines($file, $new_lines, $source_file = NULL) {
        $response = 0;
        $tab = chr(9);
        $lbreak = chr(13) . chr(10);
        if ($source_file) {
            $lines = file($source_file);
        }
        else {
            $lines = file($file);
        }
        foreach ($new_lines as $key => $value) {
            $lines[--$key] = $tab . $value . $lbreak;
        }
        $new_content = implode('', $lines);
        if ($h = fopen($file, 'w')) {
            if (fwrite($h, $new_content)) {
                $response = 1;
            }
            fclose($h);
        }
        return $response;
    }
}
