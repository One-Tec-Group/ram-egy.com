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
     if(confirm('<?php echo $this->lang->line('product_delete_conform'); ?>'))
     {
        window.location.href='<?php  echo base_url('sales/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('header_sales'); ?></li>
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
      <?php
        if($no_sales_person = $this->session->flashdata('no_sales_person')){
      ?>
        <div class="col-sm-12 no_purchaser">
          <div class="alert alert-info ">
            <button class="close" data-dismiss="alert" type="button">×</button>
              <?php echo $no_sales_person; ?>
              <a href="<?php echo base_url('biller/add'); ?>" class="btn btn-sm bg-yellow no-border">Create Saler Person / Biller</a>
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
              <h3 class="box-title"><?php echo $this->lang->line('sales_list_sales'); ?></h3>
              <a class="btn btn-sm btn-info pull-right" href="<?php echo base_url('sales/add');?>" title="Add New Purchase"><?php echo $this->lang->line('sales_add_new_sales'); ?> </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="overflow-y: auto;">
              <table id="log_datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('purchase_date'); ?></th>
                  <!-- <th><?php echo "Invoice No"; ?></th> -->
                  <th><?php echo $this->lang->line('sales_biller'); ?></th>
                  <th><?php echo $this->lang->line('sales_customer'); ?></th>
                  <th><?php echo $this->lang->line('sales_sales_status'); ?></th>
                  <th><?php echo $this->lang->line('purchase_grand_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_paid').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th>Balance Amount<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_payment_status'); ?></th>
                  <th><?php echo $this->lang->line('product_action'); ?></th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                      foreach ($data as $row) {
                         $id= $row->sales_id;                         
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->date; ?></td>
                      <?php
                        if($this->session->userdata('type')=='admin'){
                      ?>
                        <td><a href="<?php echo base_url('sales/billerView/').$row->biller_id; ?>"><?php echo $row->biller_name ?></a> (<a href="<?php echo base_url('sales/view/').$id; ?>"><?php echo $row->reference_no; ?></a>)</td>
                        <td><a href="<?php echo base_url('sales/customerView/').$row->customer_id; ?>"><?php echo $row->customer_name ?></a></td>
                      <?php
                        }
                        else{
                      ?>
                        <td><?php echo $row->reference_no; ?></td>
                        <td><?php echo $row->biller_name ?></td>
                        <td><?php echo $row->customer_name ?></td>
                      <?php
                        }
                      ?>
                      <td align="center"><span class="label label-success"><?php echo $this->lang->line('sales_complited'); ?></span></td>
                      <td align="right"><?php echo round($row->total) ?></td>
                      <td align="right">
                        <?php
                          if($row->paid_amount != null){
                            echo round($row->paid_amount);
                          }
                          else{
                            echo "0";
                          }
                        ?>
                      </td>
                    <td align="right"><?php echo round($row->total-$row->paid_amount);?></td>

                    <td align="center">
                      <?php if($row->paid_amount == 0.00){ ?>
                        <span class="label label-danger"><?php echo $this->lang->line('sales_pending'); ?></span>
                      <?php }elseif($row->paid_amount < $row->total){ ?>
                        <span class="label label-warning">Partial</span>
                      <?php }else{ ?>
                        <span class="label label-success"><?php echo $this->lang->line('sales_complited'); ?></span>
                      <?php } ?>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn btn-default gropdown-toggle" data-toggle="dropdown">
                          <?php echo $this->lang->line('product_action'); ?>
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                          <li>
                            <a href="<?php echo base_url('sales/view/');?><?php echo $id; ?>"><i class="fa fa-file-text-o"></i><?php echo $this->lang->line('sales_sales_details'); ?></a>
                          </li>
                          <?php if($row->paid_amount != $row->total){ ?>
                          <li>
                            <a href="<?php echo base_url('sales/receipt/'); ?><?php echo $id; ?>"><i class="fa fa-money"></i><?php echo $this->lang->line('sales_add_payment'); ?></a>
                          </li>
                          <?php } ?>
                          <?php if($row->paid_amount == 0.00){ ?>
                          <li>
                            <a href="<?php echo base_url('sales/edit/'); ?><?php echo $id; ?>"><i class="fa fa-edit"></i><?php echo $this->lang->line('sales_edit_sales'); ?></a>
                          </li>
                          <?php } ?>
                          <li>
                            <a href="<?php echo base_url('sales/pdf/');?><?php echo $id; ?>" target="_blank  "><i class="fa fa-file-pdf-o"></i><?php echo $this->lang->line('purchase_download_as_pdf'); ?></a>
                          </li>
                          <li>
                            <a href="<?php echo base_url('sales/ewaybill/');?><?php echo $id; ?>" target="_blank  "><i class="fa fa-file-pdf-o"></i><?php echo "Generate Ewaybill"; ?></a>
                          </li>
                          <li>
                            <a href="<?php echo base_url('sales/email/'); ?><?php echo $id; ?>"><i class="fa fa-envelope"></i><?php echo $this->lang->line('sales_email_sales'); ?></a>
                          </li>
                        
                          <?php if($row->paid_amount == 0.00){ ?>
                          <li>
                            <a href="javascript:delete_id(<?php echo $id;?>)"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('sales_delete_sales'); ?></a>
                          </li>
                          <?php } else{?>
                          <li>
                            <a href="<?php echo base_url('sales/credit_note/'); ?><?php echo $id; ?>"><i class="fa fa-file-o"></i>Create Credit Note</a>
                          </li>
                          <?php }?>
                        </ul>
                      </div>
                       <?php if($row->paid_amount == 0.00 ){ ?>
                        <a href="<?php echo base_url('sales/receipt/'); ?><?php echo $id; ?>" class="btn btn-info">Pay Now</a>
                      <?php }elseif($row->paid_amount < ($row->total-$row->flat_discount)){ ?>
                        <a class="btn btn-info" href="<?php echo base_url('sales/receipt/'); ?><?php echo $id; ?>">Pay Now</a>
                      <?php }?>
                    </td>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('purchase_date'); ?></th>
                  <th><?php echo "Invoice No"; ?></th>
                  <!-- <th><?php echo $this->lang->line('sales_biller'); ?></th> -->
                  <th><?php echo $this->lang->line('sales_customer'); ?></th>
                  <th><?php echo $this->lang->line('sales_sales_status'); ?></th>
                  <th><?php echo $this->lang->line('purchase_grand_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_paid').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th>Balance Amount<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_payment_status'); ?></th>
                  <th><?php echo $this->lang->line('product_action'); ?></th>
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
