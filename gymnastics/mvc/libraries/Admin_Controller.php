<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property document_m $document_m
 * @property email_m $email_m
 * @property error_m $error_m
 */
class Admin_Controller extends MY_Controller {
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
	
	private $_backendTheme = '';
	private $_backendThemePath = '';

	public function __construct () {
		parent::__construct();
		$this->load->model("signin_m");
		$this->load->model("permission_m");
		$this->load->model("site_m");
		$this->load->model("holiday_m");
		$this->load->model("schoolyear_m");
		$this->load->library("session");
		$this->load->helper('language');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('traffic');
		$this->load->library('form_validation');
		$this->load->model('classes_m');
		$this->load->model("menu_m");
		
		$this->data["siteinfos"] = $this->site_m->get_site(1);

		$schoolyearID = $this->data['siteinfos']->school_year;
		$this->data['schoolyearobj'] = $this->schoolyear_m->get_obj_schoolyear($schoolyearID);

		$this->data['schoolyearsessionobj'] = $this->schoolyear_m->get_obj_schoolyear($this->session->userdata('defaultschoolyearID'));

		$this->data['backendTheme'] = strtolower($this->data["siteinfos"]->backend_theme);
		$this->data['backendThemePath'] = 'assets/inilabs/themes/'.strtolower($this->data["siteinfos"]->backend_theme);
		$this->_backendTheme = $this->data['backendTheme'];
		$this->_backendThemePath = $this->data['backendThemePath'];

		$this->data['topbarschoolyears'] = $this->schoolyear_m->get_order_by_schoolyear(array('schooltype' => $this->data["siteinfos"]->school_type));
		

		/* Alert System Start */
		$this->load->model("notice_m");
		$this->load->model("alert_m");
		$this->data['all'] = array();
		$this->data['alert'] = array('notice' => array(), 'mark' => array(), 'message' => array());

		$this->data['alertfire'] = $this->getAllAlert();
		

		$this->alertNoticeChecker();

		$alertUsertypeID = $this->session->userdata('usertypeID');
		if($alertUsertypeID == 3) {
			$this->load->model('studentrelation_m');
			$alertTopbarStudentSchoolyearID = $this->session->userdata('defaultschoolyearID');
			$this->data['alertTopbarStudent'] = pluck($this->studentrelation_m->get_order_by_student(array('srschoolyearID' => $alertTopbarStudentSchoolyearID)), 'name', 'studentID');
			$alertLoginuserID = $this->session->userdata('loginuserID');
			$this->alertMarkChecker($alertLoginuserID);
		} elseif($alertUsertypeID == 4) {
			$this->load->model('studentrelation_m');
			$alertTopbarStudentSchoolyearID = $this->session->userdata('defaultschoolyearID');
			$this->data['alertTopbarStudent'] = pluck($this->studentrelation_m->get_order_by_student(array('srschoolyearID' => $alertTopbarStudentSchoolyearID)), 'name', 'studentID');
			$students = $this->studentrelation_m->get_order_by_student(array('parentID' => $this->session->userdata('loginuserID')));
			if(count($students)) {
				foreach ($students as $student) {
					$this->alertMarkChecker($student->studentID);
				}
			}
		}

		$this->alertMessageChecker();

		$this->alertEventChecker();

		$this->alertHolidayChecker();

		$this->data['alert'] = $this->alertConvertor($this->data['alert']);

		if($alertUsertypeID == 3) {
			$this->load->model('studentrelation_m');
			$student = $this->studentrelation_m->get_single_student(array('srstudentID' => $this->session->userdata('loginuserID'), 'srschoolyearID' => $this->session->userdata('defaultschoolyearID')));
			if(count($student)) {
				$this->data['myclass'] = $student->srclassesID;
			} else {
				$this->data['myclass'] = 0;
			}
		} else {
			$this->data['myclass'] = 0;
		}
		
		/* Alert System End.........*/

		/* Start All country and bloodgroup */
		$this->data['sitesettings'] = array(
			'schooltype' => 'classbase'
		);
		$this->data['allcountry'] = $this->getAllCountry();
		$this->data['allbloodgroup'] = $this->getAllBloodgroup();
		/* End All country and bloodgroup */

		$language = $this->session->userdata('lang');
		$this->lang->load('topbar_menu', $language);

		$exception_uris = array(
			'signin/index',
			'signin/signout'
		);

		if(in_array(uri_string(), $exception_uris) == FALSE) {
			if($this->signin_m->loggedin() == FALSE) {
				if($this->data["siteinfos"]->frontendorbackend === 'YES') {
					$this->load->model('fmenu_m');
					$this->load->model('pages_m');
					$frontendTopbar = $this->fmenu_m->get_single_fmenu(array('topbar' => 1));
					$homePage = $this->pages_m->get_one($frontendTopbar);
					$frontendRedirectURL = '';
					$frontendRedirectMethod = 'page';
					if(count($homePage)) {
			            if($homePage->menu_typeID == 1) {
			                $page = $this->pages_m->get_single_pages(array('pagesID' => $homePage->menu_pagesID));
			                if(count($page)) {
			                	$frontendRedirectURL = $page->url;
			                	$frontendRedirectMethod = 'page';
			                } 
			            } elseif($homePage->menu_typeID == 2) {
			                $post = $this->posts_m->get_single_posts(array('postsID' => $homePage->menu_pagesID));
			                if(count($post)) {
			                	$frontendRedirectURL = $post->url;
			                	$frontendRedirectMethod = 'post';
			                } 
			            }  
			        }

					redirect(base_url('frontend/'.$frontendRedirectMethod.'/'.$frontendRedirectURL));
				} else {
					redirect(base_url("signin/index"));
				}
			}
		}


		$module = $this->uri->segment(1);
		$action = $this->uri->segment(2);
		$permission = '';

		if($action == 'index' || $action == false) {
			$permission = $module;
		} else {
			$permission = $module.'_'.$action;
		}

		$permissionset = array();
		$userdata = $this->session->userdata;

		if($this->session->userdata('usertypeID') == 1 && $this->session->userdata('loginuserID') == 1) {
			if(isset($userdata['loginuserID']) && !isset($userdata['get_permission'])) {

				$allmodules = $this->permission_m->get_permission();

				if(count($allmodules)) {
					foreach ($allmodules as $key => $allmodule) {
						$permissionset['master_permission_set'][trim($allmodule->name)] = $allmodule->active;
					}
					$permissionset['master_permission_set']['take_exam'] = 'yes';
					$data = ['get_permission' => TRUE];
					$this->session->set_userdata($data);
					$this->session->set_userdata($permissionset);
				}
			}
		} else {
			if(isset($userdata['loginuserID']) && !isset($userdata['get_permission'])) {
				if(!$this->session->userdata($permission)) {
					$user_permission = $this->permission_m->get_modules_with_permission($userdata['usertypeID']);

					foreach ($user_permission as $value) {
						$permissionset['master_permission_set'][$value->name] = $value->active;
					}

					if($userdata['usertypeID'] == 3) {
						$permissionset['master_permission_set']['take_exam'] = 'yes';
					}
					
					$data = ['get_permission' => TRUE];
					$this->session->set_userdata($data);
					$this->session->set_userdata($permissionset);
				}
			}
		}


		$sessionPermission = $this->session->userdata('master_permission_set');

		$dbMenus	= $this->menuTree(json_decode(json_encode(pluck($this->menu_m->get_order_by_menu(['status' => 1]), 'obj', 'menuID')), true) , $sessionPermission);
		$this->data["dbMenus"] = $dbMenus;

		if((isset($sessionPermission[$permission]) && $sessionPermission[$permission] == "no") ) {
			if($permission == 'dashboard' && $sessionPermission[$permission] == "no") {
				$url = 'exceptionpage/index';
				if(in_array('yes', $sessionPermission)) {
			    	if($sessionPermission["dashboard"] == 'no') {
			    		foreach ($sessionPermission as $key => $value) {
			    			if($value == 'yes') {
			    				$url = $key;
			    				break;
			    			}
			    		}
			    	}
		    	} else {
		    		redirect(base_url('exceptionpage/index'));
		    	}
		    	redirect(base_url($url));
			} else {
				redirect(base_url('exceptionpage/error'));
			}
		}
	}

