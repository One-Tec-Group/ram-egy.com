<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','purchaser','manager');
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
        window.location.href='<?php  echo base_url('purchase/delete/'); ?>'+id;
     }
  }
  $(function() {
    // setTimeout(function() {
    //     $(".no_purchaser").hide('blind', {}, 500)
    // }, 5000);
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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('header_purchase'); ?></li>
        </ol>
      </h5>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <?php
        if($message = $this->session->flashdata('message')){
      ?>
        <div class="col-sm-12 message">
          <div class="alert alert-success ">
            <button class="close" data-dismiss="alert" type="button">×</button>
              <?php echo $message; ?>
            <div class="alerts-con"></div>
          </div>
        </div>
      <?php
        }
      ?>
      <?php
        if($no_purchaser = $this->session->flashdata('no_purchaser')){
      ?>
        <div class="col-sm-12 no_purchaser">
          <div class="alert alert-info ">
            <button class="close" data-dismiss="alert" type="button">×</button>
              <?php echo $no_purchaser; ?>
              <a href="<?php echo base_url('purchaser/add'); ?>" class="btn btn-sm bg-yellow no-border">Create Purchaser</a>
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
              <h3 class="box-title"><?php echo $this->lang->line('purchase_list_purchase'); ?></h3>
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('purchase/add');?>" title="Add New Purchase"><?php echo $this->lang->line('purchase_add_new_purchase'); ?></a>
            </div>
            <!-- /.box-header -->
            <div class="box-body outer-scroll">
              <div class="inner-scroll">
              <table id="log_datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('purchase_date'); ?></th>
                  <th><?php echo $this->lang->line('purchase_supplier'); ?></th>
                  <th><?php echo $this->lang->line('purchase_purchase_status'); ?></th>
                  <th><?php echo $this->lang->line('purchase_grand_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_paid').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_payment_status'); ?></th>
                  <th><?php echo $this->lang->line('product_action'); ?></th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($data as $row) {
                      $id= $row->purchase_id;
                  ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->date; ?></td>
                      <td><?php echo $row->supplier_name.' ('.$row->reference_no.')<br/>'.$row->company_name; ?></td>
                      <td align="center"><span class="label label-success"><?php echo $this->lang->line('purchase_received'); ?></span></td>
                      <td align="right"><?php echo $row->total-$row->flat_discount; ?></td>
                      <td align="right"><?php echo round($row->paid_amount); ?></td>
                      <td align="center">
                        <?php if($row->paid_amount == 0.00){ ?>
                          <span class="label label-danger"><?php echo $this->lang->line('sales_pending'); ?></span>
                        <?php }elseif($row->paid_amount < ($row->total-$row->flat_discount)){ ?>
                          <span class="label label-warning">Partial</span>
                        <?php }else{ ?>
                          <span class="label label-success"><?php echo $this->lang->line('sales_complited'); ?></span>
                        <?php } ?>
                      </td>
                      <td align="center">
                          <div class="dropdown">
                            <button type="button" class="btn btn-default gropdown-toggle" data-toggle="dropdown">
                              <?php echo $this->lang->line('product_action'); ?>
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                              <li>
                                <a href="<?php echo base_url('purchase/view/');?><?php echo $id; ?>"><i class="fa fa-file-text-o"></i><?php echo $this->lang->line('purchase_purchase_details'); ?></a>
                              </li>
                              <?php if($row->paid_amount < ($row->total-$row->flat_discount)){ ?>
                              <li>
                                <a href="<?php echo base_url('purchase/payment/'); ?><?php echo $id; ?>"><i class="fa fa-money"></i><?php echo $this->lang->line('sales_add_payment'); ?></a>
                              </li>
                              <?php }?>
                              <?php if($row->paid_amount == 0.00){ ?>
                              <li>
                                <a href="<?php echo base_url('purchase/edit/'); ?><?php echo $id; ?>"><i class="fa fa-edit"></i><?php echo $this->lang->line('purchase_edit_purchase'); ?></a>
                              </li>
                              <?php } ?>
                              <li>
                                <a href="<?php echo base_url('purchase/pdf/');?><?php echo $id; ?>" target="_blank  "><i class="fa fa-file-pdf-o"></i><?php echo $this->lang->line('purchase_download_as_pdf'); ?></a>
                              </li>
                              <li>
                                <a href="<?php echo base_url('purchase/email/');?><?php echo $id; ?>"><i class="fa fa-envelope"></i><?php echo $this->lang->line('purchase_email_purchase'); ?></a>
                              </li>
                              <li>
                                <a href="javascript:delete_id(<?php echo $id;?>)"><i class="fa fa-trash-o"></i><?php echo $this->lang->line('purchase_delete_purchase'); ?></a>
                              </li>
                            </ul>
                          </div>
                          <?php if($row->paid_amount == 0.00){ ?>
                            <a href="<?php echo base_url('purchase/payment/'); ?><?php echo $id; ?>" class="btn btn-info">Pay Now</a>
                          <?php }elseif($row->paid_amount < ($row->total-$row->flat_discount)){ ?>
                          <a class="btn btn-info" href="<?php echo base_url('purchase/payment/'); ?><?php echo $id; ?>">Pay Now</a>
                          <?php }?>
                      </td>
                    </tr>
                  <?php
                    }
                  ?>
                <tfoot>
                <tr>
                  <th><?php echo $this->lang->line('product_no'); ?></th>
                  <th><?php echo $this->lang->line('purchase_date'); ?></th>
                  <th><?php echo $this->lang->line('purchase_supplier'); ?></th>
                  <th><?php echo $this->lang->line('purchase_purchase_status'); ?></th>
                  <th><?php echo $this->lang->line('purchase_grand_total').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_paid').'('.$this->session->userdata('symbol').')'; ?></th>
                  <th><?php echo $this->lang->line('sales_payment_status'); ?></th>
                  <th><?php echo $this->lang->line('product_action'); ?></th>
                </tr>
                </tfoot>
              </table>
              </div>
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
