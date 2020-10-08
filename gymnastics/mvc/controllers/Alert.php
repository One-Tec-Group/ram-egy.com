<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alert extends Admin_Controller {
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
        $this->load->model("alert_m");
        $language = $this->session->userdata('lang');
        $this->lang->load('alert', $language);
    }

    public function index() { 
        $type = htmlentities(escapeString($this->uri->segment(3)));
        $id = htmlentities(escapeString($this->uri->segment(4)));
        if($type && (int)$id) {
            
            if($type == 'mark') {
                if(htmlentities(escapeString($this->uri->segment(6)))) {
                    $id = htmlentities(escapeString($this->uri->segment(6)));
                } else {
                    $id = 0;
                }
            }
            
            $alert = $this->alert_m->get_single_alert(array('itemID' => $id, "userID" => $this->session->userdata("loginuserID"), 'usertypeID' => $this->session->userdata('usertypeID'), 'itemname' => $type));

            if(!count($alert)) {
                $this->alert_m->insert_alert(array('itemID' => $id, "userID" => $this->session->userdata("loginuserID"), 'usertypeID' => $this->session->userdata('usertypeID'), 'itemname' => $type));
            }
            
            if($type == 'notice') {
                if(permissionChecker('notice_view')) {
                    redirect(base_url('notice/view/'.$id));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('alert_notice_permission'));
                    redirect(base_url('dashboard'));
                }
            } elseif($type == 'mark') {
                $classesID = htmlentities(escapeString($this->uri->segment(5)));
                if(permissionChecker('mark') && permissionChecker('mark_view')) {
                    redirect(base_url('mark/view/'.htmlentities(escapeString($this->uri->segment(4))).'/'.$classesID));
                } elseif(permissionChecker('mark')) {
                    redirect(base_url('mark'));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('alert_mark_permission'));
                    redirect(base_url('dashboard'));
                }
            } elseif($type == 'message') {
                $allMessageAlert = pluck($this->alert_m->get_order_by_alert(array("userID" => $this->session->userdata("loginuserID"), 'usertypeID' => $this->session->userdata('usertypeID'), 'itemname' => $type)), 'itemname', 'itemID');

                $allMessage = $this->conversation_m->get_conversation_msg_by_id($id);
                if(count($allMessage)) {
                    foreach ($allMessage as $allMessageValue) {
                        if(!isset($allMessageAlert[$allMessageValue->msg_id])) {
                            $this->alert_m->insert_alert(array('itemID' => $allMessageValue->msg_id, "userID" => $this->session->userdata("loginuserID"), 'usertypeID' => $this->session->userdata('usertypeID'), 'itemname' => $type));
                        }
                    }
                }

                if(permissionChecker('conversation')) {
                    redirect(base_url('conversation/view/'.$id));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('alert_message_permission'));
                    redirect(base_url('dashboard'));
                }
            } elseif($type == 'event') {
                if(permissionChecker('event_view')) {
                    redirect(base_url('event/view/'.$id));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('alert_event_permission'));
                    redirect(base_url('dashboard'));
                }
            } elseif($type == 'holiday') {
                if(permissionChecker('holiday_view')) {
                    redirect(base_url('holiday/view/'.$id));
                } else {
                    $this->session->set_flashdata('error', $this->lang->line('alert_holiday_permission'));
                    redirect(base_url('dashboard'));
                }
            }
        }
    }

}