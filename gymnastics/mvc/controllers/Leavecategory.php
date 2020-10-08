<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leavecategory extends Admin_Controller {
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
        $this->load->model("leavecategory_m");
        $language = $this->session->userdata('lang');
        $this->lang->load('leavecategory', $language);
    }

    public function index() {
        $this->data['leave_categories'] = $this->leavecategory_m->get_leavecategory();
        $this->data["subview"] = "leavecategory/index";
        $this->load->view('_layout_main', $this->data);
    }

    protected function rules() {
        $rules = array(
            array(
                'field' => 'leavecategory',
                'label' => $this->lang->line("leavecategory_category"),
                'rules' => 'trim|required|xss_clean|max_length[255]|callback_unique_category'
            ),
            array(
                'field' => 'leavegender',
                'label' => $this->lang->line("leavecategory_gender"),
                'rules' => 'trim|required|xss_clean|callback_unique_data'
            ),
        );
        return $rules;
    }

    public function unique_data($data) {
        if($data != "") {
            if($data == "0") {
                $this->form_validation->set_message('unique_data', 'The %s field is required.');
                return FALSE;
            }
            return TRUE;
        } 
        return TRUE;
    }

    public function unique_category($leavecategory) {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if((int)$id) {
            $leavecategory = $this->leavecategory_m->get_order_by_leavecategory(array('leavecategory'=>$leavecategory,'leavecategoryID !='=>$id));
            if(count($leavecategory)) {
                $this->form_validation->set_message('unique_category','The %s field value already exits.');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $leavecategory = $this->leavecategory_m->get_order_by_leavecategory(array('leavecategory'=>$leavecategory));
            if(count($leavecategory)) {
                $this->form_validation->set_message('unique_category','The %s field value already exits.');
                return FALSE;
            } else {
                return TRUE;
            }
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
        if($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "leavecategory/add";
                $this->load->view('_layout_main', $this->data);
            } else {
                $array = array(
                    "leavecategory" => $this->input->post("leavecategory"),
                    "leavegender" => $this->input->post("leavegender"),
                    "create_date" => date("Y-m-d H:i:s"),
                    "modify_date" => date("Y-m-d H:i:s"),
                    "create_userID" => $this->session->userdata('loginuserID'),
                    "create_usertypeID" => $this->session->userdata('usertypeID')
                );


                $this->leavecategory_m->insert_leavecategory($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("leavecategory/index"));
            }
        } else {
            $this->data["subview"] = "leavecategory/add";
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
        if((int)$id) {
            $this->data['leavecategory'] = $this->leavecategory_m->get_single_leavecategory(array('leavecategoryID' => $id));
            if($this->data['leavecategory']) {
                if($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "leavecategory/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else {
                        $array = array(
                            "leavecategory" => $this->input->post("leavecategory"),
                            "leavegender" => $this->input->post("leavegender"),
                            "modify_date" => date("Y-m-d H:i:s")
                        );

                        $this->leavecategory_m->update_leavecategory($array, $id);
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("leavecategory/index"));
                    }
                } else {
                    $this->data["subview"] = "leavecategory/edit";
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
        if((int)$id) {
            $this->data['leavecategory'] = $this->leavecategory_m->get_single_leavecategory(array('leavecategoryID' => $id));
            if(count($this->data['leavecategory'])) {
                $this->leavecategory_m->delete_leavecategory($id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("leavecategory/index"));
            } else {
                redirect(base_url("leavecategory/index"));
            }
        } else {
            redirect(base_url("leavecategory/index"));
        }
    }

}
