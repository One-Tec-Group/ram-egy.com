<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Section extends Admin_Controller {
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
        $this->load->model("section_m");
        $this->load->model('classes_m');
        $this->load->model('teacher_m');
        $this->load->model('studentrelation_m');
        $this->load->model("student_m");
        $this->load->model("invoice_m");
        $this->load->model("user_m");
        $language = $this->session->userdata('lang');
        $this->lang->load('section', $language);
        //$this->lang->load('student', $language);
    }

    protected function rules() {
        $rules = array(
            array(
                'field' => 'section',
                'label' => $this->lang->line("section_name"),
                'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_section'
            ),
            array(
                'field' => 'monthlyFees',
                'label' => $this->lang->line("section_monthly_fees"),
                'rules' => 'trim|required|max_length[10]|numeric|xss_clean'
            ),
            array(
                'field' => 'capacity',
                'label' => $this->lang->line("section_capacity"),
                'rules' => 'trim|required|max_length[11]|xss_clean|numeric|callback_valid_number'
            ),
            array(
                'field' => 'classesID',
                'label' => $this->lang->line("section_classes"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_classes'
            ),
            array(
                'field' => 'firsTeacherID',
                'label' => $this->lang->line("section_teacher_name_first"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean'
            ),
            array(
                'field' => 'supervisor',
                'label' => $this->lang->line("supervisor"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean'
            ),
            array(
                'field' => 'supervisor2',
                'label' => $this->lang->line("supervisor2"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean'
            ),
            array(
                'field' => 'note',
                'label' => $this->lang->line("section_note"),
                'rules' => 'trim|max_length[200]'
            ),
            array(
                'field' => 'photo',
                'label' => $this->lang->line("section_photo"),
                'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
            )
        );
        return $rules;
    }

    public function photoupload() {
        $new_file = "default.png";
        if ($_FILES["photo"]['name'] != "") {
            $file_name = $_FILES["photo"]['name'];
            $random = random19();
            $makeRandom = hash('sha512', $random . $this->input->post('section') . config_item("encryption_key"));
            $file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if (count($explode) >= 2) {
                $new_file = $file_name_rename . '.' . end($explode);
                $config['upload_path'] = "./uploads/images";
                $config['allowed_types'] = "gif|jpg|png";
                $config['file_name'] = $new_file;
                $config['max_size'] = '1024';
                $config['max_width'] = '3000';
                $config['max_height'] = '3000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload("photo")) {
                    $this->form_validation->set_message("photoupload", $this->upload->display_errors());
                    return FALSE;
                } else {
                    $this->upload_data['file'] = $this->upload->data();
                    return TRUE;
                }
            } else {
                $this->form_validation->set_message("photoupload", "Invalid file");
                return FALSE;
            }
        } else {
            $this->upload_data['file'] = array('file_name' => $new_file);
            return TRUE;
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

        if ($this->session->userdata('usertypeID') == 3) {
            $id = $this->data['myclass'];
        } else {
            $id = htmlentities(escapeString($this->uri->segment(3)));
        }

        if ((int) $id) {
            $this->data['allSectionsNoClass'] = "FALSE";
            $this->data['set'] = $id;
            $this->data['classes'] = $this->classes_m->get_classes();
            $fetchClass = pluck($this->data['classes'], 'classesID', 'classesID');
            if (isset($fetchClass[$id])) {
                $this->data['teachers'] = pluck($this->teacher_m->general_get_teacher(), 'name', 'teacherID');
                $this->data['sections'] = $this->section_m->general_get_order_by_section(array('classesID' => $id));
            } else {
                $this->data['teacher'] = [];
                $this->data['sections'] = [];
            }
            $this->data["subview"] = "section/index";
            $this->load->view('_layout_main', $this->data);
        } else {
            $this->data['allSectionsNoClass'] = "TRUE";
            $this->data['set'] = 0;
            $this->data['classes'] = $this->classes_m->get_classes();
            $this->data['sections'] = $this->section_m->general_get_order_by_section();
            $this->data["subview"] = "section/index";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function active() {
        if (permissionChecker('student_edit')) {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            if ($id != '' && $status != '') {
                if ((int) $id) {
                    $student = $this->section_m->general_get_order_by_section(array('sectionID' => $id));
                    if (count($student)) {
                        if ($status == 'chacked') {
                            $this->section_m->update_section(array('active' => 1), $id);
                            echo 'Success';
                        } elseif ($status == 'unchacked') {
                            $this->section_m->update_section(array('active' => 0), $id);
                            echo 'Success';
                        } else {
                            echo "Error";
                        }
                    } else {
                        echo 'Error';
                    }
                } else {
                    echo "Error";
                }
            } else {
                echo "Error";
            }
        } else {
            echo "Error";
        }
    }

    public function add() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/select2/select2.js'
            )
        );
        $this->data['supervisors'] = $this->user_m->get_user();
        $this->data['supervisorsT'] = $this->teacher_m->general_get_teacher();
        $this->data['classes'] = $this->classes_m->get_classes();
        $this->data['teachers'] = $this->teacher_m->general_get_teacher();
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "section/add";
                $this->load->view('_layout_main', $this->data);
            } else {
                $array = array(
                    "section" => $this->input->post("section"),
                    "capacity" => $this->input->post("capacity"),
                    "classesID" => $this->input->post("classesID"),
                    "teacherID" => $this->input->post("firsTeacherID"),
                    "teacherID_second" => $this->input->post("secondTeacherID"),
                    "teacherID_third" => $this->input->post("thirdTeacherID"),
                    "goalkeeper_coach" => $this->input->post("goalkeeper_coach"),
                    "supervisor" => $this->input->post("supervisor"),
                    "supervisor2" => $this->input->post("supervisor2"),
                    "monthly_fees" => $this->input->post("monthlyFees"),
                    "note" => $this->input->post("note"),
                    "create_date" => date("Y-m-d h:i:s"),
                    "modify_date" => date("Y-m-d h:i:s"),
                    "create_userID" => $this->session->userdata('loginuserID'),
                    "create_username" => $this->session->userdata('username'),
                    "create_usertype" => $this->session->userdata('usertype')
                );
                $array['photo'] = $this->upload_data['file']['file_name'];
                $this->section_m->insert_section($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("section/index/" . $this->input->post('classesID')));
            }
        } else {
            $this->data["subview"] = "section/add";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/select2/select2.js'
            )
        );

        $id = htmlentities(escapeString($this->uri->segment(3)));
        $url = htmlentities(escapeString($this->uri->segment(4)));
        if ((int) $id && (int) $url) {
            $this->data['supervisors'] = $this->user_m->get_user();
            $this->data['supervisorsT'] = $this->teacher_m->general_get_teacher();
            $this->data['teachers'] = $this->teacher_m->general_get_teacher();
            $this->data['classes'] = $this->classes_m->get_classes();
            $this->data['section'] = $this->section_m->general_get_single_section(array('sectionID' => $id, 'classesID' => $url));
            $fetchClass = pluck($this->data['classes'], 'classesID', 'classesID');
            if (isset($fetchClass[$url])) {
                if (count($this->data['section'])) {
                    $this->data['set'] = $url;
                    if ($_POST) {
                        $rules = $this->rules();
                        $this->form_validation->set_rules($rules);
                        if ($this->form_validation->run() == FALSE) {
                            $schoolyearID = $this->session->userdata('defaultschoolyearID');
                            $this->data['students'] = $this->studentrelation_m->get_order_by_student(array('srsectionID' => $id, 'srschoolyearID' => $schoolyearID));
                            $this->data['allStudents'] = $this->studentrelation_m->get_order_by_student(array('srclassesID' => $url, 'srschoolyearID' => $schoolyearID));
                            $this->data['sectionStudentCount'] = $this->data['section']->capacity;
                            $this->data["subview"] = "section/edit";
                            $this->load->view('_layout_main', $this->data);
                        } else {
                            $array = array(
                                "section" => $this->input->post("section"),
                                "capacity" => $this->input->post("capacity"),
                                "classesID" => $this->input->post("classesID"),
                                "teacherID" => $this->input->post("firsTeacherID"),
                                "teacherID_second" => $this->input->post("secondTeacherID"),
                                "teacherID_third" => $this->input->post("thirdTeacherID"),
                                "goalkeeper_coach" => $this->input->post("goalkeeper_coach"),
                                "supervisor" => $this->input->post("supervisor"),
                                "supervisor2" => $this->input->post("supervisor2"),
                                "monthly_fees" => $this->input->post("monthlyFees"),
                                "note" => $this->input->post("note"),
                                "modify_date" => date("Y-m-d h:i:s")
                            );
                            $array['photo'] = $this->upload_data['file']['file_name'];
                            $this->studentrelation_m->update_studentrelation_with_multicondition(array('srsection' => $this->input->post("section")), array('srsectionID' => $id));

                            $this->section_m->update_section($array, $id);
                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                            redirect(base_url("section/index/$url"));
                        }
                    } else {
                        $schoolyearID = $this->session->userdata('defaultschoolyearID');
                        $this->data["subview"] = "section/edit";
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

    public function addStudents() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/datepicker/datepicker.css',
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/datepicker/datepicker.js',
                'assets/select2/select2.js'
            )
        );

        $id = htmlentities(escapeString($this->uri->segment(3)));
        $url = htmlentities(escapeString($this->uri->segment(4)));
        if ((int) $id && (int) $url) {
            $this->data['teachers'] = $this->teacher_m->general_get_teacher();
            $this->data['supervisors'] = $this->user_m->get_user();
            $this->data['supervisorsT'] = $this->teacher_m->general_get_teacher();
            $this->data['classes'] = $this->classes_m->get_classes();
            $this->data['section'] = $this->section_m->general_get_single_section(array('sectionID' => $id, 'classesID' => $url));
            $fetchClass = pluck($this->data['classes'], 'classesID', 'classesID');
            if (isset($fetchClass[$url])) {
                if (count($this->data['section'])) {
                    $this->data['id'] = $id;
                    $this->data['set'] = $url;
                    $schoolyearID = $this->session->userdata('defaultschoolyearID');
                    $this->data['students'] = $this->studentrelation_m->get_order_by_student(array('srsectionID' => $id, 'srschoolyearID' => $schoolyearID));
                    $this->data['allStudents'] = $this->student_m->get_order_by_student();
                    $this->data['sectionStudentCount'] = $this->data['section']->capacity;
                    $this->data["subview"] = "section/playersToSection";
                    $this->load->view('_layout_main', $this->data);
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

    public function sectionAdd() {
        $class = $this->classes_m->get_single_classes(array('classesID' => $this->input->post('classesID')));
        $section = $this->section_m->general_get_single_section(array('sectionID' => $this->input->post('sectionID')));
        $student = $this->student_m->general_get_single_student(array('studentID' => $this->input->post('studentID')));

        $arrayStudentRelation = array(
            'srstudentID' => $student->studentID,
            'srname' => $student->name,
            'srclassesID' => $class->classesID,
            'srclasses' => $class->classesID,
            'srroll' => $student->roll,
            'srregisterNO' => $student->registerNO,
            'srsectionID' => $section->sectionID,
            'srsection' => $section->section,
            'srjoinDate' => $this->input->post('join_date'),
            'srschoolyearID' => $student->schoolyearID
        );

        $this->studentrelation_m->insert_studentrelation($arrayStudentRelation);

        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
        redirect(base_url("section/addStudents/" . $section->sectionID . "/" . $class->classesID));
    }

    public function exportPDF() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/datepicker/datepicker.css',
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/datepicker/datepicker.js',
                'assets/select2/select2.js'
            )
        );

        $id = htmlentities(escapeString($this->uri->segment(3)));
        $url = htmlentities(escapeString($this->uri->segment(4)));
        if ((int) $id && (int) $url) {
            $this->data['teachers'] = $this->teacher_m->general_get_teacher();
            $this->data['supervisors'] = $this->user_m->get_user();
            $this->data['supervisorsT'] = $this->teacher_m->general_get_teacher();
            $this->data['classes'] = $this->classes_m->get_classes();
            $this->data['section'] = $this->section_m->general_get_single_section(array('sectionID' => $id, 'classesID' => $url));
            $fetchClass = pluck($this->data['classes'], 'classesID', 'classesID');
            if (isset($fetchClass[$url])) {
                if (count($this->data['section'])) {
                    $this->data['id'] = $id;
                    $this->data['set'] = $url;
                    $schoolyearID = $this->session->userdata('defaultschoolyearID');
                    $this->data['students'] = $this->studentrelation_m->get_order_by_student(array('srsectionID' => $id, 'srschoolyearID' => $schoolyearID));
                    $this->data['allStudents'] = $this->student_m->get_order_by_student();
                    $this->data['sectionStudentCount'] = $this->data['section']->capacity;
                    $this->data['panel_title'] = 'Section Information';
                    $html = $this->load->view('section/sectionPDF', $this->data, true);
                    $this->load->library('mhtml2pdf');

                    $this->mhtml2pdf->folder('uploads/report/');
                    $this->mhtml2pdf->filename('Section Information');
                    $this->mhtml2pdf->paper('a4', 'portrait');
                    $this->mhtml2pdf->html($html);

                    return $this->mhtml2pdf->create("view", $this->data['panel_title'], null);
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

    public function getInvoices() {
        $studentID = $this->input->post("studentID");
        $groupID = $this->input->post("groupID");
        $invoicesObj = $this->invoice_m->get_invoice_by_studentID($studentID, $groupID);
        $invoices = "<option value disabled selected>SELECT INVOICE</option>";
        foreach ($invoicesObj as $invoice) {
            $invoices .= "<option value='" . $invoice->invoiceID . "'>" . $invoice->feetype . " (" . $invoice->amount . ")</option>";
        }
        echo $invoices;
    }

    public function remove() {
        $studentID = htmlentities(escapeString($this->uri->segment(3)));
        $sectionID = htmlentities(escapeString($this->uri->segment(4)));
        $classID = htmlentities(escapeString($this->uri->segment(5)));
        if ((int) $studentID && (int) $sectionID && (int) $classID) {
            $studentRelation = $this->studentrelation_m->get_single_studentrelation(array('srstudentID' => $studentID, 'srsectionID' => $sectionID, 'srclassesID' => $classID));
            if (count($studentRelation) > 0) {
                $this->studentrelation_m->delete_studentrelation($studentRelation->studentrelationID);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("section/addStudents/" . $sectionID . "/" . $classID));
            } else {
                redirect(base_url("section/index"));
            }
        } else {
            redirect(base_url("section/index"));
        }
    }

    public function delete() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        $url = htmlentities(escapeString($this->uri->segment(4)));
        if ((int) $id && (int) $url) {
            $section = $this->section_m->get_single_section(array('sectionID' => $id));
            $classes = $this->classes_m->get_single_classes(array('classesID' => $url));
            if (count($section) && count($classes)) {
                $this->section_m->delete_section($id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("section/index/$url"));
            } else {
                redirect(base_url("section/index"));
            }
        } else {
            redirect(base_url("section/index"));
        }
    }

    public function valid_number() {
        if ($this->input->post('capacity') < 0) {
            $this->form_validation->set_message("valid_number", "%s is invalid number");
            return FALSE;
        }
        return TRUE;
    }

    public function unique_classes() {
        if ($this->input->post('classesID') == 0) {
            $this->form_validation->set_message("unique_classes", "The %s field is required");
            return FALSE;
        }
        return TRUE;
    }

    public function unique_teacher() {
        if ($this->input->post('teacherID') == 0) {
            $this->form_validation->set_message("unique_teacher", "The %s field is required");
            return FALSE;
        }
        return TRUE;
    }

    public function section_list() {
        $classID = $this->input->post('id');
        if ((int) $classID) {
            $string = base_url("section/index/$classID");
            echo $string;
        } else {
            redirect(base_url("section/index"));
        }
    }

    public function unique_section() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $section = $this->section_m->general_get_order_by_section(array("classesID" => $this->input->post("classesID"), "section" => $this->input->post('section'), "sectionID !=" => $id));
            if (count($section)) {
                $this->form_validation->set_message("unique_section", "%s already exists");
                return FALSE;
            }
            return TRUE;
        } else {
            $section = $this->section_m->general_get_order_by_section(array("classesID" => $this->input->post("classesID"), "section" => $this->input->post('section')));

            if (count($section)) {
                $this->form_validation->set_message("unique_section", "%s already exists");
                return FALSE;
            }
            return TRUE;
        }
    }

}
