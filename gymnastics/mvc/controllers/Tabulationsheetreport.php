<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tabulationsheetreport extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('exam_m');
		$this->load->model('classes_m');
		$this->load->model('section_m');
		$this->load->model('subject_m');
		$this->load->model('schoolyear_m');
		$this->load->model('studentrelation_m');
		$this->load->model('markpercentage_m');
		$this->load->model('setting_m');
		$this->load->model('mark_m');
		$this->load->model('grade_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('tabulationsheetreport', $language);
	}

	public function index() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css',
				'assets/custom-scrollbar/jquery.mCustomScrollbar.css'
			),
			'js' => array(
				'assets/select2/select2.js',
				'assets/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js'
			)
		);

		$this->data['classes'] = $this->classes_m->general_get_classes();
		$this->data['exams']   = $this->exam_m->get_exam();
		$this->data["subview"] = "report/tabulationsheet/TabulationsheetReportView";
		$this->load->view('_layout_main', $this->data);
	}

	public function getSection() {
		$classesID = $this->input->post('classesID');
		if((int)$classesID) {
			$sections = $this->section_m->general_get_order_by_section(array('classesID' => $classesID));
			echo "<option value='0'>". $this->lang->line("tabulationsheetreport_please_select") . "</option>";
			if(count($sections)) {
				foreach ($sections as $section) {
					echo "<option value='".$section->sectionID."'>".$section->section."</option>";
				}
			}
		}
	}

	public function getStudent() {
		$classesID = $this->input->post('classesID');
		$sectionID = $this->input->post('sectionID');
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		if((int)$classesID && (int)$sectionID) {
			$students = $this->studentrelation_m->general_get_order_by_student(array('srclassesID'=>$classesID,'srsectionID'=>$sectionID,'srschoolyearID'=>$schoolyearID));
			echo "<option value='0'>". $this->lang->line("tabulationsheetreport_please_select") . "</option>";
			if(count($students)) {
				foreach ($students as $student) {
					echo "<option value='".$student->srstudentID."'>".$student->srname."</option>";
				}
			}
		}
	}

	protected function rules() {
		$rules = array(
			array(
				'field'=>'examID',
				'label'=>$this->lang->line('tabulationsheetreport_exam'),
				'rules' => 'trim|required|xss_clean|numeric|callback_unique_data'
			),
			array(
				'field'=>'classesID',
				'label'=>$this->lang->line('tabulationsheetreport_class'),
				'rules' => 'trim|required|xss_clean|numeric|callback_unique_data'
			),
			array(
				'field'=>'sectionID',
				'label'=>$this->lang->line('tabulationsheetreport_section'),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field'=>'studentID',
				'label'=>$this->lang->line('tabulationsheetreport_student'),
				'rules' => 'trim|xss_clean'
			)
		);
		return $rules;
	}

	protected function send_pdf_to_mail_rules() {
		$rules = array(
			array(
				'field'=>'examID',
				'label'=>$this->lang->line('tabulationsheetreport_exam'),
				'rules' => 'trim|required|xss_clean|numeric|callback_unique_data'
			),
			array(
				'field'=>'classesID',
				'label'=>$this->lang->line('tabulationsheetreport_class'),
				'rules' => 'trim|required|xss_clean|numeric|callback_unique_data'
			),
			array(
				'field'=>'sectionID',
				'label'=>$this->lang->line('tabulationsheetreport_section'),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field'=>'studentID',
				'label'=>$this->lang->line('tabulationsheetreport_student'),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field'=>'to',
				'label'=>$this->lang->line('tabulationsheetreport_to'),
				'rules' => 'trim|required|xss_clean|valid_email'
			),
			array(
				'field'=>'subject',
				'label'=>$this->lang->line('tabulationsheetreport_subject'),
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field'=>'message',
				'label'=>$this->lang->line('tabulationsheetreport_message'),
				'rules' => 'trim|xss_clean'
			),
		);
		return $rules;
	}

	public function unique_data($data) {
		if($data != "") {
			if($data === "0") {
				$this->form_validation->set_message('unique_data', 'The %s field is required.');
				return FALSE;
			}
			return TRUE;
		} 
		return TRUE;
	}

	public function getTabulatonsheetReport() {
		$retArray['status'] = FALSE;
		$retArray['render'] = '';
		if(permissionChecker('tabulationsheetreport')) {
			$examID      = $this->input->post('examID');
			$classesID   = $this->input->post('classesID');
			$sectionID   = $this->input->post('sectionID');
			$studentID   = $this->input->post('studentID');

			if($_POST) {
				$rules = $this->rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$retArray = $this->form_validation->error_array();
					$retArray['status'] = FALSE;
				    echo json_encode($retArray);
				    exit;
				} else {
					$schoolyearID = $this->session->userdata('defaultschoolyearID');
					$studentQuery = [];
					$studentQuery['srclassesID'] = $classesID;
					if($sectionID > 0) {
						$studentQuery['srsectionID'] = $sectionID;
					}
					if($studentID > 0) {
						$studentQuery['srstudentID'] = $studentID;
					}
					$studentQuery['srschoolyearID'] = $schoolyearID;
					$students   = $this->studentrelation_m->general_get_order_by_student($studentQuery);

					$this->data['mandatorysubjects'] = $this->subject_m->general_get_order_by_subject(array('classesID'=>$classesID, 'type' => 1));
					$this->data['optionalsubjects'] = $this->subject_m->general_get_order_by_subject(array('classesID'=>$classesID, 'type' => 0));
					$this->data['students'] = $students;
					$this->data['markpercentages'] = $this->get_setting_mark_percentage();
					$this->data['classes'] = pluck($this->classes_m->general_get_classes(), 'classes', 'classesID');
					$this->data['sections'] = pluck($this->section_m->general_get_section(), 'section', 'sectionID');
					$this->data['grades'] = $this->grade_m->get_grade();

					$this->data['examID']       = $examID; 
					$this->data['classesID']    = $classesID; 
					$this->data['sectionID']    = $sectionID; 
					$this->data['studentID']    = $studentID; 
					$marks = $this->mark_m->get_order_by_all_student_mark_with_markrelation(['schoolyearID' => $schoolyearID, 'classesID' => $classesID, 'examID' => $examID]);
					$this->data['marks'] = $this->getMark($marks);

					$retArray['render'] = $this->load->view('report/tabulationsheet/TabulationsheetReport',$this->data,true);
					$retArray['status'] = TRUE;
					echo json_encode($retArray);
		    		exit; 
				}
			} else {
				$retArray['status'] = FALSE;
				echo json_encode($retArray);
		    	exit;
			}
		} else {
			$retArray['render'] =  $this->load->view('report/reporterror', $this->data, true);
			$retArray['status'] = TRUE;
			echo json_encode($retArray);
		    exit;
		}
	}

	public function getMark($marks) {
		$retMark = [];
		if(count($marks)) {
			foreach ($marks as $mark) {
				$retMark[$mark->studentID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
			}
		}
		return $retMark;
	}

	private function get_setting_mark_percentage() {
		$markpercentagesDatabases = $this->markpercentage_m->get_markpercentage();
		$markpercentagesSettings = $this->setting_m->get_markpercentage();
		$markpercentages = array();
		$array = array();
		if(count($markpercentagesSettings)) {
			foreach ($markpercentagesSettings as $key => $markpercentagesSetting) {
				$expfieldname = explode('_', $markpercentagesSetting->fieldoption);
				$array[] = (int)$expfieldname[1];
			}
		}

		if(count($markpercentagesDatabases)) {
			foreach ($markpercentagesDatabases as $key => $markpercentagesDatabase) {
				if(in_array($markpercentagesDatabase->markpercentageID, $array)) {
					$markpercentages[] = $markpercentagesDatabase;
				}
			}
		}
		return $markpercentages;
	}

	public function pdf() {
		if(permissionChecker('tabulationsheetreport')) { 
			$examID = htmlentities(escapeString($this->uri->segment(3)));
			$classesID = htmlentities(escapeString($this->uri->segment(4)));
			$sectionID = htmlentities(escapeString($this->uri->segment(5)));
			$studentID = htmlentities(escapeString($this->uri->segment(6)));

			if((int)($examID >= 0) || (int)($classesID >= 0) || (int)($sectionID >= 0) || (int)($studentID >= 0)) {
				$postArray = [];

				$schoolyearID = $this->session->userdata('defaultschoolyearID');
				$studentQuery = [];
				$studentQuery['srclassesID'] = $classesID;
				if($sectionID > 0) {
					$studentQuery['srsectionID'] = $sectionID;
				}
				if($studentID > 0) {
					$studentQuery['srstudentID'] = $studentID;
				}
				$studentQuery['srschoolyearID'] = $schoolyearID;
				$students   = $this->studentrelation_m->general_get_order_by_student($studentQuery);

				$this->data['mandatorysubjects'] = $this->subject_m->general_get_order_by_subject(array('classesID'=>$classesID, 'type' => 1));
				$this->data['optionalsubjects'] = $this->subject_m->general_get_order_by_subject(array('classesID'=>$classesID, 'type' => 0));
				$this->data['students'] = $students;
				$this->data['markpercentages'] = $this->get_setting_mark_percentage();
				$this->data['classes'] = pluck($this->classes_m->general_get_classes(), 'classes', 'classesID');
				$this->data['sections'] = pluck($this->section_m->general_get_section(), 'section', 'sectionID');
				$this->data['grades'] = $this->grade_m->get_grade();

				$this->data['examID']       = $examID; 
				$this->data['classesID']    = $classesID; 
				$this->data['sectionID']    = $sectionID; 
				$this->data['studentID']    = $studentID; 
				$marks = $this->mark_m->get_order_by_all_student_mark_with_markrelation(['schoolyearID' => $schoolyearID, 'classesID' => $classesID, 'examID' => $examID]);
				$this->data['marks'] = $this->getMark($marks);

				$this->reportPDF('tabulationsheetreport.css', $this->data, 'report/tabulationsheet/TabulationsheetReportPDF', 'view', 'a4', 'l');
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);	
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function send_pdf_to_mail() {
		$retArray['status'] = FALSE;
		$retArray['message'] = '';
		if(permissionChecker('admitcardreport')) {
			if($_POST) {
				$rules = $this->send_pdf_to_mail_rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$retArray = $this->form_validation->error_array();
					$retArray['status'] = FALSE;
				    echo json_encode($retArray);
				    exit;
				} else{
					$examID      = $this->input->post('examID');
					$classesID   = $this->input->post('classesID');
					$sectionID   = $this->input->post('sectionID');
					$studentID   = $this->input->post('studentID');
					$to          = $this->input->post('to');
					$subject     = $this->input->post('subject');
					$message     = $this->input->post('message');

					$schoolyearID = $this->session->userdata('defaultschoolyearID');
					$studentQuery = [];
					$studentQuery['srclassesID'] = $classesID;
					if($sectionID > 0) {
						$studentQuery['srsectionID'] = $sectionID;
					}
					if($studentID > 0) {
						$studentQuery['srstudentID'] = $studentID;
					}
					$studentQuery['srschoolyearID'] = $schoolyearID;
					$students   = $this->studentrelation_m->general_get_order_by_student($studentQuery);
					
					$this->data['mandatorysubjects'] = $this->subject_m->general_get_order_by_subject(array('classesID'=>$classesID, 'type' => 1));
					$this->data['optionalsubjects'] = $this->subject_m->general_get_order_by_subject(array('classesID'=>$classesID, 'type' => 0));
					$this->data['students'] = $students;
					$this->data['markpercentages'] = $this->get_setting_mark_percentage();
					$this->data['classes'] = pluck($this->classes_m->general_get_classes(), 'classes', 'classesID');
					$this->data['sections'] = pluck($this->section_m->general_get_section(), 'section', 'sectionID');
					$this->data['grades'] = $this->grade_m->get_grade();

					$this->data['examID']       = $examID; 
					$this->data['classesID']    = $classesID; 
					$this->data['sectionID']    = $sectionID; 
					$this->data['studentID']    = $studentID; 
					$marks = $this->mark_m->get_order_by_all_student_mark_with_markrelation(['schoolyearID' => $schoolyearID, 'classesID' => $classesID, 'examID' => $examID]);
					$this->data['marks'] = $this->getMark($marks);

					$this->reportSendToMail('tabulationsheetreport.css', $this->data, 'report/tabulationsheet/TabulationsheetReportPDF', $to, $subject, $message, 'a4', 'l');
					$retArray['message'] = "Message";
					$retArray['status'] = TRUE;
					echo json_encode($retArray);
				    exit;
				}
			} else {
				$retArray['message'] = $this->lang->line('tabulationsheetreport_permission');
				echo json_encode($retArray);
				exit;
			}
		} else {
			$retArray['message'] = $this->lang->line('tabulationsheetreport_permissionmethod');
			echo json_encode($retArray);
			exit;
		}
	}
}


?>