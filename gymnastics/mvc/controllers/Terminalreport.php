<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terminalreport extends Admin_Controller {
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
		$this->load->model("classes_m");
		$this->load->model('section_m');
		$this->load->model("exam_m");
		$this->load->model("markpercentage_m");
		$this->load->model("subject_m");
		$this->load->model("setting_m");
		$this->load->model("mark_m");
		$this->load->model("grade_m");
		$this->load->model("studentrelation_m");
		$this->load->model("sattendance_m");
		$this->load->model("subjectattendance_m");
		$this->load->model("studentgroup_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('terminalreport', $language);
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'examID',
				'label' => $this->lang->line("terminalreport_exam"),
				'rules' => 'trim|required|xss_clean|callback_unique_data'
			),
			array(
				'field' => 'classesID',
				'label' => $this->lang->line("terminalreport_class"),
				'rules' => 'trim|required|xss_clean|callback_unique_data'
			),
			array(
				'field' => 'sectionID',
				'label' => $this->lang->line("terminalreport_section"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'studentID',
				'label' => $this->lang->line("terminalreport_student"),
				'rules' => 'trim|xss_clean'
			),
		);
		return $rules;
	} 

	protected function send_pdf_to_mail_rules() {
		$rules = array(
			array(
				'field' => 'examID',
				'label' => $this->lang->line("terminalreport_exam"),
				'rules' => 'trim|required|xss_clean|callback_unique_data'
			),
			array(
				'field' => 'classesID',
				'label' => $this->lang->line("terminalreport_class"),
				'rules' => 'trim|required|xss_clean|callback_unique_data'
			),
			array(
				'field' => 'sectionID',
				'label' => $this->lang->line("terminalreport_section"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'studentID',
				'label' => $this->lang->line("terminalreport_student"),
				'rules' => 'trim|xss_clean'
			),
			array(
				'field' => 'to',
				'label' => $this->lang->line("terminalreport_to"),
				'rules' => 'trim|required|xss_clean|valid_email'
			),
			array(
				'field' => 'subject',
				'label' => $this->lang->line("terminalreport_subject"),
				'rules' => 'trim|required|xss_clean'
			),
			array(
				'field' => 'message',
				'label' => $this->lang->line("terminalreport_message"),
				'rules' => 'trim|xss_clean'
			),
		);
		return $rules;
	}
	
 	public function index() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css',
				'assets/custom-scrollbar/jquery.mCustomScrollbar.css',
			),
			'js' => array(
				'assets/select2/select2.js',
				'assets/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js',
			)
		);
		$this->data['exams'] = $this->exam_m->get_exam();
		$this->data['classes'] = $this->classes_m->general_get_classes();
		$this->data["subview"] = "report/terminal/TerminalReportView";
		$this->load->view('_layout_main', $this->data);
	}

	public function getTerminalreport () {
		$retArray['status'] = FALSE;
		$retArray['render'] = '';
		if(permissionChecker('terminalreport')) {
			if($_POST) {
				$examID       = $this->input->post('examID');
				$classesID    = $this->input->post('classesID');
				$sectionID    = $this->input->post('sectionID');
				$studentID    = $this->input->post('studentID');
				$schoolyearID = $this->session->userdata('defaultschoolyearID');
				$rules = $this->rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$retArray = $this->form_validation->error_array();
					$retArray['status'] = FALSE;
				    echo json_encode($retArray);
				    exit;
				} else {
					$this->data['examID']    = $examID;
					$this->data['classesID'] = $classesID;
					$this->data['sectionID'] = $sectionID;
					$this->data['studentIDD'] = $studentID;

					$queryArray        = [];
					$studentQueryArray = [];
					$queryArray['schoolyearID']          = $schoolyearID;
					$studentQueryArray['srschoolyearID']   = $schoolyearID;

					if((int)$examID > 0) {
						$queryArray['examID'] = $examID;
					} 

					if((int)$classesID > 0) {
						$queryArray['classesID'] = $classesID;
						$studentQueryArray['srclassesID'] = $classesID;
					} 

					if((int)$sectionID > 0) {
						$queryArray['sectionID'] = $sectionID;
						$studentQueryArray['srsectionID'] = $sectionID;
					}

					if((int)$studentID > 0) {
						$studentQueryArray['srstudentID'] = $studentID;
					}

					$this->data['studentLists'] = $this->studentrelation_m->general_get_order_by_student($studentQueryArray);

					$exams    = $this->exam_m->get_exam($examID);
					$this->data['examName'] = $exams->exam;
					$this->data['grades']   = $this->grade_m->get_grade();
					$this->data['classes']  = pluck($this->classes_m->general_get_classes(),'classes','classesID');
					$this->data['sections'] = pluck($this->section_m->general_get_section(),'section','sectionID');
					$this->data['groups']   = pluck($this->studentgroup_m->get_studentgroup(),'group','studentgroupID');

					$students = $this->studentrelation_m->general_get_order_by_student(array('srclassesID' => $classesID, 'srschoolyearID' => $schoolyearID));
					$marks = $this->mark_m->student_all_mark_array($queryArray);
					$markpercentages = $this->get_setting_mark_percentage();
					$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
					$this->data['col']      = 5 + count($markpercentages);
					$this->data['subjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID));
					$this->data['markpercentages'] = $markpercentages;

					$retMark = [];
					if(count($marks)) {
						foreach ($marks as $mark) {
							$retMark[$mark->studentID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
						}
					}

					$studentPositon = [];
					$studentChecker = [];
					$studentClassPositionArray = [];
					$studentSubjectPositionArray = [];
					if(count($students)) {
						foreach ($students as $student) {
							$studentPositon[$student->srstudentID]['totalSubjectMark'] = 0;
							$studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] = 0;
							if(count($mandatorySubjects)) {
								foreach ($mandatorySubjects as $mandatorySubject) {
									if(count($markpercentages)) {
										foreach ($markpercentages as $markpercentage) {

											if(isset($studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID])) {
												if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] += $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												} else {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] += 0;
												}
											} else {
												if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] = $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												} else {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] = 0;
												}
											}

											if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
												$studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID] = $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];

												if(isset($studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID])) {
													$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] += $studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												} else {
													$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] = $studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												}
											}

											if(!isset($studentChecker['subject'][$student->srstudentID][$markpercentage->markpercentageID])) {
												if($student->sroptionalsubjectID != 0) {
													if(isset($studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID])) {
														if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] += $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														} else {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] += 0;
														}
													} else {
														if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] = $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														} else {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] = 0;
														}
													}

													if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
														$studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID] = $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];



														if(isset($studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID])) {
															$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] += $studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														} else {
															$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] = $studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														}

													}

												}
												$studentChecker['subject'][$student->srstudentID][$markpercentage->markpercentageID] = TRUE;
											}
										}
									}

									$studentPositon[$student->srstudentID]['totalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];


									$studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];


									if(!isset($studentChecker['totalSubjectMark'][$student->srstudentID])) {
										if($student->sroptionalsubjectID != 0) {
											$studentPositon[$student->srstudentID]['totalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID];
										}
										$studentChecker['totalSubjectMark'][$student->srstudentID] = TRUE;
									}

									$studentSubjectPositionArray[$mandatorySubject->subjectID][$student->srstudentID] = $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];

									if(!isset($studentChecker['studentSubjectPositionArray'][$student->srstudentID])) {
										if($student->sroptionalsubjectID != 0) {
											$studentSubjectPositionArray[$student->sroptionalsubjectID][$student->srstudentID] = $studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID];
										}
									}
								}
							}	


							$studentPositon[$student->srstudentID]['classPositionMark'] = ($studentPositon[$student->srstudentID]['totalSubjectMark'] / count($studentPositon[$student->srstudentID]['subjectMark']));
							$studentClassPositionArray[$student->srstudentID] = $studentPositon[$student->srstudentID]['classPositionMark'];

							$studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] = ($studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] / count($mandatorySubjects));


							if(isset($studentPositon['totalStudentMarkAverage'])) {
								$studentPositon['totalStudentMarkAverage'] += $studentPositon[$student->srstudentID]['classPositionMark'];
							} else {
								$studentPositon['totalStudentMarkAverage'] = $studentPositon[$student->srstudentID]['classPositionMark'];
							}
						}
					}

					arsort($studentClassPositionArray);
					$studentPositon['studentClassPositionArray'] = $studentClassPositionArray;
					if(count($studentSubjectPositionArray)) {
						foreach($studentSubjectPositionArray as $subjectID => $studentSubjectPositionMark) {
							arsort($studentSubjectPositionMark);
							$studentPositon['studentSubjectPositionMark'][$subjectID] = $studentSubjectPositionMark;
						}
					}
					
					if((int)$studentID > 0) {
						$queryArray['studentID'] = $studentID;
					}


					$this->data['attendance']     = $this->get_student_attendance($queryArray,$this->data['subjects'], $this->data['studentLists']);
					$this->data['studentPosition'] = $studentPositon;

					$retArray['render'] = $this->load->view('report/terminal/TerminalReport',$this->data,true);
					$retArray['status'] = TRUE;
					echo json_encode($retArray);
					exit();
				}
			} else {
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

	private function get_student_attendance($queryArray, $subjects, $studentlists) {
		unset($queryArray['examID']);
		$newArray = [];
		$attendanceArray = [];
		$getWeekendDay = $this->getWeekendDays();
		$getHoliday    = explode('","', $this->getHolidays());

		if($this->data['siteinfos']->attendance == 'subject') {
			$attendances   = $this->subjectattendance_m->get_order_by_sub_attendance($queryArray);

			if(count($attendances)) {
				foreach ($attendances as $attendance) {
					$monthyearArray = explode('-', $attendance->monthyear);
					$monthDay = date('t', mktime(0, 0, 0, $monthyearArray['0'], 1, $monthyearArray['1'])); 
					for($i=1; $i<=$monthDay; $i++) {
						$currentDate = sprintf("%02d", $i).'-'.$attendance->monthyear;
						if(in_array($currentDate, $getHoliday)) {
							continue;
						} elseif(in_array($currentDate, $getWeekendDay)) {
							continue;
						} else {
							$day = 'a'.$i;
							if($attendance->$day == 'P' || $attendance->$day == 'L' || $attendance->$day == 'LE') {
								if(!isset($newArray[$attendance->studentID][$attendance->subjectID]['pCount'])) {
									$newArray[$attendance->studentID][$attendance->subjectID]['pCount'] = 1;
								} else {
									$newArray[$attendance->studentID][$attendance->subjectID]['pCount'] += 1;
								}
							} else {
								if(!isset($newArray[$attendance->studentID][$attendance->subjectID]['aCount'])) {
									$newArray[$attendance->studentID][$attendance->subjectID]['aCount'] = 1;
								} else {
									$newArray[$attendance->studentID][$attendance->subjectID]['aCount'] += 1;
								}
							}
							if(!isset($newArray[$attendance->studentID][$attendance->subjectID]['tCount'])) {
								$newArray[$attendance->studentID][$attendance->subjectID]['tCount'] = 1;
							} else {
								$newArray[$attendance->studentID][$attendance->subjectID]['tCount'] += 1;
							}
						}
					}
				}

				$studentlistsArray = pluck($studentlists,'sroptionalsubjectID','srstudentID');
				$subjects  = pluck($subjects,'obj','subjectID');

				if(count($newArray)) {
					foreach($newArray as $studentID => $array) {
						$str = '';
						if(count($subjects)) {
							foreach ($subjects as $subjectID => $subject) {
								if($subject->type == '1') {
									$pCount = isset($array[$subjectID]['pCount']) ? $array[$subjectID]['pCount'] : '0';
									$tCount = isset($array[$subjectID]['tCount']) ? $array[$subjectID]['tCount'] : '0';
									$str .= $subjects[$subjectID]->subject .":".$pCount."/".$tCount.',';
								}
							}
						}

						if(isset($studentlistsArray[$studentID]) && $studentlistsArray[$studentID] != '0' ) {
							$pCount = isset($newArray[$studentID][$studentlistsArray[$studentID]]['pCount']) ? $newArray[$studentID][$studentlistsArray[$studentID]]['pCount'] : '0';
							$tCount = isset($newArray[$studentID][$studentlistsArray[$studentID]]['tCount']) ? $newArray[$studentID][$studentlistsArray[$studentID]]['tCount'] : '0';
							$str .= $subjects[$subjectID]->subject .":".$pCount."/".$tCount.',';
						}

						$attendanceArray[$studentID] = $str;
					}
				}
			}
		} else {
			$attendances   = $this->sattendance_m->get_order_by_attendance($queryArray);
			if(count($attendances)) {
				foreach($attendances as $attendance) {
					$monthyearArray = explode('-', $attendance->monthyear);
					$monthDay = date('t', mktime(0, 0, 0, $monthyearArray['0'], 1, $monthyearArray['1'])); 
					for($i=1; $i<=$monthDay; $i++) {
						$currentDate = sprintf("%02d", $i).'-'.$attendance->monthyear;
						if(in_array($currentDate, $getHoliday)) {
							continue;
						} elseif(in_array($currentDate, $getWeekendDay)) {
							continue;
						} else {
							$day = 'a'.$i;
							if($attendance->$day == 'P' || $attendance->$day == 'L' || $attendance->$day == 'LE') {
								if(!isset($newArray[$attendance->studentID]['pCount'])) {
									$newArray[$attendance->studentID]['pCount'] = 1;
								} else {
									$newArray[$attendance->studentID]['pCount'] += 1;
								}
							} else {
								if(!isset($newArray[$attendance->studentID]['aCount'])) {
									$newArray[$attendance->studentID]['aCount'] = 1;
								} else {
									$newArray[$attendance->studentID]['aCount'] += 1;
								}
							}
							if(!isset($newArray[$attendance->studentID]['tCount'])) {
								$newArray[$attendance->studentID]['tCount'] = 1;
							} else {
								$newArray[$attendance->studentID]['tCount'] += 1;
							}
						}
					}
					$pCount = isset($newArray[$attendance->studentID]['pCount']) ? $newArray[$attendance->studentID]['pCount'] : '0';
					$tCount = isset($newArray[$attendance->studentID]['tCount']) ? $newArray[$attendance->studentID]['tCount'] : '0';
					$attendanceArray[$attendance->studentID] = $pCount."/".$tCount;
				}
			}
		}
		return $attendanceArray;
	}

	private function classStudentPostion($arrays) {
		$newArray = [];
		if(count($arrays)) {
			arsort($arrays);
			foreach ($arrays as $studentID => $array) {
				$i = array_search($studentID, array_keys($arrays));
				$newArray[$studentID] = $i+1;
			}
		}
		return $newArray;
	}

	private function avarageCount($averageMarkArray) {
		$newArray = array();
		$classAverageMark = 0;
		if(count($averageMarkArray)) {
			foreach($averageMarkArray as $studentID => $marks) {
				$studentTotalSubject = count($marks['subjects']);
				$studenbtAverageMark  = $marks['studentTotalMark'] / $studentTotalSubject;
				$newArray[$studentID]['student_average'] = $studenbtAverageMark;
				$classAverageMark += $studenbtAverageMark;
			}
		}
		$newArray['classAverageMark'] = $classAverageMark;
		return $newArray;
	}

	private function subjectPostion($subjectPostionArray) {
		$positionArray = [];
		if(count($subjectPostionArray)) {
			foreach($subjectPostionArray as $subjectID => $subjectPostions) {
				arsort($subjectPostions);
				if(count($subjectPostions)) {
					foreach($subjectPostions as $studentID => $subjectPostion) {
						(int) $i = array_search($studentID, array_keys($subjectPostions));
						$positionArray[$studentID][$subjectID] = $i++;
					}
				}
			}
		}
		return $positionArray;
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
		if(permissionChecker('terminalreport')) {
			$examID = htmlentities(escapeString($this->uri->segment(3)));
			$classesID  = htmlentities(escapeString($this->uri->segment(4)));
			$sectionID  = htmlentities(escapeString($this->uri->segment(5)));
			$studentID  = htmlentities(escapeString($this->uri->segment(6)));
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			if((int)$examID && (int)$classesID && ((int)$sectionID || $sectionID >= 0) && ((int)$studentID || $studentID >= 0)) {
				$this->data['examID']    = $examID;
				$this->data['classesID'] = $classesID;
				$this->data['sectionID'] = $sectionID;
				$this->data['studentIDD'] = $studentID;

				$queryArray        = [];
				$studentQueryArray = [];
				$queryArray['schoolyearID']          = $schoolyearID;
				$studentQueryArray['srschoolyearID'] = $schoolyearID;

				if((int)$examID > 0) {
					$queryArray['examID'] = $examID;
				} 

				if((int)$classesID > 0) {
					$queryArray['classesID'] = $classesID;
					$studentQueryArray['srclassesID'] = $classesID;
				} 

				if((int)$sectionID > 0) {
					$queryArray['sectionID'] = $sectionID;
					$studentQueryArray['srsectionID'] = $sectionID;
				}

				if((int)$studentID > 0) {
					$studentQueryArray['srstudentID'] = $studentID;
				}

				$this->data['studentLists'] = $this->studentrelation_m->general_get_order_by_student($studentQueryArray);

				$exams    = $this->exam_m->get_exam($examID);
				$this->data['examName'] = $exams->exam;
				$this->data['grades']   = $this->grade_m->get_grade();
				$this->data['classes']  = pluck($this->classes_m->general_get_classes(),'classes','classesID');
				$this->data['sections'] = pluck($this->section_m->general_get_section(),'section','sectionID');
				$this->data['groups']   = pluck($this->studentgroup_m->get_studentgroup(),'group','studentgroupID');

				$students = $this->studentrelation_m->general_get_order_by_student(array('srclassesID' => $classesID, 'srschoolyearID' => $schoolyearID));
				$marks = $this->mark_m->student_all_mark_array($queryArray);
				$markpercentages = $this->get_setting_mark_percentage();
				$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
				$this->data['col']      = 5 + count($markpercentages);
				$this->data['subjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID));
				$this->data['markpercentages'] = $markpercentages;

				$retMark = [];
				if(count($marks)) {
					foreach ($marks as $mark) {
						$retMark[$mark->studentID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
					}
				}

				$studentPositon = [];
				$studentChecker = [];
				$studentClassPositionArray = [];
				$studentSubjectPositionArray = [];
				if(count($students)) {
					foreach ($students as $student) {
						$studentPositon[$student->srstudentID]['totalSubjectMark'] = 0;
						$studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] = 0;
						if(count($mandatorySubjects)) {
							foreach ($mandatorySubjects as $mandatorySubject) {
								if(count($markpercentages)) {
									foreach ($markpercentages as $markpercentage) {

										if(isset($studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID])) {
											if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
												$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] += $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
											} else {
												$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] += 0;
											}
										} else {
											if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
												$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] = $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
											} else {
												$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] = 0;
											}
										}

										if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
											$studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID] = $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];

											if(isset($studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID])) {
												$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] += $studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
											} else {
												$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] = $studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
											}
										}

										if(!isset($studentChecker['subject'][$student->srstudentID][$markpercentage->markpercentageID])) {
											if($student->sroptionalsubjectID != 0) {
												if(isset($studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID])) {
													if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
														$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] += $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
													} else {
														$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] += 0;
													}
												} else {
													if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
														$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] = $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
													} else {
														$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] = 0;
													}
												}

												if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
													$studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID] = $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];



													if(isset($studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID])) {
														$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] += $studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
													} else {
														$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] = $studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
													}

												}

											}
											$studentChecker['subject'][$student->srstudentID][$markpercentage->markpercentageID] = TRUE;
										}
									}
								}

								$studentPositon[$student->srstudentID]['totalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];

								$studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];

								if(!isset($studentChecker['totalSubjectMark'][$student->srstudentID])) {
									if($student->sroptionalsubjectID != 0) {
										$studentPositon[$student->srstudentID]['totalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID];
									}
									$studentChecker['totalSubjectMark'][$student->srstudentID] = TRUE;
								}

								$studentSubjectPositionArray[$mandatorySubject->subjectID][$student->srstudentID] = $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];

								if(!isset($studentChecker['studentSubjectPositionArray'][$student->srstudentID])) {
									if($student->sroptionalsubjectID != 0) {
										$studentSubjectPositionArray[$student->sroptionalsubjectID][$student->srstudentID] = $studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID];
									}
								}
							}
						}	

						$studentPositon[$student->srstudentID]['classPositionMark'] = ($studentPositon[$student->srstudentID]['totalSubjectMark'] / count($studentPositon[$student->srstudentID]['subjectMark']));
						
						$studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] = ($studentPositon[$student->srstudentID]['totalWithOutOptionalSubjectMark'] / count($mandatorySubjects));

						$studentClassPositionArray[$student->srstudentID] = $studentPositon[$student->srstudentID]['classPositionMark'];
						if(isset($studentPositon['totalStudentMarkAverage'])) {
							$studentPositon['totalStudentMarkAverage'] += $studentPositon[$student->srstudentID]['classPositionMark'];
						} else {
							$studentPositon['totalStudentMarkAverage'] = $studentPositon[$student->srstudentID]['classPositionMark'];
						}
					}
				}

				arsort($studentClassPositionArray);
				$studentPositon['studentClassPositionArray'] = $studentClassPositionArray;
				if(count($studentSubjectPositionArray)) {
					foreach($studentSubjectPositionArray as $subjectID => $studentSubjectPositionMark) {
						arsort($studentSubjectPositionMark);
						$studentPositon['studentSubjectPositionMark'][$subjectID] = $studentSubjectPositionMark;
					}
				}
				
				if((int)$studentID > 0) {
					$queryArray['studentID'] = $studentID;
				}

				$this->data['attendance']     = $this->get_student_attendance($queryArray,$this->data['subjects'], $this->data['studentLists']);
				$this->data['studentPosition'] = $studentPositon;
				$this->reportPDF('terminalreport.css', $this->data, 'report/terminal/TerminalReportPDF');
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "errorpermission";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function send_pdf_to_mail() {
		$retArray['status'] = FALSE;
		$retArray['message'] = '';

		if(permissionChecker('terminalreport')) {
			if($_POST) {
				$to      = $this->input->post('to');
				$subject = $this->input->post('subject');
				$message = $this->input->post('message');
				$examID  = $this->input->post('examID');
				$classesID  = $this->input->post('classesID');
				$sectionID  = $this->input->post('sectionID');
				$studentID  = $this->input->post('studentID');
				$schoolyearID = $this->session->userdata('defaultschoolyearID');

				$rules = $this->send_pdf_to_mail_rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) {
					$retArray = $this->form_validation->error_array();
					$retArray['status'] = FALSE;
				    echo json_encode($retArray);
				    exit;
				} else {
					$this->data['examID']    = $examID;
					$this->data['classesID'] = $classesID;
					$this->data['sectionID'] = $sectionID;
					$this->data['studentIDD'] = $studentID;

					$queryArray        = [];
					$studentQueryArray = [];
					$queryArray['schoolyearID']          = $schoolyearID;
					$studentQueryArray['srschoolyearID']   = $schoolyearID;
					// $studentQueryArray['studentID !=']   = 'NULL';

					if((int)$examID > 0) {
						$queryArray['examID'] = $examID;
					} 

					if((int)$classesID > 0) {
						$queryArray['classesID'] = $classesID;
						$studentQueryArray['srclassesID'] = $classesID;
					} 

					if((int)$sectionID > 0) {
						$queryArray['sectionID'] = $sectionID;
						$studentQueryArray['srsectionID'] = $sectionID;
					}

					if((int)$studentID > 0) {
						$studentQueryArray['srstudentID'] = $studentID;
					}

					$this->data['studentLists'] = $this->studentrelation_m->general_get_order_by_student($studentQueryArray);

					$exams    = $this->exam_m->get_exam($examID);
					$this->data['examName'] = $exams->exam;
					$this->data['grades']   = $this->grade_m->get_grade();
					$this->data['classes']  = pluck($this->classes_m->general_get_classes(),'classes','classesID');
					$this->data['sections'] = pluck($this->section_m->general_get_section(),'section','sectionID');
					$this->data['groups']   = pluck($this->studentgroup_m->get_studentgroup(),'group','studentgroupID');

					$students = $this->studentrelation_m->general_get_order_by_student(array('srclassesID' => $classesID, 'srschoolyearID' => $schoolyearID));
					$marks = $this->mark_m->student_all_mark_array($queryArray);
					$markpercentages = $this->get_setting_mark_percentage();
					$mandatorySubjects = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID, 'type' => 1));
					$this->data['col']      = 5 + count($markpercentages);
					$this->data['subjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID));
					$this->data['markpercentages'] = $markpercentages;

					$retMark = [];
					if(count($marks)) {
						foreach ($marks as $mark) {
							$retMark[$mark->studentID][$mark->subjectID][$mark->markpercentageID] = $mark->mark;
						}
					}

					$studentPositon = [];
					$studentChecker = [];
					$studentClassPositionArray = [];
					$studentSubjectPositionArray = [];
					if(count($students)) {
						foreach ($students as $student) {
							$studentPositon[$student->srstudentID]['totalSubjectMark'] = 0;
							if(count($mandatorySubjects)) {
								foreach ($mandatorySubjects as $mandatorySubject) {
									if(count($markpercentages)) {
										foreach ($markpercentages as $markpercentage) {

											if(isset($studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID])) {
												if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] += $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												} else {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] += 0;
												}
											} else {
												if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] = $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												} else {
													$studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID] = 0;
												}
											}

											if(isset($retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
												$studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID] = $retMark[$student->srstudentID][$mandatorySubject->subjectID][$markpercentage->markpercentageID];

												if(isset($studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID])) {
													$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] += $studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												} else {
													$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] = $studentPositon[$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
												}
											}

											if(!isset($studentChecker['subject'][$student->srstudentID][$markpercentage->markpercentageID])) {
												if($student->sroptionalsubjectID != 0) {
													if(isset($studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID])) {
														if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] += $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														} else {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] += 0;
														}
													} else {
														if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] = $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														} else {
															$studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID] = 0;
														}
													}

													if(isset($retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
														$studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID] = $retMark[$student->srstudentID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];



														if(isset($studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID])) {
															$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] += $studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														} else {
															$studentPositon[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] = $studentPositon[$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
														}

													}

												}
												$studentChecker['subject'][$student->srstudentID][$markpercentage->markpercentageID] = TRUE;
											}
										}
									}

									$studentPositon[$student->srstudentID]['totalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];

									if(!isset($studentChecker['totalSubjectMark'][$student->srstudentID])) {
										if($student->sroptionalsubjectID != 0) {
											$studentPositon[$student->srstudentID]['totalSubjectMark'] += $studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID];
										}
										$studentChecker['totalSubjectMark'][$student->srstudentID] = TRUE;
									}

									$studentSubjectPositionArray[$mandatorySubject->subjectID][$student->srstudentID] = $studentPositon[$student->srstudentID]['subjectMark'][$mandatorySubject->subjectID];

									if(!isset($studentChecker['studentSubjectPositionArray'][$student->srstudentID])) {
										if($student->sroptionalsubjectID != 0) {
											$studentSubjectPositionArray[$student->sroptionalsubjectID][$student->srstudentID] = $studentPositon[$student->srstudentID]['subjectMark'][$student->sroptionalsubjectID];
										}
									}
								}
							}	

							$studentPositon[$student->srstudentID]['classPositionMark'] = ($studentPositon[$student->srstudentID]['totalSubjectMark'] / count($studentPositon[$student->srstudentID]['subjectMark']));
							$studentClassPositionArray[$student->srstudentID] = $studentPositon[$student->srstudentID]['classPositionMark'];
							if(isset($studentPositon['totalStudentMarkAverage'])) {
								$studentPositon['totalStudentMarkAverage'] += $studentPositon[$student->srstudentID]['classPositionMark'];
							} else {
								$studentPositon['totalStudentMarkAverage'] = $studentPositon[$student->srstudentID]['classPositionMark'];
							}
						}
					}

					arsort($studentClassPositionArray);
					$studentPositon['studentClassPositionArray'] = $studentClassPositionArray;
					if(count($studentSubjectPositionArray)) {
						foreach($studentSubjectPositionArray as $subjectID => $studentSubjectPositionMark) {
							arsort($studentSubjectPositionMark);
							$studentPositon['studentSubjectPositionMark'][$subjectID] = $studentSubjectPositionMark;
						}
					}
					
					if((int)$studentID > 0) {
						$queryArray['studentID'] = $studentID;
					}

					$this->data['attendance']     = $this->get_student_attendance($queryArray, $this->data['subjects'], $this->data['studentLists']);
					$this->data['studentPosition'] = $studentPositon;

					$this->reportSendToMail('terminalreport.css', $this->data, 'report/terminal/TerminalReportPDF',$to, $subject,$message);
					$retArray['status'] = TRUE;
					echo json_encode($retArray);
    				exit;
				}
			} else {
				$retArray['message'] = $this->lang->line('terminalreport_permissionmethod');
				echo json_encode($retArray);
				exit;
			}
		} else {
			$retArray['message'] = $this->lang->line('terminalreport_permission');
			echo json_encode($retArray);
			exit;
		}
	}

	public function getSection() {
		$classesID = $this->input->post('classesID');
		if((int)$classesID) {
			$sections = $this->section_m->general_get_order_by_section(array('classesID' => $classesID));
			echo "<option value='0'>", $this->lang->line("terminalreport_please_select"),"</option>";
			if(count($sections)) {
				foreach ($sections as $section) {
					echo "<option value=\"$section->sectionID\">".$section->section."</option>";
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
			if(count($students)) {
				echo "<option value='0'>". $this->lang->line("terminalreport_please_select") ."</option>";
				foreach($students as $student) {
					echo "<option value=\"$student->srstudentID\">".$student->srname."</option>";
				}
			}
		}
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
}
