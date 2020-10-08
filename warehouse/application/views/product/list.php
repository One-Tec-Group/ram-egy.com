<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin', 'manager', 'sales_person');
if (!(in_array($this->session->userdata('type'), $p))) {
    redirect('auth');
}
$this->load->view('layout/header');
?>
<script type="text/javascript">
    function delete_id(id)
    {
        if (confirm('<?php echo $this->lang->line('product_delete_conform'); ?>'))
        {
            window.location.href = '<?php echo base_url('product/delete/'); ?>' + id;
        }
    }
    $(function () {
        setTimeout(function () {
            $(".message").hide('blind', {}, 500)
        }, 5000);
    });
</script>
<div class="content-wrapper">
    <section class="content-header">
        <h5>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('header_dashboard'); ?></a></li>
                <li class="active"><?php echo $this->lang->line('header_product'); ?></li>
            </ol>
        </h5>
    </section>

    <?php
    if ($no_of_warehouse == 0 || $no_of_category == 0) {
        ?>
        <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($no_of_warehouse == 0) { ?>
                        <a type="button" name="warehouse" class="btn bg-orange margin pull-right" href="<?php echo base_url('warehouse/add'); ?>">Add Warehouse</a>
                    <?php } ?>

                    <?php if ($no_of_category == 0) { ?>
                        <a type="button" name="category" class="btn bg-orange margin pull-right" href="<?php echo base_url('category/add'); ?>">Add Category</a>
                    <?php } ?>

                </div>
            </div>
        </section>
        <?php
    }
    ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($this->session->flashdata('success') != '') {
                    ?>
                    <div class="alert alert-success message">
                        <p><?php echo $this->session->flashdata('success'); ?></p>
                    </div>
                    <?php
                }
                if ($this->session->flashdata('fail') != '') {
                    ?>
                    <div class="alert alert-danger message">
                        <p><?php echo $this->session->flashdata('fail'); ?></p>
                    </div>
                    <?php
                }
                ?>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('product_list_product'); ?></h3>
                        <?php
                        if ($this->session->userdata('type') == "admin" || $this->session->userdata('type') == "purchaser") {
                            if ($no_of_warehouse == 0 || $no_of_category == 0) {
                                ?>
                                <a class="btn btn-sm btn-info pull-right btn-flat disabled" style="margin-right: 10px" href="<?php echo base_url('product/add'); ?>"><?php echo $this->lang->line('product_add_new_product'); ?></a>
                                <a class="btn btn-sm btn-success pull-right btn-flat disabled" style="margin-right: 10px" href="<?php echo base_url('product/import'); ?>">Import Products</a>
                                <a class="btn btn-sm btn-default btn-flat pull-right disabled" style="margin-right: 10px" href="<?php echo base_url('product/products_barcode'); ?>" onclick="window.open(this.href, 'popUpWindow', 'height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no'); return false;">Products Barcode</a>
                                <?php
                            } else {
                                ?>
                                <a class="btn btn-sm btn-info pull-right btn-flat" style="margin-right: 10px" href="<?php echo base_url('product/add'); ?>"><?php echo $this->lang->line('product_add_new_product'); ?></a>
                                <a class="btn btn-sm btn-success pull-right btn-flat" style="margin-right: 10px" href="<?php echo base_url('product/import'); ?>">Import Products</a>
                                <a class="btn btn-sm btn-default btn-flat pull-right" style="margin-right: 10px" href="<?php echo base_url('product/products_barcode'); ?>" onclick="window.open(this.href, 'popUpWindow', 'height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no'); return false;">Products Barcode</a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="box-body">
                        <table id="index" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_no'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_image'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_code'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_name'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('header_category'); ?></th>
                                    <th style="font-size: 12px;" width=10%><?php echo $this->lang->line('product_cost') . '(' . $this->session->userdata('symbol') . ')'; ?></th>
                                    <th style="font-size: 12px;" width=10%><?php echo $this->lang->line('product_price') . '(' . $this->session->userdata('symbol') . ')'; ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_quantity'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_unit'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_alert_quantity'); ?></th>
                                    <?php
                                    if ($this->session->userdata('type') != "sales_person") {
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
                                    $id = $row->product_id;
                                    ?>
                                    <tr>
                                        <td><?php echo ++$no; ?></td>
                                        <td width="5%"><img src="<?php
                                            if ($row->image == null) {
                                                echo base_url('assets/images') . "/no_image.png";
                                            } else {
                                                echo $row->image;
                                            }
                                            ?>" width="100%" height="10%"></td>
                                        <td><?php echo $row->code; ?></td>
                                        <td><?php echo $row->name; ?></td>
                                        <td><?php echo $row->category_name; ?></td>
                                        <td align="right"><?php echo $row->cost; ?></td>
                                        <td align="right"><?php echo $row->price; ?></td>
                                        <td id="PQ_<?= $id; ?>"><?php
                                            if ($this->session->userdata('type') == "sales_person") {
                                                echo $row->w_quantity;
                                            } else if ($this->session->userdata('type') == "admin") {
                                                echo $row->quantity . '&nbsp;&nbsp;<a href="javascript:;" data-id="' . $id .'" data-quantity="' . $row->quantity . '" class="label label-success extend_quntity" title="Add Quantity"><b>+</b></a>';
                                            }
                                            ?></td>
                                        <td><?php echo $row->unit; ?></td>
                                        <td><?php echo $row->alert_quantity; ?></td>
                                        <?php
                                        if ($this->session->userdata('type') != "sales_person") {
                                            ?>
                                            <td>
                                                <a href="<?php echo base_url('product/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                                                <a href="javascript:delete_id(<?php echo $id; ?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_no'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_image'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_code'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_name'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('header_category'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_cost') . '(' . $this->session->userdata('symbol') . ')'; ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_price') . '(' . $this->session->userdata('symbol') . ')'; ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_quantity'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_unit'); ?></th>
                                    <th style="font-size: 12px;"><?php echo $this->lang->line('product_alert_quantity'); ?></th>
                                        <?php
                                        if ($this->session->userdata('type') != "sales_person") {
                                            ?>
                                        <th><?php echo $this->lang->line('product_action'); ?></th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $("#index").delegate(".extend_quntity", "click", function() {
       var id = $(this).attr("data-id");
       var Qty = $(this).attr("data-quantity");
       $(this).parent().html('<input name="new_Qty_' + id + '" type="number" min="' + Qty + '" id="new_Qty_' + id + '" value="' + Qty + '" style="width:85px;" class="form-control"><a href="javascript:;"  data-id="' + id + '" class="label label-success confirm_extend_quntity">ADD</a> <a href="javascript:;"  data-id="' + id + '" data-quantity="' + Qty + '" class="label label-danger cancel_extend_quntity">X</a>');
    });

    $("#index").delegate(".confirm_extend_quntity", "click", function() {
       var id = $(this).attr("data-id");
       var Qty = $('#new_Qty_' + id).val();
       $.ajax({
           url: "<?php echo base_url('product/editQuantity') ?>",
           type: "POST",
           data: "productID=" + id + "&productQty=" + Qty,
           success: function (response) {
              if(response == "SUCCESS"){
                  $('#new_Qty_' + id).parent().html(Qty + '&nbsp;&nbsp;<a href="javascript:;" data-id="' + id + '" data-quantity="' + Qty + '" class="label label-success extend_quntity" title="Add Quantity"><b>+</b></a>');
              }
           }
       });
    });

    $("#index").delegate(".cancel_extend_quntity", "click", function() {
       var id = $(this).attr("data-id");
       var Qty = $(this).attr("data-quantity");
       $(this).parent().html(Qty + '&nbsp;&nbsp;<a href="javascript:;" data-id="' + id + '" data-quantity="' + Qty + '" class="label label-success extend_quntity" title="Add Quantity"><b>+</b></a>');
    });
</script>

<?php $this->load->view('layout/footer'); ?>
