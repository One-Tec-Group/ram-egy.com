<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expense_model extends CI_Model
{
  
    function __construct()
    {
        parent::__construct();

    }

    /*

    this function used for add new expense record

    */
    public function addExpanses($expenses)
    {  
        if($this->db->insert("expense",$expenses)){
           return true; 
        }
       else
       {
            return false;
       }
    }
     /*
       this function used for display expense data
    */
    public function expensesData()
    {
       $this->db->where('delete_status','0');   
       $query=$this->db->get('expense');
        return $query->result();    
    }

     /*
       this function used for display expense data where delete_status is 0.
    */
    public  function expUserData()
    {               
        /*$query = $this->db->get('expense');
        $result = $this->db->query('SELECT e.id,a.account_name, a.account_no,
                  e.description,  e.amount, e.date FROM expense AS e
                  INNER JOIN bank_account as a ON a.id = e.account_id 
                  WHERE e.delete_status=0');
             return $result->result(); */
        if($this->session->userdata('type') == "admin"){   
        
            $this->db->select('e.*,b.id as bank_account_id,b.account_name,b.account_no as account_no')
                 ->from('expense e')
                 ->join('bank_account b','b.id=e.account_id')
                 ->where('e.delete_status',0);
            return  $this->db->get()->result();
        } 
        else
        {
            $this->db->select('e.*,b.*')
                 ->from('expense e')
                 ->join('bank_account b','b.id=e.account_id')
                 ->where('e.delete_status',0)
                 ->where('e.user_id',$this->session->userdata('user_id'));
            return  $this->db->get()->result();
        }
        
    } 

     /*

       this function used for get account data 

    */
    public function getAccount()
    {
        if($this->session->userdata('type') == "admin"){   

            $data = $this->db->select('b.*')             
                     ->from('bank_account b')
                     ->join('ledger l','l.id = b.ledger_id')
                     ->where('b.delete_status',0)
                     ->get()
                     ->result();
            // echo $this->db->last_query();
            // exit;                     

            return $data;
        }
        else
        {
            $this->db->select('b.*')             
                     ->from('bank_account b')
                     ->join('ledger l','l.ledger_id = b.ledger_id')
                     ->where('b.delete_status',0);
                return  $this->db->get()->result();
        }
    }

     /*

       this function used for get payment data 

    */
    public function getPayment()
    {
         $query=$this->db->get_where('payment_method',array('delete_status'=>0));
        return $query->result();    
    }

     /*

       this function used for get category data 

    */
    public function getCategory()
    {
        $this->db->where('delete_status',0);
        $query=$this->db->get('expense_category');
        return $query->result();    
    }

     /*

       this function used for get last insert id  

    */
    public function getLastID()
    {
       $sql1="SELECT id FROM  `expense` ORDER BY `id` DESC LIMIT 1";
       $query=$this->db->query($sql1);
       if( $query->num_rows() > 0 )
       {
           return $query->row()->id;      
       } 
       return FALSE;
    }  

     /*
       this function used for fetch data 
    */
    public  function getContents() 
    {
        $this->db->select('*');
        $this->db->from('expense');
        $query = $this->db->get();
        return $result = $query->result();
        $this->load->view('edit_content', $result);
    }

    /*
     this function used for fetch data at update time
    */
    public  function getData($id) 
    {
        $this->db->select('*');
        $this->db->from('expense');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
            
    }

    /*
       this function used for delete expense data 
    */
    public function delete($del)
    {
        $sql="UPDATE expense set delete_status = ? , delete_date = ? WHERE id = ? ";
        if($this->db->query($sql,$del))
        {
           
            return true;
        }
        return FALSE;
    }

    /*

    this function used for update expense details

    */
    public function editExpanses($expenses)
    {
       
        $sql="UPDATE `expense` SET 
            `account_id`= ? ,
            `date`= ? ,
            `description`= ? ,
            `amount`= ? ,
            `category_id`= ? ,
            `payment_method_id`= ? ,
            `reference_no`= ? 
            
            WHERE id = ? ";

        if($this->db->query($sql,$expenses))
        {
            return true;
        }
        return FALSE;
    }

}
