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
          <li><a href="<?php echo base_url('uqc'); ?>">UQC</a></li>
          <li class="active"> Add UQC</li>
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
              <h3 class="box-title">Add New UQC</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" id="form" method="post" action="<?php echo base_url('uqc/addUqc');?>">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="uom">UOM<span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="uom" name="uom" value="<?php echo set_value('uom'); ?>">
                    <span class="validation-color" id="err_uom"><?php echo form_error('uom'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="description">Description<span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="description" name="description" value="<?php echo set_value('description'); ?>">
                    <span class="validation-color" id="err_description"><?php echo form_error('description'); ?></span>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('uqc')"><!-- Cancel --><?php echo $this->lang->line('category_cancel'); ?></span>
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
<?php
  $this->load->view('layout/footer');
?>
<script>
  $(document).ready(function(){
    $("#submit").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var uom = $('#uom').val().trim();
      var description = $('#description').val().trim();
      if(uom==null || uom==""){
        $("#err_uom").text("Please Enter UOM");
        return false;
      }
      else{
        $("#err_uom").text("");
      }
//UOM name validation complite.
      if(description==null || description==""){
        $("#err_description").text("Please Enter Description");
        return false;
      }
      else{
        $("#err_description").text("");
      }
//description name validation complite.
    });

    $("#uom").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var uom = $('#uom').val();
        if(uom==null || uom==""){
        $("#err_uom").text("Please Enter UOM");
        return false;
      }
      else{
        $("#err_uom").text("");
      }
    });
    $("#description").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var description = $('#description').val();
        if(description==null || description==""){
        $("#err_description").text("Please Enter Description");
        return false;
      }
      else{
        $("#err_description").text("");
      }
    });
   
}); 
</script>