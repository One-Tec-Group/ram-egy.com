<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager','sales_person');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('<?php echo $this->lang->line('piece_delete_conform'); ?>'))
     {
        window.location.href='<?php  echo base_url('pieces/delete/'); ?>'+id;
     }
  }
  $(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function() {
        $(".message").hide('blind', {}, 500)
    }, 5000);
  });
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('header_pieces'); ?></li>
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
              <h3 class="box-title"><?php echo $this->lang->line('pieces_list_pieces'); ?></h3>
          <?php
          if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser"){
          ?>
              <a class="btn btn-sm btn-info pull-right btn-flat" style="margin-right: 10px" href="<?php echo base_url('pieces/add');?>"><?php echo $this->lang->line('pieces_add_new_piece'); ?></a>
              <a class="btn btn-sm btn-success pull-right btn-flat" style="margin-right: 10px" href="<?php echo base_url('pieces/import');?>">Import Pieces</a>
              <a class="btn btn-sm btn-default btn-flat pull-right" style="margin-right: 10px" href="<?php echo base_url('pieces/pieces_barcode');?>" onclick="window.open(this.href,'popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no'); return false;">Pieces Barcode</a>
        <?php
          }
        ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_no'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_image'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_code'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_hsn_sac_code'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_name'); ?></th>
                    <th style="font-size: 12px;" width=10%><?php echo $this->lang->line('product_cost').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th style="font-size: 12px;" width=10%><?php echo $this->lang->line('product_price').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_quantity'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_unit'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_alert_quantity'); ?></th>
                    <?php
                        if($this->session->userdata('type')!="sales_person"){
                    ?>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_action'); ?></th>
                    <?php
                        }
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                      $no = 0;
                      foreach ($data as $row) {
                         $id= $row->piece_id;

                    ?>
                    <tr>
                      <td><?php echo ++$no; ?></td>
                      <td width="5%"><img src="<?php if($row->image == null) {echo base_url('assets/images')."/no_image.png";}else{echo $row->image;} ?>" width="100%" height="10%"></td>
                      <td><?php echo $row->code; ?></td>
                      <td><?php echo $row->hsn_sac_code; ?></td>
                      <td><?php echo $row->name; ?></td>
                      <td align="right"><?php echo $row->cost;?></td>
                      <td align="right"><?php echo $row->price;?></td>

                      <td><?php

                        if($this->session->userdata('type')=="sales_person"){
                          echo $row->w_quantity;
                        }else if($this->session->userdata('type')=="admin"){
                          echo $row->quantity;
                        }


                      ?></td>

                      <td><?php echo $row->unit; ?></td>
                      <td><?php echo $row->alert_quantity; ?></td>
                      <?php
                          if($this->session->userdata('type')!="sales_person"){
                      ?>
                      <td>
                          <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                          <a href="<?php echo base_url('pieces/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                      <?php
                          }
                      ?>

                    <?php
                      }
                    ?>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_no'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_image'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_code'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_hsn_sac_code'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_name'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_cost').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_price').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_quantity'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_unit'); ?></th>
                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_alert_quantity'); ?></th>
                    <?php
                        if($this->session->userdata('type')!="sales_person"){
                    ?>
                    <th><?php echo $this->lang->line('product_action'); ?></th>
                    <?php
                        }
                    ?>
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
  </div><?php
  $this->load->view('layout/footer');
?>
