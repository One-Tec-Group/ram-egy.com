<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager','sales_person');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>

  <div class="content-wrapper">
      <!-- Main content -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('expense'); ?>">Bank Account</a></li>
          <li class="active">Edit Expense</li>
        </ol>
      </h5>    
    </section>
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">
                Edit Expense
                <!-- <?php echo $this->lang->line('lbl_editexpense_header');?> -->
              </h3>
            </div>
            <div class="box-body">
              <form name="Form" action="<?php echo base_url();?>expense/edit"  method="post" class="form-horizontal" enctype="multipart/form-data">                
                  <?php echo validation_errors(); ?>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="inputEmail3" class="control-label">
                       Account 
                        
                      <span style="color:red;">*</span></label>
                      
                      <div class="control">
                          <select class="form-control select2" id="acount" name="acount" tabindex="2" onblur='chkDrop("Form","acount","Please Enter Name");'>
                              <option value="">select one </option>
                              <?php foreach ($account as $value) {?>
                              <option value="<?php echo $value->id;?>" <?php if($value->id == $data->account_id){echo "selected";} ?>><?php echo $value->account_name;?></option>
                              <?php } ?>  
                          </select>
                          <span style="color: red;"><?php echo form_error('acount'); ?></span>
                          <p style="color:#990000;"></p>
                      </div> 
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">
                           Date
                        <?php echo $this->lang->line('lbl_addexpense_date');?>
                        <label style="color:red;">*</label></label>
                   
                            <div class="input-group date"> 
                              <div class="input-group-addon">
                                 <i class="fa fa-calendar"></i>
                              </div>
                              <div class="control">
                                  <input type="text" class="form-control pull-right datepicker" name="date" tabindex="2" onblur='chkEmpty("Form","date","Please Select Date");' value="<?php echo $data->date;?>" placeholder="<?php echo $this->lang->line('lbl_addexpense_date');?>">
                              </div>  
                           
                        </div>   
                    </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="control-label">
                         Description 
                        <?php echo $this->lang->line('lbl_addexpense_desc');?>
                      </label>
                        
                           <div class="control">
                                <input type="hidden" name="id" value="<?php echo $data->id;?>" >
                                <input type="text" class="form-control" name="desc" id="desc" placeholder="<?php echo $this->lang->line('lbl_addexpense_desc');?>" tabindex="2" onblur='chkEmpty("Form","desc","Please Enter Description");' value="<?php echo $data->description;?>">
                                <span style="color: red;"><?php echo form_error('desc'); ?></span>
                                <p style="color:#990000;"></p>
                          </div> 
                    </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="control-label">
                        Amount 
                        <?php echo $this->lang->line('lbl_addexpense_amount');?>
                      <label style="color:red;">*</label></label>
                     
                        <div class="control">
                            <input type="number" class="form-control" name="amount" id="amount" placeholder="<?php echo $this->lang->line('lbl_addexpense_amount');?>" min="0" tabindex="2" onblur='chkEmpty("Form","amount","Please Enter amount");' value="<?php echo $data->amount;?>">
                            <span style="color: red;"><?php echo form_error('amount'); ?></span>
                             <p style="color:#990000;"></p>
                          </div> 
                    </div>
                
                    <div class="form-group">
                      <label for="inputEmail3" class="control-label">
                      Category
                        <?php echo $this->lang->line('lbl_addexpense_category');?>
                      <label style="color:red;">*</label></label>
                       
                           <div class="control">
                              <select class="form-control select2" id="category" name="category" tabindex="2" onblur='chkDrop("Form","category","Please Enter category");' >
                                <option value="">
                                  <?php echo $this->lang->line('lbl_dropdown_customer');?>
                                </option>
                                  <?php foreach ($category as $value) {?>
                                <option value="<?php echo $value->id;?>" <?php if($value->id == $data->category_id){echo "selected";} ?>><?php echo $value->name;?></option>
                                 <?php } ?>   
                              </select>
                              <span style="color: red;"><?php echo form_error('category'); ?></span>
                              <p style="color:#990000;"></p>
                          </div> 
                    </div>

                    <div class="form-group">
                      <label for="inputEmail3" class="control-label">
                       Payment Method 
                        <?php echo $this->lang->line('lbl_addexpense_paymentmethod');?>
                        <label style="color:red;">*</label></label>
                       
                           <div class="control">
                             <select class="form-control select2" id="units" name="units"  tabindex="2" onblur='chkDrop("Form","units","Please Select Payment Method");'>
                                <option value="">
                                  <!-- select one -->
                                  <?php echo $this->lang->line('lbl_dropdown_customer');?>
                                </option>
                                  <?php foreach ($payment as $value) {?>
                                <option value="<?php echo $value->id;?>" <?php if($value->id == $data->payment_method_id){echo "selected";} ?>><?php echo $value->name;?></option>
                                
                                    <?php } ?>
                                </select>
                               <span style="color: red;"><?php echo form_error('units'); ?></span>
                               <p style="color:#990000;"></p>
                          </div> 
                    </div>
              
                    <div class="form-group">
                      <label for="inputEmail3" class="control-label">
                        Reference
                        <?php echo $this->lang->line('lbl_addexpense_reference');?>
                      </label>
                        
                           <div class="control">
                            <!-- <?php
                              $orderno=sprintf('%03d',intval($referense_no)+1);
                            ?> -->
                              <input type="text" class="form-control" id="reference" name="reference" tabindex="2" onblur='chkEmpty("Form","reference","Please Enter reference_no");' id="reference" value="<?php echo $data->reference_no;?>" placeholdder="<?php echo $this->lang->line('lbl_addexpense_reference');?>">
                              <span style="color: red;"><?php echo form_error('reference'); ?></span>
                              <p id="b" style="color:#990000;"></p>
                          </div> 
                    </div>
                  </div>
                <div class="row">  
                  <div class="col-sm-12">
                    <div class="box-footer">
                      <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;Update
                        &nbsp;&nbsp;&nbsp;</button>
                      <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('expense')"><!-- Cancel -->
                        <?php echo $this->lang->line('add_user_btn_cancel'); ?></span>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          <!-- /.box-body -->
          </div>       
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
    $this->load->view('layout/footer');
  ?>


