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
        window.location.href='<?php  echo base_url('bank_account/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active">Bank Account
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
              <h3 class="box-title">List Bank Account
              </h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('bank_account/add');?>">Add New Bank Account</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="log_datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Account Name</th>
                  <th>Account Type</th>
                  <th>Account Number</th>
                  <th>Bank Name</th>
                  <th>Bank Address</th>
                  <th>Balance</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($data as $row) {
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->account_name; ?></td>
                      <td><?php echo $row->account_type; ?></td>
                      <td><?php echo $row->account_no; ?></td>
                      <td><?php echo $row->bank_name; ?></td>
                      <td><?php echo $row->bank_address; ?></td>
                      <td><?php echo $row->opening_balance; ?></td>
                      <td>
                          <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                          <a href="<?php echo base_url('bank_account/edit/'); ?><?php echo $row->id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="javascript:delete_id(<?php echo $row->id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Account Name</th>
                  <th>Account Type</th>
                  <th>Account Number</th>
                  <th>Bank Name</th>
                  <th>Bank Address</th>
                  <th>Balance</th>
                  <th>Action</th>
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
