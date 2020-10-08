<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {
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

	protected $_info;
	protected $_internet_connection = FALSE;

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->helper('file');
		$this->load->helper('traffic');
		$this->load->config('iniconfig');


		$this->_info = array(
            'purchase_code' => '',
            'username'      => '',
            'ip'            => getIpAddress(),
            'domain'		=> base_url(),
            'purpose'       => 'update',
            'product_name'  => config_item('product_name'),
            'version'		=> config_item('ini_version'),
        );

        if($this->check_internet_connection()) {
			$this->_internet_connection = TRUE;
		}

		$pstatus = strpos($this->uri->uri_string(), 'install');
		if ($pstatus == FALSE && $this->config->config_install()) {
            redirect(site_url('signin'));
		}
	}

	protected function rules_purchase_code() {
		$rules = array(
			array(
				'field' => 'purchase_username',
				'label' => 'Username',
				'rules' => 'trim|required|max_length[255]|xss_clean|callback_pusername_validation'
			),
			array(
				'field' => 'purchase_code',
				'label' => 'Purchase Code',
				'rules' => 'trim|required|max_length[255]|xss_clean|callback_pcode_validation'
			)
		);
		return $rules;
	}

	protected function rules_database() {
		$rules = array(
				array(
					'field' => 'host',
					'label' => 'host',
					'rules' => 'trim|required|max_length[255]|xss_clean'
				),
				array(
					'field' => 'database',
					'label' => 'database',
					'rules' => 'trim|required|max_length[255]|xss_clean|callback_database_unique'
				),
				array(
					'field' => 'user',
					'label' => 'user',
					'rules' => 'trim|required|max_length[255]|xss_clean'
				),
				array(
					'field' => 'password',
					'label' => 'password',
					'rules' => 'trim|required|max_length[255]|xss_clean'
				)
			);
		return $rules;
	}

	protected function rules_timezone() {
		$rules = array(
				array(
					'field' => 'timezone',
					'label' => 'timezone',
					'rules' => 'trim|required|max_length[255]|xss_clean|callback_index_validation'
				)
			);
		return $rules;
	}

	protected function rules_site() {
		$rules = array(
				array(
					'field' => 'sname',
					'label' => 'Site Name',
					'rules' => 'trim|required|max_length[40]|xss_clean'
				),
				array(
					'field' => 'phone',
					'label' => 'Phone',
					'rules' => 'trim|required|max_length[25]|xss_clean'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|max_length[40]|xss_clean|valid_email|callback_email_update'
				),
				array(
					'field' => 'adminname',
					'label' => 'Admin Name',
					'rules' => 'trim|required|max_length[40]|xss_clean'
				),
				array(
					'field' => 'username',
					'label' => 'Username',
					'rules' => 'trim|required|max_length[40]|xss_clean'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|max_length[40]|xss_clean'
				),
			);
		return $rules;
	}

	public function index() {
		$this->data['errors'] = array();
		$this->data['success'] = array();

		// Check PHP version
		if (phpversion() < "5.6") {
			$this->data['errors'][] = 'You are running PHP old version';
		} else {
			$phpversion = phpversion();
			$this->data['success'][] = ' You are running PHP '.$phpversion;
		}
		// Check Mcrypt PHP exention
		if(!extension_loaded('mcrypt')) {
			$this->data['errors'][] = 'Mcriypt PHP exention unloaded';
		} else {
			$this->data['success'][] = 'Mcriypt PHP exention loaded';
		}
		// Check Mysql PHP exention
		if(!extension_loaded('mysqli')) {
			$this->data['errors'][] = 'Mysqli PHP exention unloaded';
		} else {
			$this->data['success'][] = 'Mysqli PHP exention loaded';
		}
		// Check MBString PHP exention
		if(!extension_loaded('mbstring')) {
			$this->data['errors'][] = 'MBString PHP exention unloaded';
		} else {
			$this->data['success'][] = 'MBString PHP exention loaded';
		}
		// Check GD PHP exention
		if(!extension_loaded('gd')) {
			$this->data['errors'][] = 'GD PHP exention unloaded';
		} else {
			$this->data['success'][] = 'GD PHP exention loaded';
		}
		// Check CURL PHP exention
		if(!extension_loaded('curl')) {
			$this->data['errors'][] = 'CURL PHP exention unloaded';
		} else {
			$this->data['success'][] = 'CURL PHP exention loaded';
		}
		// Check Mysql PHP exention
		if(!extension_loaded('zip')) {
			$this->data['errors'][] = 'Zip PHP exention unloaded';
		} else {
			$this->data['success'][] = 'Zip PHP exention loaded';
		}
		// Check Config Path
		if (@include($this->config->config_path)) {
			$this->data['success'][] = 'Config file is loaded';
			@chmod($this->config->config_path, FILE_WRITE_MODE);
			if(is_really_writable($this->config->config_path) == TRUE) {
				$this->data['success'][] = 'Config file is writable';
			} else {
				$this->data['errors'][] = 'Config file is unwritable';
			}
		} else {
			$this->data['errors'][] = 'Config file is unloaded';
		}
		// Check Database Path
		if (@include($this->config->database_path)) {
			$this->data['success'][] = 'Database file is loaded';
			@chmod($this->config->database_path, FILE_WRITE_MODE);
			if (is_really_writable($this->config->database_path) === FALSE) {
				$this->data['errors'][] = 'database file is unwritable';
			} else {
				$this->data['success'][] = 'Database file is writable';
			}

		} else {
			$this->data['errors'][] = 'Database file is unloaded';
		}

		if($this->_internet_connection) {
			$this->data['success'][] = 'Internet connection OK';
		} else {
			$this->data['errors'][] = 'Internet connection problem';
		}

		$this->data["subview"] = "install/index";
		$this->load->view('_layout_install', $this->data);
	}

	public function purchase_code() {
		if($_POST) {
			$rules = $this->rules_purchase_code();
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run() == FALSE) {
				$this->data["subview"] = "install/purchase_code";
				$this->load->view('_layout_install', $this->data);
			} else {
				redirect(base_url("install/database"));
			}
		} else {
			$this->data["subview"] = "install/purchase_code";
			$this->load->view('_layout_install', $this->data);
		}
	}

	public function database() {
		if($this->check_pcode() == TRUE) {
			if($_POST) {
				$rules = $this->rules_database();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$this->data["subview"] = "install/database";
					$this->load->view('_layout_install', $this->data);
				} else {
					redirect(base_url("install/timezone"));
				}
			} else {
				$this->data["subview"] = "install/database";
				$this->load->view('_layout_install', $this->data);
			}
		} else {
			redirect(base_url("install/purchase_code"));
		}
	}

	public function timezone() {
		if($this->check_pcode()) {
			if($this->check_database_connection()) {
				if($_POST) {
					$rules = $this->rules_timezone();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) {
						$this->data["subview"] = "install/timezone";
						$this->load->view('_layout_install', $this->data);
					} else {
						$array = array(
							'time_zone' => $this->input->post('timezone')
						);

						$this->load->model('install_m');
						$this->install_m->insertorupdate($array);
						redirect(base_url("install/site"));
					}
				} else {
					$this->data["subview"] = "install/timezone";
					$this->load->view('_layout_install', $this->data);
				}
			} else {
				redirect(base_url("install/database"));
			}
		} else {
			redirect(base_url("install/purchase_code"));
		}
	}

	public function site() {
		if($this->check_pcode()) {
			if($this->check_database_connection()) {
				if($_POST) {
					$this->load->library('session');
					unset($this->db);
					$rules = $this->rules_site();
					$this->form_validation->set_rules($rules);
					if ($this->form_validation->run() == FALSE) {
						$this->data["subview"] = "install/site";
						$this->load->view('_layout_install', $this->data);
					} else {
						$this->load->helper('form');
						$this->load->helper('url');
						$this->load->model('install_m');
						$this->load->model('systemadmin_m');
						$this->load->model('automation_shudulu_m');
						$this->load->model('schoolyear_m');
						$this->load->model('update_m');
						$this->get_purchase_code();

						$array = array(
							'address' => $this->input->post("address"),
							'attendance' => 'day',
							'automation' => 5,
							'auto_invoice_generate' => 0,
							'backend_theme' => 'default',
							'currency_code' => $this->input->post("currency_code"),
							'currency_symbol' => $this->input->post("currency_symbol"),
							'email' => $this->input->post("email"),
							'frontendorbackend' => TRUE,
							'frontend_theme' => 'default',
							'footer' =>  'Copyright &copy; '. $this->input->post("sname"),
							'google_analytics' => '',
							'language' => 'english',
							'mark_1' => 1,
							'note' => 1,
							'phone' => $this->input->post("phone"),
							'photo' => 'site.png',
							'purchase_code' => $this->_info['purchase_code'],
							'purchase_username' => $this->_info['username'],
							'school_type' => 'classbase',
							'school_year' => 1,
							'sname' => $this->input->post("sname"),
							'student_ID_format' => 1,
							'updateversion' => config_item('ini_version'),
							'captcha_status' => 1,
							'recaptcha_site_key' => '',
							'recaptcha_secret_key' => '',
						);

						$array_admin = array(
							'name' => $this->input->post("adminname"),
							'dob' => date('Y-m-d'),
							'sex' => 'Male',
							'religion' => 'Unknown',
							'email' => $this->input->post("email"),
							'phone' => '',
							'address' => '',
							'jod' => date('Y-m-d'),
							'photo' => 'default.png',
							'username' => $this->input->post("username"),
							'password' => $this->install_m->hash($this->input->post("password")),
							'usertypeID' => 1,
							'create_date' => date("Y-m-d h:i:s"),
							'modify_date' => date("Y-m-d h:i:s"),
							'create_userID' => 0,
							'create_username' => $this->input->post("username"),
							'create_usertype' => 'Admin',
							'active' => 1,
							'systemadminextra1' => '',
							'systemadminextra2' => ''
						);

						$array_schedule = array(
							'date' => date('Y-m-d'),
							'day' => date('d'),
							'month' => date('m'),
							'year' => date('Y')
						);

						$array_schoolyear = array(
							'schoolyear' => (date('Y').'-'.((int)date('Y')+ 1)),
							'startingdate' => (date('Y').'-'.'01-01'),
							'endingdate' => (date('Y').'-'.'12-31')
						);

						$array_version = array(
							'version' => config_item('ini_version'),
							'date' => date('Y-m-d H:i:s'),
							'userID' => 1,
							'usertypeID' => 1,
							'log' => '<h4>1. initial install</h4>',
							'status' => 1
						);
						
						$this->install_m->insertorupdate($array);
						$this->systemadmin_m->update_systemadmin($array_admin, 1);
						$this->automation_shudulu_m->update_automation_shudulu($array_schedule, 1);
						$this->schoolyear_m->update_schoolyear($array_schoolyear, 1);
						$this->update_m->insert_update($array_version);

						$this->load->library('session');
						$sesdata= array(
		                   	'username'  => $this->input->post('username'),
		                   	'password'  => $this->input->post('password'),
		               	);
						$this->session->set_userdata($sesdata);
						redirect(base_url("install/done"));
					}
				} else {
					$this->data["subview"] = "install/site";
					$this->load->view('_layout_install', $this->data);
				}
			} else {
				redirect(base_url("install/database"));	
			}
		} else {
			redirect(base_url("install/purchase_code"));
		}
	}

	public function done() {
		if($this->check_pcode()) {
			if($this->check_database_connection()) {
				$this->load->library('session');
				if($this->session->userdata('username') && $this->session->userdata('password')) {
					$this->load->library('session');
					if($_POST) {
						$this->config->config_update(array("installed" => TRUE));
						@chmod($this->config->database_path, FILE_READ_MODE);
						@chmod($this->config->config_path, FILE_READ_MODE);
						$this->session->sess_destroy();
						redirect(site_url('signin/index'));
					} else {
						$this->data["subview"] = "install/done";
						$this->load->view('_layout_install', $this->data);
					}
				} else {
					redirect(base_url("install/site"));	
				}
			} else {
				redirect(base_url("install/database"));	
			}
		} else {
			redirect(base_url("install/purchase_code"));
		}
	}

	public function email_update() {
		$this->get_purchase_code();
		
		$apiCurl = apiCurl($this->_info);
		return $apiCurl->status;
	}

	public function database_unique() {
		if(strpos($this->input->post('database'), '.') === false) {
			ini_set('display_errors', 'Off');
			$config_db['hostname'] = trim($this->input->post('host'));
			$config_db['username'] = trim($this->input->post('user'));
			$config_db['password'] = $this->input->post('password');
			$config_db['database'] = trim($this->input->post('database'));
			$config_db['dbdriver'] = 'mysqli';
			$this->config->db_config_update($config_db);
			$db_obj = $this->load->database($config_db,TRUE);

	  		$connected = $db_obj->initialize();
	  		if($connected) {
	  			unset($this->db);
				$config_db['db_debug'] = FALSE;
				$this->load->database($config_db);
				$this->load->dbutil();
	  			if ($this->dbutil->database_exists($this->db->database)) {
					if ($this->db->table_exists('setting') == FALSE) {
					    $id = uniqid();
						$encryption_key = md5(config_item('product_name').$id);
						$this->config->config_update(array('encryption_key'=> $encryption_key));

						$this->get_purchase_code();

						$this->_info['purpose'] = 'install';
				        
				        $apiCurl = apiCurl($this->_info);

						if($apiCurl->status == TRUE) {
							$this->load->model('install_m');

							if(!empty($apiCurl->schema)) {
								$schemes = $apiCurl->schema;
								$expSchemas = explode(';', $schemes);
								if(count($expSchemas)) {
									foreach ($expSchemas as $expSchema) {
										$this->install_m->use_sql_string($expSchema);
									}
									return TRUE;
								} else {
									$this->form_validation->set_message("database_unique", "Schema not explode.");
									return FALSE;
								}
							} else {
								$this->form_validation->set_message("database_unique", "Schema not found.");
								return FALSE;
							}
						} else {
							$this->form_validation->set_message("database_unique", "Check internet connection.");
							return FALSE;
						}
					}
					return TRUE;
				} else {
					$this->form_validation->set_message("database_unique", "Database Not Found.");
					return FALSE;
				}
	  		} else {
	  			$this->form_validation->set_message("database_unique", "Database Connection Failed.");
				return FALSE;
	  		}
		} else {
			$this->form_validation->set_message("database_unique", "Database can not accept dot in DB name.");
			return FALSE;
		}
	}

	public function check_database_connection() {
		ini_set('display_errors', 'Off');
		$getConnectionArray = $this->config->db_config_get();
		$get_obj = $this->load->database($getConnectionArray, TRUE);
  		$connected = $get_obj->initialize();
  		if($connected) {
  			return TRUE;
  		}
  		return FALSE;
	}

	public function index_validation() {
		$timezone = $this->input->post('timezone');
		@chmod($this->config->index_path, 0777);
		if (is_really_writable($this->config->index_path) === FALSE) {
			$this->form_validation->set_message("index_validation", "Index file is unwritable");
			return FALSE;
		} else {
			$file = $this->config->index_path;
			$filecontent = "date_default_timezone_set('". $timezone ."');";
			$fileArray = array(2 => $filecontent);
			$this->replace_lines($file, $fileArray);
			@chmod($this->config->index_path, 0644);
			return TRUE;
		}
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

	public function pcode_validation() {
		$file = APPPATH.'config/purchase'.EXT;

		if(!$this->_internet_connection) {
			$this->form_validation->set_message("pcode_validation", 'Internet connection problem!');
			return FALSE;
		}

		if (!is_really_writable($file)) {
			$this->form_validation->set_message("pcode_validation", 'mvc/config folder is not writable');
			return FALSE;
		}

		$this->_info['purchase_code'] = trim($this->input->post('purchase_code'));
		$this->_info['username'] = trim($this->input->post('purchase_username'));

		$apiCurl = apiCurl($this->_info);

        if($apiCurl->status == FALSE) {
			if($apiCurl->for == 'purchasecode' || $apiCurl->for == 'block') {
				$this->form_validation->set_message("pcode_validation", $apiCurl->message);
				return FALSE;
			}
			return TRUE;
		} else {
			$uac = json_encode(array(trim($this->input->post('purchase_username')), trim($this->input->post('purchase_code'))));
			@chmod($file, FILE_WRITE_MODE);
			$purchase_file = file_get_contents($file);
			write_file($file, $uac);
			return TRUE;
		}
	}

	public function pusername_validation() {

		$file = APPPATH.'config/purchase'.EXT;

		if (!is_really_writable($file)) {
			$this->form_validation->set_message("pusername_validation", 'mvc/config folder is not writable');
			return FALSE;
		}

		$this->_info['purchase_code'] = trim($this->input->post('purchase_code'));
		$this->_info['username'] = trim($this->input->post('purchase_username'));

		$apiCurl = apiCurl($this->_info);


		if($apiCurl->status == FALSE) {
			if($apiCurl->for == 'username') {
				$this->form_validation->set_message("pusername_validation", $apiCurl->message);
				return FALSE;
			}
			return TRUE;
		}
		return TRUE;
	}

	private function check_pcode() {
		$this->get_purchase_code();
		if(empty($this->_info['purchase_code']) || empty($this->_info['username'])) {
			return FALSE;
		}
        $apiCurl = apiCurl($this->_info);
		return $apiCurl->status;
	}

	private function get_purchase_code() {
		$file = APPPATH.'config/purchase'.EXT;
		@chmod($file, FILE_WRITE_MODE);
		$purchase = file_get_contents($file);
		$purchase = json_decode($purchase);

		if(is_array($purchase)) {
			$this->_info['purchase_code'] = trim($purchase[1]);
			$this->_info['username'] = trim($purchase[0]);
			return TRUE;
		}
		return FALSE;
	}

	private function check_internet_connection($sCheckHost = 'www.google.com')  {
    	return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
	}
}


