<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  $this->load->view('layout/header');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a>
          </li>
          <li><a href="<?php echo base_url('biller'); ?>">Purchaser</a>
          </li>
          <li class="active">Add Purchaser</li>
        </ol>
      </h5>    
    </section>
<!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
        <div class="col-sm-12">
           
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Purchaser
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                
                <form role="form" id="form" method="post" action="<?php echo base_url('purchaser/addPurchaser');?>">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="firstname">
                      First Name                         
                  </label>
                    <input type="text" name="firstname" id="firstname" class="form-control">
                    <span class="validation-color" id="err_firstname"><?php echo form_error('firstname'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="lastname">
                        Last Name                          
                    </label>
                    <input type="text" name="lastname" id="lastname" class="form-control">
                    <span class="validation-color" id="err_lastname"><?php echo form_error('lastname'); ?></span>
                  </div>                  
                  <div class="form-group">
                    <label for="company">
                        Company Name 
                        
                  </label>
                    <input type="text" name="company" id="company" class="form-control">
                    <span class="validation-color" id="err_company"><?php echo form_error('company'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="email">
                          Email                         
                    </label>
                    <input type="email" name="email" id="email" class="form-control">
                    <span class="validation-color" id="err_email"><?php echo form_error('email'); ?></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="phone">
                          Mobile No
                    </label>
                      <input type="phone" name="phone" id="phone" class="form-control">
                      <span class="validation-color" id="err_phone"><?php echo form_error('phone'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="password">
                          Password
                    </label>
                    <input type="password" name="password" id="password" class="form-control">
                    <span class="validation-color" id="err_password"><?php echo form_error('password'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="password_confirm">
                        Confirm Password                       
                    </label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                    <span class="validation-color" id="err_c_password"><?php echo form_error('password_confirm'); ?></span>
                  </div>
                  <div class="form-group">                   
                        <div class="groups">                         
                          <input type="hidden" name="groups[]" value="5">
                        </div>                                       
                  </div> 
                  <div class="form-group">
                    <label for="warehouse">Warehouse (Assign Warehouse)<span class="validation-color">*</span></label>
                    <select class="form-control select2" id="warehouse_id" name="warehouse_id" style="width: 100%;">
                      <option value=""><?php echo $this->lang->line('assign_warehouse_select')." Warehouse"; ?></option>
                      <?php
                        foreach ($warehouse as $value) {
                      ?>
                        <option value="<?php echo $value->warehouse_id ?>"><?php echo $value->warehouse_name." ".$value->branch_name; ?><?php if($value->primary_warehouse == 1){ echo " (Primary)";} ?></option>
                      <?php
                        }
                      ?>
                    </select>
                   <!--  <span style="font-size:12px;">(Only 1 purchaser is allowed to one warehouse so you will be able to see only unassigned warehouse list.)</span> -->
                  </div>   
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<!-- Add -->
                        <?php echo $this->lang->line('add_user_btn');?>
                    &nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('biller')"><!-- Cancel -->
                      <?php echo $this->lang->line('add_user_btn_cancel');?>
                    </span>
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
<!-- <script>
  $(document).ready(function(){
    $("#submit").click(function(event){
      var name_regex = /^[a-zA-Z]+$/;
      var cname_regex = /^[a-zA-Z\s]+$/;
      var uname_regex = /^[a-zA-Z0-9]+$/;
      var mobile_regex = /^[0-9]+$/;
      var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      var firstname = $('#firstname').val();
      var lastname = $('#lastname').val();
      var username = $('#company').val();
      var phone = $('#phone').val();
      var email = $('#email').val();
      var password = $('#password').val();
      var c_password = $('#password_confirm').val();

        if(firstname==null || firstname==""){
          $("#err_firstname").text("Please Enter First Name");
          return false;
        }
        else{
          $("#err_firstname").text("");
        }
        if (!firstname.match(name_regex)) {
          $('#err_firstname').text(" Please Enter Valid First Name ");
          return false;
        }
        else{
          $("#err_firstname").text("");
        }
//first name validation complite.

        if(lastname==null || lastname==""){
          $("#err_lastname").text("Please Enter Last Name");
          return false;
        }
        else{
          $("#err_lastname").text("");
        }
        if (!lastname.match(name_regex) ) {
          $('#err_lastname').text(" Please Enter Valid Last Name ");   
          return false;
        }
        else{
          $("#err_lastname").text("");
        }
//last name validation complite.
      
        if(company==null || company==""){
          $("#err_company").text("Please Enter Company Name");
          return false;
        }
        else{
          $("#err_company").text("");
        }
        if (!company.match(cname_regex) ) {
          $('#err_company').text(" Please Enter Valid Company ");   
          return false;
        }
        else{
          $("#err_company").text("");
        }
//company validation complite

      
        if(phone==null || phone==""){
          $("#err_phone").text("Please Enter the Phone Number");
          return false;
        }
        else{
          $("#err_phone").text("");
        }
        if (!phone.match(mobile_regex) ) {
          $('#err_phone').text(" Please Enter Valid 10 digit MObile Number (Ex. 9898989898) ");   
          return false;
        }
        else{
          $("#err_phone").text("");
        }
//Username validation complite

        if(email==null || email==""){
          $("#err_email").text("Please Enter Email");
          return false;
        }
        else{
          $("#err_email").text("");
        }
        if (!email.match(email_regex) ) {
          $('#err_email').text(" Please Enter Valid Email Address(Ex: abc@dd.com) ");   
          return false;
        }
        else{
          $("#err_email").text("");
        }
//email validation complite

        if(password==null || password==""){
          $("#err_password").text("Please Enter Password");
          return false;
        }
        else{
          $("#err_password").text("");
        }
        if(password.length < 8 || password.length > 20){
          $("#err_password").text("Please Enter Password 8 to 20 character long");
          return false;
        }
        else{
          $("#err_password").text("");
        }

//password validation complite
        
        if(c_password==null || c_password==""){
          $("#err_c_password").text("Please Enter Confirm Password.");
          return false;
        }
        else{
          $("#err_c_password").text("");
        }
        if(password != c_password){
          $("#err_c_password").text("Password and Confirm Password does not match.");
           return false;
        }
        else{
          $("#err_c_password").text("");
        }
        
//confirm passowrd complite
        //event.preventDefault();
    });

    $("#first_name").on("blur keyup",  function (event){
        var name_regex = /^[a-zA-Z]+$/;
        var firstname = $('#first_name').val();
        if(firstname==null || firstname==""){
          $("#err_firstname").text(" Please Enter First Name.");
          $("#first_name").focus();
          return false;
        }
        else{
          $("#err_firstname").text("");
        }
        if (!firstname.match(name_regex) ) {
          $('#err_firstname').text(" Please Enter Valid First Name  ");  
          $("#first_name").focus();
          return false;
        }
        else{
          $("#err_firstname").text("");
        }
        //event.preventDefault();
    });
    $("#last_name").on("blur keyup",  function (event){
        var name_regex = /^[a-zA-Z]+$/;
        var lastname = $('#last_name').val();
        if(lastname==null || lastname==""){
          $("#err_lastname").text(" Please Enter Last Name.");
          $("#last_name").focus();
          return false;
        }
        else{
          $("#err_lastname").text("");
        }
        if (!lastname.match(name_regex) ) {
          $('#err_lastname').text(" Please Enter Valid Last Name  ");  
          $("#last_name").focus();
          return false;
        }
        else{
          $("#err_lastname").text("");
        }
        //event.preventDefault();
    });
    
    $("#company").on("blur keyup",  function (event){
        var cname_regex = /^[a-zA-Z\s]+$/;
        var company = $('#company').val();
         if(company==null || company==""){
          $("#err_company").text("Please Enter Company Name");
          $("#company").focus();
          return false;
        }
        else{
          $("#err_company").text("");
        }
        if (!company.match(cname_regex) ) {
          $('#err_company').text(" Please Enter Valid Company Name");  
          $("#company").focus(); 
          return false;
        }
        else{
          $("#err_company").text("");
        }
    });
    $("#phone").on("blur keyup",  function (event){
        var mobile_regex = /^[6-9][0-9]{9}$/
        var phone = $('#phone').val();
        if(phone==null || phone==""){
          $("#err_phone").text("Please Enter the Phone Number");
          return false;
        }
        else{
          $("#err_phone").text("");
        }
        if (!phone.match(mobile_regex)) {
          $('#err_phone').text(" Please Enter Valid 10 digit MObile Number (Ex. 9898989898) ");   
          return false;
        }
        else{
          $("#err_phone").text("");
        }
    });
    
    $("#email").on("blur keyup",  function (event){
        var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var email = $('#email').val();
        if(email==null || email==""){
          $("#err_email").text("Please Enter Email");
          $("#email").focus();
          return false;
        }
        else{
          $("#err_email").text("");
        }
        if (!email.match(email_regex) ) {
          $('#err_email').text(" Please Enter Valid Email Address(Ex: abc@dd.com) ");  
          $("#email").focus();
          return false;
        }
        else{
          $("#err_email").text("");
        }
        //event.preventDefault();
    });
    $("#password").on("blur keyup",  function (event){
        var password = $('#password').val();
        if(password==null || password==""){
          $("#err_password").text(" Please Enter Password");
          $("#password").focus();
          return false;
        }
        else{
          $("#err_password").text("");
        }
        if(password.length < 8 || password.length > 20){
          $("#err_password").text("Please Enter Password 8 to 20 character long");
          $("#password").focus();
          return false;
        }
        else{
          $("#err_password").text("");
        }
    });
    $("#password_confirm").on("blur keyup",  function (event){
        var c_password = $('#password_confirm').val();
        var password = $('#password').val();
        if(c_password==null || c_password==""){
          $("#err_c_password").text("Please Enter Confirm Password");
          $("#password_confirm").focus();
          return false;
        }
        else{
          $("#err_c_password").text("");
        }
        if(password != c_password){
          $("#err_c_password").text("Password and Confirm Password does not match");
          $("#password_confirm").focus();
          return false;
        }
        else{
          $("#err_c_password").text("");
        }
    });
}); 
</script> -->