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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active">SMS Setting</li>
        </ol>
      </h5>    
    </section>
<!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
        <?php
          if($fail = $this->session->flashdata('fail')){
        ?>
          <div class="col-sm-12">
            <div class="alert alert-success">
              <button class="close" data-dismiss="alert" type="button">×</button>
                <?php echo $fail; ?>
              <div class="alerts-con"></div>
            </div>
          </div>
        <?php
          }
        ?>
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">SMS Setting</h3>
              <a class="btn btn-sm btn-warning pull-right" href="<?php echo base_url('sms_setting/history');?>" title="SMS History" onclick=""> SMS History <?php //echo $this->lang->line('sms_history'); ?></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('sms_setting/updateSmsSetting');?>">
                  <div class="col-md-6">

                    <!-- bhash gateway -->

                    <div class="form-group">
                      <label for="sms_gateway">SMS Gateway<span class="validation-color">*</span></label>
                      <select class="form-control" id="sms_gateway" name="sms_gateway">
                        <option value="0">MSG 91</option>
                        <option value="1">Bhash SMS</option>
                      </select>
                      <span class="validation-color" id="err_sms_gateway"><?php echo form_error('sms_gateway'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="default_gateway">Default Gateway<span class="validation-color">*</span></label>
                      <select class="form-control" id="default_gateway" name="default_gateway">
                        <option value="0" <?php 
                            if(isset($data->default_gateway)){ 
                              if($data->default_gateway ==0)
                                {
                                  echo 'selected';
                                }
                              }else{ 
                                echo 'selected';
                              } 
                              ?>>MSG 91</option>
                        <option value="1" <?php 
                            if($data->default_gateway ==1){ 
                                echo 'selected';
                              } 
                              ?>>Bhash SMS</option>
                      </select>
                      <span class="validation-color" id="err_default_gateway"><?php echo form_error('default_gateway'); ?></span>
                    </div>

                    

                    <div class="form-group bhash">
                      <label for="bhash_api_url">API Url<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="bhash_api_url" name="bhash_api_url" value="<?php if(isset($data->bhash_api_url)){ echo $data->bhash_api_url; }?>">
                      <span class="validation-color" id="err_bhash_api_url"><?php echo form_error('bhash_api_url'); ?></span>
                    </div>

                    <div class="form-group bhash">
                      <label for="username">Username<span class="validation-color">*</span></label></span>
                      <input type="text" class="form-control" id="username" name="username" value="<?php if(isset($data->username)){ echo $data->username; }?>">
                      <span class="validation-color" id="err_username"><?php echo form_error('username'); ?></span>
                    </div>

                    <div class="form-group bhash">
                      <label for="password">Password<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="password" name="password" value="<?php if(isset($data->password)){ echo $data->password; }?>">
                      <span class="validation-color" id="err_password"><?php echo form_error('password'); ?></span>
                    </div>

                    <div class="form-group bhash">
                      <label for="sender_b">Sender<span class="validation-color">*</span></label><span class="pull-right">(Receiver will see as sender ID : 6 Characters only)</span>
                      <input type="text" class="form-control" id="sender_b" name="sender_b" value="<?php if(isset($data->sender_b)){ echo $data->sender_b; }?>">
                      <span class="validation-color" id="err_sender_b"><?php echo form_error('sender_b'); ?></span>
                    </div>

                    
                    <div class="form-group msg91">
                      <label for="api_url">API Url<span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="api_url" name="api_url" value="<?php if(isset($data->api_url)){ echo $data->api_url; }?>">
                      <span class="validation-color" id="err_api_url"><?php echo form_error('api_url'); ?></span>
                    </div>

                    <div class="form-group msg91">
                      <label for="sender">Sender<span class="validation-color">*</span></label><span class="pull-right">(Receiver will see as sender ID : 6 Characters only)</span>
                      <input type="text" class="form-control" id="sender" name="sender" value="<?php if(isset($data->sender)){ echo $data->sender; }?>">
                      <span class="validation-color" id="err_sender"><?php echo form_error('sender'); ?></span>
                    </div>

                    <div class="form-group msg91">
                        <label for="route">Route<span class="validation-color">*</span></label><span class="pull-right">(1 = for promotional, 2 = transactional)</span>
                        <input type="text" class="form-control" id="route" name="route" value="<?php if(isset($data->route)){ echo $data->route; }?>">
                        <span class="validation-color" id="err_route"><?php echo form_error('route'); ?></span>
                    </div>

                    <div class="form-group msg91">
                        <label for="auth_key">Auth Key<span class="validation-color">*</span></label><span class="pull-right">(API key you will get login into your sms provider after login)</span>
                        <input type="text" class="form-control" id="auth_key" name="auth_key" value="<?php if(isset($data->auth_key)){ echo $data->auth_key; }?>">
                        <span class="validation-color" id="err_auth_key"><?php echo form_error('auth_key'); ?></span>
                    </div>

                    <div class="form-group msg91">
                        <label for="unicode">Unicode<span class="validation-color">*</span></label><span class="pull-right">(1 = unicode sms)</span>
                        <input type="text" class="form-control" id="unicode" name="unicode" value="<?php if(isset($data->unicode)){ echo $data->unicode; }?>">
                        <span class="validation-color" id="err_unicode"><?php echo form_error('unicode'); ?></span>
                    </div>

                    <div class="form-group msg91">
                        <label for="country">Country Code<span class="validation-color">*</span></label><span class="pull-right">(91 for India <a href="https://countrycode.org/" target="_blank">Know your country code</a>)</span>
                        <input type="text" class="form-control" id="country" name="country" value="<?php if(isset($data->country)){ echo $data->country; }?>">
                        <span class="validation-color" id="err_country"><?php echo form_error('country'); ?></span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-solid">
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="box-group" id="accordion">
                              <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                                      Add Customer
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                  <div class="box-body">
                                    <table class="table table-bordered">
                                      <tr>
                                        <td>Customer</td>
                                        <td>Dear {customer_name}, Welcome to {company_name}. Thank you for visiting us.</td>
                                      </tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">
                                      Sale Invoice 
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false">
                                  <div class="box-body">
                                    <table class="table table-bordered">
                                      <tr>
                                        <td>Customer</td>
                                        <td>Dear {cusotmer_name}, Invoice no {invoice_no} is genrated worth amount of {sales_amount}. {company_name}</td>
                                      </tr>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour" class="collapsed" aria-expanded="false">
                                      Payment from Customer
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse" aria-expanded="false">
                                  <div class="box-body">
                                    <table class="table table-bordered">
                                      <tr>
                                        <td>Customer</td>
                                        <td>We have received your payment of {amount} in regards with {invoice_no}. Thank you visting our store. {company_name}</td>
                                      </tr>
                                    </table>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                          <!-- /.box-body -->
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-info">
                        <!-- /.box-header -->
                        <div class="box-header with-border bg-yellow">
                          <h3 class="box-title ">Buy 25% SMS Credit Extra</h3>
                        </div>
                        <div class="box-body">
                          <div class="row">
                            <div class="col-md-6"><span style="font-size: 25px;">Get 25 % extra credit by purchasing 5000 SMS <a href="https://msg91.com/signup/172c27b31a" target="_blank" style="font-size: 15px;"> (Purchase Now)</a></span></div>
                            <div class="col-md-6">
                              <a href="https://msg91.com/signup/172c27b31a" target="_blank"><img src="<?php echo base_url('assets/images')."/msg91.png" ?>" height="120px" width="200px;"></a>
                            </div>
                          </div>
                        </div>
                        <!-- /.box-body -->
                      </div>  

                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box box-solid">
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="box-group" id="accordion">
                              <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#configure" aria-expanded="true" class>
                                      How Configure MSG91 in InventO ???
                                    </a>
                                  </h4>
                                </div>
                                <div id="configure" class="panel-collapse collapse in" aria-expanded="true">
                                  <div class="box-body">
                                    <table class="table table-bordered">
                                      <tr>
                                        <td width="25%">Step 1</td>
                                        <td>Register to MSG91 with this <a href="https://msg91.com/signup/172c27b31a" target="_blank">URL</a> </td>
                                      </tr>
                                      <tr>
                                        <td>Step 2</td>
                                        <td>Buy SMS Credit (Transactional SMS Only) <a href="http://nimb.ws/k3qvc1" target="_blank">click here</a> for more details </td>
                                      </tr>
                                      <tr>
                                        <td>Step 3</td>
                                        <td>Copy auth key from MSG91 to InventO SMS Setting.<br/> <a href="http://nimb.ws/FOolxr" target="_blank">Click here for information </a></td>
                                      </tr>
                                      <tr>
                                        <td>Step 4</td>
                                        <td>Save the auth key to InventO > SMS Setting <br/> <a href="http://nimb.ws/PpxYdC" target="_blank">Click here for information </a></td>
                                      </tr>
                                    </table>
                                  </div>


                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- /.box-body -->
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  <div class="col-sm-12">
                  	<div class="box-footer">
                      <button type="submit" id="submit" name="submit" class="btn btn-info btn-flat"><?php echo $this->lang->line('company_setting_submit'); ?></button>
                      <span class="btn btn-default btn-flat" id="cancel" style="margin-left: 2%" onclick="cancel('auth/dashboard')"><?php echo $this->lang->line('company_setting_cancel'); ?></span>
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
<script>
  $('.bhash').toggle();
  $(document).ready(function(){
    var email_encription_empty = "Please Enter Email Encription.";
    var smtp_host_empty = "Please Enter SMTP Host.";
    var email_empty = "Please Enter Email.";
    var email_invalid = "Please Enter Valid Email";
    var smtp_port_empty = "Please Enter SMTP Port.";
    var smtp_port_invalid = "Please Enter Valid SMTP Port";
    var from_address_empty = "Please Enter From address.";
    var from_name_empty = "Please Enter From Name.";
    var smtp_username_empty = "Please SMTP Username.";
    var smtp_password_empty = "Please SMTP Password.";

    $('#sms_gateway').change(function () { 
       $('.msg91').toggle();
       $('.bhash').toggle();
    });
    
}); 
</script>
