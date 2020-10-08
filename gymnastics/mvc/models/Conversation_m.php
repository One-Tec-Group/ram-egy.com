<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class conversation_m extends MY_Model {

	protected $_table_name = 'conversation_message_info';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = "id ASC";

	function __construct() {
		parent::__construct();
	}

	function get_conversation($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}

	public function get_my_conversations() {
		$userID = $this->session->userdata("loginuserID");
		$usertypeID = $this->session->userdata("usertypeID");
		$this->db->distinct();
		$this->db->select('*');
        $this->db->from('conversation_user'); 
        $this->db->join('conversation_message_info', 'conversation_user.conversation_id=conversation_message_info.id', 'left');
        $this->db->join('conversation_msg', 'conversation_user.conversation_id=conversation_msg.conversation_id', 'left');
        $this->db->where('conversation_user.user_id',$userID);
        $this->db->where('conversation_user.usertypeID',$usertypeID);
        $this->db->where('conversation_user.trash',0);
        $this->db->where('conversation_msg.start',1);
        $this->db->where('conversation_message_info.draft',0);
        $this->db->order_by('conversation_message_info.id','desc');
        $this->db->group_by('conversation_message_info.id');
        $query = $this->db->get(); 
        if($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
	}

	public function get_my_conversations_draft() {
		$userID = $this->session->userdata("loginuserID");
		$usertypeID = $this->session->userdata("usertypeID");
		$this->db->select('*');
        $this->db->from('conversation_user'); 
        $this->db->join('conversation_message_info', 'conversation_user.conversation_id=conversation_message_info.id', 'left');
        $this->db->join('conversation_msg', 'conversation_user.conversation_id=conversation_msg.conversation_id', 'left');
        $this->db->where('conversation_user.user_id',$userID);
        $this->db->where('conversation_user.usertypeID',$usertypeID);
        $this->db->where('conversation_user.trash',0);
        $this->db->where('conversation_user.is_sender',1);
        $this->db->where('conversation_msg.start',1);
        $this->db->where('conversation_message_info.draft',1);
        $this->db->order_by('conversation_message_info.id','desc');
        $query = $this->db->get(); 
        if($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
	}

	public function get_my_conversations_sent() {
		$userID = $this->session->userdata("loginuserID");
		$usertypeID = $this->session->userdata("usertypeID");
		$this->db->select('*');
        $this->db->from('conversation_user'); 
        $this->db->join('conversation_message_info', 'conversation_user.conversation_id=conversation_message_info.id', 'left');
        $this->db->join('conversation_msg', 'conversation_user.conversation_id=conversation_msg.conversation_id', 'left');
        $this->db->where('conversation_user.user_id',$userID);
        $this->db->where('conversation_user.usertypeID',$usertypeID);
        $this->db->where('conversation_user.trash',0);
        $this->db->where('conversation_user.is_sender',1);
        $this->db->where('conversation_msg.start',1);
        $this->db->where('conversation_message_info.draft',0);
        $this->db->order_by('conversation_message_info.id','desc');
        $query = $this->db->get(); 
        if($query->num_rows() != 0) {
            return $query->result_array();
        } else {
            return false;
        }
	}

	public function get_my_conversations_trash() {
		$userID = $this->session->userdata("loginuserID");
		$usertypeID = $this->session->userdata("usertypeID");
		$this->db->select('*');
        $this->db->from('conversation_user'); 
        $this->db->join('conversation_message_info', 'conversation_user.conversation_id=conversation_message_info.id', 'left');
        $this->db->join('conversation_msg', 'conversation_user.conversation_id=conversation_msg.conversation_id', 'left');
        $this->db->where('conversation_user.user_id',$userID);
        $this->db->where('conversation_user.usertypeID',$usertypeID);
        $this->db->where('conversation_user.trash',1);
        $this->db->where('conversation_msg.start',1);
        $this->db->where('conversation_message_info.draft',0);
        $this->db->order_by('conversation_message_info.id','desc');
        $query = $this->db->get(); 
        if($query->num_rows() != 0) {
            return $query->result_array();
        }
        else {
            return false;
        }
	}

	public function get_conversation_msg_by_id($id=null) {
		$this->db->order_by("msg_id", "asc");
		$query = $this->db->get_where('conversation_msg', array('conversation_id' => $id));
		return $query->result();
	}

	public function get_student_by_class($studentID) {
		$query = $this->db->get_where('student', array('studentID' => $studentID));
		return $query->result();	
	}

	function get_recivers($single=FALSE, $array=NULL) {
		if ($array) {
			$query = $this->db->get_where($single, $array);
		} else {
			$query = $this->db->get($single);
		}
		return $query->result();
	}

	function get_order_by_conversation($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}

	function insert_conversation($array) {
		$insetID = parent::insert($array);
		return $insetID;
	}
	function insert_conversation_user($array) {
		$this->db->insert("conversation_user", $array);
		return true;
	}
	function insert_conversation_msg($array) {
		$this->db->insert("conversation_msg", $array);
		return true;
	}

	function update_conversation($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_conversation($id){
		parent::delete($id);
	}
	
	public function user_Check($conv_id, $user_id, $usertypeID) {
		$query = $this->db->get_where('conversation_user', array('conversation_id' => $conv_id, 'user_id' => $user_id, 'usertypeID' => $usertypeID));
		return $query->row();
	}

	public function trash_conversation($data, $id) {
		$usertypeID = $this->session->userdata("usertypeID");
		$username = $this->session->userdata("username");
		$userID = $this->session->userdata("loginuserID");
		$query = $this->db->get_where('conversation_user', array('conversation_id' => $id, 'user_id' => $userID, 'usertypeID' => $usertypeID));
		if (count($query->row())==1) {
			$this->db->where('conversation_id', $id);
			$this->db->where('user_id', $userID);
			$this->db->where('usertypeID', $usertypeID);
			$this->db->update('conversation_user', $data); 
			return true;
		} else {
			return false;
		}
	}

	function get_usertype_by_permission() {
		$this->db->select('*');
		$this->db->from('permission_relationships');
		$this->db->join('permissions', 'permissions.permissionID = permission_relationships.permission_id', 'LEFT');
		$this->db->join('usertype', 'usertype.usertypeID = permission_relationships.usertype_id', 'LEFT');
		$this->db->where(array('permissions.name' => 'conversation'));
		$query = $this->db->get();
		return $query->result();
	}
}

/* End of file conversation_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/conversation_m.php */
