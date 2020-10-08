<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller 
{

    public function __construct()
    {
    	parent::__construct();
    	$this->load->library(array('form_validation','ion_auth'));
        $this->load->model('expense_model');    
    	$this->load->model('receipt_model');	
    }


	/*
        this function used for display expense list and Expense data form
    */
	public function index()
	{	
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }
		$data['data'] = $this->expense_model->expUserData();
        /*echo "<pre>";
        print_r($data);
        exit();*/
		$this->load->view('expenses/list',$data);
	}


	/*
        this function used for display expense add form
    */
	public function addExpanses(){
		$data['ledger']=$this->expense_model->getLedger();
		$data['category']=$this->expense_model->getCategory();
		$data['payment']=$this->expense_model->getPayment();
		$data['referense']=$this->expense_model->getLastID();
		$this->load->view('expenses/add',$data);	
	}


   
    /*

    this function used for add new expense record

    */
	public function add()
	{
		//$this->form_validation->set_rules('desc', 'Enter desc', 'required');
		$this->form_validation->set_rules('amount', ' Enter Amount ', 'required');
		
		if ($this->form_validation->run() == true)
		 {
		      $data = array(
                    'date'              => $this->input->post('date'),
                    'description'       => $this->input->post('desc'),
                    'amount'            => $this->input->post('amount'),
                    'payment_method_id' => $this->input->post('units'),
                    'reference_no'      => $this->input->post('reference'),
                    "user_id"           => $this->session->userdata('user_id')
                   );
              $transaction_data = array(
                    'invoice_id'        => null,
                    'from_account'           => $this->input->post('from_ac'),
                    'to_account'             => $this->input->post('to_ac'),
                    "transaction_date"  => date('Y-m-d'),
                    "type"              => 'E',
                    'amount'            => $this->input->post('amount')
                   );
              /*echo $this->db->insert('transaction_header',$transaction_data);
                echo "<pre>";
                print_r($transaction_data);
                exit();*/
                if($this->expense_model->addExpanses($data) && $this->receipt_model->addReceipt($transaction_data))
                {
                    redirect('expense','refresh');
                }   
                else{
                    redirect('expense','refresh');
                }


        }
		else
		{  
			$this->addExpanses();
		}
     }
	 /*
         this function used for fetch data at update expense details
     */
    public function edit_data($id)
    {  
        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        $data['account']=$this->expense_model->getAccount();
		$data['category']=$this->expense_model->getCategory();
		$data['payment']=$this->expense_model->getPayment();
		$data['data'] = $this->expense_model->getData($id);
       /* echo "<pre>";
        print_r($data);
        exit();*/
		$data['referense_no']=$this->expense_model->getLastID();

		 $this->load->view('expenses/edit',$data);
    }

     /*

        this function used for delete expense data

      */
    public function delete($id)
    {

        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

		$del=array(
				'delete_status'   => 1,
				'delete_date'     => date('Y-m-d'),
				'id'              => $id
				);
			
		if($this->expense_model->delete($del))
        {
			$this->session->set_flashdata('success', 'Expense Deleted successfully.');
            redirect("expense",'refresh');
	    }
	}

	 /*
          this function used for update expense details

     */
   	public function edit()
    {

        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

    	$id=$this->input->post('id');

		//$this->form_validation->set_rules('acount', 'Select Acount name ','required');
		//$this->form_validation->set_rules('date', 'date ', 'required');
		$this->form_validation->set_rules('desc', 'Enter Description', 'required');
		$this->form_validation->set_rules('amount', 'Enter  Amount ', 'required');
		//$this->form_validation->set_rules('category', 'Select category Name ', 'required');
		//$this->form_validation->set_rules('reference', 'Name ', 'required');
		
		if ($this->form_validation->run() == true)
		 {
		
		 	 $expenses = array(
                
                    'account_id'        =>$this->input->post('acount'),
                    'date'              => $this->input->post('date'),
                    'description'       => $this->input->post('desc'),
                    'amount'            => $this->input->post('amount'),
                    'category_id'       => $this->input->post('category'),
                    'payment_method_id' => $this->input->post('units'),
                    'reference_no'      => $this->input->post('reference'),
                    'id'=>$id
                    );
		 	
            $expenses['id']=$id;

        }

        if (($this->form_validation->run() == true) && $this->expense_model->editExpanses($expenses))
        {
            $this->session->set_flashdata('success', 'Expense edit successfully.');
            redirect("expense",'refresh');
        }
		else
		{  
			$this->edit_data($id);
		}

    }
		
}
