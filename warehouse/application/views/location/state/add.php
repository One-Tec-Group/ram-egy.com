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
        <li><a href="<?php echo base_url('location/state'); ?>"><!-- Category --><?php echo "State"; ?></a></li>
        <li class="active">Add State</li>
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
            <form role="form" id="form" method="post" action="<?php echo base_url('location/addState');?>">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="country"><?php echo "Country"; ?> <span class="validation-color">*</span></label>
                  <select class="form-control select2" id="country_id" name="country_id" style="width: 100%;">
                    <option value=""><?php echo $this->lang->line('add_biller_select'); ?>    </option>
                    <?php
                      foreach ($countries as  $row) {
                    ?>
                    <option value='<?php echo $row->id ?>' 
                      <?php 
                        if(isset($data->country_id)){
                          if($row->id == $data->country_id){
                            echo "selected";
                          }
                        } 
                      ?>
                    >
                    <?php echo $row->name; ?>
                    </option>
                    <?php
                      }
                    ?>
                  </select>
                  <span class="validation-color" id="err_country"><?php echo form_error('country'); ?></span>
                </div>
                <div class="form-group">
                  <label for="name">State Name<span class="validation-color">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($data->name)){ echo $data->name;} else{ echo set_value('name'); }?>">
                  <span class="validation-color" id="err_name"><?php echo form_error('name'); ?></span>
                </div>
                
              </div>
              <div class="col-sm-12">
                <div class="box-footer">
                  <input type="hidden" name="state_id" value="<?php if(isset($data->id)){echo $data->id;} ?>">
                  <button type="submit" id="submit" class="btn btn-info" style="padding-right: 10px;">Submit</button>
                  <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('location/state/')">Cancel</span>
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