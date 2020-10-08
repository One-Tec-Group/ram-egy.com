<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Routine extends Admin_Controller {
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
        $this->load->model("routine_m");
        $this->load->model("classes_m");
        $this->load->model("section_m");
        $this->load->model("subject_m");
        $this->load->model('parents_m');
        $this->load->model('student_m');
        $this->load->model('teacher_m');
        $this->load->model('schoolyear_m');
        $this->load->model('teachersection_m');
        $language = $this->session->userdata('lang');
        $this->lang->load('routine', $language);
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

        if ($this->session->userdata('usertypeID') == 3) {
            $id = $this->data['myclass'];
        } else {
            $id = htmlentities(escapeString($this->uri->segment(3)));
        }

        $schoolyearID = $this->session->userdata('defaultschoolyearID');
        if ((int) $id) {
            $this->data['set'] = $id;
            $this->data['classes'] = $this->classes_m->get_classes();
            $this->data['routines'] = $this->routine_m->get_routine_with_teacher_class_section_subject(array('classesID' => $id, 'schoolyearID' => $schoolyearID));

            $fetchClass = pluck($this->data['classes'], 'classesID', 'classesID');
            if (isset($fetchClass[$id])) {
                if ($this->data['routines']) {
                    $sections = $this->section_m->general_get_order_by_section(array("classesID" => $id));
                    $this->data['sections'] = $sections;
                    foreach ($sections as $key => $section) {
                        $this->data['allsection'][$section->section] = $this->routine_m->get_routine_with_teacher_class_section_subject(array('classesID' => $id, 'sectionID' => $section->sectionID, 'schoolyearID' => $schoolyearID));
                    }
                } else {
                    $this->data['routines'] = [];
                }
                $this->data["subview"] = "routine/index";
                $this->load->view('_layout_main', $this->data);
            } else {
                $this->data['set'] = 0;
                $this->data['routines'] = [];
                $this->data['classes'] = $this->classes_m->get_classes();
                $this->data["subview"] = "routine/index";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data['set'] = 0;
            $this->data['routines'] = [];
            $this->data['classes'] = $this->classes_m->get_classes();
            $this->data["subview"] = "routine/index";
            $this->load->view('_layout_main', $this->data);
        }
    }

    protected function rules() {
        $rules = array(
            array(
                'field' => 'schoolyearID',
                'label' => $this->lang->line("routine_schoolyear"),
                'rules' => 'trim|required|xss_clean|numeric|max_length[11]|callback_unique_data'
            ),
            array(
                'field' => 'classesID',
                'label' => $this->lang->line("routine_classes"),
                'rules' => 'trim|required|xss_clean|numeric|max_length[11]|callback_unique_data'
            ),
            array(
                'field' => 'sectionID',
                'label' => $this->lang->line("routine_section"),
                'rules' => 'trim|required|xss_clean|numeric|max_length[11]|callback_unique_data|callback_unique_section'
            ),
            array(
                'field' => 'teacherID',
                'label' => $this->lang->line("routine_teacher"),
                'rules' => 'trim|required|xss_clean|numeric|max_length[11]|callback_unique_data|callback_unique_teacher'
            ),
            array(
                'field' => 'start_time',
                'label' => $this->lang->line("routine_start_time"),
                'rules' => 'trim|required|xss_clean|max_length[10]'
            ),
            array(
                'field' => 'end_time',
                'label' => $this->lang->line("routine_end_time"),
                'rules' => 'trim|required|xss_clean|max_length[10]'
            ),
            array(
                'field' => 'room',
                'label' => $this->lang->line("routine_room"),
                'rules' => 'trim|required|xss_clean|max_length[11]|callback_unique_room'
            )
        );
        return $rules;
    }

    public function add() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css',
                'assets/timepicker/timepicker.css'
            ),
            'js' => array(
                'assets/select2/select2.js',
                'assets/timepicker/timepicker.js'
            )
        );

        $this->data['schoolyears'] = $this->schoolyear_m->get_schoolyear();
        $this->data['classes'] = $this->classes_m->get_classes();
        $classesID = $this->input->post("classesID");

        if ($classesID > 0) {
            $this->data['sections'] = $this->section_m->get_order_by_section(array("classesID" => $classesID));
            if ($this->input->post('sectionID') > 0) {
                $this->data['teachers'] = $this->teachersection_m->get_teacher_with_section($this->input->post('sectionID'));
            }
        } else {
            $this->data['sections'] = [];
            $this->data['teachers'] = [];
        }

        if ($_POST && !empty($_POST['day'])) {
            $dayCount = 0;
            do {
                $rules = $this->rules();
                $this->data['day'] = $this->input->post("day")[$dayCount];
                $this->form_validation->set_rules($rules);
                if ($this->form_validation->run() == FALSE) {
                    $this->data['form_validation'] = validation_errors();
                    $this->data["subview"] = "routine/add";
                    $this->load->view('_layout_main', $this->data);
                    break;
                } else {
                    $array = array(
                        "classesID" => $this->input->post("classesID"),
                        "sectionID" => $this->input->post("sectionID"),
                        'schoolyearID' => $this->input->post('schoolyearID'),
                        "day" => $this->data['day'],
                        'teacherID' => $this->input->post('teacherID'),
                        "start_time" => $this->input->post("start_time"),
                        "end_time" => $this->input->post("end_time"),
                        "room" => $this->input->post("room")
                    );
                    $this->routine_m->insert_routine($array);
                    if ($dayCount >= (count($this->input->post("day")) - 1)) {
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("routine/index"));
                    }
                }
                $dayCount++;
            } while ($dayCount < count($this->input->post("day")));
        } else {
            $this->data["subview"] = "routine/add";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css',
                'assets/timepicker/timepicker.css'
            ),
            'js' => array(
                'assets/select2/select2.js',
                'assets/timepicker/timepicker.js'
            )
        );

        $id = htmlentities(escapeString($this->uri->segment(3)));
        $url = htmlentities(escapeString($this->uri->segment(4)));
        if ((int) $id && (int) $url) {
            if (($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
                $schoolyearID = $this->session->userdata('defaultschoolyearID');
                $this->data['routine'] = $this->routine_m->get_single_routine(array('routineID' => $id, 'classesID' => $url, 'schoolyearID' => $schoolyearID));
                if (count($this->data['routine'])) {
                    if ($this->input->post('classesID') > 0) {
                        $classID = $this->input->post('classesID');
                    } else {
                        $classID = $this->data['routine']->classesID;
                    }
                    $this->db->where("sectionID", $this->data['routine']->sectionID);
                    foreach ($this->db->get('section')->result() as $section) {
                        $this->db->where("teacherID", $section->teacherID);
                        $this->db->or_where("teacherID", $section->teacherID_second);
                        $this->db->or_where("teacherID", $section->teacherID_third);
                        $this->data['teachers'] = $this->db->get("teacher")->result();
                    }
                    $this->data['classes'] = $this->classes_m->get_classes();
                    $this->data['schoolyears'] = $this->schoolyear_m->get_schoolyear();
                    $this->data['sections'] = $this->section_m->general_get_order_by_section(array("classesID" => $classID));
                    $this->data['set'] = $url;
                    $fetchClass = pluck($this->data['classes'], 'classesID', 'classesID');
                    if (isset($fetchClass[$url])) {
                        if ($_POST) {
                            $this->data['day'] = $this->input->post("day");
                            $rules = $this->rules();
                            $this->form_validation->set_rules($rules);
                            if ($this->form_validation->run() == FALSE) {
                                $this->data["subview"] = "routine/edit";
                                $this->load->view('_layout_main', $this->data);
                            } else {
                                $array = array(
                                    "classesID" => $this->input->post("classesID"),
                                    "sectionID" => $this->input->post("sectionID"),
                                    "day" => $this->data['day'],
                                    'teacherID' => $this->input->post('teacherID'),
                                    "start_time" => $this->input->post("start_time"),
                                    "end_time" => $this->input->post("end_time"),
                                    "room" => $this->input->post("room")
                                );

                                $this->routine_m->update_routine($array, $id);
                                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                                redirect(base_url("routine/index/$url"));
                            }
                        } else {
                            $this->data["subview"] = "routine/edit";
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
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function delete() {
        $routineID = htmlentities(escapeString($this->uri->segment(3)));
        $classesID = htmlentities(escapeString($this->uri->segment(4)));
        if ((int) $routineID && (int) $classesID) {
            if (($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
                $schoolyearID = $this->session->userdata('defaultschoolyearID');
                $fetchClass = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
                if (isset($fetchClass[$classesID])) {
                    $routine = $this->routine_m->get_order_by_routine(array('routineID' => $routineID, 'classesID' => $classesID, 'schoolyearID' => $schoolyearID));
                    if (count($routine)) {
                        $this->routine_m->delete_routine($routineID);
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("routine/index/$classesID"));
                    } else {
                        redirect(base_url("routine/index"));
                    }
                } else {
                    redirect(base_url("routine/index"));
                }
            } else {
                redirect(base_url('routine/index'));
            }
        } else {
            redirect(base_url("routine/index"));
        }
    }

    public function routine_list() {
        $classID = $this->input->post('id');
        if ((int) $classID) {
            $string = base_url("routine/index/$classID");
            echo $string;
        } else {
            redirect(base_url("routine/index"));
        }
    }

    public function unique_teacher() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $routine = $this->routine_m->get_order_by_routine(array('day' => $this->data['day'], 'start_time' => $this->input->post('start_time'), 'end_time' => $this->input->post('end_time'), 'schoolyearID' => $this->input->post('schoolyearID'), 'teacherID' => $this->input->post('teacherID'), 'routineID !=' => $id));
            if (count($routine)) {
                $this->form_validation->set_message("unique_teacher", "%s already assign another schedule in this time.");
                return FALSE;
            }
            return TRUE;
        } else {
            $routine = $this->routine_m->get_order_by_routine(array('day' => $this->data['day'], 'start_time' => $this->input->post('start_time'), 'end_time' => $this->input->post('end_time'), 'teacherID' => $this->input->post('teacherID'), 'schoolyearID' => $this->input->post('schoolyearID')));
            if (count($routine)) {
                $this->form_validation->set_message("unique_teacher", "%s already assign another schedule in this time.");
                return FALSE;
            }
            return TRUE;
        }
    }

    public function unique_data($data) {
        if ($data == 0) {
            $this->form_validation->set_message("unique_data", "The %s field is required");
            return FALSE;
        }
        return TRUE;
    }

    public function teachercall() {
//            echo $this->input->post("sectionID");
//                    exit();
        echo "<option value='0'>", $this->lang->line("routine_select_teacher"), "</option>";
        $this->db->where("sectionID", $this->input->post("sectionID"));
        foreach ($this->db->get('section')->result() as $section) {
            $this->db->where("teacherID", $section->teacherID);
            $this->db->or_where("teacherID", $section->teacherID_second);
            $this->db->or_where("teacherID", $section->teacherID_third);
            foreach ($this->db->get("teacher")->result() as $teacher) {
                echo "<option value=\"$teacher->teacherID\">", $teacher->name, "</option>";
            }
        }
    }

    public function subjectcall() {
        $classID = $this->input->post('id');
        if ((int) $classID) {
            $allclasses = $this->subject_m->general_get_order_by_subject(array('classesID' => $classID));
            echo "<option value='0'>", $this->lang->line("routine_subject_select"), "</option>";
            foreach ($allclasses as $value) {
                echo "<option value=\"$value->subjectID\">", $value->subject, "</option>";
            }
        }
    }

    public function sectioncall() {
        $classID = $this->input->post('id');
        if ((int) $classID) {
            $allsection = $this->section_m->general_get_order_by_section(array('classesID' => $classID));
            echo "<option value='0'>", $this->lang->line("routine_select_section"), "</option>";
            foreach ($allsection as $value) {
                echo "<option value=\"$value->sectionID\">", $value->section, "</option>";
            }
        }
    }

    public function unique_room() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $routine = $this->routine_m->get_order_by_routine(array('classesID' => $this->input->post('classesID'), 'day' => $this->data['day'], 'start_time' => $this->input->post('start_time'), 'end_time' => $this->input->post('end_time'), 'room' => $this->input->post('room'), 'schoolyearID' => $this->input->post('schoolyearID'), 'routineID !=' => $id));
            if (count($routine)) {
                $this->form_validation->set_message("unique_room", "%s already exists");
                return FALSE;
            }
            return TRUE;
        } else {
            $routine = $this->routine_m->get_order_by_routine(array('classesID' => $this->input->post('classesID'), 'day' => $this->data['day'], 'start_time' => $this->input->post('start_time'), 'end_time' => $this->input->post('end_time'), 'room' => $this->input->post('room'), 'schoolyearID' => $this->input->post('schoolyearID')));
            if (count($routine)) {
                $this->form_validation->set_message("unique_room", "%s already exists");
                return FALSE;
            }
            return TRUE;
        }
    }

    public function unique_section() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $routine = $this->routine_m->get_order_by_routine(array('classesID' => $this->input->post('classesID'), 'day' => $this->data['day'], 'start_time' => $this->input->post('start_time'), 'end_time' => $this->input->post('end_time'), 'sectionID' => $this->input->post('sectionID'), 'schoolyearID' => $this->input->post('schoolyearID'), 'routineID !=' => $id));
            if (count($routine)) {
                $this->form_validation->set_message("unique_section", "%s already exists");
                return FALSE;
            }
            return TRUE;
        } else {
            $routine = $this->routine_m->get_order_by_routine(array('classesID' => $this->input->post('classesID'), 'day' => $this->data['day'], 'start_time' => $this->input->post('start_time'), 'end_time' => $this->input->post('end_time'), 'sectionID' => $this->input->post('sectionID'), 'schoolyearID' => $this->input->post('schoolyearID')));
            if (count($routine)) {
                $this->form_validation->set_message("unique_section", "%s already exists");
                return FALSE;
            }
            return TRUE;
        }
    }

    public function unique_day() {
        $day = $this->input->post('day');
        if (count($day) == '0') {
            $this->form_validation->set_message("unique_day", "The %s field is required.");
            return FALSE;
        }
        return TRUE;
    }

}
