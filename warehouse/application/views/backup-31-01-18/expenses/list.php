<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager','sales_person');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>

<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='<?php  echo base_url('expense/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i>
                 <!-- Dashboard -->
                <?php echo $this->lang->line('header_dashboard'); ?>
              </a>
            </li>
          <li class="active">Expense
              
          </li>
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">
                List Expense
                
              </h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('expense/addExpanses');?>"> 
                  New Expenses
                  
               </a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>
                    S/N
                    
                  </th>
                  <th>
                    Account Name
                  </th>
                  <th>
                    Account Number
                    
                  </th>
                  <th>
                    Description
                   
                  </th>
                  <th>
                    Amount
                    
                  </th>
                  <th>
                    Date
                  </th>
                  <th>
                    Action
                    
                  </th>
                </tr>
                </thead>
                <tbody>
          
                <?php
                $i=1; 
                 foreach ($data as $value) {
                 ?>
                  <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $value->account_name;?></td>
                    <td><?php echo $value->account_no;?></td>
                    <td><?php echo $value->description;?></td>
                    <td><?php echo $value->amount;?></td>
                    <td><?php echo $value->date;?></td>
                    <td>
                        <a title="Edit" class="btn btn-xs btn-primary" href="<?php echo base_url();?>expense/edit_data/<?php echo $value->id;?>"><span class="fa fa-edit"></span></a>
                         
                         <a href="javascript:delete_id(<?php echo $value->id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>                      
                       </td>
                </tr>
                <?php
              }
              ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>
                    S/N
                    
                  </th>
                  <th>
                    Account Name
                  </th>
                  <th>
                    Account Number
                    
                  </th>
                  <th>
                    Description
                   
                  </th>
                  <th>
                    Amount
                    
                  </th>
                  <th>
                    Date
                  </th>
                  <th>
                    Action
                    
                  </th>
                </tr>
               </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php 
  $this->load->view('layout/footer');
?>

<script type="text/javascript">

    window.setTimeout(function() {
        $(".alert").fadeTo(400, 0).slideUp(400, function(){
            $(this).remove(); 
        });
    }, 4000);
  </script>