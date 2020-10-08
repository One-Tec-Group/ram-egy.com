<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','accountant','manager');
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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('reports_product_reports'); ?></li>
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
            <div class="control-group">
              <div class="controls">
                <input type="submit" class="btn btn-info" id="hide1" name="submit" value="<?php echo $this->lang->line('reports_hide_show'); ?>">
              </div>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row hide1">
              <form target="" id="edit-profile" method="post" action="<?php echo base_url('reports/products_report');?>">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="product">Product</label>
                    <select class="form-control select2" id="product" name="product" style="width: 100%;">
                      <option value="">Select</option>
                      <?php

                        foreach ($products as $row) {
                          echo "<option value='$row->product_id'".set_select('product_id',$row->product_id).">$row->name( $row->code )</option>";
                        }
                      ?>
                    </select>
                    <span class="validation-color" id="err_product"><?php echo form_error('product'); ?></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="warehouse">Warehouse</label>
                    <select class="form-control select2" id="warehouse" name="warehouse" style="width: 100%;">
                      <option value="">Select</option>
                      <?php

                        foreach ($warehouse as $row) {
                          echo "<option value='$row->warehouse_id'".set_select('warehouse_id',$row->warehouse_id).">$row->warehouse_name</option>";
                        }
                      ?>
                    </select>
                    <span class="validation-color" id="err_warehouse"><?php echo form_error('warehouse'); ?></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="start_date"><?php echo $this->lang->line('reports_start_date'); ?></label>
                    <input type="text" class="form-control datepicker" id="start_date" name="start_date" value="">
                    <span class="validation-color" id="err_start_date"><?php echo form_error('start_date'); ?></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="end_date"><?php echo $this->lang->line('reports_end_date'); ?></label>
                    <input type="text" class="form-control datepicker" id="end_date" name="end_date" value="<?php echo date("Y-m-d");  ?>">
                    <span class="validation-color" id="err_end_date"><?php echo form_error('end_date'); ?></span>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="box-footer">
                    <input type="submit" class="btn btn-info" id="submit" name="submit" value="<?php echo $this->lang->line('reports_submit'); ?>">
                  </div>
                </div>
              
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $this->lang->line('reports_product_reports'); ?></h3>
              <input type="submit" class="pull-right btn btn-info btn-flat" id="pdf" name="submit" value="PDF">
              <input type="submit" class="pull-right btn btn-info btn-flat" id="csv" name="submit" value="CSV">
            </div></form>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('product_product_name'); ?></th>
                  <th><?php echo $this->lang->line('product_product_code'); ?></th>
                  <th><?php echo $this->lang->line('reports_purchased'); ?></th>
                  <th><?php echo $this->lang->line('reports_sold'); ?></th>
                  <th><?php echo $this->lang->line('purchase_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('reports_profite_title').'('.$this->session->userdata('symbol').')'; ?></th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                      foreach ($data as $row) {
                    ?>
                          <tr>
                            <td></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->code; ?></td>
                            <td><?php echo $row->pquantity; ?></td>
                            <td>
                              <?php 
                                ($row->squantity!=null)? $s = $row->squantity : $s = '0';
                                echo $s;
                              ?>
                            </td>
                            <td align="right">
                              <?php
                                ($row->sptotal!=null)? $s = $row->sptotal: $s = '0';
                                echo round($s);
                              ?>
                            </td>
                            <td align="right">
                              <?php
                                ($row->profit!=null)? $s = $row->profit: $s = '0';
                                echo round($s);
                              ?>
                            </td>
                          </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                <tfoot>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('product_product_name'); ?></th>
                  <th><?php echo $this->lang->line('product_product_code'); ?></th>
                  <th><?php echo $this->lang->line('reports_purchased'); ?></th>
                  <th><?php echo $this->lang->line('reports_sold'); ?></th>
                  <th><?php echo $this->lang->line('purchase_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('reports_profite_title').'('.$this->session->userdata('symbol').')'; ?></th>
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
<script type="text/javascript">
  $(document).ready(function(){
    $('#pdf').click(function(){
      $('form').attr('target','_blank');
    });
    $('#csv').click(function(){
      $('form').attr('target','_blank');
    });
    $('#submit').click(function(){
      $('form').attr('target','');
    });
  });
  $("#hide1").click(function(){
    $(".hide1").toggle();
  });
</script>
<script type="text/javascript">
$(document).ready(function() {

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "auto",
        todayBtn: true,
        todayHighlight: true,  
    });

});
</script>
