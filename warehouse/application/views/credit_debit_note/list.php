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
        window.location.href='<?php  echo base_url('credit_debit_note/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active">Credit/Debit Note</li>
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
              <h3 class="box-title">Credit/Debit Note List </h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('credit_debit_note/add');?>"onclick="">Add New Credit/Debit Note</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Invoice No</th>
                  <th>Note/Refund Voucher No.</th>
                  <th>Note/Refund Voucher Date</th>
                  <th>Note/Refund Voucher Value</th>
                  <th>Document Type</th>
                  <th>Pre GST</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($data as $row) {
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->invoice_no; ?></td>
                      <td><?php echo $row->note_or_refund_voucher_no; ?></td>
                      <td><?php echo $row->note_or_refund_voucher_date; ?></td>
                      <td><?php echo $row->note_or_refund_voucher_value; ?></td>
                      <td>
                        <?php 
                          if($row->document_type=='C'){
                            echo "Credit";
                          } 
                          else{
                            echo "Debit";
                          }
                        ?>
                      </td>
                      <td><?php if(isset($row->pre_gst)){ echo "Y";}else{ echo "N";} ?></td>
                      <td>
                          <a href="<?php echo base_url('credit_debit_note/edit/'); ?><?php echo $row->id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="javascript:delete_id(<?php echo $row->id; ?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    </tr>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Invoice No</th>
                  <th>Note/Refund Voucher No.</th>
                  <th>Note/Refund Voucher Date</th>
                  <th>Note/Refund Voucher Value</th>
                  <th>Document Type</th>
                  <th>Pre GST</th>
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
