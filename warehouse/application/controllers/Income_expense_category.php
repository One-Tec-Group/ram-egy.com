<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Income_expense_category extends CI_Controller {

  	public function __construct()
  	{
  		parent::__construct();
  		$this->load->library(array('form_validation','ion_auth'));
  		$this->load->model('income_expense_category_model');
      if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
  	}

  	public function index()
  	{
      
  		$data['data'] = $this->income_expense_category_model->categoryData();
      $data['data'] = $this->income_expense_category_model->payUserData();
  		$this->load->view('income_expense_category/list',$data);
  	}

    /*

    this function used for expense_category form

    */
  	public function add_expensecategory()
  	{
      
  		$this->load->view('income_expense_category/add');	
  	}

    /*

    this function used for add new expense data

    */
	  public function add()
    {
        if (!$this->ion_auth->logged_in())
        {
          // redirect them to the login page
          redirect('auth/login', 'refresh');
        }
         $this->form_validation->set_rules('name', 'Name ', 'required');
         $this->form_validation->set_rules('type', 'type ', 'required');
        
        if ($this->form_validation->run() == true)
        {

            $category = array(
                
                    'name'        =>  $this->input->post('name'),
                    'type'        =>  $this->input->post('type')
                          
            );
        }
       
        if ( ($this->form_validation->run() == true) && $this->income_expense_category_model->addCategory($category))
        {
           redirect('income_expense_category','refresh');
        }    
        
        else
        {  
            $this->add_expensecategory();
        }
    }

   
    /*

        this function used for delete expense_category data

    */
    public function delete($id)
    {

      

      		  $del=array(
      			'delete_status'   => 1,
      			'delete_date'     => date('Y-m-d'),
      			'id'              => $id
      			);
		
	       if($this->income_expense_category_model->delete($del))
	        {
            $this->session->set_flashdata('success', 'expense_category Deleted successfully.');
              redirect('income_expense_category','refresh');
          }
    }

    /*

        this function used for fetch expense_category data

    */
    public function edit_category($id)
    {	
        if (!$this->ion_auth->logged_in())
        {
          // redirect them to the login page
          redirect('auth/login', 'refresh');
        }

            $data['data'] = $this->income_expense_category_model->getData($id);
    	     $this->load->view('income_expense_category/edit',$data);
    }

     /*

        this function used for update expense_category data

    */
    function edit()
    {
        if (!$this->ion_auth->logged_in())
        {
          // redirect them to the login page
          redirect('auth/login', 'refresh');
        }

    	   $id = $this->input->post('id');

          $this->form_validation->set_rules('name', 'Name ', 'required');
          $this->form_validation->set_rules('type', 'type ', 'required');
         
           if ($this->form_validation->run() == true)
           {
              $this->load->model('income_expense_category_model');
              $id = $this->input->post('id');

              $category = array(
                
                    'name'          => $this->input->post('name'),
                    'type'          => $this->input->post('type'),
   
                     'id'=>$id        
            );
           
            }

         if(($this->form_validation->run() == true) && $this->income_expense_category_model->editCategory($category))
            {
               $this->session->set_flashdata('success', 'expense_category edit successfully.');
              redirect('income_expense_category','refresh');
            }    
           else
            {  
               $this->edit_category($id);
            }
        }
    } 