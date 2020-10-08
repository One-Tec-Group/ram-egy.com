<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


   class Income_expense_category_model extends CI_Model
   {
    
   
   function __construct()
   {
      parent::__construct();

   }

   public function addCategory($category)
   {
      
        $sql=" INSERT INTO `expense_category`(`name`, `type`) VALUES (?, ?)";

        if($this->db->query($sql,$category))
        {
                return true; 
        }
        else
        {
            return false;
        }
    }

    public function categoryData()
    {
        $query=$this->db->get('expense_category');
        return $query->result();    
    }

     public  function payUserData()
     {
         $this->db->where('delete_status','0');                  
         $data = $this->db->get('expense_category');
    	 return $data->result();
     }

  	 public  function getContents() 
     {
        $this->db->select('*');
        $this->db->from('expense_category');
        $query = $this->db->get();
        return $result = $query->result();
        $this->load->view('edit_content', $result);
     }

 	 public  function getData($id) 
     {
        $this->db->select('*');
        $this->db->from('expense_category');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
                
     }

     public function delete($del)
     {
        $sql="UPDATE expense_category set delete_status = ? , delete_date = ? WHERE id = ? ";
        if($this->db->query($sql,$del)) {
           
            return true;
        }
        return FALSE;
     }

     public function editCategory($category)
     {
    
      
        $sql="UPDATE `expense_category` SET 
        `name`= ?,
        `type`= ?
       
          WHERE id = ?";

        if($this->db->query($sql,$category)){
            return true;
            
        }
       
       return false;

     }
 }

