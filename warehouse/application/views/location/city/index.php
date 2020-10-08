<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='<?php  echo base_url('location/deleteCity/'); ?>'+id;
     }
  }
  $(function() {    
    setTimeout(function() {
        $(".message").hide('blind', {}, 100)
    }, 2000);
  });
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><?php echo "City"; ?></li>
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
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
                <li><a href="<?php echo base_url('location/country'); ?>"><i class="fa fa-circle-o text-red"></i>Country</a></li>
                <li><a href="<?php echo base_url('location/state'); ?>"><i class="fa fa-circle-o text-yellow"></i>State</a></li>
                <li><a href="<?php echo base_url('location/city'); ?>"><i class="fa fa-circle-o text-light-blue"></i>City</a></li>
              </ul>
            </div>
          </div>
        </div>
      <!-- right column -->
        <div class="col-md-9">
          <?php 
            if ($this->session->flashdata('success') != ''){ 
          ?>
          <div class="alert alert-success message">    
            <p><?php echo $this->session->flashdata('success');?></p>
          </div>
          <?php
            }
          ?>

          <?php 
            if ($this->session->flashdata('fail') != ''){ 
          ?>
          <div class="alert alert-danger message">    
            <p><?php echo $this->session->flashdata('fail');?></p>
          </div>
          <?php
            }
          ?>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><!-- List Category -->
                  <?php echo "City"; ?>
              </h3>
              <a class="btn btn-sm btn-info pull-right" style="margin-right: 10px" href="<?php echo base_url('location/addCity');?>" title="Add New City" onclick=""><!-- Add New Category --> <?php echo "Add City"; ?>
              </a>
            </div>
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th><!-- No --><?php echo $this->lang->line('category_lable_no'); ?></th>
                    <th><!-- Category Code --><?php echo "City"; ?></th>
                    <th><!-- Category Code --><?php echo "State"; ?></th>
                    <th><!-- Actions --><?php echo "Country"; ?></th>
                    <th><!-- Actions --><?php echo "Action"; ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      $country = $this->db->get_where('countries',array('id'=>$country_id))->row()->name;
                      $state = $this->db->get_where('states',array('id'=>$state_id))->row()->name;
                      foreach ($data as $row) {
                      $id= $row->id;
                  ?>
                  <tr>
                    <td></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $state; ?></td>
                    <td><?php echo $country; ?></td>
                    
                    <td>
                        <a href="<?php echo base_url('location/addCity/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                        <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th><!-- No --><?php echo $this->lang->line('category_lable_no'); ?></th>
                    <th><!-- Category Code --><?php echo "City"; ?></th>
                    <th><!-- Category Code --><?php echo "State"; ?></th>
                    <th><!-- Actions --><?php echo "Country"; ?></th>
                    <th><!-- Actions --><?php echo "Action"; ?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
            
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
