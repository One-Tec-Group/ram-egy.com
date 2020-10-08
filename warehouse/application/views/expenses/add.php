<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager','sales_person');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> 
                <!-- Dashboard -->
                <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('expense'); ?>">
               Expense 
              <!-- <?php echo $this->lang->line('customer_header'); ?> --></a>
          </li>
          <li class="active">New Expense 
              
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
               New Expense 
                <!-- <?php echo $this->lang->line('add_customer_header'); ?> -->
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('expense/add');?>">
                <div class="col-md-6">
                     <div class="form-group">
                       <label for="inputEmail3" class="control-label">
                          Account
                      <label style="color:red;">*</label></label>
                         
                            <div class="control">
                               <select class="form-control select2" id="acount" name="acount" tabindex="2" onblur='chkEmpty("Form","acount","Please Enter Name");'>
                                 <?php foreach ($account as $value) {?>
                                 <option value="<?php echo $value->id;?>"><?php echo $value->account_name;?></option>
                                 <?php } ?>  
                              </select>
                              <span style="color: red;"><?php echo form_error('acount'); ?></span>
                              <p style="color:#990000;"></p>  
                           </div> 
                      </div>
                 

                  <div class="form-group">
                     <label for="inputEmail3" class="control-label">
                      Date
                      <label style="color:red;">*</label></label>
                      
                       <div class="input-group date">
                         <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                         </div>
                         <div class="control">
                            <input type="text" class="form-control pull-right datepicker" autocomplete="off" name="date" tabindex="2" onblur='chkEmpty("Form","date","Please Select Date");' placeholder="<?php echo $this->lang->line('lbl_addexpense_date');?>">
                         </div>
                            <span style="color: red;"><?php echo form_error('date'); ?></span>
                            <p style="color:#990000;"></p>  
                       </div>
                    
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                      Description
                      
                    </label>
                      
                        <div class="control">
                            <input type="text" class="form-control" name="desc" id="desc" placeholder="<?php echo $this->lang->line('lbl_addexpense_desc');?>" tabindex="2" onblur='chkEmpty("Form","desc","Please Enter Name");'>
                            <span style="color: red;"><?php echo form_error('desc'); ?></span>
                             <p style="color:#990000;"></p>
                          </div> 
                     
                      </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                      Amount
                      
                    <label style="color:red;">*</label></label>
                      
                        <div class="control">
                            <input type="number" class="form-control" name="amount" id="amount" placeholder="<?php echo $this->lang->line('lbl_addexpense_amount');?>" min="0" tabindex="2" onblur='chkEmpty("Form","amount","Please Enter Name");'>
                            <span style="color: red;"><?php echo form_error('amount'); ?></span>
                             <p style="color:#990000;"></p>
                          </div> 
                      </div>
                  
                    
                  <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                      Category
                      
                      <label style="color:red;">*</label></label>
                      
                        <div class="control">
                            <select class="form-control select2" id="category" name="category">
                            <?php foreach ($category as $value) {?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                            <?php } ?>    
                            </select>
                            <span style="color: red;"><?php echo form_error('category'); ?></span>
                            <p style="color:#990000;"></p>
                        </div> 
                      
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                      Payment Method
                      
                      <label style="color:red;">*</label></label>
                      
                        <div class="control">
                            <select class="form-control select2" id="units" name="units">
                            <?php foreach ($payment as $value) {?>
                            <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                            <?php } ?>    
                            </select>
                            <span style="color: red;"><?php echo form_error('units'); ?></span>
                            <p style="color:#990000;"></p>
                          </div> 
                      
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                      Reference
                      
                    </label>
                     
                        <div class="control">
                          <?php
                          $orderno=sprintf('%03d',intval($referense)+1);
                          ?>
                          <input type="text" class="form-control" name="reference" id="reference" value="<?php echo $orderno;?>" placement="<?php echo $this->lang->line('lbl_addexpense_reference');?>">
                        </div> 
                      </div>
                  
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<!-- Add -->
                        <?php echo $this->lang->line('add_user_btn'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('expense')"><!-- Cancel -->
                      <?php echo $this->lang->line('add_user_btn_cancel'); ?></span>
                  </div>
                </div>
              </form>
          </div>
          <!-- /.box-body -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    $this->load->view('layout/footer');
  ?>
