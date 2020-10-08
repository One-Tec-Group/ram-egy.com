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
        window.location.href='<?php  echo base_url('subcategory/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active">Subcategory</li>
        </ol>
      </h5>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
      <div class="col-md-12">
        <div class="box bo">
            <div class="box-header with-border">
              <h3 class="box-title"><!-- List Subcategory --><?php echo $this->lang->line('subcategory_lable_listcategory'); ?></h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('subcategory/add');?>" title="Add New Category" onclick=""><!-- Add New Subcategory --><?php echo $this->lang->line('subcategory_newcategory'); ?></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><!-- No --><?php echo $this->lang->line('product_no'); ?></th>
                  <th><!-- Subcategory Code --><?php echo $this->lang->line('product_code'); ?></th>
                  <th><!-- Subcategory Name --><?php echo $this->lang->line('product_name'); ?></th>
                  <th><!-- Main Category --><?php echo $this->lang->line('header_category'); ?></th>
                  <th><!-- Actions --><?php echo $this->lang->line('product_action'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                      foreach ($data as $row) {
                        $id= $row->sub_category_id;
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->sub_category_code; ?></td>
                      <td><?php echo $row->sub_category_name; ?></td>
                      <td><?php echo $row->category_name ?></td>
                      <td>
                          <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                          <a href="<?php echo base_url('subcategory/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    </tr>  
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th><!-- No --><?php echo $this->lang->line('product_no'); ?></th>
                  <th><!-- Subcategory Code --><?php echo $this->lang->line('product_code'); ?></th>
                  <th><!-- Subcategory Name --><?php echo $this->lang->line('product_name'); ?></th>
                  <th><!-- Main Category --><?php echo $this->lang->line('header_category'); ?></th>
                  <th><!-- Actions --><?php echo $this->lang->line('product_action'); ?></th>
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
