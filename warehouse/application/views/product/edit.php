<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin', 'manager');
if (!(in_array($this->session->userdata('type'), $p))) {
    redirect('auth');
}
$this->load->view('layout/header');
?>
<div class="content-wrapper">
    <section class="content-header">
        <h5>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
                <li><a href="<?php echo base_url('product'); ?>"><?php echo $this->lang->line('header_product'); ?></a></li>
                <li class="active"><?php echo $this->lang->line('header_edit_product'); ?></li>
            </ol>
        </h5>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('header_edit_product'); ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <form role="form" id="form" method="post" action="<?php echo base_url('product/editProduct'); ?>" encType="multipart/form-data">
                                <?php foreach ($data as $row) { ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code"><?php echo $this->lang->line('product_product_code'); ?><span class="validation-color">*</span></label>
                                            <input type="text" class="form-control" id="code" name="code" value="<?php echo $row->code; ?>" readonly>
                                            <input type="hidden" name="id" value="<?php echo $row->product_id; ?>">
                                            <span class="validation-color" id="err_code"><?php echo form_error('code'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="name"><?php echo $this->lang->line('product_product_name'); ?> <span class="validation-color">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row->name; ?>">
                                            <span class="validation-color" id="err_name"><?php echo form_error('name'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="category"><?php echo $this->lang->line('product_select_category'); ?> <span class="validation-color">*</span></label><a href="" data-toggle="modal" data-target="#category_model" class="pull-right">+ Add New Category</a>
                                            <select class="form-control select2" id="category" name="category" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                                                <?php foreach ($category as $cat) { ?>
                                                    <option value='<?php echo $cat->category_id ?>' <?php
                                                    if ($cat->category_id == $row->category_id) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $cat->category_name ?></option>
                                                        <?php } ?>
                                            </select>
                                            <span class="validation-color" id="err_category"><?php echo form_error('category'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="subcategory"><?php echo $this->lang->line('product_select_subcategory'); ?> </label><a href="" data-toggle="modal" data-target="#subcategory_model" class="pull-right">+ Add New Subcategory</a>
                                            <select class="form-control select2" id="subcategory" name="subcategory" style="width: 100%;">
                                                <option value="0"><?php echo $this->lang->line('product_select'); ?></option>
                                                <?php foreach ($subcategory as $sub) { ?>
                                                    <option value='<?php echo $row->subcategory_id ?>' <?php
                                                    if ($sub->sub_category_id == $row->subcategory_id) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $sub->sub_category_name ?></option>
                                                        <?php } ?>
                                            </select>
                                            <span class="validation-color" id="err_subcategory"><?php echo form_error('subcategory'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">
                                                Select Brand
                                                <!-- <?php echo $this->lang->line('product_select_category'); ?> -->
                                            </label><a href="" data-toggle="modal" data-target="#brand_model" class="pull-right">+ Add New Brand</a>
                                            <select class="form-control select2" id="brand" name="brand" style="width: 100%;">
                                                <option value="0"><?php echo $this->lang->line('product_select'); ?></option>
                                                <?php foreach ($brand as $br) { ?>
                                                    <option value='<?php echo $br->id ?>' <?php
                                                    if ($br->id == $row->brand_id) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $br->brand_name ?></option>
                                                        <?php } ?>
                                            </select>
                                            <span class="validation-color" id="err_category"><?php echo form_error('category'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="unit"><?php echo $this->lang->line('product_product_unit'); ?> <span class="validation-color">*</span></label>
                                            <select class="form-control select2" id="unit" name="unit">
                                                <option value="">Select</option>
                                                <?php foreach ($uqc as $vuqc) { ?>
                                                    <option value='<?php echo $vuqc->uom . " - " . $vuqc->description ?>' <?php
                                                    if ($vuqc->uom . " - " . $vuqc->description == $row->unit) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $vuqc->uom . ' - ' . $vuqc->description ?></option>
                                                        <?php } ?>
                                            </select>
                                            <span class="validation-color" id="err_unit"><?php echo form_error('unit'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="size"><?php echo $this->lang->line('product_product_size'); ?>  </label>
                                            <input type="text" class="form-control" id="size" name="size" value="<?php echo $row->size; ?>">
                                            <span class="validation-color" id="err_size"><?php echo form_error('size'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cost"><?php echo $this->lang->line('product_product_cost'); ?>  <span class="validation-color">*</span></label>
                                            <input type="text" class="form-control" id="cost" name="cost" value="<?php echo $row->cost; ?>">
                                            <span class="validation-color" id="err_cost"><?php echo form_error('cost'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="price"><?php echo $this->lang->line('product_product_price'); ?> <span class="validation-color">*</span></label>
                                            <input type="text" class="form-control" id="price" name="price" value="<?php echo $row->price; ?>">
                                            <span class="validation-color" id="err_price"><?php echo form_error('price'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="alert_quantity"><?php echo $this->lang->line('product_alert_quantity'); ?>  </label>
                                            <input type="text" class="form-control" id="alert_quantity" name="alert_quantity" value="<?php echo $row->alert_quantity; ?>">
                                            <span class="validation-color" id="err_alert_quantity"><?php echo form_error('alert_quantity'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="tax"><?php echo $this->lang->line('product_select_product_tax'); ?> <span class="validation-color">*</span></label><a href="" data-toggle="modal" data-target="#tax_model" class="pull-right">+ Add New Tax</a>
                                            <select class="form-control select2" id="tax" name="tax" style="width: 100%;">
                                                <option value=""><?php echo $this->lang->line('product_no_tax'); ?></option>
                                                <?php foreach ($tax as $t) { ?>
                                                    <option value='<?php echo $row->tax_id ?>' <?php
                                                    if ($t->tax_id == $row->tax_id) {
                                                        echo "selected";
                                                    }
                                                    ?>><?php echo $t->tax_name ?></option>
                                                        <?php } ?>
                                            </select>
                                            <span class="validation-color" id="err_tax"><?php echo form_error('tax'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="image"><?php echo $this->lang->line('product_product_image'); ?> </label>
                                            <input type="file" class="" id="image" name="image" value="">
                                            <input type="hidden" name="hidden_image" value="<?php echo $row->image; ?>">
                                            <span class="validation-color" id="err_image"><?php echo form_error('image'); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="note"><?php echo $this->lang->line('product_product_details'); ?></label>
                                            <textarea class="form-control" id="note" name="note"><?php echo $row->details; ?></textarea>
                                            <span class="validation-color" id="err_note"><?php echo form_error('note'); ?></span>
                                        </div>
                                    </div>
                                    <?php
                                    $piecesData = $row->p_pieces;
                                    $piecesData = explode(",", $piecesData);
                                    ?>
                                    <div id="pieces_count" class="col-md-6">
                                        <input type="hidden" id="piecesTotal" name="piecesTotal" value="<?= count($piecesData); ?>">
                                        <label for="pieces_1"><?php echo $this->lang->line('product_pieces'); ?> </label>
                                        <?php
                                        for ($i = 0; $i < count($piecesData); $i++) {
                                            $piece = str_replace(array("{", "}"), "", $piecesData[$i]);
                                            $piece = explode(":", $piece);
                                            if($i > 0){
                                              echo "<br/>";
                                            }
                                            ?>
                                            <div class="input-group">
                                                <select class="form-control select2" required id="pieces_<?= ($i + 1); ?>" name="pieces_<?= ($i + 1); ?>">
                                                    <option value=""><?php echo $this->lang->line('product_no_piece'); ?></option>
                                                    <?php
                                                    $allPieces = "";
                                                    foreach ($pieces as $row) {
                                                        $allPieces .= "<option value='$row->piece_id'" . (($piece[0] == $row->piece_id) ? " selected" : "") . ">$row->name ($row->code" . ((!empty($row->size)) ? " - " . str_replace("*", "x", $row->size) : "" ) . ")</option>";
                                                    }
                                                    echo $allPieces;
                                                    ?>
                                                </select>
                                                <div class="input-group-addon" style="border: 0px !important;padding:0px !important;margin: 0px !important;width:30% !important;">
                                                    <div class="input-group">
                                                        <input type="number" min="0" class="form-control" required id="pieces_count_<?= ($i + 1); ?>" name="pieces_count_<?= ($i + 1); ?>" placeholder="<?= $this->lang->line("pieces_count"); ?>" value="<?= $piece[1]; ?>">
                                                        <?php if($i == (count($piecesData) - 1)){ ?>
                                                        <div class="input-group-addon" data-toggle="tooltip" data-placement="top" data-original-title="New prodct piece">
                                                            <a title="Add more" class="add_more_piece" data-next-id="<?= count($piecesData) + 1; ?>" id="add_more_piece" href="javascript:;"><i class="fa fa-plus"></i></a>
                                                        </div>
                                                      <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="box-footer text-right">
                                            <button type="submit" id="submit" class="btn btn-info"><?php echo $this->lang->line('product_update'); ?></button>
                                            <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('product')"><?php echo $this->lang->line('product_cancel'); ?></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php
include('category.php');
include('subcategory.php');
include('brand.php');
include('tax.php');
$this->load->view('layout/product_footer');
?>
<script>
    $('#category').change(function () {
        var id = $(this).val();
        $('#subcategory').html('');
        $('#subcategory').append('<option value="0">Select</option>');
        $.ajax({
            url: "<?php echo base_url('product/getSubcategory') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                for (i = 0; i < data.length; i++) {
                    $('#subcategory').append('<option value="' + data[i].sub_category_id + '">' + data[i].sub_category_name + '</option>');
                }
            }
        });

    });
</script>

<script>
    $(document).ready(function () {
        $("#pieces_count").delegate(".add_more_piece", "click", function () {
            var nextID = $(this).attr("data-next-id");
            $("#pieces_count").append('<br/><div class="input-group"><select required class="form-control select2" id="pieces_' + nextID + '" name="pieces_' + nextID + '"><option value=""><?= $this->lang->line('product_no_piece'); ?></option>' + "<?= $allPieces; ?>" + '</select>'
                    + '<div class="input-group-addon" style="border: 0px !important;padding:0px !important;margin: 0px !important;width:30% !important;">'
                    + '<div class="input-group"><input type="text" class="form-control" required id="pieces_count_' + nextID + '" name="pieces_count_' + nextID + '" placeholder="<?= $this->lang->line("pieces_count"); ?>">'
                    + '<div class="input-group-addon" data-toggle="tooltip" data-placement="top" data-original-title="New prodct piece">'
                    + '<a title="Add more" class="add_more_piece" data-next-id="' + (parseInt(nextID) + 1) + '" id="add_more_piece" href="javascript:;"><i class="fa fa-plus"></i></a></div></div></div></div>');
            $("#piecesTotal").val(nextID);
            $(this).parent().remove();
        });

        $("#submit").click(function (event) {
            var name_regex = /^[-a-zA-Z\s]+$/;
            var p_name_regex = /^[-a-zA-Z0-9\s]+$/;
            var sname_regex = /^[a-zA-Z0-9]+$/;
            var num_regex = /^\$?[0-9]+(\.[0-9][0-9])?$/;
            var snum_regex = /^[0-9]+$/;
            var code = $('#code').val();
            var name = $('#name').val();
            var category = $('#category').val();
            var subcategory = $('#subcategory').val();
            var unit = $('#unit').val();
            var size = $('#size').val();
            var cost = $('#cost').val();
            var price = $('#price').val();
            var alert_quantity = $('#alert_quantity').val();
            var tax = $('#tax').val();
            var image = $('#image').val();
            var details = $('#details').val();

            if (code == null || code == "") {
                $("#err_code").text("Please Enter Product Code.");
                return false;
            } else {
                $("#err_code").text("");
            }
            if (!code.match(num_regex)) {
                $('#err_code').text(" Please Enter Valid Product Code. Ex - 1100 ");
                return false;
            } else {
                $("#err_code").text("");
            }

            if (name == null || name == "") {
                $("#err_name").text("Please Enter Product Name.");
                return false;
            } else {
                $("#err_name").text("");
            }
            if (!name.match(p_name_regex)) {
                $('#err_name').text(" Please Enter Valid Product Name ");
                return false;
            } else {
                $("#err_name").text("");
            }

            if (category == "") {
                $("#err_category").text("Select the Category.");
                return false;
            } else {
                $("#err_category").text("");
            }

            if (subcategory == "") {
                $("#err_subcategory").text("Select the Subcategory.");
                return false;
            } else {
                $("#err_subcategory").text("");
            }

            if (unit == null || unit == "") {
                $("#err_unit").text("Please Enter Product Unit.");
                return false;
            } else {
                $("#err_unit").text("");
            }

            if (size == null || size == "") {
                $("#err_size").text("Please Enter Product Size");
                return false;
            } else {
                $("#err_size").text("");
            }
            if (!size.match(sname_regex)) {
                $('#err_size').text(" Please Enter Valid Product Size ");
                return false;
            } else {
                $("#err_size").text("");
            }

            if (cost == null || cost == "") {
                $("#err_cost").text("Please Enter Product Cost");
                return false;
            } else {
                $("#err_cost").text("");
            }
            if (!cost.match(num_regex)) {
                $('#err_cost').text(" Please Enter Valid Product Cost. (Ex - 1000 or 100.10)");
                return false;
            } else {
                $("#err_cost").text("");
            }

            if (price == null || price == "") {
                $("#err_price").text("Please Enter Product Price");
                return false;
            } else {
                $("#err_price").text("");
            }
            if (!price.match(num_regex)) {
                $('#err_price').text(" Please Enter Valid Product Price. (Ex - 1000 or 100.10)");
                return false;
            } else {
                $("#err_price").text("");
            }

            if (alert_quantity == null || alert_quantity == "") {
                $("#err_alert_quantity").text("Please Enter Product Alert Quantity");
                return false;
            } else {
                $("#err_alert_quantity").text("");
            }
            if (!alert_quantity.match(sname_regex)) {
                $('#err_alert_quantity').text(" Please Enter Valid Produce Alert Quantity ");
                return false;
            } else {
                $("#err_alert_quantity").text("");
            }

            if (tax == "Product Tax") {
                $("#err_tax").text("Select the Product Tax");
                return false;
            } else {
                $("#err_tax").text("");
            }
        });

        $("#code").on("blur keyup", function (event) {
            var num_regex = /^[0-9]+$/;
            var code = $('#code').val();
            if (code == null || code == "") {
                $("#err_code").text("Please Enter Product Code.");
                return false;
            } else {
                $("#err_code").text("");
            }
            if (!code.match(num_regex)) {
                $('#err_code').text(" Please Enter Valid Product Code. Ex - 1100 ");
                return false;
            } else {
                $("#err_code").text("");
            }
        });

        $("#name").on("blur keyup", function (event) {
            var name_regex = /^[-a-zA-Z0-9\s]+$/;
            var name = $('#name').val();
            if (name == null || name == "") {
                $("#err_name").text("Please Enter Product Name.");
                return false;
            } else {
                $("#err_name").text("");
            }
            if (!name.match(name_regex)) {
                $('#err_name').text(" Please Enter Valid Product Name ");
                return false;
            } else {
                $("#err_name").text("");
            }
        });
        $("#category").change(function (event) {
            var category = $('#category').val();
            if (category == "") {
                $("#err_category").text("Select the Category.");
                return false;
            } else {
                $("#err_category").text("");
            }
        });

        $("#subcategory").change(function (event) {
            var subcategory = $('#subcategory').val();
            if (subcategory == "") {
                $("#err_subcategory").text("Select the Subcategory.");
                return false;
            } else {
                $("#err_subcategory").text("");
            }
        });

        $("#unit").on("blur keyup", function (event) {
            var name_regex = /^[-a-zA-Z\s]+$/;
            var unit = $('#unit').val();
            if (unit == null || unit == "") {
                $("#err_unit").text("Please Enter Product Unit.");
                return false;
            } else {
                $("#err_unit").text("");
            }
        });

        $("#cost").on("blur keyup", function (event) {
            var num_regex = /^\$?[0-9]+(\.[0-9][0-9])?$/;
            var cost = $('#cost').val();
            if (cost == null || cost == "") {
                $("#err_cost").text("Please Enter Product Cost");
                return false;
            } else {
                $("#err_cost").text("");
            }
            if (!cost.match(num_regex)) {
                $('#err_cost').text(" Please Enter Valid Product Cost. (Ex - 1000 or 100.10)");
                return false;
            } else {
                $("#err_cost").text("");
            }
        });
        $("#price").on("blur keyup", function (event) {
            var num_regex = /^\$?[0-9]+(\.[0-9][0-9])?$/;
            var price = $('#price').val();
            if (price == null || price == "") {
                $("#err_price").text("Please Enter Product Price");
                return false;
            } else {
                $("#err_price").text("");
            }
            if (!price.match(num_regex)) {
                $('#err_price').text(" Please Enter Valid Product Price. (Ex - 1000 or 100.10)");
                return false;
            } else {
                $("#err_price").text("");
            }
        });
    });
</script>
