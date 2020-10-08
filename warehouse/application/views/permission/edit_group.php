<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>

<div class="content-wrapper">

    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i>
                 <!-- Dashboard -->
                <?php echo $this->lang->line('header_dashboard'); ?>
              </a>
            </li>
          <li class="active"><a href="<?php echo base_url("permission") ?>">User Roles</a></li>
          <li class="active">Edit User Role</li>
        </ol>
      </h5> 
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
 
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><center>
                      <!-- Create User Role -->
                      <?php echo $this->lang->line('lbl_add_userrole_header');?>
                    </center></h3>
            </div>
            <!-- /.box-header -->
            <form action="<?php echo base_url();?>permission/edit" method="post" id="role" name="role" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" name="role_id" value="<?php echo $role->group_id;?>">
                  <label class="col-sm-2 control-label require" for="rolename">
                      <!-- Name -->
                      <?php echo $this->lang->line('lbl_add_userrole_name');?>
                  </label>
                  <div class="col-sm-4">
                    <input type="text" placeholder="Role Name" class="form-control" id="rolename" name="rolename" onblur='chkEmpty("role","rolename","Please Enter Role Name")' value="<?php echo $role->group_name;?>">
                    <span style="font-size:20px;"></span>
                    <p style="color:#990000;"></p>
                    </span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label require" for="description">          <!-- Description -->
                        <?php echo $this->lang->line('lbl_userrole_desc');?>
                  </label>
                  <div class="col-sm-4">
                    <input type="text" placeholder="Description" class="form-control valdation_check" id="description" name="description" onblur='chkEmpty("role","description","Please Enter Description")' value="<?php echo $role->group_name;?>">
                    <span style="font-size:20px;"></span>
                    <p style="color:#990000;"></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                      <h3>
                        <!-- Permissions -->
                        <?php echo $this->lang->line('lbl_add_userrole_permission');?>
                      </h3>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12">
                    <input type="checkbox" name="test" id="test" value=""> <label for="test">Check All</label>
                  </div>
                </div>
                <br>
                <div class="row">
                  <?php foreach ($permission as $value) {?>
                  <div class="col-sm-3">
                    <input type="checkbox" name="permission[]" id="<?php echo $value->id;?>" value="<?php echo $value->id;?>" <?php foreach ($roles as $r) {
                              if($r->permission_id == $value->id){ echo 'checked="checked"';}}?>>&nbsp;&nbsp;&nbsp;
                          
                    <label for="<?php echo $value->id;?>"><?php echo $value->display_name;?></label>
                  </div>
                  <?php } ?>
                </div>  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <center>
                  <input type="submit" name="rolesubmit" class="btn btn-info btn-flat" value="<?php echo $this->lang->line('btn_submit');?>">
                  <a href="<?php echo base_url();?>permission/" class="btn btn-default btn-flat"><!-- Cancel --><?php echo $this->lang->line('btn_cancel');?></a>
                </center>
              </div>
              <!-- /.box-footer -->
            </form>
            <!-- /.box-body -->
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
<?php 
  $this->load->view('layout/footer');
  $this->load->view('layout/validation');
?>

<script type="text/javascript">
$(document).ready(function(){
  $("input[name='rolesubmit']").click(function(e){
    var role=chkEmpty("role","rolename","Please Enter Role Name");
    var desc=chkEmpty("role","description","Please Enter Description");
    
    if((role + desc) < 1){
      role.submit();
      return true;
    }else{
      return false;
    }
    
  });

  $("#test").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
  });
});


</script>