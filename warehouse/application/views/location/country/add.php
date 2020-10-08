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
        <li><a href="<?php echo base_url('location/country'); ?>"><!-- Category --><?php echo "Country"; ?></a></li>
        <li class="active">Add Country</li>
      </ol>
    </h5>    
  </section>
    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3">
        <!-- /. box -->
        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Location</h3>

            <div class="box-tools">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
              <li><a href="<?php echo base_url('location/country'); ?>"><i class="fa fa-circle-o text-red"></i> Country</a></li>
              <li><a href="<?php echo base_url('location/state'); ?>"><i class="fa fa-circle-o text-yellow"></i> State</a></li>
              <li><a href="<?php echo base_url('location/city'); ?>"><i class="fa fa-circle-o text-light-blue"></i> City</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-9">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><!-- Add New Category --><?php echo $this->lang->line('category_lable_newcategory'); ?></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <form role="form" id="form" method="post" action="<?php echo base_url('location/addCountry');?>">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="name">Country<span class="validation-color">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($data->name)){ echo $data->name;} else{ echo set_value('name'); }?>">
                  <span class="validation-color" id="err_name"><?php echo form_error('name'); ?></span>
                </div>
                <div class="form-group">
                  <label for="sortname">Short Name<span class="validation-color">*</span></label>
                  <input type="text" class="form-control" id="sortname" name="sortname" value="<?php if(isset($data->sortname)){ echo $data->sortname;} else{ echo set_value('sortname'); }?>">
                  <span class="validation-color" id="err_sortname"><?php echo form_error('sortname'); ?></span>
                </div>
                <div class="form-group">
                  <label for="phonecode">Phonecode<span class="validation-color">*</span></label>
                  <input type="text" class="form-control" id="phonecode" name="phonecode" value="<?php if(isset($data->phonecode)){ echo $data->phonecode;} else{ echo set_value('phonecode'); }?>">
                  <span class="validation-color" id="err_phonecode"><?php echo form_error('phonecode'); ?></span>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="box-footer">
                  <input type="hidden" name="country_id" value="<?php if(isset($data->id)){ echo $data->id;}?>">
                  <button type="submit" id="submit" class="btn btn-info" style="padding-right: 10px;">Add </button>
                  <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('category')"><!-- Cancel --><?php echo $this->lang->line('category_cancel'); ?></span>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
<?php
  $this->load->view('layout/footer');
?>
<script>
  $(document).ready(function(){
    var category_name_empty = "Please Enter the Category Name.";
    var category_name_invalid = "Please Enter Valid Category Name";
    var category_name_length = "Please Enter Category Name Minimun 3 Character";
    $("#submit").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var category_name = $('#category_name').val().trim();
      $('#category_name').val(category_name);
      if(category_name==null || category_name==""){
        $("#err_category_name").text(category_name_empty);
        return false;
      }
      else{
        $("#err_category_name").text("");
      }
      if (!category_name.match(name_regex) ) {
        $('#err_category_name').text(category_name_invalid);   
        return false;
      }
      else{
        $("#err_category_name").text("");
      }
      if (category_name.length < 3) {
        $('#err_category_name').text(category_name_length);  
        return false;
      }
      else{
        $("#err_category_name").text("");
      }
//category name validation complite.
    });

    $("#category_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var category_name = $('#category_name').val();
        if(category_name==null || category_name==""){
          $("#err_category_name").text(category_name_empty);
          return false;
        }
        else{
          $("#err_category_name").text("");
        }
        if (!category_name.match(name_regex)) {
          $('#err_category_name').text(category_name_invalid);  
          return false;
        }
        else{
          $("#err_category_name").text("");
        }
        if (category_name.length < 3) {
          $('#err_category_name').text(category_name_length);  
          return false;
        }
        else{
          $("#err_category_name").text("");
        }
    });
   
}); 
</script>