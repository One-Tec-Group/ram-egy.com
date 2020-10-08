<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mark extends Admin_Controller {
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
		$this->load->model("student_m");
		$this->load->model("mark_m");
		$this->load->model("grade_m");
		$this->load->model("classes_m");
		$this->load->model("exam_m");
		$this->load->model("subject_m");
		$this->load->model("user_m");
		$this->load->model("section_m");
		$this->load->model("parents_m");
		$this->load->model("markpercentage_m");
		$this->load->model("markrelation_m");
		$this->load->model('setting_m');
		$this->load->model('studentgroup_m');
		$this->load->model('studentrelation_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('mark', $language);
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'examID',
				'label' => $this->lang->line("mark_exam"),
				'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_examID'
			),
			array(
				'field' => 'classesID',
				'label' => $this->lang->line("mark_classes"),
				'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_classesID'
			),
			array(
				'field' => 'sectionID',
				'label' => $this->lang->line("mark_section"),
				'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_sectionID'
			),
			array(
				'field' => 'subjectID',
				'label' => $this->lang->line("mark_subject"),
				'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_subjectID'
			)
		);
		return $rules;
	}

	protected function markRules() {
		$rules = array(
			array(
				'field' => 'examID',
				'label' => $this->lang->line("mark_exam"),
				'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_examID'
			),
			array(
				'field' => 'classesID',
				'label' => $this->lang->line("mark_classes"),
				'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_classesID'
			),
			array(
				'field' => 'subjectID',
				'label' => $this->lang->line("mark_subject"),
				'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_subjectID'
			),
			array(
				'field' => 'inputs',
				'label' => $this->lang->line("mark_subject"),
				'rules' => 'trim|xss_clean|max_length[11]|callback_unique_inputs'
			)
		);
		return $rules;
	}

	public function send_mail_rules() {
		$rules = array(
			array(
				'field' => 'to',
				'label' => $this->lang->line("mark_to"),
				'rules' => 'trim|required|max_length[60]|valid_email|xss_clean'
			),
			array(
				'field' => 'subject',
				'label' => $this->lang->line("mark_subject"),
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'message',
				'label' => $this->lang->line("mark_message"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'id',
				'label' => $this->lang->line("mark_studentID"),
				'rules' => 'trim|required|max_length[10]|xss_clean|callback_unique_data'
			),
			array(
				'field' => 'set',
				'label' => $this->lang->line("mark_classesID"),
				'rules' => 'trim|required|max_length[10]|xss_clean|callback_unique_data'
			)
		);
		return $rules;
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


		$myProfile = false;
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		if($this->session->userdata('usertypeID') == 3) {
			$id = $this->data['myclass'];
			if(!permissionChecker('mark_view')) {
				$myProfile = true;
			}
		} else {
			$id = htmlentities(escapeString($this->uri->segment(3)));
		}

		if($this->session->userdata('usertypeID') == 3 && $myProfile) {
			$url = $id;
			$id = $this->session->userdata('loginuserID');
			$this->view($id, $url);
		} else {
			$this->data['set'] = $id;
			$this->data['classes'] = $this->classes_m->get_classes();

			if((int)$id) {
				$fetchClass = pluck($this->data['classes'], 'classesID', 'classesID');
				if(isset($fetchClass[$id])) {
					$this->data['students'] = $this->studentrelation_m->get_order_by_student(array('srclassesID' => $id, 'srschoolyearID' => $schoolyearID));
					if(count($this->data['students'])) {
						$sections = $this->section_m->general_get_order_by_section(array("classesID" => $id));
						$this->data['sections'] = $sections;
						foreach ($sections as $key => $section) {
							$this->data['allsection'][$section->sectionID] = $this->studentrelation_m->get_order_by_student(array('srclassesID' => $id, "srsectionID" => $section->sectionID, 'srschoolyearID' => $schoolyearID));
						}
					} else {
						$this->data['students'] = [];
					}
				} else {
					$this->data['students'] = [];
				}
			} else {
				$this->data['students'] = [];
			}

			$this->data["subview"] = "mark/index";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function add() {
		if(($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID') || $this->session->userdata('usertypeID') == 1)) {
			$this->data['headerassets'] = array(
				'css' => array(
					'assets/select2/css/select2.css',
					'assets/select2/css/select2-bootstrap.css'
				),
				'js' => array(
					'assets/select2/select2.js'
				)
			);

	        $this->data['students'] = [];
	        $this->data['set_exam'] = 0;
	        $this->data['set_classes'] = 0;
	        $this->data['set_section'] = 0;
	        $this->data['set_subject'] = 0;

	        $this->data['sendExam'] = [];
	        $this->data['sendSubject'] = [];
	        $this->data['sendClasses'] = [];
	        $this->data['sendSection'] = [];

	        $classesID = $this->input->post("classesID");
	        if($classesID != 0) {
	            $this->data['subjects'] = $this->subject_m->get_order_by_subject(array('classesID' => $classesID));
	            $this->data['sections'] = $this->section_m->get_order_by_section(array('classesID' => $classesID));
	        } else {
	            $this->data['subjects'] = 0;
	            $this->data['sections'] = 0;
	        }
	        $this->data['exams'] = $this->exam_m->get_exam();
	        $this->data['classes'] = $this->classes_m->get_classes();
	        if($_POST) {
	            $rules = $this->rules();
	            $this->form_validation->set_rules($rules);
	            if ($this->form_validation->run() == FALSE) {
	                $this->data["subview"] = "mark/add";
	                $this->load->view('_layout_main', $this->data);
	            } else {
	                $examID 						= $this->input->post('examID');
	                $classesID                      = $this->input->post('classesID');
	                $sectionID                      = $this->input->post('sectionID');
	                $subjectID                      = $this->input->post('subjectID');
	                $this->data['set_exam']         = $examID;
	                $this->data['set_classes']      = $classesID;
	                $this->data['set_section']      = $sectionID;
	                $this->data['set_subject']      = $subjectID;

	                $exam = $this->exam_m->get_exam($examID);
	                $this->data['sendExam'] = $exam;
	                $subject = $this->subject_m->get_subject($subjectID);
	                $this->data['sendSubject'] = $subject;
	                $classes = $this->classes_m->get_classes($classesID);
	                $this->data['sendClasses'] = $classes;
	                $section = $this->section_m->get_section($sectionID);
	                $this->data['sendSection'] = $section;
	                $year = date("Y");
	                $schoolyearID = $this->session->userdata('defaultschoolyearID');
	                $markpercentages  = $this->markpercentage_m->get_markpercentage();

	                $studentArray = [
	                	'srclassesID' => $classesID,
	                	'srsectionID' => $sectionID,
	                	'srschoolyearID' => $schoolyearID,
	                ];

	                if(count($subject)) {
	                	if($subject->type == 1) {
			                $students = $this->studentrelation_m->get_order_by_student([
			                    "srclassesID"    	=> $classesID,
			                    'srschoolyearID' 	=> $schoolyearID
			                ]);
	                	} else {
	                		$students = $this->studentrelation_m->get_order_by_student(array(
								"srclassesID" => $classesID,
								'srschoolyearID' => $schoolyearID,
								'sroptionalsubjectID' => $subject->subjectID
							));

							$studentArray['sroptionalsubjectID'] = $subject->subjectID;
	                	}
	                } else {
	                	$students = [];
	                }

	                $sendStudent = $this->studentrelation_m->get_order_by_student($studentArray);

	                $markPluck = pluck($this->mark_m->get_order_by_mark(array("examID" => $examID, "classesID" => $classesID, "	subjectID" => $subjectID, 'schoolyearID' => $schoolyearID)), 'obj', 'studentID');

	                $array = [];
	                if(count($students)) {
	                    foreach ($students as $student) {
	                        if(!isset($markPluck[$student->studentID])) {
	                            $array[] = array(
	                                "examID" => $examID,
									"schoolyearID" => $schoolyearID,
	                                "exam" => $exam->exam,
	                                "studentID" => $student->studentID,
	                                "classesID" => $classesID,
	                                "subjectID" => $subjectID,
	                                "subject" => $subject->subject,
	                                "year" => $year,
	                                "create_date" => date("Y-m-d H:i:s"),
	                                'create_userID' => $this->session->userdata("loginuserID"),
	                                'create_usertypeID' => $this->session->userdata('usertypeID')
	                            );
	                        }
	                    }
	                
	                    if(count($array)) {
		                    $count = count($array);

		                    $firstID = $this->mark_m->insert_batch_mark($array);
		                    $lastID = $firstID + ($count-1);

		                    $alertArray = [];
		                    $markRelationArray = []; 
		                    if($lastID >= $firstID) {
		                    	for ($i = $firstID; $i <= $lastID ; $i++) {
		                    		$alertArray[] = array('itemID' => $i, "userID" => $this->session->userdata("loginuserID"), 'usertypeID' => $this->session->userdata('usertypeID'), 'itemname' => 'mark');

		                    		foreach ($markpercentages as $value) {
										$markRelationArray[] = [
											"markID" => $i,
											"markpercentageID" => $value->markpercentageID
										];
									}
		                    	}
		                    }

	                		/* Start for initial alert post */
							if(count($alertArray)) {
								$this->alert_m->insert_batch_alert($alertArray);
							}
							/* End for initial alert post */

							if(count($markRelationArray)) {
								$this->markrelation_m->insert_batch_markrelation($markRelationArray);
							}
	                    }

	                    $mark = $this->mark_m->get_order_by_mark(array('schoolyearID' => $schoolyearID, "examID" => $examID, "classesID" => $classesID, "subjectID" => $subjectID));
	                    $this->data['marks'] = $mark;
	                }

					if(count($students)) {
						$missingmMarkRelationArray = [];
						$allMarkWithRelation = $this->markrelation_m->get_all_mark_with_relation(array('schoolyearID' => $schoolyearID, 'examID' => $examID, 'classesID' => $classesID, 'subjectID' => $subjectID));


						$studentMarkPercentage = [];
						foreach ($allMarkWithRelation as $key => $value) {
							$studentMarkPercentage[$value->studentID][$value->examID][$value->subjectID]['markpercentage'][] = $value->markpercentageID;
							$studentMarkPercentage[$value->studentID][$value->examID]['markID'][$value->subjectID] = $value->markID;
						}

						$markpercentages = pluck($markpercentages, 'markpercentageID');
						foreach ($students as $student) {
							$studentPercentage = isset($studentMarkPercentage[$student->studentID][$examID][$subjectID]['markpercentage']) ? $studentMarkPercentage[$student->studentID][$examID][$subjectID]['markpercentage'] : [];

							if(count($studentPercentage)) {
								$diffMarkPercentage = array_diff($markpercentages, $studentMarkPercentage[$student->studentID][$examID][$subjectID]['markpercentage']);
								foreach ($diffMarkPercentage as $item) {
									$missingmMarkRelationArray[] = [
										"markID" => $studentMarkPercentage[$student->studentID][$examID]['markID'][$subjectID],
										"markpercentageID" => $item
									];
								}
							}
						}

						if(count($missingmMarkRelationArray)) {
							$this->markrelation_m->insert_batch_markrelation($missingmMarkRelationArray);
						}
					}

					$this->data['students'] = $sendStudent;
					$this->data['markpercentages']  = $this->get_setting_mark_percentage();
					$this->data['markRelations'] = $this->getMarkRelationArray($this->mark_m->student_all_mark_array(array('schoolyearID' => $schoolyearID, 'examID' => $examID, 'classesID' => $classesID, 'subjectID' => $subjectID,)));

					$this->data["subview"] = "mark/add";
	                $this->load->view('_layout_main', $this->data);
	            }
	        } else {
	            $this->data["subview"] = "mark/add";
	            $this->load->view('_layout_main', $this->data);
	        }
		} else {
			$this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
		}
	}

	public function unique_inputs() {
		if($this->input->post('inputs')) {
			$inputs = $this->input->post('inputs');
			if(count($inputs)) {
				$getMarkPercentage = pluck($this->get_setting_mark_percentage(), 'obj', 'markpercentageID');
				foreach ($inputs as $key => $value) {
					$mark = explode('-', $value['mark']);
					$markPercentage = $mark[1];
					$markValue = $value['value'];
					
					if(isset($getMarkPercentage[$markPercentage])) {
						if(is_numeric($markValue)) {
							if(0 > $markValue || $markValue > $getMarkPercentage[$markPercentage]->percentage) {
								$this->form_validation->set_message('unique_inputs', 'Mark can not cross max mark');
								return FALSE;
							}
						} else {
							if(is_string($markValue) && $markValue != '') {
								$this->form_validation->set_message('unique_inputs', 'String data is deniable');
								return FALSE;
							}
							return TRUE;
						}
					}
				}

				return TRUE;
			}
			return TRUE;
		}
		return TRUE;
	}

	private function getMarkRelationArray($arrays=NULL) {
		$mark = array();
		$markwr = array();
		if(count($arrays)) {
			foreach ($arrays as $key => $array) {
				$mark[$array->studentID][$array->markpercentageID] = $array->mark;
				$markwr[$array->studentID][$array->markpercentageID] = $array->markrelationID;
			}
		}
		$this->data['markwr'] = $markwr;
		return $mark;
	}

	public function mark_send() {
		$retArray['status'] = FALSE;
        $retArray['message'] = '';

        if($_POST) {
	        $rules = $this->markRules();
	        $this->form_validation->set_rules($rules);
	        if ($this->form_validation->run() == FALSE) {
	            $retArray = $this->form_validation->error_array();
	            $retArray['status'] = FALSE;
	            echo json_encode($retArray);
	            exit;
	        } else {
				$examID 		= $this->input->post("examID");
				$classesID		= $this->input->post("classesID");
				$subjectID 		= $this->input->post("subjectID");
				$inputs 		= $this->input->post("inputs");
				$schoolyearID 	= $this->data['siteinfos']->school_year;

				$markRelationArray = [];
				if(count($inputs)) {
					foreach ($inputs as $key => $value) {
						$data = explode('-', $value['mark']);
						if(!empty($value['value']) || $value['value'] != "") {
							$markRelationArray[] = [
								'markrelationID' => $data[1],
								'mark' => abs($value['value'])
							];
						} else {
							$markRelationArray[] = [
								'markrelationID' => $data[1],
								'mark' => NULL
							];
						}
					}
				}

				if(count($markRelationArray)) {
					$this->markrelation_m->update_batch_markrelation($markRelationArray, 'markrelationID');
				}

				$retArray['status'] = TRUE;;
				$retArray['message'] = $this->lang->line('mark_success');
				echo json_encode($retArray);
            	exit;
	        }
	    } else {
			$retArray['message'] = 'Something wrong';
            echo json_encode($retArray);
            exit;
	    }
	}

	private function getView($id, $url) {
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		if((int)$id && (int)$url) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$studentInfo = $this->studentrelation_m->get_single_student(array('srstudentID' => $id, 'srclassesID' => $url, 'srschoolyearID' => $schoolyearID));

			$this->pluckInfo();
			$this->basicInfo($studentInfo);
			$this->markInfo($studentInfo);

			if(count($studentInfo)) {
				$this->data["subview"] = "mark/view";
				$this->load->view('_layout_main', $this->data);
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		}
	}

	private function pluckInfo() {
		$this->data['subjects'] = pluck($this->subject_m->general_get_subject(), 'subject', 'subjectID');
	}

	private function basicInfo($studentInfo) {
		if(count($studentInfo)) {
			$this->data['profile'] = $studentInfo;
			$this->data['usertype'] = $this->usertype_m->get_single_usertype(array('usertypeID' => $studentInfo->usertypeID));
			$this->data['class'] = $this->classes_m->get_single_classes(array('classesID' => $studentInfo->srclassesID));
			$this->data['section'] = $this->section_m->general_get_single_section(array('sectionID' => $studentInfo->srsectionID));
		} else {
			$this->data['profile'] = [];
		}
	}

	private function markInfo($studentInfo) {
		if(count($studentInfo)) {
			$this->getMark($studentInfo->studentID, $studentInfo->srclassesID);
		} else {
			$this->data['set'] 				= [];
			$this->data["exams"] 			= [];
			$this->data["grades"] 			= [];
			$this->data['markpercentages']	= [];
			$this->data['validExam'] 		= [];
			$this->data['separatedMarks'] 	= [];
			$this->data["highestMarks"] 	= [];
			$this->data["section"] 			= [];
		}
	}

	private function getMark($studentID, $classesID) {
		if((int)$studentID && (int)$classesID) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$student = $this->studentrelation_m->get_single_student(array('srstudentID' => $studentID, 'srclassesID' => $classesID, 'srschoolyearID' => $schoolyearID));
			$classes = $this->classes_m->get_single_classes(array('classesID' => $classesID));
			if(count($student) && count($classes)) {
				$queryArray = [
					'classesID' => $student->srclassesID,
					'sectionID' => $student->srsectionID,
					'studentID' => $student->srstudentID, 
					'schoolyearID' => $schoolyearID, 
				];

				$exams = $this->exam_m->get_exam();
				$grades = $this->grade_m->get_grade();
				$marks = $this->mark_m->student_all_mark_array($queryArray);
				$markpercentages = $this->get_setting_mark_percentage();

				$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
				$optionalSubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 0));

				$retMark = [];
				if(count($marks)) {
					foreach ($marks as $mark) {
						$retMark[$mark->examID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
					}
				}

				$allStudentMarks = $this->mark_m->student_all_mark_array(array('classesID' => $classesID, 'schoolyearID' => $schoolyearID));

				$highestMarks = array();
				foreach ($allStudentMarks as $key => $value) {
					if(!isset($highestMarks[$value->examID][$value->subjectID][$value->markpercentageID])) {
						$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = -1;
					}
					$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = max($value->mark, $highestMarks[$value->examID][$value->subjectID][$value->markpercentageID]);
				}

				$this->data['exams'] = $exams;
				$this->data['grades'] = $grades;
				$this->data['markpercentages'] = $markpercentages;
				$this->data['mandatorysubjects'] = $mandatorySubjects;
				$this->data['optionalsubjects'] = pluck($optionalSubjects,'subject','subjectID');
				$this->data['marks'] = $retMark;
				$this->data['hightmarks'] = $highestMarks;
			} else {
				$this->data['exams'] = [];
				$this->data['grades'] = [];
				$this->data['markpercentages'] = [];
				$this->data['mandatorysubjects'] = [];
				$this->data['optionalsubjects'] = [];
				$this->data['marks'] = [];
				$this->data['hightmarks'] = [];
			}
		} else {
			$this->data['exams'] = [];
			$this->data['grades'] = [];
			$this->data['markpercentages'] = [];
			$this->data['mandatorysubjects'] = [];
			$this->data['optionalsubjects'] = [];
			$this->data['marks'] = [];
			$this->data['hightmarks'] = [];
		}
	}

	private function get_setting_mark_percentage() {
		$markpercentagesDatabases = $this->markpercentage_m->get_markpercentage();
		$markpercentagesSettings = $this->setting_m->get_markpercentage();
		$markpercentages = [];
		$array = [];
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

	public function view($studentID = null, $classID = null) {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/custom-scrollbar/jquery.mCustomScrollbar.css'
			),
			'js' => array(
				'assets/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js'
			)
		);

		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		if((int) $studentID && (int) $classID) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$student = $this->studentrelation_m->get_single_student(array('srstudentID' => $studentID, 'srclassesID' => $classID, 'srschoolyearID' => $schoolyearID));
			if(count($student)) {
				$fetchClass = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
				if(isset($fetchClass[$classID])) {

					/* Start For mark alert */
					if(count($this->data['alert'])) {
						foreach($this->data['alert'] as $alertValue) {
							if(isset($alertValue->markID)) {
								if($alertValue->studentID == $this->session->userdata('loginuserID')) {
									$alert = $this->alert_m->get_single_alert(array('itemID' => $alertValue->markID, "userID" => $this->session->userdata("loginuserID"), 'usertypeID' => $this->session->userdata('usertypeID'), 'itemname' => 'mark'));
									if(!count($alert)) {
										$this->alert_m->insert_alert(array('itemID' => $alertValue->markID, "userID" => $this->session->userdata("loginuserID"), 'usertypeID' => $this->session->userdata('usertypeID'), 'itemname' => 'mark'));
									}	
								}
								
							}
						}
					}
					/* End For mark alert */

					$this->getView($studentID, $classID);
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
	
	public function print_preview() {
		if(permissionChecker('mark_view') || (($this->session->userdata('usertypeID') == 3) && permissionChecker('mark') && ($this->session->userdata('loginuserID') == htmlentities(escapeString($this->uri->segment(3)))))) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$studentID 	= htmlentities(escapeString($this->uri->segment(3)));
			$classID 	= htmlentities(escapeString($this->uri->segment(4)));

			if((int)$studentID && (int)$classID) {
				$schoolyearID = $this->session->userdata('defaultschoolyearID');
				$student = $this->studentrelation_m->get_single_student(array('srstudentID' => $studentID, 'srclassesID' => $classID, 'srschoolyearID' => $schoolyearID));
				if(count($student)) {
					$fetchClass = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
					if(isset($fetchClass[$classID])) {
						$this->getMarkPrintPDF($studentID, $classID);
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
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	private function getMarkPrintPDF($studentID, $classesID) {
		if((int)$studentID && (int)$classesID) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$student = $this->studentrelation_m->get_single_student(array('srstudentID' => $studentID, 'srschoolyearID' => $schoolyearID));
			$classes = $this->classes_m->get_single_classes(array('classesID' => $classesID));
			if(count($student) && count($classes)) {
				$queryArray = [
					'classesID' => $student->srclassesID,
					'sectionID' => $student->srsectionID,
					'studentID' => $student->srstudentID, 
					'schoolyearID' => $schoolyearID, 
				];

				$exams = $this->exam_m->get_exam();
				$grades = $this->grade_m->get_grade();
				$marks = $this->mark_m->student_all_mark_array($queryArray);
				$markpercentages = $this->get_setting_mark_percentage();
				$usertype = $this->usertype_m->get_single_usertype(array('usertypeID' => $student->usertypeID));
				$section = $this->section_m->general_get_single_section(array('sectionID' => $student->srsectionID));

				$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
				$optionalSubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 0));

				$retMark = [];
				if(count($marks)) {
					foreach ($marks as $mark) {
						$retMark[$mark->examID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
					}
				}

				$allStudentMarks = $this->mark_m->student_all_mark_array(array('classesID' => $classesID, 'schoolyearID' => $schoolyearID));

				$highestMarks = array();
				foreach ($allStudentMarks as $key => $value) {
					if(!isset($highestMarks[$value->examID][$value->subjectID][$value->markpercentageID])) {
						$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = -1;
					}
					$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = max($value->mark, $highestMarks[$value->examID][$value->subjectID][$value->markpercentageID]);
				}

				$this->data['student'] = $student;
				$this->data['classes'] = $classes;
				$this->data['section'] = $section;
				$this->data['usertype'] = $usertype;
				$this->data['exams'] = $exams;
				$this->data['grades'] = $grades;
				$this->data['markpercentages'] = $markpercentages;
				$this->data['mandatorysubjects'] = $mandatorySubjects;
				$this->data['optionalsubjects'] = pluck($optionalSubjects,'subject','subjectID');
				$this->data['marks'] = $retMark;
				$this->data['hightmarks'] = $highestMarks;

				$this->reportPDF('markmodule.css',$this->data, 'mark/print_preview');
			} else {
				$this->data['student'] = [];
				$this->data['classes'] = [];
				$this->data['section'] = [];
				$this->data['usertype'] = [];
				$this->data['exams'] = [];
				$this->data['grades'] = [];
				$this->data['markpercentages'] = [];
				$this->data['mandatorysubjects'] = [];
				$this->data['optionalsubjects'] = [];
				$this->data['marks'] = [];
				$this->data['hightmarks'] = [];
			}
		} else {
			$this->data['student'] = [];
			$this->data['classes'] = [];
			$this->data['section'] = [];
			$this->data['usertype'] = [];
			$this->data['exams'] = [];
			$this->data['grades'] = [];
			$this->data['markpercentages'] = [];
			$this->data['mandatorysubjects'] = [];
			$this->data['optionalsubjects'] = [];
			$this->data['marks'] = [];
			$this->data['hightmarks'] = [];
		}
	}

	private function getMarkSendToMail($studentID, $classesID, $sysEmail, $sysSubject, $sysMessage) {
		$studentID = $studentID;
		$classID = $classesID;
		if((int)$studentID && (int)$classID) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$this->data["student"] = $this->student_m->get_student($studentID);
			$this->data["classes"] = $this->student_m->get_class($classID);
			if($this->data["student"] && $this->data["classes"]) {
				$this->data['set'] 				= $classID;
				$this->data["exams"] 			= $this->exam_m->get_exam();
				$this->data["grades"] 			= $this->grade_m->get_grade();
				$this->data['markpercentages']	= $this->markpercentage_m->get_markpercentage();
				$this->data['mandatorysubjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $classID, 'type' => 1));
				$this->data['allsubjects'] = pluck($this->subject_m->general_get_order_by_subject(array('classesID' => $classID)), 'subject', 'subjectID');

				$allMarkWithRelation = $this->markrelation_m->get_all_mark_with_relation($classID, $schoolyearID);
				$studentMarkPercentage = array();
				foreach ($allMarkWithRelation as $key => $value) {
					$studentMarkPercentage[$value->studentID][$value->examID]['markpercentage'][] = $value->markpercentageID;
					$studentMarkPercentage[$value->studentID][$value->examID][$value->subjectID] = $value->markID;
				}

				$examDataFound = [];
				$markpercentages = pluck($this->data['markpercentages'], 'markpercentageID');
				foreach ($this->data["exams"] as $exam) {
					$studentPercentage = isset($studentMarkPercentage[$studentID][$exam->examID]['markpercentage']) ? $studentMarkPercentage[$studentID][$exam->examID]['markpercentage'] : [] ;
					if(count($studentPercentage)) {

						if(!in_array($exam->examID, $examDataFound)) {
							$examDataFound[$exam->examID] = $exam->examID;
						}

						$diffMarkPercentage = array_diff($markpercentages, $studentMarkPercentage[$studentID][$exam->examID]['markpercentage']);
						foreach ($diffMarkPercentage as $item) {
							if(isset($studentMarkPercentage[$studentID][$exam->examID]) && count($studentMarkPercentage[$studentID][$exam->examID])) {
								foreach ($studentMarkPercentage[$studentID][$exam->examID] as $subjectID => $markID) {
									if($subjectID == 'markpercentage') continue;
									$markRelation = [
										"markID" => $markID,
										"markpercentageID" => $item
									];
									$this->markrelation_m->insert($markRelation);
								}
							}
						}
					}
				}

				$this->data['validExam'] = $examDataFound;

				$this->data['markpercentages'] = $this->get_setting_mark_percentage();
				$marks = $this->mark_m->student_all_mark_array(array('classesID' => $classID, 'schoolyearID' => $schoolyearID, 'studentID' => $studentID));
				$allStudentMarks = $this->mark_m->student_all_mark_array(array('classesID' => $classID, 'schoolyearID' => $schoolyearID));
				$this->data['marks'] = $marks;

				$separatedMarks = array();
				foreach ($marks as $key => $value) {
					$separatedMarks[$value->examID][$value->subjectID]['subject'] = $value->subject;
					$separatedMarks[$value->examID][$value->subjectID]['subjectID'] = $value->subjectID;
					$separatedMarks[$value->examID][$value->subjectID][$value->markpercentageID]= $value->mark;
				}
				$this->data['separatedMarks'] = $separatedMarks;

				$highestMarks = array();
				foreach ($allStudentMarks as $key => $value) {
					if(!isset($highestMarks[$value->examID][$value->subjectID][$value->markpercentageID])) {
						$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = -1;
					}
					$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = max($value->mark, $highestMarks[$value->examID][$value->subjectID][$value->markpercentageID]);
				}
				$this->data["highestMarks"] = $highestMarks;
				$this->data["section"] = $this->section_m->get_section($this->data['student']->sectionID);
				$this->reportSendToMail('markmodule.css',$this->data, 'mark/print_preview', $sysEmail, $sysSubject, $sysMessage);
				$retArray['message'] = "Message";
				$retArray['status'] = TRUE;
				echo json_encode($retArray);
			    exit;
			}
		} else {
			$retArray['message'] = $this->lang->line('mark_data_not_found');
			echo json_encode($retArray);
		    exit;
		}

		if((int)$studentID && (int)$classesID) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$student = $this->studentrelation_m->get_single_student(array('srstudentID' => $studentID, 'srschoolyearID' => $schoolyearID));
			$classes = $this->classes_m->get_single_classes(array('classesID' => $classesID));
			if(count($student) && count($classes)) {
				$queryArray = [
					'classesID' => $student->srclassesID,
					'sectionID' => $student->srsectionID,
					'studentID' => $student->srstudentID, 
					'schoolyearID' => $schoolyearID, 
				];

				$exams = $this->exam_m->get_exam();
				$grades = $this->grade_m->get_grade();
				$marks = $this->mark_m->student_all_mark_array($queryArray);
				$markpercentages = $this->get_setting_mark_percentage();
				$usertype = $this->usertype_m->get_single_usertype(array('usertypeID' => $student->usertypeID));
				$section = $this->section_m->general_get_single_section(array('sectionID' => $student->srsectionID));

				$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
				$optionalSubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 0));

				$retMark = [];
				if(count($marks)) {
					foreach ($marks as $mark) {
						$retMark[$mark->examID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
					}
				}

				$allStudentMarks = $this->mark_m->student_all_mark_array(array('classesID' => $classesID, 'schoolyearID' => $schoolyearID));

				$highestMarks = array();
				foreach ($allStudentMarks as $key => $value) {
					if(!isset($highestMarks[$value->examID][$value->subjectID][$value->markpercentageID])) {
						$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = -1;
					}
					$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = max($value->mark, $highestMarks[$value->examID][$value->subjectID][$value->markpercentageID]);
				}

				$this->data['student'] = $student;
				$this->data['classes'] = $classes;
				$this->data['section'] = $section;
				$this->data['usertype'] = $usertype;
				$this->data['exams'] = $exams;
				$this->data['grades'] = $grades;
				$this->data['markpercentages'] = $markpercentages;
				$this->data['mandatorysubjects'] = $mandatorySubjects;
				$this->data['optionalsubjects'] = pluck($optionalSubjects,'subject','subjectID');
				$this->data['marks'] = $retMark;
				$this->data['hightmarks'] = $highestMarks;

				$this->reportPDF('markmodule.css',$this->data, 'mark/print_preview');
			} else {
				$this->data['student'] = [];
				$this->data['classes'] = [];
				$this->data['section'] = [];
				$this->data['usertype'] = [];
				$this->data['exams'] = [];
				$this->data['grades'] = [];
				$this->data['markpercentages'] = [];
				$this->data['mandatorysubjects'] = [];
				$this->data['optionalsubjects'] = [];
				$this->data['marks'] = [];
				$this->data['hightmarks'] = [];
			}
		} else {
			$this->data['student'] = [];
			$this->data['classes'] = [];
			$this->data['section'] = [];
			$this->data['usertype'] = [];
			$this->data['exams'] = [];
			$this->data['grades'] = [];
			$this->data['markpercentages'] = [];
			$this->data['mandatorysubjects'] = [];
			$this->data['optionalsubjects'] = [];
			$this->data['marks'] = [];
			$this->data['hightmarks'] = [];
		}
	}

	public function send_mail() {
		$retArray['status'] = FALSE;
		$retArray['message'] = '';
		if(permissionChecker('mark_view') || (($this->session->userdata('usertypeID') == 3) && permissionChecker('mark') && ($this->session->userdata('loginuserID') == $this->input->post('id')))) {
			if($_POST) {
				$rules = $this->send_mail_rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$retArray = $this->form_validation->error_array();
					$retArray['status'] = FALSE;
				    echo json_encode($retArray);
				    exit;
				} else {
					$studentID = $this->input->post('id');
					$classesID = $this->input->post('set');

					if((int)$studentID && (int)$classesID) {
						$schoolyearID = $this->session->userdata('defaultschoolyearID');
						$student = $this->studentrelation_m->get_single_student(array('srstudentID' => $studentID, 'srclassesID' => $classesID, 'srschoolyearID' => $schoolyearID));
						if(count($student)) {
							$fetchClass = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
							if(isset($fetchClass[$classesID])) {
								$email = $this->input->post('to');
								$subject = $this->input->post('subject');
								$message = $this->input->post('message');

								$classes = $this->classes_m->get_single_classes(array('classesID' => $classesID));
								$queryArray = [
									'classesID' => $student->srclassesID,
									'sectionID' => $student->srsectionID,
									'studentID' => $student->srstudentID, 
									'schoolyearID' => $schoolyearID, 
								];

								$exams = $this->exam_m->get_exam();
								$grades = $this->grade_m->get_grade();
								$marks = $this->mark_m->student_all_mark_array($queryArray);
								$markpercentages = $this->get_setting_mark_percentage();
								$usertype = $this->usertype_m->get_single_usertype(array('usertypeID' => $student->usertypeID));
								$section = $this->section_m->general_get_single_section(array('sectionID' => $student->srsectionID));

								$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
								$optionalSubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 0));

								$retMark = [];
								if(count($marks)) {
									foreach ($marks as $mark) {
										$retMark[$mark->examID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
									}
								}

								$allStudentMarks = $this->mark_m->student_all_mark_array(array('classesID' => $classesID, 'schoolyearID' => $schoolyearID));

								$highestMarks = array();
								foreach ($allStudentMarks as $key => $value) {
									if(!isset($highestMarks[$value->examID][$value->subjectID][$value->markpercentageID])) {
										$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = -1;
									}
									$highestMarks[$value->examID][$value->subjectID][$value->markpercentageID] = max($value->mark, $highestMarks[$value->examID][$value->subjectID][$value->markpercentageID]);
								}

								$this->data['student'] = $student;
								$this->data['classes'] = $classes;
								$this->data['section'] = $section;
								$this->data['usertype'] = $usertype;
								$this->data['exams'] = $exams;
								$this->data['grades'] = $grades;
								$this->data['markpercentages'] = $markpercentages;
								$this->data['mandatorysubjects'] = $mandatorySubjects;
								$this->data['optionalsubjects'] = pluck($optionalSubjects,'subject','subjectID');
								$this->data['marks'] = $retMark;
								$this->data['hightmarks'] = $highestMarks;

								$this->reportSendToMail('markmodule.css',$this->data, 'mark/print_preview', $email, $subject, $message);
								$retArray['message'] = "Success";
								$retArray['status'] = TRUE;
								echo json_encode($retArray);
							    exit;
							} else {
								$retArray['message'] = $this->lang->line('mark_data_not_found');
								echo json_encode($retArray);
								exit;
							}
						} else {
							$retArray['message'] = $this->lang->line('mark_data_not_found').'lol';
							echo json_encode($retArray);
							exit;
						}
					} else {
						$retArray['message'] = $this->lang->line('mark_data_not_found');
						echo json_encode($retArray);
						exit;
					}
				}
			} else {
				$retArray['message'] = $this->lang->line('mark_permissionmethod');
				echo json_encode($retArray);
				exit;
			}
		} else {
			$retArray['message'] = $this->lang->line('mark_permission');
			echo json_encode($retArray);
			exit;
		}
	}

	public function mark_list() {
		$classID = $this->input->post('id');
		if((int)$classID) {
			$string = base_url("mark/index/$classID");
			echo $string;
		} else {
			redirect(base_url("mark/index"));
		}
	}

	public function subjectcall() {
		$id = $this->input->post('id');
		if((int)$id) {
			$allsubject = $this->subject_m->get_order_by_subject(array("classesID" => $id));
			echo "<option value='0'>", $this->lang->line("mark_select_subject"),"</option>";
			foreach ($allsubject as $value) {
				echo "<option value=\"$value->subjectID\">",$value->subject,"</option>";
			}
		} else {
			echo "<option value='0'>", $this->lang->line("mark_select_subject"),"</option>";
		}
	}

	public function sectioncall() {
		$id = $this->input->post('id');
		if((int)$id) {
			$allsection = $this->section_m->get_order_by_section(array("classesID" => $id));
			echo "<option value='0'>", $this->lang->line("mark_select_section"),"</option>";
			foreach ($allsection as $value) {
				echo "<option value=\"$value->sectionID\">",$value->section,"</option>";
			}
		} else {
			echo "<option value='0'>", $this->lang->line("mark_select_section"),"</option>";
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

	public function unique_examID() {
		if($this->input->post('examID') == 0) {
			$this->form_validation->set_message("unique_examID", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function unique_classesID() {
		if($this->input->post('classesID') == 0) {
			$this->form_validation->set_message("unique_classesID", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function unique_sectionID() {
		if($this->input->post('sectionID') == 0) {
			$this->form_validation->set_message("unique_sectionID", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function unique_subjectID() {
		if($this->input->post('subjectID') == 0) {
			$this->form_validation->set_message("unique_subjectID", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}
}