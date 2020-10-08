<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');
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
        window.location.href='<?php  echo base_url('payment/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active">Receipt</li>
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <?php
        if($message = $this->session->flashdata('message')){
      ?>
        <div class="col-sm-12">
          <div class="alert alert-success">
            <button class="close" data-dismiss="alert" type="button">×</button>
              <?php echo $message; ?>
            <div class="alerts-con"></div>
          </div>
        </div>
      <?php
        }
      ?>
      <!-- right column -->
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title pull-left">List Receipt</h3>
              <a class="btn btn-sm btn-info pull-right" href="<?php echo base_url('receipt/add');?>" >Add Receipt</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="log_datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th>Receipt No</th>
                  <th>Ledger</th>
                  <th>Receipt Date</th>
                  <th>Description</th>
                  <th><?php echo $this->lang->line('sales_amount').'('.$this->session->userdata('symbol').')'; ?></th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                      foreach ($data as $row) {
                         $id= $row->id;
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->voucher_no; ?></td>
                      <td>
                        <?php echo $row->to_account; ?>
                        <?php
                          if(isset($row->invoice_no)){
                        ?>
                            (<a href="<?php echo base_url('sales/view/').$row->sales_id; ?>"><?php echo $row->invoice_no; ?></a>)
                        <?php
                          }
                        ?>
                      </td>
                      <td><?php echo $row->voucher_date; ?></td>
                      <td><?php echo $row->narration; ?></td>
                      <td><?php echo round($row->amount); ?></td>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th>Receipt No</th>
                  <th>Ledger</th>
                  <th>Receipt Date</th>
                  <th>Description</th>
                  <th><?php echo $this->lang->line('sales_amount').'('.$this->session->userdata('symbol').')'; ?></th>
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
