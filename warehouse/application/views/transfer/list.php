<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='<?php  echo base_url('transfer/delete/'); ?>'+id;
     }
  }
  $(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function() {
        $(".transfer-fail").hide('blind', {}, 500)
    }, 5000);
    setTimeout(function() {
        $(".transfer-success").hide('blind', {}, 500)
    }, 5000);
  });
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth'); ?>"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('transfer_transfers'); ?></li>
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
      <div class="col-md-12">

        <?php 
          if ($this->session->flashdata('success') != ''){ 
        ?>
        <div class="alert alert-success transfer-success">    
          <p><?php echo $this->session->flashdata('success');?></p>
        </div>
        <?php
          }
        ?>

        <?php 
          if ($this->session->flashdata('fail') != ''){ 
        ?>
        <div class="alert alert-danger transfer-fail">    
          <p><?php echo $this->session->flashdata('fail');?></p>
        </div>
        <?php
          }
        ?>
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $this->lang->line('transfer_listtransfers'); ?></h3>
              <a class="btn btn-sm btn-info pull-right btn-flat" style="" href="<?php echo base_url('transfer/add');?>" title="Add New Transfer" onclick=""><?php echo $this->lang->line('transfer_add_new_transfer'); ?></a>
              <a class="btn btn-sm btn-success pull-right btn-flat" style="margin-right: 5px;" href="<?php echo base_url('transfer/transfer');?>">Stock Transfer</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?php echo $this->lang->line('transfer_no'); ?></th>
                  <th><?php echo $this->lang->line('transfer_date'); ?></th>
                  <th><?php echo $this->lang->line('transfer_warehouse_from'); ?></th>
                  <th><?php echo $this->lang->line('transfer_warehouse_to'); ?></th>
                  <th><?php echo $this->lang->line('transfer_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('transfer_actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                      foreach ($data as $row) {
                        $id= $row->id;
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->date; ?></td>
                      <td><?php echo $row->from_warehouse_name; ?></td>
                      <td><?php echo $row->to_warehouse_name; ?></td>
                      <td><?php echo $row->total; ?></td>
                      <td>
                          <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                          <!--<a href="<?php echo base_url('transfer/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;-->
                          <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th><?php echo $this->lang->line('transfer_no'); ?></th>
                  <th><?php echo $this->lang->line('transfer_date'); ?></th>
                  <th><?php echo $this->lang->line('transfer_warehouse_from'); ?></th>
                  <th><?php echo $this->lang->line('transfer_warehouse_to'); ?></th>
                  <th><?php echo $this->lang->line('transfer_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('transfer_actions'); ?></th>
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