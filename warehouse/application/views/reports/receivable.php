<?php
$this->load->view('layout/header');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="active">Receivable Amount Report</li>
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
              <form target="" id="edit-profile" method="post" action="<?php echo base_url('reports/receivable_report');?>">
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
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Receivable Amount Report </h3>
            </div>
          </form>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="log_datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Date</th>
                  <th>Customer</th>
                  <th>Invoice No</th>
                  <th>Sales Amount</th>
                  <th>Received Amount</th>
                  <th>Due Amount</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                      $sales = 0;
                      $paid = 0;
                      foreach ($data as $row) {
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->invoice_date; ?></td>
                      <td><a href="<?php echo base_url('sales/customerView/').$row->customer_id; ?>"><?php echo $row->customer_name ?></a></td>
                      <td><a href="<?php echo base_url('sales/view/').$row->sales_id; ?>"><?php echo $row->invoice_no; ?></a></td>
                      <td align="right"><?php echo $row->sales_amount; ?></td>
                      <td align="right"><?php echo $row->paid_amount; ?></td>
                      <td align="right"><?php echo number_format((float)($row->sales_amount-$row->paid_amount), 2, '.', ''); ?></td>
                    <?php
                        $sales += $row->sales_amount;
                        $paid += $row->paid_amount;
                      }
                    ?>
                <tfoot>
                <tr>
                  <td colspan="4" align="right" style="background-color: #f5f5f5;font-weight: bold;">Total</td>
                  <td align="right" style="background-color: #f5f5f5;font-weight: bold;"><?php echo $sales; ?></td>
                  <td align="right" style="background-color: #f5f5f5;font-weight: bold;"><?php echo $paid; ?></td>
                  <td align="right" style="background-color: #f5f5f5;font-weight: bold;"><?php echo $sales-$paid; ?></td>
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
    $('#print').click(function(){
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