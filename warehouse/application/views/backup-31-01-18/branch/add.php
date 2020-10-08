<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('branch'); ?>"><!-- Branch --> <?php echo $this->lang->line('branch_label'); ?></a></li>
          <li class="active"><!-- Add Branch --> <?php echo $this->lang->line('branch_label_addbranch'); ?></li>
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
              <h3 class="box-title"><!-- Add New Branch --> <?php echo $this->lang->line('branch_label_addbranch'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-sm-6">
                <form role="form" id="form" method="post" action="<?php echo base_url('branch/addBranch');?>">
                  <div class="form-group">
                    <label for="branch_name"><!-- Branch Name -->  <?php echo $this->lang->line('branch_label_name'); ?><span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo set_value('branch_name'); ?>">
                    <span class="validation-color" id="err_branch_name"><?php echo form_error('branch_name'); ?></span>
                  </div>
                  <div class="form-group">
                      <label for="country"><!-- Country --> 
                          <?php echo $this->lang->line('biller_lable_country'); ?> <span class="validation-color">*</span>
                        </label>
                      <select class="form-control select2" id="country" name="country" style="width: 100%;">
                        <option value="">
                          <!-- Select -->
                          <?php echo $this->lang->line('add_biller_select'); ?>    
                        </option>
                        <?php
                          foreach ($country as  $key) {
                        ?>
                        <option 
                          value='<?php echo $key->id ?>' 
                          <?php 
                            if(isset($data[0]->country_id)){
                              if($key->id == $data[0]->country_id){
                                echo "selected";
                              }
                            } 
                          ?>
                        >
                        <?php echo $key->name; ?>
                        </option>
                        <?php
                          }
                        ?>
                      </select>
                      <span class="validation-color" id="err_country"><?php echo form_error('country'); ?></span>
                    </div>
                  <div class="form-group">
                      <label for="state"><!-- State --> 
                          <?php echo $this->lang->line('add_biller_state'); ?> 
                          <span class="validation-color">*</span>
                      </label>
                      <select class="form-control select2" id="state" name="state" style="width: 100%;">
                        <option value=""><!-- Select -->
                            <?php echo $this->lang->line('add_biller_select'); ?>
                            
                        </option>
                      </select>
                      <span class="validation-color" id="err_state"><?php echo form_error('state'); ?></span>
                    </div>
                  <div class="form-group">
                      <label for="city"><!-- City --> 
                          <?php echo $this->lang->line('biller_lable_city'); ?> 
                          <span class="validation-color">*</span>
                      </label>
                      <select class="form-control select2" id="city" name="city" style="width: 100%;">
                        <option value=""><!-- Select -->
                            <?php echo $this->lang->line('add_biller_select'); ?>
                            
                            </option>
                      </select>
                      <span class="validation-color" id="err_city"><?php echo form_error('city'); ?></span>
                    </div>
                  <div class="form-group">
                    <label for="address"><!-- Address --> <?php echo $this->lang->line('branch_label_address'); ?> <span class="validation-color">*</span></label>
                    <textarea type="text" class="form-control" id="address" name="address"><?php echo set_value('address'); ?></textarea>
                    <span class="validation-color" id="err_address"><?php echo form_error('address'); ?></span>
                  </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<!-- Add --> <?php echo $this->lang->line('branch_label_add'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('branch')"><!-- Cancel --> <?php echo $this->lang->line('branch_label_cancel'); ?></span>
                  </div>
                </div>
                </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
    $('#country').change(function(){
      var id = $(this).val();
      $('#state').html('<option value="">Select</option>');
      $('#state_code').val('');
      $('#city').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('customer/getState') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#state').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
</script>
<script>
    $('#state').change(function(){
      var id = $(this).val();
      var country = $('#country').val();
      $('#city').html('<option value="">Select</option>');
      $('#state_code').val('');
      $.ajax({
          url: "<?php echo base_url('customer/getCity') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#city').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
      $.ajax({
          url: "<?php echo base_url('biller/getStateCode') ?>/"+id+'/'+country,
          type: "GET",
          dataType: "TEXT",
          success: function(data){
            $('#state_code').val(data);
          }
        });
    });
</script>
<script>
  $(document).ready(function(){
    var branch_name_empty = "Please Enter the Branch Name.";
    var branch_name_invalid = "Please Enter Valid Branch Name";
    var branch_name_length = "Please Enter Branch Name Minimun 3 Character";
    var city_empty = "Please Select City.";
    var state_empty = "Please Selec State.";
    var country_empty = "Please Select Country.";
    var address_empty = "Please Enter Branch Address";
    $("#submit").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var city_regex = /^[a-zA-Z\s]+$/;
      var branch_name = $('#branch_name').val().trim();
      var city = $('#city').val().trim();
      var state = $('#state').val().trim();
      var country = $('#country').val().trim();
      var address = $('#address').val().trim();
      $('#branch_name').val(branch_name);
      if(branch_name==null || branch_name==""){
        $("#err_branch_name").text(branch_name_empty);
        return false;
      }
      else{
        $("#err_branch_name").text("");
      }
      if (!branch_name.match(name_regex) ) {
        $('#err_branch_name').text(branch_name_invalid);   
        return false;
      }
      else{
        $("#err_branch_name").text("");
      }
      if (branch_name.length < 3) {
        $('#err_branch_name').text(branch_name_length);  
        return false;
      }
      else{
        $("#err_branch_name").text("");
      }
//branch name validation complite.
      if(city==null || city==""){
        $("#err_city").text(city_empty);
        return false;
      }
      else{
        $("#err_city").text("");
      }
//city name validation complite.
if(state==null || state==""){
        $("#err_state").text(state_empty);
        return false;
      }
      else{
        $("#err_state").text("");
      }
//state name validation complite.
if(country==null || country==""){
        $("#err_country").text(country_empty);
        return false;
      }
      else{
        $("#err_country").text("");
      }
//country name validation complite.
      if(address == "" || address == null){
        $('err_address').text(address_empty);
      }
      else{
        $('err_address').text("");
      }
//address name validation complite. 
    });

    $("#branch_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var branch_name = $('#branch_name').val();
      if(branch_name==null || branch_name==""){
        $("#err_branch_name").text(branch_name_empty);
        return false;
      }
      else{
        $("#err_branch_name").text("");
      }
      if (!branch_name.match(name_regex) ) {
        $('#err_branch_name').text(branch_name_invalid);   
        return false;
      }
      else{
        $("#err_branch_name").text("");
      }
      if (branch_name.length < 3) {
        $('#err_branch_name').text(branch_name_length);  
        return false;
      }
      else{
        $("#err_branch_name").text("");
      }
    });

    $("#city").on("change",  function (event){
      var city = $('#city').val();
      $('#city').val(city);
      if(city==null || city==""){
        $("#err_city").text(city_empty);
        return false;
      }
      else{
        $("#err_city").text("");
      }
    });
    $("#state").on("change",  function (event){
      var state = $('#state').val();
      $('#state').val(state);
      if(state==null || state==""){
        $("#err_state").text(state_empty);
        return false;
      }
      else{
        $("#err_state").text("");
      }
    });
    $("#country").on("change",  function (event){
      var country = $('#country').val();
      $('#country').val(country);
      if(country==null || country==""){
        $("#err_country").text(country_empty);
        return false;
      }
      else{
        $("#err_country").text("");
      }
    });

    $("#address").on("blur keyup",  function (event){
      var address = $('#address').val();
      if(address == "" || address == null){
        $('#err_address').text(address_empty);
      }
      else{
        $('#err_address').text("");
      }
    });
   
}); 
</script>