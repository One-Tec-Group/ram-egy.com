<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Permission_model extends CI_Model{
    
    function __construct()
    {
        parent::__construct();
    }

    function getGroup()
    {   
        $this->db->where('delete_status',0);
    	$query = $this->db->get('groups');
    	return $query->result();
    }

    function isAdmin($id)
    {
        $sql1="SELECT name FROM  `groups` WHERE id=".$id;
        $query=$this->db->query($sql1);
        if( $query->num_rows() > 0 )
        {
            return $query->row()->name;
        } 
        return FALSE;
    }


    function getPermission()
    {	
    	$query = $this->db->get('permissions');
    	return $query->result();
    }

    function addRole($data)
    {
    	$query="INSERT INTO `groups`(`name`, `description`) VALUES (?,?)";

    	if($this->db->query($query,$data))
    	{
    		return $this->db->insert_id();
    	}
    }

    public function addPermissionRole($permission)
    {
        $this->db->insert_batch('permission_role', $permission);
    }

    public function getRole($id)
    {
        $this->db->select('g.id as group_id,g.name as group_name,g.description as g_description,pr.permission_id,p.name as permission_name');
        $this->db->from('groups g');
        $this->db->join('permission_role pr','g.id = pr.role_id');
        $this->db->join('permissions p','p.id = pr.permission_id');
        $this->db->where('g.id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getRoles($id)
    {
    	$this->db->select('g.id as group_id,g.name as group_name,g.description as g_description,pr.permission_id,p.name as permission_name');
    	$this->db->from('groups g');
    	$this->db->join('permission_role pr','g.id = pr.role_id');
    	$this->db->join('permissions p','p.id = pr.permission_id');
    	$this->db->where('g.id',$id);
    	$query = $this->db->get();
    	return $query->result();
    }

    public function getPermissionRole($id)
    {
    	$this->db->where('role_id',$id);
    	$query = $this->db->get('permission_role');
    	return $query->result();

    }

    function updateRole($data)
    {
    	$query="UPDATE `groups` SET `name`= ?,`description`=? WHERE id = ?";
    	if($this->db->query($query,$data))
    	{
    		return true;
    	}
    	return false;
    }

    function deletePermissionRole($id)
    {
    	$query="DELETE FROM `permission_role` WHERE role_id = ?";
    	if ($this->db->query($query,$id)) {
    		return true;
    	}
    	return false;
    }

    public function deleteRoles($data)
    {
        $sql="UPDATE groups SET delete_status= ? , delete_date = ? WHERE id =?";
        if($this->db->query($sql,$data)) {
            return true;
        }
        return FALSE;
    }    

}