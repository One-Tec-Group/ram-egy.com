<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


  class Payment_method_model extends CI_Model
  {
      protected $table = 'billing';
      function __construct()
      {
        parent::__construct();

      }
        /*

         this function used for add payment_method data 

       */         
        public function addPayment($payment)
        {

            $sql="INSERT INTO `payment_method`(`name`, `default`) VALUES (?, ?)";

            if($this->db->query($sql,$payment)){
                    return true; 
            }
            else
            {
                return false;
            }
        }

         /*

           this function used for display payment_method data 

        */
         public function paymenttermsData()
         {
               $this->db->where('delete_status','0');
               $query=$this->db->get('payment_method');
                return $query->result();      
         }

        /*

         this function used for display payment_method data where delete_status is 0.

       */
        public  function payUserData()
        {
            $this->db->where('delete_status','0');                  
            $data = $this->db->get('payment_method');
            return $data->result();
        } 

        /*

         this function used for fetch payment_method 

        */
         public  function getContents() 
         {
            $this->db->select('*');
            $this->db->from('payment_method');
            $query = $this->db->get();
            return $result = $query->result();
            //$this->load->view('edit_content', $result);
         }

         /*

            this function used for fetch payment_method at update time

         */
         public  function getData($id) 
         {
            $this->db->select('*');
            $this->db->from('payment_method');
            $this->db->where('id',$id);
            $query = $this->db->get();
            return $query->row();
         }

        /*

            this function used for delete payment_method data

        */
        public function delete($del)
        {
            $sql="UPDATE payment_method set delete_status = ? , delete_date = ? WHERE id = ? ";
            if($this->db->query($sql,$del)) 
            {
                return true;
            }
            return FALSE;
        }

        /*

            this function used for edit payment_method data

         */
        public function editPayment($payment)
        {
            $sql="UPDATE `payment_method` SET 
            `name`= ?,
            `default`= ?
              WHERE id = ?";

            if($this->db->query($sql,$payment))
            {
                return true;
                
            }
                return false;
        }
}