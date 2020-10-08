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
     if(confirm('<?php echo $this->lang->line('product_delete_conform'); ?>'))
     {
        window.location.href='<?php  echo base_url('product/delete/'); ?>'+id;
     }
  }
  $(document).ready(function(){
      $("#warehouse").change(function(){
          var warehouse_id = $(this).val();
          window.location.replace("<?php echo base_url('reports/warehouse_report') ?>/"+warehouse_id);
         
      });
  });
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('header_product'); ?></li>
        </ol>
      </h5> 
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
      <!-- right column -->
        <div class="col-md-12">
          <div class="box">
            <?php
              if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser" ){
            ?>
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $this->lang->line('product_list_product'); ?></h3>
              <div class="form-group pull-right"> 
                <form name="warehouse_change">
                  <select class="form-control pull-right select2" name="warehouse" id="warehouse">
                    <option value="0">All Warehouse</option>
                    <?php
                      foreach ($warehouse as $row) {
                    ?>
                      <option value="<?php echo $row->warehouse_id; ?>" <?php if($row->warehouse_id == $selected_warehouse) echo "selected"; ?>><?php echo $row->warehouse_name." - ".$row->branch_name; ?><?php if($row->primary_warehouse==1) echo "( Primary )"; ?></option>
                    <?php
                      }
                    ?>
                  </select>  
                </form>
              </div>
               
              
            </div>
            <?php } ?>    
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('product_no'); ?></th>
                    <th><?php echo $this->lang->line('product_image'); ?></th>
                    <th><?php echo $this->lang->line('product_code'); ?></th>
                    <th><?php echo $this->lang->line('product_hsn_sac_code'); ?></th>
                    <th><?php echo $this->lang->line('product_name'); ?></th>
                    <th><?php echo $this->lang->line('header_category'); ?></th>
                    <th width=10%><?php echo $this->lang->line('product_cost').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th width=10%><?php echo $this->lang->line('product_price').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th><?php echo $this->lang->line('product_quantity'); ?></th>
                    <th><?php echo $this->lang->line('product_unit'); ?></th>
                    <th><?php echo $this->lang->line('product_alert_quantity'); ?></th>
                    <!-- <th><?php //echo $this->lang->line('product_action'); ?></th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      foreach ($data as $row) {
                         $id= $row->product_id;
                    ?>
                    <tr>
                      <td></td>
                      <td width="5%"><img src="<?php if($row->image == null) {echo base_url('assets/images')."/no_image.png";}else{echo $row->image;} ?>" width="100%" height="10%"></td>
                      <td><?php echo $row->code; ?></td>
                      <td><?php echo $row->hsn_sac_code; ?></td>
                      <td><?php echo $row->name; ?></td>
                      <td><?php echo $row->category_name; ?></td>
                      <td align="right"><?php echo $row->cost;?></td>
                      <td align="right"><?php echo $row->price;?></td>
                      <td><?php echo $row->warehouse_quantity; ?></td>
                      <td><?php echo $row->unit; ?></td>
                      <td><?php echo $row->alert_quantity; ?></td>
                      <!-- <td>
                          <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; 
                          <a href="<?php // echo base_url('product/edit/'); ?><?php // echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="javascript:delete_id(<?php // echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td> -->
                    <?php
                      }
                    ?>
                <tfoot>
                  <tr>
                    <th><?php echo $this->lang->line('product_no'); ?></th>
                    <th><?php echo $this->lang->line('product_image'); ?></th>
                    <th><?php echo $this->lang->line('product_code'); ?></th>
                    <th><?php echo $this->lang->line('product_hsn_sac_code'); ?></th>
                    <th><?php echo $this->lang->line('product_name'); ?></th>
                    <th><?php echo $this->lang->line('header_category'); ?></th>
                    <th><?php echo $this->lang->line('product_cost').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th><?php echo $this->lang->line('product_price').'('.$this->session->userdata('symbol').')'; ?></th>
                    <th><?php echo $this->lang->line('product_quantity'); ?></th>
                    <th><?php echo $this->lang->line('product_unit'); ?></th>
                    <th><?php echo $this->lang->line('product_alert_quantity'); ?></th>
                    <!-- <th><?php // echo $this->lang->line('product_action'); ?></th> -->
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
