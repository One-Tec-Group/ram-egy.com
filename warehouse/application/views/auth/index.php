<?php
redirect('biller');

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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i>
               <!-- Dashboard -->
               <?php echo $this->lang->line('header_dashboard'); ?>
               </a>
          </li>
          <li class="active">
            <!-- Users -->
            <?php echo $this->lang->line('user_lable');?>
          </li>
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
              <h3 class="box-title">
                <!-- List Users -->
                <?php echo $this->lang->line('user_lable_header'); ?>
              </h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('auth/create_user');?>" title="Add New Category" onclick="">
                <!-- Add New User -->
                <?php echo $this->lang->line('user_btn_new'); ?>
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  <th><!-- Group -->
                      <?php echo $this->lang->line('user_lable_group'); ?>
                  </th>
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($users as $user):?>
                  <tr>
                    <td></td>
                    <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    <td>
                      <?php foreach ($user->groups as $group):?>
                        <?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
                              <?php endforeach?>
                    </td>
                    <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                    <td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
                  </tr>
                <?php endforeach;?>
                <tfoot>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  <th><!-- Group -->
                      <?php echo $this->lang->line('user_lable_group'); ?>
                  </th>
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </tfoot>
              </table>
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