	private function getAllAlert() {
		$retArray = [];
		$alerts = $this->alert_m->get_order_by_alert(array('userID' => $this->session->userdata('loginuserID'), 'usertypeID' => $this->session->userdata('usertypeID')));
		if(count($alerts)) {
			foreach ($alerts as $alert) {
				$retArray[$alert->itemID][$alert->itemname] = $alert;
			}
		}
		return $retArray;
	} 

	public function alertConvertor($arrays) {
		$alert = $this->data['alertfire'];
		$retArray = [];
		if(count($arrays)) {
			foreach ($arrays as $array) {
				foreach ($array as  $ar) {
					$retArray[] = $ar;
				}
			}
			
			$retArray = json_decode(json_encode($retArray), TRUE);
			array_multisort(array_column($retArray, "create_date"), SORT_DESC, $retArray);
			$retArray = json_decode(json_encode($retArray), FALSE);
		}

		return $retArray;
	}

	private function alertNoticeChecker() {
		$alert = $this->data['alertfire'];
		$notices = $this->notice_m->get_order_by_notice(array('schoolyearID' => $this->session->userdata('defaultschoolyearID')));
		if(count($notices)) {
			foreach ($notices as $notice) {
				if(!isset($alert[$notice->noticeID]['notice'])) {
					$this->data['alert']['notice'][] = $notice;
				}
			}
		}

		return $this->data['alert'];
	}

