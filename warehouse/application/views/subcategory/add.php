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
          <li><a href="<?php echo base_url('subcategory'); ?>">Subcategory </a></li>
          <li class="active"><!-- Add Subcategory --><?php echo $this->lang->line('subcategory_label_add'); ?></li>
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
              <h3 class="box-title"><!-- Add New Subcategory --><?php echo $this->lang->line('subcategory_newcategory'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                <form role="form" id="form" method="post" action="<?php echo base_url('subcategory/addSubcategory');?>">
                  <div class="form-group">
                    <label for="category"><!-- Select Category  --><?php echo $this->lang->line('product_select'); ?><span class="validation-color">*</span></label>
                    <a class="pull-right" href="<?php echo base_url('category/add'); ?>">+ Add Category</a> 
                    <select class="form-control select2" id="category" name="category" style="width: 100%;">
                      <option value="">Select</option>
                      <?php
                        foreach ($data as $row) {
                          echo "<option value='$row->category_id'".set_select('category',$row->category_id).">$row->category_name</option>";
                        }
                      ?>
                    </select>
                    <span class="validation-color" id="err_category"><?php echo form_error('category'); ?></span>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label for="subcategory_name"><!-- Subcategory Name  --><?php echo $this->lang->line('product_name'); ?><span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" value="<?php echo set_value('subcategory_name'); ?>">
                    <span class="validation-color" id="err_subcategory_name"><?php echo form_error('subcategory_name'); ?></span>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<!-- Add --><?php echo $this->lang->line('subcategory_add'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('subcategory')"><!-- Cancel --><?php echo $this->lang->line('subcategory_cancel'); ?></span>
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
  $(document).ready(function(){
    var subcategory_name_empty = "Please Enter Subategory.";
    var subcategory_name_invalid = "Please Enter Valid Subategory Name";
    var subcategory_name_length = "Please Enter Subcategory Name Minimun 3 Character";
    var category_select = "Please Select Category."
    $("#submit").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var subcategory_name = $('#subcategory_name').val().trim();
      var category = $('#category').val();

      if(category == "" || category == null){
        $('#err_category').text(category_select);
      }
      else{
        $('#err_category').text("");
      }
//select category validation copmlite.

      $('#subcategory_name').val(subcategory_name);
      if(subcategory_name==null || subcategory_name==""){
        $("#err_subcategory_name").text(subcategory_name_empty);
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (!subcategory_name.match(name_regex) ) {
        $('#err_subcategory_name').text(subcategory_name_invalid);   
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (subcategory_name.length < 3) {
        $('#err_subcategory_name').text(subcategory_name_length);  
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
//subcategory name validation complite.
    });

    $("#subcategory_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var subcategory_name = $('#subcategory_name').val();
      if(subcategory_name==null || subcategory_name==""){
        $("#err_subcategory_name").text(subcategory_name_empty);
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (!subcategory_name.match(name_regex) ) {
        $('#err_subcategory_name').text(subcategory_name_invalid);   
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (subcategory_name.length < 3) {
        $('#err_subcategory_name').text(subcategory_name_length);  
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
    });
    $('#category').change(function(){
      var category = $('#category').val();
      if(category == "" || category == null){
        $('#err_category').text(category_select);
      }
      else{
        $('#err_category').text("");
      }
    });
}); 
</script>
