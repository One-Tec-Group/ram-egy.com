<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Classes extends Admin_Controller {
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
        $this->load->model("teacher_m");
        $this->load->model("user_m");
        $this->load->model('studentrelation_m');
        $language = $this->session->userdata('lang');
        $this->lang->load('classes', $language);
    }

    protected function rules() {
        $rules = array(
            array(
                'field' => 'classes',
                'label' => $this->lang->line("classes_name"),
                'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_classes'
            ),
            array(
                'field' => 'classes_numeric',
                'label' => $this->lang->line("classes_numeric"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_classes_numeric|callback_unique_valid_number'
            ),
            array(
                'field' => 'teacherID',
                'label' => $this->lang->line("teacher_name"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_teacher'
            ),
            array(
                'field' => 'first_supervisor',
                'label' => $this->lang->line("class_supervisor1"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean'
            ),
            array(
                'field' => 'second_supervisor',
                'label' => $this->lang->line("class_supervisor2"),
                'rules' => 'trim|required|numeric|max_length[11]|xss_clean'
            ),
            array(
                'field' => 'note',
                'label' => $this->lang->line("classes_note"),
                'rules' => 'trim|max_length[200]'
            ),
            array(
                'field' => 'photo',
                'label' => $this->lang->line("class_photo"),
                'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
            ),
        );
        return $rules;
    }

    public function index() {
        $this->data['teachers'] = pluck($this->teacher_m->get_teacher(), 'name', 'teacherID');
        $this->data['classes'] = $this->classes_m->get_classes();
        $this->data["subview"] = "classes/index";
        $this->load->view('_layout_main', $this->data);
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

        $this->data['teachers'] = $this->teacher_m->get_teacher();
        $this->data['supervisors'] = $this->user_m->get_user();
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "classes/add";
                $this->load->view('_layout_main', $this->data);
            } else {
                $array = array(
                    "classes" => $this->input->post("classes"),
                    "classes_numeric" => $this->input->post("classes_numeric"),
                    "teacherID" => $this->input->post("teacherID"),
                    "first_supervisor" => $this->input->post("first_supervisor"),
                    "second_supervisor" => $this->input->post("second_supervisor"),
                    "studentmaxID" => 999999999,
                    "note" => $this->input->post("note"),
                    "create_date" => date("Y-m-d h:i:s"),
                    "modify_date" => date("Y-m-d h:i:s"),
                    "create_userID" => $this->session->userdata('loginuserID'),
                    "create_username" => $this->session->userdata('username'),
                    "create_usertype" => $this->session->userdata('usertype')
                );

                $array['photo'] = $this->upload_data['file']['file_name'];
                
                $this->classes_m->insert_classes($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("classes/index"));
            }
        } else {
            $this->data["subview"] = "classes/add";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function photoupload() {
        $new_file = "default.png";
        if ($_FILES["photo"]['name'] != "") {
            $file_name = $_FILES["photo"]['name'];
            $random = random19();
            $makeRandom = hash('sha512', $random . $this->input->post('classes') . config_item("encryption_key"));
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
        if ((int) $id) {
            $this->data['teachers'] = $this->teacher_m->get_teacher();
            $this->data['supervisors'] = $this->user_m->get_user();
            $this->data['classes'] = $this->classes_m->get_single_classes(array('classesID' => $id));
            if (count($this->data['classes'])) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "classes/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else {
                        $array = array(
                            "classes" => $this->input->post("classes"),
                            "classes_numeric" => $this->input->post("classes_numeric"),
                            "teacherID" => $this->input->post("teacherID"),
                            "first_supervisor" => $this->input->post("first_supervisor"),
                            "second_supervisor" => $this->input->post("second_supervisor"),
                            "studentmaxID" => 999999999,
                            "note" => $this->input->post("note"),
                            "modify_date" => date("Y-m-d h:i:s")
                        );
                        $array['photo'] = $this->upload_data['file']['file_name'];

                        $this->studentrelation_m->update_studentrelation_with_multicondition(array('srclasses' => $this->input->post("classes")), array('srclassesID' => $id));

                        $this->classes_m->update_classes($array, $id);
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("classes/index"));
                    }
                } else {
                    $this->data["subview"] = "classes/edit";
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
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $classes = $this->classes_m->get_single_classes(array('classesID' => $id));
            if (count($classes)) {
                $this->classes_m->delete_classes($id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("classes/index"));
            } else {
                redirect(base_url("classes/index"));
            }
        } else {
            redirect(base_url("classes/index"));
        }
    }

    public function unique_classes() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $classes = $this->classes_m->get_order_by_classes(array("classes" => $this->input->post("classes"), "classesID !=" => $id));
            if (count($classes)) {
                $this->form_validation->set_message("unique_classes", "%s already exists");
                return FALSE;
            }
            return TRUE;
        } else {
            $classes = $this->classes_m->get_order_by_classes(array("classes" => $this->input->post("classes")));
            if (count($classes)) {
                $this->form_validation->set_message("unique_classes", "%s already exists");
                return FALSE;
            }
            return TRUE;
        }
    }

    public function unique_classes_numeric() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $classes_numeric = $this->classes_m->get_order_by_classes(array("classes_numeric" => $this->input->post("classes_numeric"), "classesID !=" => $id));
            if (count($classes_numeric)) {
                $this->form_validation->set_message("unique_classes_numeric", "%s already exists");
                return FALSE;
            }
            return TRUE;
        } else {
            $classes_numeric = $this->classes_m->get_order_by_classes(array("classes_numeric" => $this->input->post("classes_numeric")));
            if (count($classes_numeric)) {
                $this->form_validation->set_message("unique_classes_numeric", "%s already exists");
                return FALSE;
            }
            return TRUE;
        }
    }

    public function unique_teacher() {
        if ($this->input->post('teacherID') == 0) {
            $this->form_validation->set_message("unique_teacher", "The %s field is required");
            return FALSE;
        }
        return TRUE;
    }

    public function unique_valid_number() {
        if ($this->input->post('classes_numeric') < 0) {
            $this->form_validation->set_message("unique_valid_number", "%s is invalid number");
            return FALSE;
        }
        return TRUE;
    }

}
