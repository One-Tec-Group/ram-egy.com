<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends Admin_Controller {
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

	protected $studentStatus 	= array();
	protected $studentResult 	= array();
	protected $separatedMarks	= array();
	protected $allStudentMarks	= array();

	function __construct() {
		parent::__construct();
		$this->load->model("student_m");
		$this->load->model("subject_m");
		$this->load->model("promotionlog_m");
		$this->load->model("classes_m");
		$this->load->model("studentrelation_m");
		$this->load->model("exam_m");
		$this->load->model("grade_m");
		$this->load->model("markpercentage_m");
		$this->load->model("setting_m");
		$this->load->model("mark_m");
		$this->load->model('section_m');
		$this->load->model('schoolyear_m');
		$this->load->model('studentextend_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('mark', $language);
		$this->lang->load('promotion', $language);
	}

	public function send_mail_rules() {
		$rules = array(
			array(
				'field' => 'to',
				'label' => $this->lang->line("promotion_to"),
				'rules' => 'trim|required|max_length[60]|valid_email|xss_clean'
			),
			array(
				'field' => 'subject',
				'label' => $this->lang->line("promotion_subject"),
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'message',
				'label' => $this->lang->line("promotion_message"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'studentID',
				'label' => $this->lang->line("promotion_studentID"),
				'rules' => 'trim|required|max_length[10]|xss_clean|callback_unique_data'
			),
			array(
				'field' => 'classesID',
				'label' => $this->lang->line("promotion_classesID"),
				'rules' => 'trim|required|max_length[10]|xss_clean|callback_unique_data'
			),
			array(
				'field' => 'schoolyearID',
				'label' => $this->lang->line("promotion_academicyear"),
				'rules' => 'trim|required|max_length[10]|xss_clean|callback_unique_data'
			)
		);
		return $rules;
	}

	public function index() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/icheck/skins/all.css',
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/icheck/icheck.js',
				'assets/select2/select2.js'
			)
		);

		$id = htmlentities(escapeString($this->uri->segment(3)));
		$schoolyearID = htmlentities(escapeString($this->uri->segment(4)));
		if((int)$id && (int)$schoolyearID) {
			$this->data['set'] = $id;
			$this->data['schoolyearID'] = $schoolyearID;
			$this->data['classes'] = $this->classes_m->general_get_classes();
			$this->data['students'] = $this->student_m->general_get_order_by_student(array('classesID' => $id, 'schoolyearID' => $schoolyearID));
			$this->data['subjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $id));
			$this->data['exams'] = $this->exam_m->get_exam();
			$this->data['markpercentages'] = $this->get_setting_mark_percentage();
			$this->data['schoolyears'] = $this->data['topbarschoolyears'];

			$rules = [];
			$array = [];
			if ($_POST) {
				if(config_item('demo') == FALSE) {
					if($this->pcode_validation($this->data['siteinfos']->purchase_code, $this->data['siteinfos']->purchase_username, config_item('ini_version')) == FALSE) {
						redirect(base_url('promotion/add'));
					}
				}

				foreach ($_POST as $key => $subjectMark) {
					$rules[] = array(
						'field' => "".$key,
						'label' => " ",
						'rules' => 'trim|required|xss_clean|max_length[6]|numeric'
					);
				}

				$promotionLog = array(
					'promotionType' => $this->input->post('promotionType'),
					'classesID' => $id,
					'jumpClassID' => $this->input->post('jclassesID'),
					'schoolYearID' => $schoolyearID,
					'jumpSchoolYearID' => $this->input->post('jschoolyear'),
					'status' => 0,
					'subjectandsubjectcodeandmark' => json_encode($this->input->post('subject')),
					'exams' => json_encode($this->input->post('exams')),
					'markpercentages' => json_encode($this->input->post('markpercentages')),
					'created_at' => date('Y-m-d h:i:s'),
					'create_userID' => $this->session->userdata('loginuserID')
				);

				$this->promotionlog_m->insert_promotionlog($promotionLog);
				$promotionLogID = $this->db->insert_id();
				$this->session->set_userdata(array('promotionLogID' => $promotionLogID));

				redirect("promotion/add/$id/$schoolyearID");
			} else {
				$this->data["subview"] = "promotion/index";
				$this->load->view('_layout_main', $this->data);
			}

		} else {
			$this->data['schoolyears'] = $this->data['topbarschoolyears'];
			$this->data['classes'] = $this->classes_m->general_get_classes();
			$this->data["subview"] = "promotion/search";
			$this->load->view('_layout_main', $this->data);
		}
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

	public function promotion_list() {
		$classID = $this->input->post('id');
		$schoolyearID = $this->input->post('year');
		if((int)$classID) {
			$string = base_url("promotion/index/$classID/$schoolyearID");
			echo $string;
		} else {
			redirect(base_url("promotion/index"));
		}
	}

	public function add() {
		$classID = htmlentities(escapeString($this->uri->segment(3)));
		$schoolyearID = htmlentities(escapeString($this->uri->segment(4)));
		if((int)$classID && (int)$schoolyearID) {
			$classes = $this->classes_m->general_get_classes($classID);
			$schoolyear = $this->schoolyear_m->get_schoolyear($schoolyearID);
			if(count($classes) && count($schoolyear)) {
				$this->data['classes'] = pluck($this->classes_m->general_get_classes(), 'obj', 'classesID');
				$this->data['set'] = $classID;
				$this->data['schoolyears'] = pluck($this->data['topbarschoolyears'], 'obj', 'schoolyearID');
				$this->data['schoolyearID'] = $schoolyearID;
				$this->data['sections']	= pluck($this->section_m->general_get_order_by_section(array('classesID' => $classID)), 'obj', 'sectionID');

				$this->studentPromotionCalculation($classID, $schoolyearID);

				$this->data['currentClass'] = $classes;
				$this->data['currentSchoolYear'] = $this->data['schoolyears'][$schoolyearID];

				$this->data['promotionClass'] = $this->data['classes'][$this->data['promotionClassID']];
				$this->data['promotionSchoolYear'] = $this->data['schoolyears'][$this->data['promotionSchoolYearID']];

				$this->data["subview"] = "promotion/add";
				$this->load->view('_layout_main', $this->data);
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	private function studentPromotionCalculation($classID, $schoolyearID) {
		$marks		= $this->mark_m->get_order_by_student_mark_with_subject($classID, $schoolyearID);

		$students	= $this->student_m->general_get_order_by_student(array('classesID' => $classID, 'schoolyearID' => $schoolyearID));
		$students	= pluck($students, 'obj', 'studentID');

		$promotionLog = $this->promotionlog_m->get_promotionlog($this->session->userdata('promotionLogID'));

		$this->data['promotionType'] = $promotionLog->promotionType;
		$this->data['promotionClassID'] = $promotionLog->jumpClassID;
		$this->data['promotionSchoolYearID'] = $promotionLog->jumpSchoolYearID;

		$promotionExams 			= array_keys((array) json_decode($promotionLog->exams, true));
		$promotionMarkPercentages 	= array_keys((array) json_decode($promotionLog->markpercentages, true));
		$promotionSubjectPassMark 	= json_decode($promotionLog->subjectandsubjectcodeandmark, true);

		$this->data['promotionMarkPercentages'] = $promotionMarkPercentages;
		$this->data['promotionExams'] = $promotionExams;

		$separatedMarks = array();
		$studentStatus 	= array();
		$studentResult 	= array();

		$this->allStudentMarks = $marks;

		foreach ($marks as $key => $value) {

			if(!isset($students[$value->studentID])) continue;

			if(in_array($value->examID, $promotionExams)) {
				$separatedMarks[$value->studentID][$value->examID][$value->subjectID]['subject']	= $value->subject;
				$separatedMarks[$value->studentID][$value->examID][$value->subjectID]['optional']	= (int) $value->type;
				if(in_array($value->markpercentageID, $promotionMarkPercentages)) {
					$separatedMarks[$value->studentID][$value->examID][$value->subjectID][$value->markpercentageID]= $value->mark;
					if(!isset($separatedMarks[$value->studentID][$value->examID][$value->subjectID]['sum'])) {
						$separatedMarks[$value->studentID][$value->examID][$value->subjectID]['sum'] = 0;
					}
					$separatedMarks[$value->studentID][$value->examID][$value->subjectID]['sum'] += $value->mark;
					$studentStatus[$value->studentID]['status'] = 1;
					$studentResult[$value->studentID] = 1;
					$studentStatus[$value->studentID]['total'] = 0;
				}
			}
		}

		$this->separatedMarks = $separatedMarks;

		foreach ($studentStatus as $studentID => $value) {
			foreach ($promotionExams as $examID) {
				foreach ($promotionSubjectPassMark as $subjectID => $passMark) {
					if(isset($separatedMarks[$studentID][$examID][$subjectID])) {
						if($separatedMarks[$studentID][$examID][$subjectID]['sum'] < $passMark && $separatedMarks[$studentID][$examID][$subjectID]['optional']) {
							$studentStatus[$studentID]['status'] 	= 0;
							$studentResult[$studentID]				= 0;

							$studentStatus[$studentID]['exams'][$examID][$subjectID]['passmark'] = $passMark;
							$studentStatus[$studentID]['exams'][$examID][$subjectID]['havemark'] = $separatedMarks[$studentID][$examID][$subjectID]['sum'];
							$studentStatus[$studentID]['exams'][$examID][$subjectID]['subject'] = $separatedMarks[$studentID][$examID][$subjectID]['subject'];
						}
						$studentStatus[$studentID]['total'] += $separatedMarks[$studentID][$examID][$subjectID]['sum'];
					}
				}
			}

			if(isset($students[$studentID])) {
				$studentStatus[$studentID]['info'] = $students[$studentID];
			} else {
				$studentStatus[$studentID]['info'] = [
					  "studentID" => $studentID,
					  "name" =>  "Deleted User",
					  "roll" =>  "0",
					  "photo" =>  "default.png",
					  "username" =>  "Deleted User"
				];
			}
		}
		uasort($studentStatus, function($a, $b) {
			if ($a['total'] == $b['total']) {
				return 0;
			}
			return ($a['total'] > $b['total']) ? -1 : 1;
		});

		$this->studentStatus = $studentStatus;
		$this->studentResult = $studentResult;

		if($promotionLog->promotionType == 'normal') {
			$this->data['studentStatus'] = $students;
			$this->data['student_result'] = $studentResult;
			return;
		}
		$this->data['studentStatus'] = $this->studentStatus;
		$this->data['student_result'] = $this->studentResult;
	}

	public function summary() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/custom-scrollbar/jquery.mCustomScrollbar.css',
			),
			'js' => array(
				'assets/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js',
			)
		);

		$studentID = htmlentities(escapeString($this->uri->segment(3)));
		$classID = htmlentities(escapeString($this->uri->segment(4)));
		$schoolyearID = htmlentities(escapeString($this->uri->segment(5)));

		if((int)$studentID && (int)$classID && (int)$schoolyearID) {
			$checkStudent = $this->student_m->general_get_single_student(array('studentID' => $studentID, 'schoolyearID' => $schoolyearID));
			$checkClass = $this->classes_m->general_get_single_classes(array('classesID' => $classID));
			$checkSchoolyear = $this->schoolyear_m->get_single_schoolyear(array('schoolyearID' => $schoolyearID));

			if(count($checkStudent) && count($checkClass) && count($checkSchoolyear)) {
				$this->data['set'] = $classID;
				$this->studentPromotionCalculation($classID, $schoolyearID);
				$this->data['studentStatus'] = $this->studentStatus[$studentID];

                $this->getMark($studentID, $classID, $schoolyearID);

                $this->data['passschoolyearID'] = $schoolyearID;
				$this->data["subview"] = "promotion/summary";
				$this->load->view('_layout_main', $this->data);
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	private function getMark($studentID, $classesID, $schoolyearID) {
		if((int)$studentID && (int)$classesID && (int)$schoolyearID) {
			$student = $this->student_m->get_single_student(array('studentID' => $studentID, 'classesID' => $classesID, 'schoolyearID' => $schoolyearID));
			$classes = $this->classes_m->get_single_classes(array('classesID' => $classesID));
			if(count($student) && count($classes)) {
				$queryArray = [
					'classesID' => $student->classesID,
					'sectionID' => $student->sectionID,
					'studentID' => $student->studentID, 
					'schoolyearID' => $schoolyearID, 
				];

				$exams = pluck($this->exam_m->get_exam(), 'obj', 'examID');
				$grades = $this->grade_m->get_grade();
				$marks = $this->mark_m->student_all_mark_array($queryArray);
				$markpercentages = $this->get_setting_mark_percentage();
				$section = $this->section_m->general_get_single_section(array('sectionID' => $student->sectionID));
                $usertype = $this->usertype_m->get_single_usertype(array('usertypeID' => $student->usertypeID));

				$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
				$optionalSubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 0));

				$retMark = [];
				if(count($marks)) {
					foreach ($marks as $mark) {
						$retMark[$mark->examID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
					}
				}

				$allStudentMarks = $this->mark_m->student_all_mark_array(array('classesID' => $classesID, 'schoolyearID' => $schoolyearID));

				$highestMarks = [];
				foreach ($allStudentMarks as $key => $value) {
					if(!isset($highestMarks[$value->examID][$value->subjectID][$value->markpercentageID])) {
						$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = -1;
					}
					$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = max($value->mark, $highestMarks[$value->examID][$value->subjectID][$value->markpercentageID]);
				}
                
                $exams = pluck($this->exam_m->get_exam(), 'obj', 'examID');
                foreach ($exams as $key => $exam) {
                    if(!in_array($exam->examID, $this->data['promotionExams'])) {
                        unset($exams[$key]);
                    }
                }

				$this->data["student"] = $student;
				$this->data['classes'] = $classes;
				$this->data['classes'] = $classes;
				$this->data["section"] = $section;
                $this->data["usertype"] = $usertype;


				$this->data['exams'] = $exams;
				$this->data['grades'] = $grades;
				$this->data['markpercentages'] = $markpercentages;
				$this->data['mandatorysubjects'] = $mandatorySubjects;
				$this->data['optionalsubjects'] = pluck($optionalSubjects,'subject','subjectID');
				$this->data['marks'] = $retMark;
				$this->data['hightmarks'] = $highestMarks;
			} else {
				$this->data["student"] = [];
				$this->data['classes'] = [];
				$this->data['classes'] = [];
				$this->data["section"] = [];
                $this->data["usertype"] = [];

				$this->data['exams'] = [];
				$this->data['grades'] = [];
				$this->data['markpercentages'] = [];
				$this->data['mandatorysubjects'] = [];
				$this->data['optionalsubjects'] = [];
				$this->data['marks'] = [];
				$this->data['hightmarks'] = [];
			}
		} else {
			$this->data["student"] = [];
			$this->data['classes'] = [];
			$this->data['classes'] = [];
			$this->data["section"] = [];
            $this->data["usertype"] = [];

			$this->data['exams'] = [];
			$this->data['grades'] = [];
			$this->data['markpercentages'] = [];
			$this->data['mandatorysubjects'] = [];
			$this->data['optionalsubjects'] = [];
			$this->data['marks'] = [];
			$this->data['hightmarks'] = [];
		}
	}

	public function promotion_to_next_class() {
		$studentIDs = $this->input->post("studentIDs");
		$enroll		= $this->input->post('enroll');

		$promotionLogID = $this->session->userdata('promotionLogID');
		$promotionLog = $this->promotionlog_m->get_promotionlog($promotionLogID);

		$previousClasseID = $promotionLog->classesID;
		$previousYearID = $promotionLog->schoolYearID;

		$promotionClassID = $promotionLog->jumpClassID;
		$promotionYearID = $promotionLog->jumpSchoolYearID;

		$explodeStudents = explode(",",  $studentIDs);
		$students = pluck($this->student_m->general_get_order_by_student(array("classesID" => $previousClasseID, "schoolyearID" => $previousYearID)), 'obj', 'studentID');

		$promoteClassPreviousStudentsList = pluck($this->student_m->general_get_order_by_student(array("classesID" => isset($enroll) && $enroll ? $previousClasseID : $promotionClassID, "schoolyearID" => $promotionYearID)), 'obj', 'studentID');

		$sections =$this->section_m->general_get_order_by_section(array("classesID" => isset($enroll) && $enroll ? $previousClasseID : $promotionClassID));

		$lastSectionID = $sections[count($sections)-1]->sectionID;

		$sections = pluck($sections, 'obj', 'sectionID');

		$capacity = [];
		$roll = 1;

		foreach ($promoteClassPreviousStudentsList as $studentID => $studentInfo) {
			if(isset($sections[$studentInfo->sectionID])) {
				if(isset($capacity[$studentInfo->sectionID])) {
					$capacity[$studentInfo->sectionID]++;
				} else {
					$capacity[$studentInfo->sectionID] = 1;
				}
				$roll++;
			}
		}

		if(count($students) && count($studentIDs) && count($previousClasseID)) {
			$f=0;
			$promoteStudents = isset($promotionLog->promoteStudents) && $promotionLog->promoteStudents!=NULL ? json_decode($promotionLog->promoteStudents, true) : array();

			foreach ($explodeStudents as $key => $studentID) {
				if($studentID == 0) continue;

				if(isset($students[$studentID])) {
					$promoteSectionID = 0;
					foreach ($sections as $sectionID => $sectionInfo) {
						if(isset($capacity[$sectionID])) {
							if($sectionInfo->capacity >= $capacity[$sectionID]+1) {
								$capacity[$sectionID]++;
								$promoteSectionID = $sectionID;
								break;
							}
						} else {
							$capacity[$sectionID] = 1;
							$promoteSectionID = $sectionID;
							break;
						}
					}

					if($promoteSectionID == 0 || (isset($enroll) && $enroll)) {
						$promoteSectionID = $lastSectionID;
					}

					$array = array(
						'classesID' => isset($enroll) && $enroll ? $previousClasseID : $promotionClassID,
						'schoolyearID' => $promotionYearID,
						'roll' => isset($enroll) && $enroll ? 0 : $roll,
						'sectionID' => $promoteSectionID
					);


					$studentReletion = $this->studentrelation_m->get_order_by_studentrelation(array('srstudentID' => $studentID, 'srschoolyearID' => $promotionYearID));

                    $classesRelation = $this->classes_m ->general_get_classes($promotionClassID);
					$sectionRelation = $this->section_m->general_get_section($promoteSectionID);

					$setClassesID = NULL;
					$setClasses = NULL;

					$setSectionID = NULL;
					$setSection = NULL;

                    if(count($classesRelation)) {
                        $setClassesID 	= $classesRelation->classesID;
                        $setClasses 	= $classesRelation->classes;
                    } else {
                    	$setClassesID 	= $students[$studentID]->classesID;
                    	$setClasses 	= $students[$studentID]->classes;
                    }

                    if(count($sectionRelation)) {
                        $setSectionID 	= $sectionRelation->sectionID;
                        $setSection 	= $sectionRelation->section;
                    } else {
                    	$setSectionID 	= $students[$studentID]->sectionID;
                        $setSection 	= $students[$studentID]->section;
                    }

                    if(!count($studentReletion)) {
                        $arrayStudentRelation = array(
                            'srstudentID' => $studentID,
                            'srname' => $students[$studentID]->name,
                            'srclassesID' => $setClassesID,
                            'srclasses' => $setClasses,
                            'srroll' => $roll,
                            'srregisterNO' => $students[$studentID]->registerNO,
                            'srsectionID' => $setSectionID,
                            'srsection' => $setSection,
                            'srstudentgroupID' => $students[$studentID]->studentgroupID,
                            'sroptionalsubjectID' => 0,
                            'srschoolyearID' => $promotionYearID
                        );
                        $this->studentrelation_m->insert_studentrelation($arrayStudentRelation);
					}

					$this->student_m->update_student($array, $studentID);
					$this->studentextend_m->update_studentextend_by_studentID(array('optionalsubjectID' => 0), $studentID);
					$promoteStudents[] = array('studentID' => $studentID, 'roll' => $roll, 'enroll' => $enroll, 'sectionID' => $promoteSectionID);
					$roll++;
				}
			}

			$this->promotionlog_m->update_promotionlog(array('promoteStudents' => json_encode($promoteStudents), 'status' => 1), $promotionLogID);

			if($f){
				$this->session->set_flashdata('error', $this->lang->line('promotion_create_class'));
				echo 'error';
			} else {
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				echo 'success';
			}
		}
	}

	public function print_preview() {
		if(permissionChecker('promotion')) {
			$studentID = htmlentities(escapeString($this->uri->segment(3)));
			$classID = htmlentities(escapeString($this->uri->segment(4)));
			$schoolyearID = htmlentities(escapeString($this->uri->segment(5)));

			if((int)$studentID && (int)$classID && (int)$schoolyearID) {
				$checkStudent = $this->student_m->general_get_single_student(array('studentID' => $studentID, 'schoolyearID' => $schoolyearID));
				$checkClass = $this->classes_m->general_get_single_classes(array('classesID' => $classID));
				$checkSchoolyear = $this->schoolyear_m->get_single_schoolyear(array('schoolyearID' => $schoolyearID));

				if(count($checkStudent) && count($checkClass) && count($checkSchoolyear)) {
					$this->data['set'] = $classID;
					$this->studentPromotionCalculation($classID, $schoolyearID);
					$this->data['studentStatus'] = $this->studentStatus[$studentID];

	                $this->getMark($studentID, $classID, $schoolyearID);

	                $this->data['passschoolyearID'] = $schoolyearID;
					$this->reportPDF('markmodule.css',$this->data, 'promotion/print_preview');
				} else {
					$this->data["subview"] = "error";
					$this->load->view('_layout_main', $this->data);
				}
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function send_mail() {
		$retArray['status'] = FALSE;
		$retArray['message'] = '';
		if(permissionChecker('promotion')) {
			if($_POST) {
				$rules = $this->send_mail_rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$retArray = $this->form_validation->error_array();
					$retArray['status'] = FALSE;
				    echo json_encode($retArray);
				    exit;
				} else {
					$studentID = $this->input->post('studentID');
					$classID = $this->input->post('classesID');
					$schoolyearID = $this->input->post('schoolyearID');

					if((int)$studentID && (int)$classID && (int)$schoolyearID) {
						$checkStudent = $this->student_m->general_get_single_student(array('studentID' => $studentID, 'schoolyearID' => $schoolyearID));
						$checkClass = $this->classes_m->general_get_single_classes(array('classesID' => $classID));
						$checkSchoolyear = $this->schoolyear_m->get_single_schoolyear(array('schoolyearID' => $schoolyearID));

						if(count($checkStudent) && count($checkClass) && count($checkSchoolyear)) {
							$this->data['set'] = $classID;
							$this->studentPromotionCalculation($classID, $schoolyearID);
							$this->data['studentStatus'] = $this->studentStatus[$studentID];

			                $this->getMark($studentID, $classID, $schoolyearID);

			                $this->data['passschoolyearID'] = $schoolyearID;

			                $email = $this->input->post('to');
							$subject = $this->input->post('subject');
							$message = $this->input->post('message');
							$this->reportSendToMail('markmodule.css', $this->data, 'promotion/print_preview', $email, $subject, $message);
							$retArray['message'] = "Message";
							$retArray['status'] = TRUE;
							echo json_encode($retArray);
						    exit;
						} else {
							$retArray['message'] = $this->lang->line('promotion_data_not_found');
							echo json_encode($retArray);
							exit;
						}
					} else {
						$retArray['message'] = $this->lang->line('promotion_data_not_found');
						echo json_encode($retArray);
						exit;
					}
				}
			} else {
				$retArray['message'] = $this->lang->line('promotion_permissionmethod');
				echo json_encode($retArray);
				exit;
			}
		} else {
			$retArray['message'] = $this->lang->line('promotion_permissionmethod');
			echo json_encode($retArray);
			exit;
		}
	}

	public function unique_data($data) {
		if($data != '') {
			if($data == '0') {
				$this->form_validation->set_message('unique_data', 'The %s field is required.');
				return FALSE;
			}
			return TRUE;
		}
		return TRUE;
	}

	private function pcode_validation($pcode, $pusername, $version) {
		$email = trim($this->data['siteinfos']->email);
        $apiCurl = varifyValidUser($email);
		if($apiCurl->status == FALSE) {
			$this->session->set_flashdata('error', $apiCurl->message);
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

