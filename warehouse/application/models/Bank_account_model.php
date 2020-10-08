<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bank_account_model extends CI_Model
{
    /*
        Get All Bank account Data
    */
    public function getBankAccount()
    {
    	return $this->db->get_where('bank_account',array('delete_status'=>0))->result();
    }


    /*
        Add Bank Account Data 
    */
    public function addModel($data)
    {
    	if($this->db->insert('bank_account',$data)){
        return $this->db->insert_id();
      }
      return false;
    }
   
   /*
        Delete Bank Account Data 
    */
	 public function delete($id)
	 {
      $this->db->where('id',$id);
      return $this->db->update('bank_account',array('delete_status'=>1));
	 }

   /*
        Update Bank Account Data 
    */
	 public function editBankAccount($id,$data)
	 {
      $this->db->where('id',$id);
  		return $this->db->update('bank_account',$data);
	 }

   /*
     Get Bank Account Data for Update 
  */
	public function getRecord($id)
	{
		return $this->db->get_where('bank_account',array('id'=>$id))->row();
	}
}
