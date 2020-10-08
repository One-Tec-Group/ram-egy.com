<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('sales_person');
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
        window.location.href='<?php  echo base_url('branch/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><!-- Branch --> <?php echo $this->lang->line('branch_label'); ?></li>
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
              <h3 class="box-title"><!-- List Branch --><?php echo $this->lang->line('customer_list'); ?></h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('customer/add');?>" title="Add New Branch" onclick=""><!-- Add New Branch --> <?php echo $this->lang->line('branch_label_newbranch'); ?></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><!-- No -->
                      <?php echo $this->lang->line('customer_lable_no'); ?>
                  </th>
                  <th><!-- Name -->
                      <?php echo $this->lang->line('customer_name'); ?>
                  </th>
                  <th><!-- Company -->
                      <?php echo $this->lang->line('customer_gstin'); ?>                    
                  </th>
                  <th><!-- Phone -->
                      <?php echo $this->lang->line('customer_mobile'); ?>
                  </th>
                  <th><!-- Email Address -->
                      <?php echo $this->lang->line('customer_email'); ?>
                  </th>
                  <th><!-- city -->
                      <?php echo $this->lang->line('customer_city'); ?>
                  </th>
                  <th><!-- Company name -->
                      <?php echo $this->lang->line('customer_company_name'); ?>
                  </th>
                  
                </tr>
                </thead>
                <tbody>
                  <?php 
                    $id = 0;
                    foreach ($customer as $row) {
                       //$id= $row->branch_id;
                  ?>
                  <tr>
                    <td><?php echo ++$id; ?></td>
                    <td><?php echo $row->customer_name; ?></td>
                    <td><?php echo $row->gstid; ?></td>
                    <td><?php echo $row->mobile; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td><?php echo $row->ctname; ?></td>
                    <td><?php echo $row->company_name; ?></td>
                    
                  <?php
                    }
                  ?>
                <tfoot>
                <tr>
                  <th><!-- No -->
                      <?php echo $this->lang->line('customer_lable_no'); ?>
                  </th>
                  <th><!-- Name -->
                      <?php echo $this->lang->line('customer_name'); ?>
                  </th>
                  <th><!-- Company -->
                      <?php echo $this->lang->line('customer_gstin'); ?>                    
                  </th>
                  <th><!-- Phone -->
                      <?php echo $this->lang->line('customer_mobile'); ?>
                  </th>
                  <th><!-- Email Address -->
                      <?php echo $this->lang->line('customer_email'); ?>
                  </th>
                  <th><!-- city -->
                      <?php echo $this->lang->line('customer_city'); ?>
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
