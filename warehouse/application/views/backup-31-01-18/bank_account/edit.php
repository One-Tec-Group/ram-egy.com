<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('bank_account'); ?>">Bank Account</a></li>
          <li class="active">Edit Bank Account</li>
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
              <h3 class="box-title">Edit Bank Account</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                <form role="form" id="form" method="post" action="<?php echo base_url('bank_account/editBankAccount');?>">
                    <div class="form-group">
                      <label for="account_name">Account Name<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="account_name" name="account_name" value="<?php echo $data->account_name; ?>">
                      <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                      <span class="validation-color" id="err_account_name"><?php echo form_error('account_name'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="type">Account Type<span class="validation-color">*</span></label>
                      <select class="form-control select2" id="type" name="type" style="width: 100%;">
                        <option value="">Select</option>
                        <option value="Savings Account" <?php if($data->account_type=='Savings Account'){ echo 'selected'; } ?>>Savings Account</option>
                        <option value="Credit Account" <?php if($data->account_type=='Credit Account'){ echo 'selected'; } ?>>Credit Account</option>
                        <option value="Cash Account" <?php if($data->account_type=='Cash Account'){ echo 'selected'; } ?>>Cash Account</option>
                        <option value="Chequing Account" <?php if($data->account_type=='Chequing Account'){ echo 'selected'; } ?>>Chequing Account</option>
                      </select>
                      <span class="validation-color" id="err_type"><?php echo form_error('type'); ?></span>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label for="account_number">Account Number<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="account_number" name="account_number" value="<?php echo $data->account_no; ?>">
                      <span class="validation-color" id="err_account_number"><?php echo form_error('account_number'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="bank_name">Bank Name<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo $data->bank_name; ?>">
                      <span class="validation-color" id="err_bank_name"><?php echo form_error('bank_name'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="balance">Opening Balance<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="balance" name="balance" value="<?php echo $data->opening_balance; ?>">
                      <span class="validation-color" id="err_balance"><?php echo form_error('balance'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="address">Bank Address<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="address" name="address" value="<?php echo $data->bank_address; ?>">
                      <span class="validation-color" id="err_address"><?php echo form_error('address'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="default">Default Account</label>
                      <select class="form-control select2" id="default" name="default" style="width: 100%;">
                        <option value="YES" <?php if($data->default_account=='YES'){ echo 'selected'; } ?>>YES</option>
                        <option value="NO" <?php if($data->default_account=='NO'){ echo 'selected'; } ?>>NO</option>
                      </select>
                      <span class="validation-color" id="err_default"><?php echo form_error('default'); ?></span>
                    </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<!-- Add --><?php echo $this->lang->line('subcategory_add'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('bank_account')"><!-- Cancel --><?php echo $this->lang->line('subcategory_cancel'); ?></span>
                  </div>
                </div>
              </form>
            </div>
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