	private function alertMarkChecker($alertLoginuserID) {
		if(permissionChecker('mark_view')) {
			$this->load->model('mark_m');
			$this->load->model('subject_m');
			$this->load->model('markrelation_m');

			$alertSchoolyearID = $this->session->userdata('defaultschoolyearID');
			$alertMarks = $this->mark_m->get_order_by_mark(array('schoolyearID' => $alertSchoolyearID, 'studentID' => $alertLoginuserID));
			$alert = $this->data['alertfire'];
			if(count($alertMarks)) {
				foreach ($alertMarks as $alertMark) {
					if(!isset($alert[$alertMark->markID]['mark'])) {
						$this->data['alert']['mark'][] = $alertMark;
					}
				}
			}
			return $this->data['alert'];
		}
	}

	private function alertMessageChecker() {
		$allMessageSend = [];
		$this->load->model('conversation_m');
		$messageUsertypeID = $this->session->userdata("usertypeID");
		$messageUserID = $this->session->userdata("loginuserID");
		$this->data['messageConversations'] = $this->conversation_m->get_my_conversations(); 
		$this->data['messageMethodpass'] = $this->uri->segment(htmlentities(escapeString(2)));
		$messageBind = [];

		if ($this->data['messageConversations']) {
			foreach ($this->data['messageConversations'] as $key => $item) {
				if ($item['usertypeID']== 1) {
					$table = "systemadmin";
				} elseif($item['usertypeID']== 2) {
					$table = "teacher";
				} elseif($item['usertypeID']== 3) {
					$table = 'student';
				} elseif($item['usertypeID']== 4) {
					$table = 'parents';
				} else {
					$table = 'user';
				}

				$messageQuery = $this->db->get_where($table, array($table.'ID' => $item['user_id']));
				if(count($messageQuery->row())) {
					$this->data['messageConversations'][$key] = array_merge((array)$item, array('sender' => $messageQuery->row()->name));
				}
			}

			$allMessages = [];
			if(count($this->data['messageConversations'])) {
				foreach ($this->data['messageConversations'] as $key => $value) {
					$getmessage = $this->conversation_m->get_conversation_msg_by_id($value['conversation_id']);
					if(count($getmessage)) {
						$allMessages[] = $this->conversation_m->get_conversation_msg_by_id($value['conversation_id']);
					}
				}
			} else {
				$allMessages = [];
			}

			$alertAllMessage = $this->data['alertfire'];
			
			if(count($allMessages)) {
				array_multisort($allMessages, SORT_DESC);

				$flagArray = [];
				$flagSubject = [];
				foreach ($allMessages as $allMessage) {
					if(count($allMessage)) {
						foreach ($allMessage as $messageKey => $messageValue) {
							if(!array_key_exists($messageValue->conversation_id, $flagSubject)) {
								$flagSubject[$messageValue->conversation_id] = $messageValue->subject;
							}

							if(!isset($alertAllMessage[$messageValue->msg_id]['message'])) {
								if(!in_array($messageValue->conversation_id, $flagArray)) {
									$flagArray[] = $messageValue->conversation_id;
								}

								if(in_array($messageValue->conversation_id, $flagArray)) {
									$messageBind[$messageValue->conversation_id] = $messageValue;
								}
							}
						}
					}
				}

				if(count($messageBind)) {
					$messageBind = json_decode(json_encode($messageBind), true);
					foreach ($messageBind as $key => $mbind) {
						if(empty($mbind['subject'])) {
							if(isset($flagSubject[$mbind['conversation_id']])) {
								$messageBind[$mbind['conversation_id']]['subject'] = $flagSubject[$mbind['conversation_id']];
								$messageBind[$mbind['conversation_id']] = (object) $messageBind[$mbind['conversation_id']];
							}
						} else {
							$messageBind[$mbind['conversation_id']] = (object) $messageBind[$mbind['conversation_id']];
						}
					}
				}
			}
		}

		$this->data['alert']['message'] = $messageBind;
		return $this->data['alert'];
	}

