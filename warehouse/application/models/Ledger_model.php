<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ledger_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        
    }
    public function index(){
        
    } 
    /* 
        return all discount details to display list  
    */
    public function getLedger(){

        return $this->db->select('l.*,a.group_title')
                 ->from('ledger l')
                 ->join('account_group a','a.id=l.accountgroup_id')
                 ->get()
                 ->result();
    }

    public function getBranch()
    {
        $this->db->select('branch_id,branch_name');
        $branch = $this->db->get('branch');
        return $array = $branch->result_array();
    }
    
    public function getAccountGroup()
    {
        $this->db->select('id,group_title');
        $acc_group = $this->db->get('account_group');
        return $array = $acc_group->result_array();
    }
    
    public function addModel($data){
        $sql = "insert into discount (discount_name,discount_value,user_id) values(?,?,?)";
        if($this->db->query($sql,$data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function getRecord($id){
        $sql = "select * from discount where discount_id = ?";
        if($query = $this->db->query($sql,array($id))){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
    
    public function editModel($data,$id){
        $sql = "update discount set discount_name = ?,discount_value = ? where discount_id = ?";
        if($this->db->query($sql,array($data['discount_name'],$data['discount_value'],$id))){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function deleteModel($id){
        $sql = "delete from discount where discount_id = ?";
        if($this->db->query($sql,array($id))){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function addLedger($data)
    {
        $this->db->insert('ledger', $data);
        return $this->db->insert_id();
    }
    
    public function getledgerWithJoin($id)
    {
        $this->db->select('L.*,B.branch_name,A.group_title');
        $this->db->from('ledger AS L');// I use aliasing make joins easier
        $this->db->join('branch AS B', 'B.id = L.branch_id', 'INNER');
        $this->db->join('account_group AS A', 'A.id = L.accountgroup_id', 'INNER');
        $this->db->where('L.id',$id);
        $q = $this->db->get();
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function getledgerById($id)
    {
        $q = $this->db->get_where('ledger', array('id' => $id), 1); 
        if( $q->num_rows() > 0 )
        {
            return $q->row();
        } 
    
        return FALSE;
    }
    
    public function updateLedger($ledgerDetail,$id)
    {
        $ledgerData = array(
            'branch_id'   =>  $ledgerDetail['branch_id'],
            'type'        =>  $ledgerDetail['type'],
            'title'                   =>  $ledgerDetail['title'],
            'accountgroup_id'   =>  $ledgerDetail['accountgroup_id'],
            'opening_balance'          =>  $ledgerDetail['opening_balance'],
            'closing_balance'          =>  $ledgerDetail['closing_balance'],
        );
        
        $this->db->where('id', $id);
        if($this->db->update('ledger', $ledgerData)) {
                return true;
        }
        return false;
    }

    public function getBillerLedgerDetail($ledger_id){
        $user = $this->db->get_where('biller', array('ledger_id' => $ledger_id))->row(); 
        if(is_null($user)){
            return false;
        }else{
            return $user->biller_id;
        }
    }

    public function getCustomerLedgerDetails($ledger_id){
        $user = $this->db->get_where('customer', array('ledger_id' => $ledger_id))->row();
        if(is_null($user)){
            return false;
        }else{
            return $user->customer_id;
        }
    }

    public function getBankLedgerDetails($ledger_id){
        $user = $this->db->get_where('bank_account', array('ledger_id' => $ledger_id))->row();
        if(is_null($user)){
            return false;
        }else{
            return true;
        }
    }

    public function getSuppliersLedgerDetails($ledger_id){
        $user = $this->db->get_where('suppliers', array('ledger_id' => $ledger_id))->row();
        if(is_null($user)){
            return false;
        }else{
            return true;
        }
    }

    public function getPurchaserLedgerDetails($ledger_id){
        $user = $this->db->get_where('users', array('ledger_id' => $ledger_id))->row();
        if(is_null($user)){
            return false;
        }else{
            return $user->id;
        }
    }



    public function deleteLedger($id)
    {
        if($this->db->delete('ledger', array('id' => $id))) {
            return true;
        }
            
        return FALSE;
    }
}
?>