	private function alertEventChecker() {
		if(permissionChecker('event_view')) {
			$alert = $this->data['alertfire'];
			$this->load->model('event_m');
			$events = $this->event_m->get_order_by_event(array('schoolyearID' => $this->session->userdata('defaultschoolyearID')));
			if(count($events)) {
				foreach ($events as $event) {
					if(!isset($alert[$event->eventID]['event'])) {
						$this->data['alert']['event'][] = $event;
					}
				}
			}
			return $this->data['alert'];
		}
	}

	private function alertHolidayChecker() {
		if(permissionChecker('holiday_view')) {
			$alert = $this->data['alertfire'];
			$this->load->model('holiday_m');
			$holiday = $this->holiday_m->get_order_by_holiday(array('schoolyearID' => $this->session->userdata('defaultschoolyearID')));

			if(count($holiday)) {
				foreach ($holiday as $holiday) {
					if(!isset($alert[$holiday->holidayID]['holiday'])) {
						$this->data['alert']['holiday'][] = $holiday;
					}
				}
			}
			return $this->data['alert'];
		}
	}

	public function usercreatemail($email=NULL, $username=NULL, $password=NULL) {
		$this->load->model('emailsetting_m');
		$emailSetting = $this->emailsetting_m->get_emailsetting();
		$this->load->library('email');
		$this->email->set_mailtype("html");

		if(count($emailSetting)) {
			if($emailSetting->email_engine == 'smtp') {
				$config = array(
				    'protocol'  => 'smtp',
				    'smtp_host' => $emailSetting->smtp_server,
				    'smtp_port' => $emailSetting->smtp_port,
				    'smtp_user' => $emailSetting->smtp_username,
				    'smtp_pass' => $emailSetting->smtp_password,
				    'mailtype'  => 'html',
				    'charset'   => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->set_newline("\r\n");
			}
		}

	    if($email) {
	        $this->email->from($this->data['siteinfos']->email, $this->data['siteinfos']->sname);
	        $this->email->to($email);
	        $this->email->subject($this->data['siteinfos']->sname);
	        $url = base_url();
	        $message = "<h2>Welcome to ".$this->data['siteinfos']->sname."</h2>
	        <p>Please log-in to this website and change the password as soon as possible </p>
	        <p>Website : ".$url."</p>
	        <p>Username: ".$username."</p>
	        <p>Password: ".$password."</p>
	        <br>
	        <p>Once again, thank you for choosing ".$this->data['siteinfos']->sname."</p>
	        <p>Best Wishes,</p>
	        <p>The ".$this->data['siteinfos']->sname." Team</p>";
	        $this->email->message($message);
	        $this->email->send();
	    }
	}

	public function reportPDF($stylesheet=NULL, $data=NULL, $viewpath= NULL, $mode = 'view', $pagesize = 'a4', $pagetype='portrait') {
		$designType = 'LTR';
		$this->data['panel_title'] = $this->lang->line('panel_title');
		$html = $this->load->view($viewpath, $this->data, true);

		$this->load->library('mhtml2pdf');

		$this->mhtml2pdf->folder('uploads/report/');
		$this->mhtml2pdf->filename('Report');
		$this->mhtml2pdf->paper($pagesize, $pagetype);
		$this->mhtml2pdf->html($html);

		if(!empty($stylesheet)) {
			$stylesheet = file_get_contents(base_url('assets/pdf/'.$designType.'/'.$stylesheet));
			return $this->mhtml2pdf->create($mode, $this->data['panel_title'], $stylesheet);
		} else { 
			return $this->mhtml2pdf->create($mode, $this->data['panel_title']);
		}
	}

	public function reportSendToMail($stylesheet=NULL, $data=NULL, $viewpath=NULL, $email=NULL, $subject=NULL, $message=NULL, $pagesize = 'a4', $pagetype='portrait') {
		$this->load->model('emailsetting_m');

		$designType = 'LTR';
		$this->load->library('email');
		$this->load->library('mhtml2pdf');
	    $this->mhtml2pdf->folder('uploads/report/');
	    $rand = random19() . date('y-m-d h:i:s');
	    $sharand = hash('sha512', $rand);

	    $this->mhtml2pdf->filename($sharand);
	    $this->mhtml2pdf->paper($pagesize, $pagetype);
	    $this->data['panel_title'] = $this->lang->line('panel_title');
		$html = $this->load->view($viewpath, $this->data, true);
		$this->mhtml2pdf->html($html);


		if(!empty($stylesheet)) {
			$stylesheet = file_get_contents(base_url('assets/pdf/'.$designType.'/'.$stylesheet));
		}

		$emailsetting = $this->emailsetting_m->get_emailsetting();
		$this->email->set_mailtype("html");

		if(count($emailsetting)) {
			if($path = @$this->mhtml2pdf->create('save',$this->data['panel_title'], $stylesheet)) {
				if($emailsetting->email_engine == 'smtp') {
					$config = array(
					    'protocol'  => 'smtp',
					    'smtp_host' => $emailsetting->smtp_server,
					    'smtp_port' => $emailsetting->smtp_port,
					    'smtp_user' => $emailsetting->smtp_username,
					    'smtp_pass' => $emailsetting->smtp_password,
					    'mailtype'  => 'html',
					    'charset'   => 'utf-8'
					);
					$this->email->initialize($config);
					$this->email->set_newline("\r\n");
				}

				$fromEmail = $this->data["siteinfos"]->email;
				if($this->session->userdata('email') != '') {
					$fromEmail = $this->session->userdata('email');
				}

				$this->email->from($fromEmail, $this->data['siteinfos']->sname);
				$this->email->to($email);
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->attach($path);
				if($this->email->send()) {
					$this->session->set_flashdata('success', $this->lang->line('mail_success'));
				} else {
					$this->session->set_flashdata('error', $this->lang->line('mail_error'));
				}
			}
		} else {
			$this->session->set_flashdata('error', $this->lang->line('mail_error'));
		}
	}

	public function getAllCountry() {
		$country = array(
			"AF" => "Afghanistan",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua and Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BA" => "Bosnia and Herzegovina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"BQ" => "British Antarctic Territory",
			"IO" => "British Indian Ocean Territory",
			"VG" => "British Virgin Islands",
			"BN" => "Brunei",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CT" => "Canton and Enderbury Islands",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos [Keeling] Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo - Brazzaville",
			"CD" => "Congo - Kinshasa",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"HR" => "Croatia",
			"CU" => "Cuba",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"CI" => "Côte d’Ivoire",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"NQ" => "Dronning Maud Land",
			"DD" => "East Germany",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"FQ" => "French Southern and Antarctic Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GG" => "Guernsey",
			"GN" => "Guinea",
			"GW" => "Guinea-Bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard Island and McDonald Islands",
			"HN" => "Honduras",
			"HK" => "Hong Kong SAR China",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IM" => "Isle of Man",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JE" => "Jersey",
			"JT" => "Johnston Island",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Laos",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macau SAR China",
			"MK" => "Macedonia",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"FX" => "Metropolitan France",
			"MX" => "Mexico",
			"FM" => "Micronesia",
			"MI" => "Midway Islands",
			"MD" => "Moldova",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"ME" => "Montenegro",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar [Burma]",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NT" => "Neutral Zone",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"KP" => "North Korea",
			"VD" => "North Vietnam",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PC" => "Pacific Islands Trust Territory",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PS" => "Palestinian Territories",
			"PA" => "Panama",
			"PZ" => "Panama Canal Zone",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"YD" => "People's Democratic Republic of Yemen",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn Islands",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RO" => "Romania",
			"RU" => "Russia",
			"RW" => "Rwanda",
			"RE" => "Réunion",
			"BL" => "Saint Barthélemy",
			"SH" => "Saint Helena",
			"KN" => "Saint Kitts and Nevis",
			"LC" => "Saint Lucia",
			"MF" => "Saint Martin",
			"PM" => "Saint Pierre and Miquelon",
			"VC" => "Saint Vincent and the Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"RS" => "Serbia",
			"CS" => "Serbia and Montenegro",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SK" => "Slovakia",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia and the South Sandwich Islands",
			"KR" => "South Korea",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard and Jan Mayen",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syria",
			"ST" => "São Tomé and Príncipe",
			"TW" => "Taiwan",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania",
			"TH" => "Thailand",
			"TL" => "Timor-Leste",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad and Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks and Caicos Islands",
			"TV" => "Tuvalu",
			"UM" => "U.S. Minor Outlying Islands",
			"PU" => "U.S. Miscellaneous Pacific Islands",
			"VI" => "U.S. Virgin Islands",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"SU" => "Union of Soviet Socialist Republics",
			"AE" => "United Arab Emirates",
			"GB" => "United Kingdom",
			"US" => "United States",
			"ZZ" => "Unknown or Invalid Region",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VA" => "Vatican City",
			"VE" => "Venezuela",
			"VN" => "Vietnam",
			"WK" => "Wake Island",
			"WF" => "Wallis and Futuna",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe",
			"AX" => "Åland Islands",
			);
		return $country;
	}

	public function getAllBloodgroup() {
		$bloodgroup = array(
			'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'B-' => 'B-',
            'O+' => 'O+',
            'O-' => 'O-',
            'AB+' => 'AB+',
            'AB-' => 'AB-'
        );
        return $bloodgroup;
	}

	public function menuTree($dataset, $sessionPermission) {
    	$tree = array();
    	foreach ($dataset as $id=>&$node) {
			// echo $node['menuName']." => ";
			// echo (isset($sessionPermission[$node['link']]) && $sessionPermission[$node['link']] != "no");
			// echo "<br>";
			if($node['link'] == '#' || (isset($sessionPermission[$node['link']]) && $sessionPermission[$node['link']] != "no") ) {
	    		if ($node['parentID'] == 0) {
	    			$tree[$id]=&$node;
	    		} else {
					if (!isset($dataset[$node['parentID']]['child']))
						$dataset[$node['parentID']]['child'] = array();

					$dataset[$node['parentID']]['child'][$id] = &$node;
	    		}
			}
    	}
    	return $tree;
    }

    public function getHolidays() {
    	$schoolyearID = $this->data['siteinfos']->school_year;
		$holidays = $this->holiday_m->get_order_by_holiday(array('schoolyearID' => $schoolyearID));
		$allHolidayList = array();
		if(count($holidays)) {
			foreach ($holidays as $holiday) {
				$from_date = strtotime($holiday->fdate);
				$to_date   = strtotime($holiday->tdate);
				$oneday    = 60*60*24;
				for($i= $from_date; $i<= $to_date; $i= $i+$oneday) {
				   	$allHolidayList[] = date('d-m-Y', $i);
				}
			}
		}

		$uniqueHolidays =  array_unique($allHolidayList);
		if(count($uniqueHolidays)) {
	        $uniqueHolidays = implode('","', $uniqueHolidays);
	    } else {
	        $uniqueHolidays = '';
	    }
	    
	    return $uniqueHolidays;
	}

	public function getHolidaysSession() {
    	$schoolyearID = $this->session->userdata('defaultschoolyearID');
		$holidays = $this->holiday_m->get_order_by_holiday(array('schoolyearID' => $schoolyearID));
		$allHolidayList = array();
		if(count($holidays)) {
			foreach ($holidays as $holiday) {
				$from_date = strtotime($holiday->fdate);
				$to_date   = strtotime($holiday->tdate);
				$oneday    = 60*60*24;
				for($i= $from_date; $i<= $to_date; $i= $i+$oneday) {
				   	$allHolidayList[] = date('d-m-Y', $i);
				}
			}
		}

		$uniqueHolidays =  array_unique($allHolidayList);
		if(count($uniqueHolidays)) {
	        $uniqueHolidays = implode('","', $uniqueHolidays);
	    } else {
	        $uniqueHolidays = '';
	    }
	    
	    return $uniqueHolidays;
	}

	public function getWeekendDays() {
		$date_from = strtotime($this->data['schoolyearobj']->startingdate);
		$date_to = strtotime($this->data['schoolyearobj']->endingdate);
		$oneDay = 60*60*24;

		$allDays = array(
            '0' => 'Sunday',
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday'
        );

       	$weekendDay = $this->data['siteinfos']->weekends;
		$weekendArrays = explode(',', $weekendDay);

		$weekendDateArrays = array();
		
		for($i= $date_from; $i<= $date_to; $i= $i+$oneDay) {
		    if($weekendDay != "") {
		    	foreach($weekendArrays as $weekendValue) {
		            if($weekendValue >= 0 && $weekendValue <= 6) {
		                if(date('l',$i) == $allDays[$weekendValue]) {
		                    $weekendDateArrays[] = date('d-m-Y', $i);
		                }
		            }
		        }
		    }
		}
		return $weekendDateArrays;
	}

	public function getWeekendDaysSession() {
		$date_from = strtotime($this->data['schoolyearsessionobj']->startingdate);
		$date_to = strtotime($this->data['schoolyearsessionobj']->endingdate);
		$oneDay = 60*60*24;

		$allDays = array(
            '0' => 'Sunday',
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday'
        );

       	$weekendDay = $this->data['siteinfos']->weekends;
		$weekendArrays = explode(',', $weekendDay);

		$weekendDateArrays = array();
		
		for($i= $date_from; $i<= $date_to; $i= $i+$oneDay) {
		    if($weekendDay != "") {
		    	foreach($weekendArrays as $weekendValue) {
		            if($weekendValue >= 0 && $weekendValue <= 6) {
		                if(date('l',$i) == $allDays[$weekendValue]) {
		                    $weekendDateArrays[] = date('d-m-Y', $i);
		                }
		            }
		        }
		    }
		}
		return $weekendDateArrays;
	}
}

