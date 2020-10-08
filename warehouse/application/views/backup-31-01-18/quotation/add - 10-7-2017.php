<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('quotation'); ?>">Quotation</a></li>
          <li class="active">Add Quotation</li>
        </ol>
      </h5>    
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Quotation</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('quotation/addQuotation');?>">

                <div class="col-sm-6">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="date"><?php echo $this->lang->line('purchase_date'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo date("Y-m-d");  ?>">
                          <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                        </div>
                        <?php
                          if($reference_no==null){
                              $no = sprintf('%06d',intval(1));
                          }
                          else{
                            foreach ($reference_no as $value) {
                              $no = sprintf('%06d',intval($value->quotation_id)+1); 
                            }
                          }
                        ?>
                        <div class="form-group">
                          <label for="reference_no"><?php echo $this->lang->line('purchase_reference_no'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control" id="reference_no" name="reference_no" value="SO-<?php echo $no;?>" readonly>
                          <span class="validation-color" id="err_reference_no"><?php echo form_error('reference_no'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="warehouse"><?php echo $this->lang->line('purchase_select_warehouse'); ?> <span class="validation-color">*</span></label>
                          <select class="form-control select2" id="warehouse" name="warehouse" style="width: 100%;">
                            <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                            <?php  
                              foreach ($warehouse as $row) {
                                echo "<option value='$row->warehouse_id'>$row->warehouse_name</option>";
                              }
                            ?> 
                          </select>
                          <span class="validation-color" id="err_warehouse"><?php echo form_error('warehouse');?></span>
                        </div>
                        <div class="form-group">
                          <label for="biller"><?php echo $this->lang->line('sales_select_biller'); ?> <span class="validation-color">*</span></label>
                          <select class="form-control select2" id="biller" name="biller" style="width: 100%;">
                            <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                            <?php  
                              foreach ($biller as $row) {
                                echo "<option value='$row->biller_id'>$row->biller_name</option>";
                              }
                            ?> 
                          </select>
                          <span class="validation-color" id="err_biller"><?php echo form_error('biller');?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="country"><!-- Country --> 
                              <?php echo $this->lang->line('biller_lable_country'); ?> <span class="validation-color">*</span>
                            </label>
                          <select class="form-control select2" id="country" name="country" style="width: 100%;">
                            <option value="">
                              <!-- Select -->
                              <?php echo $this->lang->line('add_biller_select'); ?>    
                            </option>
                          </select>
                          <span class="validation-color" id="err_country"><?php echo form_error('country'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="state"><!-- State --> 
                              <?php echo $this->lang->line('add_biller_state'); ?> 
                              <span class="validation-color">*</span>
                          </label>
                          <select class="form-control select2" id="state" name="state" style="width: 100%;">
                            <option value=""><!-- Select -->
                                <?php echo $this->lang->line('add_biller_select'); ?>
                                
                            </option>
                          </select>
                          <span class="validation-color" id="err_state"><?php echo form_error('state'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="city"><!-- City --> 
                              <?php echo $this->lang->line('biller_lable_city'); ?> 
                              <span class="validation-color">*</span>
                          </label>
                          <select class="form-control select2" id="city" name="city" style="width: 100%;">
                            <option value=""><!-- Select -->
                                <?php echo $this->lang->line('add_biller_select'); ?>
                                
                                </option>
                          </select>
                          <span class="validation-color" id="err_city"><?php echo form_error('city'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="address"><!-- Address --> 
                              <?php echo $this->lang->line('add_biller_address'); ?> 
                              <span class="validation-color">*</span>
                          </label>
                          <textarea class="form-control" id="address" rows="2" name="address"><?php echo set_value('address'); ?></textarea>
                          <span class="validation-color" id="err_address"><?php echo form_error('address'); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="customer">Customer <span class="validation-color">*</span></label><a href="" data-toggle="modal" data-target="#myModal" class="pull-right">+ Add New Customer</a>
                          <select class="form-control select2" id="customer" name="customer" style="width: 100%;">
                            <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                            <?php  
                              foreach ($customer as $row) {
                                echo "<option value='$row->customer_id'>$row->customer_name</option>";
                              }
                            ?> 
                          </select>
                          <span class="validation-color" id="err_customer"><?php echo form_error('customer');?></span>
                        </div>
                        
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="shipping_charge">Shipping Charge</label>
                          <input type="text" class="form-control" id="shipping_charge" name="shipping_charge" value="<?php echo set_value('shipping_charge'); ?>">
                          <span class="validation-color" id="err_shipping_charge"><?php echo form_error('shipping_charge'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <label>Sales Type</label>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="sales_type" id="sales_type" value="0"> Through E-commerce &nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="sales_type" id="sales_type" value="1" checked> Other than E-commerce 
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="sales_invoice">Invoice Type</label>
                          <select id="sales_invoice" name="sales_invoice" class="form-control select2">
                            <option value="1">Regular</option>
                            <option value="2">SEZ Supplies with Payment</option>
                            <option value="3">SEZ Supplies without Payment</option>
                            <option value="4">Deemed Export</option>
                          </select>
                          <span class="validation-color" id="err_shipping_charge"><?php echo form_error('shipping_charge'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <br>
                          <input type="checkbox" class="" id="gst_payable" name="gst_payable" value="Y">&nbsp;&nbsp;&nbsp;&nbsp;
                          <label for="gst_payable">GST Payable On Reverse Charge</label>
                          <span class="validation-color" id="err_gst_payable"><?php echo form_error('gst_payable'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-12 invoice_type_hide">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="port_code">Port Code</label>
                            <input type="text" name="port_code" id="port_code" class="form-control">
                            <span class="validation-color" id="err_port_code"><?php echo form_error('port_code'); ?></span>
                          </div>
                          <div class="form-group">
                            <label for="shipping_bill_no">Shipping Bill Number</label>
                            <input type="text" name="shipping_bill_no" id="shipping_bill_no" class="form-control">
                            <span class="validation-color" id="err_shipping_bill_no"><?php echo form_error('shipping_bill_no'); ?></span>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="shipping_bill_date">Shipping Bill Date</label>
                            <input type="text" name="shipping_bill_date" id="shipping_bill_date" class="form-control datepicker">
                            <span class="validation-color" id="err_shipping_bill_date"><?php echo form_error('shipping_bill_date'); ?></span>
                          </div>
                        </div>
                      </div>
                      <script>
                        $('.invoice_type_hide').hide();
                      </script>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="supplier_ref">Supplier Reference</label>
                          <input type="text" class="form-control" id="supplier_ref" name="supplier_ref" value="">
                          <span class="validation-color" id="err_supplier_ref"><?php echo form_error('supplier_ref'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="buyer_order">Buyer Order</label>
                          <input type="text" class="form-control" id="buyer_order" name="buyer_order" value="" >
                          <span class="validation-color" id="err_buyer_order"><?php echo form_error('buyer_order'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="dispatch_document_no">Dispatch Document No</label>
                          <input type="text" class="form-control" id="dispatch_document_no" name="dispatch_document_no" value="">
                          <span class="validation-color" id="err_dispatch_document_no"><?php echo form_error('dispatch_document_no'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="delivery_note_date">Delivery Note Date</label>
                          <input type="text" class="form-control datepicker" id="delivery_note_date" name="delivery_note_date" value="">
                          <span class="validation-color" id="err_delivery_note_date"><?php echo form_error('delivery_note_date'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="dispatch_through">Dispatched Through</label>
                          <input type="text" class="form-control" id="dispatch_through" name="dispatch_through" value="">
                          <span class="validation-color" id="err_dispatch_through"><?php echo form_error('dispatch_through'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="discount">Discount</label>
                          <input class="form-control" id="discount" name="discount">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-12">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-12 search_product_code">
                        <input id="input_product_code" class="form-control" autofocus="off" type="text" name="input_product_code" placeholder="Enter Product Code/Name" >
                      </div>
                      <div class="col-sm-8">
                        <span class="validation-color" id="err_product"></span>
                      </div>
                    </div>
                  </div>
                </div> <!--/col-md-12 -->

                <div class="col-sm-12">
                  <div class="form-group">
                    <label><?php echo $this->lang->line('purchase_inventory_items'); ?></label>
                    
                    <table class="table items table-striped table-bordered table-condensed table-hover product_table" name="product_data" id="product_data">
                      <thead>
                        <tr>
                          <th style="width: 20px;"><img src="<?php  echo base_url(); ?>assets/images/bin1.png" /></th>
                          <th class="span2" width="15%"><?php echo $this->lang->line('purchase_product_description'); ?></th>
                          <th class="span2" width="10%"><?php echo $this->lang->line('product_unit'); ?></th>
                          <th class="span2" width="10%">Qty</th>
                          <th class="span2" width="10%"><?php echo $this->lang->line('product_price'); ?></th>
                          <th class="span2" width="10%"><?php echo $this->lang->line('header_discount'); ?></th>
                          <th class="span2"><?php echo $this->lang->line('purchase_taxable_value'); ?></th>
                          <th class="span2" width="10%">IGST</th>
                          <th class="span2" width="10%">CGST</th>
                          <th class="span2" width="10%">SGST</th>
                          <th class="span2" width="10%"><?php echo $this->lang->line('purchase_total'); ?></th>
                        </tr>
                      </thead>
                      <tbody id="product_table_body">
                        
                      </tbody>
                    </table>
                    <input type="hidden" name="total_value" id="total_value">
                    <input type="hidden" name="total_discount" id="total_discount">
                    <input type="hidden" name="total_tax" id="total_tax">
                    <input type="hidden" name="grand_total" id="grand_total">
                    <input type="hidden" name="table_data" id="table_data">
                    
                    
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <tr>
                        <td align="right" width="80%"><?php echo $this->lang->line('purchase_total_value'); ?></td>
                        <td align='right'><span id="totalValue">&nbsp;0.00</span></td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total_discount'); ?></td>
                        <td align='right'>
                          <span id="totalDiscount">&nbsp;0.00</span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total_tax'); ?></td>
                        <td align='right'>
                          <span id="totalTax">&nbsp;0.00</span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total'); ?> </td>
                        <td align='right'><span id="grandTotal">&nbsp;0.00</span></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="control-group">                     
                    <div class="controls">
                      <div class="tabbable">
                        <ul class="nav nav-tabs">
                          <li>
                            <a href="#note" data-toggle="tab"><?php echo $this->lang->line('purchase_note'); ?></a>
                          </li>
                          <li class="active"><a href="#internal_note" data-toggle="tab"><?php echo $this->lang->line('sales_internal_note'); ?></a></li>
                        </ul>                           
                        <br>
                          <div class="tab-content">
                            <div class="tab-pane" id="note">
                              <textarea class="col-sm-12 form-control" id="note" name="note" value=""></textarea>
                              <span style="color:red;" id="err_note"></span>
                            </div>
                            <div class="tab-pane active" id="internal_note">
                              <textarea class="col-sm-12 form-control" id="note" name="internal_note" value=""></textarea>
                              <span style="color:red;" id="err_note"></span>
                            </div>
                          </div>
                        </div>
                      </div> <!-- /controls -->       
                  </div> <!-- /control-group --> 
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('product_add'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('quotation')"><?php echo $this->lang->line('product_cancel'); ?></span>
                  </div>
                </div>
              </form>
          </div>
          <!-- /.box-body -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  $this->load->view('layout/product_footer');
?>
<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<?php 
  include('customer.php');
?>
</script>
<!-- close datepicker  -->
<script>
  $(document).ready(function(){
    $('#customer').change(function(){
      var customer_id = $(this).val();
      $.ajax({
          url: "<?php echo base_url('sales/getCustomerData') ?>/"+customer_id,
          type: "GET",
          dataType: "JSON",
          data:{
                '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
          },
          success: function(data){
            $('#country').text('');
            $('#state').text('');
            $('#city').text('');
            $('#err_country').text('');
            $('#err_state').text('');
            $('#err_city').text('');
            for(a=0;a<data['country'].length;a++){
              $('#country').append('<option value="' + data['country'][a].id + '">' + data['country'][a].name+'</option>');
            }
            for(a=0;a<data['state'].length;a++){
              $('#state').append('<option value="' + data['state'][a].id + '">' + data['state'][a].name+'</option>');
            }
            for(a=0;a<data['city'].length;a++){
              $('#city').append('<option value="' + data['city'][a].id + '">' + data['city'][a].name+'</option>');
            }
            $('#country').val(data['data'].country_id).attr("selected","selected");
            $('#state').val(data['data'].state_id).attr("selected","selected");
            $('#city').val(data['data'].city_id).attr("selected","selected");
            $('#address').val(data['data'].address);

          }
        });
    });
  });
</script>
<script>
    $('#country').change(function(){
      var id = $(this).val();
      $('#state').html('<option value="">Select</option>');
      $('#city').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('customer/getState') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#state').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
</script>
<script>
    $('#state').change(function(){
      var id = $(this).val();
      $('#city').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('customer/getCity') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#city').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
</script>
<script>
 $(document).ready(function(){
    var i = 0;
    var product_data = new Array();
    var counter = 1;
    var mapping = { };
    $(function(){
            $('#input_product_code').autoComplete({
                minChars: 1,
                cache: false,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    var warehouse_id = $('#warehouse').val();
                    $.ajax({
                      url: "<?php echo base_url('purchase_return/getBarcodeProducts') ?>/"+term+'/'+warehouse_id,
                      type: "GET",
                      dataType: "json",
                      success: function(data){
                        var suggestions = [];
                        for(var i = 0; i < data.length; ++i) {
                            suggestions.push(data[i].code+' - '+data[i].name);
                            mapping[data[i].code] = data[i].product_id;
                        }
                        suggest(suggestions);
                        }
                    });
                },
                onSelect: function(event, ui) {
                  var str = ui.split(' ');
                  var warehouse_id = $('#warehouse').val();
                  $.ajax({
                    url:"<?php echo base_url('purchase_return/getProductUseCode') ?>/"+mapping[str[0]]+'/'+warehouse_id,
                    type:"GET",
                    dataType:"JSON",
                    success: function(data){
                      add_row(data);
                      $('#input_product_code').val('');
                    }
                  });
                } 
            });
    });
    function add_row(data){
      var flag = 0;
      $("table.product_table").find('input[name^="product_id"]').each(function () {
                if(data[0].product_id  == +$(this).val()){
                  flag = 1;
                }
            });
            if(flag == 0){
              var id = data[0].product_id;
              var code = data[0].code;
              var name = data[0].name;
              var hsn_sac_code = data[0].hsn_sac_code;
              var price = data[0].price;
              var tax_id = data[0].tax_id;
              var tax_value = data[0].tax_value;
              if(tax_value==null){
                tax_value = 0;
              }
              var product = { "product_id" : id,
                              "price" : price
                            };
              product_data[i] = product;

              length = product_data.length - 1 ;
            
              var select_discount = "";
              select_discount += '<div class="form-group">';
              select_discount += '<select class="form-control select2" id="item_discount" name="item_discount" style="width: 100%;">';
              select_discount += '<option value="">Select</option>';
                for(a=0;a<data['discount'].length;a++){
                  select_discount += '<option value="' + data['discount'][a].discount_id + '">' + data['discount'][a].discount_name+'('+data['discount'][a].discount_value +'%)'+ '</option>';
                }
              select_discount += '</select></div>';
              var color;
              data[0].quantity>10?color="green":color="red";
              var newRow = $("<tr>");
              var cols = "";
              cols += "<td><a class='deleteRow'> <img src='<?php  echo base_url(); ?>assets/images/bin3.png' /> </a><input type='hidden' name='id' name='id' value="+i+"><input type='hidden' name='product_id' name='product_id' value="+id+"></td>";
              cols += "<td>"+name+"<br>HSN:"+hsn_sac_code+"</td>";
              cols += "<td>"+data[0].unit+"</td>";
              cols += "<td>"
                      +"<input type='number' class='form-control text-center' value='0' data-rule='quantity' name='qty"+ counter +"' id='qty"+ counter +"' min='1'>" 
                      +"<span style='color:"+color+";'>Avai Qty: "+data[0].quantity+"</span>"
                    +"</td>";
              cols += "<td>" 
                        +"<span id='price_span'>"
                          +"<input type='number'step='0.01' min='1' class='form-control text-right' name='price"+ counter +"' id='price"+ counter +"' value='"+price
                        +"'>"
                        +"</span>"
                        +"<span id='sub_total' class='pull-right'></span>"
                        +"<input type='hidden' class='form-control text-right' style='' value='0.00' name='linetotal"+ counter +"' id='linetotal"+ counter +"'>"
                      +"</td>";
              cols += '<td>'
                      +'<input type="hidden" id="discount_value" name="discount_value">'
                      +'<input type="hidden" id="hidden_discount" name="hidden_discount">'
                      +select_discount
                    +'</td>';
              cols += '<td align="right"><span id="taxable_value"></span></td>';
              cols += '<td>'
                      +'<input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0">' 
                      +'<input type="hidden" name="igst_tax" id="igst_tax" class="form-control">'
                      +'<span id="igst_tax_lbl" class="pull-right" style="color:red;"></span>'
                    +'</td>';
              cols += '<td>'
                      +'<input type="number" step="0.01" name="cgst" id="cgst" class="form-control" max="100" min="0">'
                      +'<input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control">'
                      +'<span id="cgst_tax_lbl" class="pull-right" style="color:red;"></span>'
                    +'</td>';
              cols += '<td>'
                      +'<input type="number" step="0.01" name="sgst" id="sgst" class="form-control" max="100" min="0">'
                      +'<input type="hidden" name="sgst_tax" id="sgst_tax" class="form-control">'
                      +'<span id="sgst_tax_lbl" class="pull-right" style="color:red;"></span>'
                    +'</td>';
              cols += '<td><input type="text" class="form-control text-right" id="product_total" name="product_total" readonly></td>';
              cols += "</tr>";
              counter++;

              newRow.append(cols);
              $("table.product_table").append(newRow);
              var table_data = JSON.stringify(product_data);
              $('#table_data').val(table_data);
              i++;
            }
            else{
              $('#err_product').text('Product Already Added').animate({opacity: '0.0'}, 2000).animate({opacity: '0.0'}, 1000).animate({opacity: '1.0'}, 2000);
            }
    }
    
    $("table.product_table").on("click", "a.deleteRow", function (event) {
        deleteRow($(this).closest("tr"));
        $(this).closest("tr").remove();
        calculateGrandTotal();
    });

    function deleteRow(row){
      var id = +row.find('input[name^="id"]').val();
      var array_id = product_data[id].product_id;
      //product_data.splice(id, 1);
      product_data[id] = null;
      //alert(product_data);
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }

    $("table.product_table").on("change", 'input[name^="price"], input[name^="qty"],input[name^="igst"],input[name^="cgst"],input[name^="sgst"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateDiscountTax($(this).closest("tr"));
        calculateGrandTotal();
    });

    $("table.product_table").on("change",'#item_discount',function (event) {
      var row = $(this).closest("tr");
      var discount = +row.find('#item_discount').val();
      if(discount != ""){
        $.ajax({
          url: '<?php echo base_url('purchase/getDiscountValue/') ?>'+discount,
          type: "GET",
          data:{
            '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
          },
          datatype: JSON,
          success: function(value){
            data = JSON.parse(value);
            row.find('#discount_value').val(data[0].discount_value);
            calculateDiscountTax(row,data[0].discount_value);
            calculateGrandTotal();
          }
        });
      }
      else{
        row.find('#discount_value').val('0');
        calculateDiscountTax(row,0);
        calculateGrandTotal();
      }
    });
    function calculateDiscountTax(row,data = 0,data1 = 0){
      var discount;
      if(data == 0 ){
        discount = +row.find('#discount_value').val();
      }
      else{
        discount = data;
      }
      var sales_total = +row.find('input[name^="linetotal"]').val();
      var total_discount = sales_total*discount/100;
      var taxable_value = sales_total - total_discount;
      row.find('#taxable_value').text(taxable_value.toFixed(2));
      var igst = +row.find("#igst").val();
      var cgst = +row.find("#cgst").val();
      var sgst = +row.find("#sgst").val();
      var igst_tax = taxable_value*igst/100;
      var cgst_tax = taxable_value*cgst/100;
      var sgst_tax = taxable_value*sgst/100;
      var tax = igst_tax+cgst_tax+sgst_tax;
      row.find('#product_total').val(taxable_value+tax);
      row.find('#igst_tax').val(igst_tax);
      row.find('#igst_tax_lbl').text(igst_tax.toFixed(2));
      row.find('#cgst_tax').val(cgst_tax);
      row.find('#cgst_tax_lbl').text(cgst_tax.toFixed(2));
      row.find('#sgst_tax').val(sgst_tax);
      row.find('#sgst_tax_lbl').text(sgst_tax.toFixed(2));

      row.find('#hidden_discount').val(total_discount);

      var key = +row.find('input[name^="id"]').val();
      product_data[key].discount = total_discount;
      product_data[key].discount_value = +row.find('#discount_value').val();
      product_data[key].discount_id = +row.find('#item_discount').val();
      product_data[key].igst = igst;
      product_data[key].igst_tax = igst_tax;
      product_data[key].cgst = cgst;
      product_data[key].cgst_tax = cgst_tax;
      product_data[key].sgst = sgst;
      product_data[key].sgst_tax = sgst_tax;
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }
    
    function calculateRow(row) {
      var key = +row.find('input[name^="id"]').val();
      var price = +row.find('input[name^="price"]').val();
      var qty = +row.find('input[name^="qty"]').val();
      row.find('input[name^="linetotal"]').val((price * qty).toFixed(2));
      row.find('#sub_total').text((price * qty).toFixed(2));
      
      product_data[key].quantity = qty;
      product_data[key].total = (price * qty).toFixed(2);
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }
    function calculateGrandTotal() {
      var totalValue = 0;
      var totalDiscount = 0;
      var grandTax = 0;
      var grandTotal = 0;
      $("table.product_table").find('input[name^="linetotal"]').each(function () {
        totalValue += +$(this).val();
      });
      $("table.product_table").find('input[name^="hidden_discount"]').each(function () {
        totalDiscount += +$(this).val();
      });
      $("table.product_table").find('input[name^="igst_tax"]').each(function () {
        grandTax += +$(this).val();
      });
      $("table.product_table").find('input[name^="cgst_tax"]').each(function () {
        grandTax += +$(this).val();
      });
      $("table.product_table").find('input[name^="sgst_tax"]').each(function () {
        grandTax += +$(this).val();
      });
      $("table.product_table").find('input[name^="product_total"]').each(function () {
        grandTotal += +$(this).val();
      });
      $('#totalValue').text(totalValue);
      $('#total_value').val(totalValue);
      $('#totalDiscount').text(totalDiscount.toFixed(2));
      $('#total_discount').val(totalDiscount);
      $('#totalTax').text(grandTax.toFixed(2));
      $('#total_tax').val(grandTax.toFixed(2));
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#grand_total').val(grandTotal.toFixed(2));
    }
});

</script>

<script>
  $(document).ready(function(){

    $("#submit").click(function(event){
      var name_regex = /^[a-zA-Z]+$/;
      var sname_regex = /^[a-zA-Z0-9]+$/;
      var num_regex = /^[0-9]+$/;
      var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      var date = $('#date').val();
      var reference_no = $('#reference_no').val();
      var warehouse = $('#warehouse').val();
      var biller = $('#biller').val();
      var product = $('#product').val();
      var customer = $('#customer').val();
      var discount = $('#discount').val();
      var note = $('#note').val();
      var internal_note = $('#internal_note').val();
      var grand_total = $('#grand_total').val();
      var address = $('#address').val();
      var city = $('#city').val();
      var state = $('#state').val();
      var country = $('#country').val();
      

        if(date==null || date==""){
          $("#err_date").text("Please Enter Date");
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
        if (!date.match(date_regex) ) {
          $('#err_code').text(" Please Enter Valid Date ");   
          $('#date').focus();
          return false;
        }
        else{
          $("#err_code").text("");
        }
//date codevalidation complite.


        if(warehouse==""){
          $("#err_warehouse").text("Please Enter Warehouse");
          $('#warehouse').focus();
          return false;
        }
        else{
          $("#err_warehouse").text("");
        }
//warehouse code validation complite.

        if(biller==""){
          $("#err_biller").text("Please Enter Biller");
          $('#biller').focus();
          return false;
        }
        else{
          $("#err_biller").text("");
        }
//biller code validation complite.

         if(customer==""){
          $("#err_customer").text("Please Enter Customer");
          $('#customer').focus();
          return false;
        }
        else{
          $("#err_customer").text("");
        }
//customer code validation complite.
      
         if(address==null || address==""){
          $("#err_address").text(" Please Enter Address");
          return false;
        }
        else{
          $("#err_address").text("");
        }
//Address validation complite.
        
        if(country==null || country==""){
          $("#err_country").text("Please Select Country ");
          return false;
        }
        else{
          $("#err_country").text("");
        }
//country validation complite.
      
        if(state==null || state==""){
          $("#err_state").text("Please Select State ");
          return false;
        }
        else{
          $("#err_state").text("");
        }
//state validation complite.
        
         if(city==null || city==""){
          $("#err_city").text("Please Select City ");
          return false;
        }
        else{
          $("#err_city").text("");
        }
//city validation complite.

        if(grand_total=="" || grand_total==null || grand_total==0.00){;
          $("#err_product").text("Please Select Product");
          $('#product').focus();
          return false;
        }
        else{
          $("#err_product").text("");
        }
    }); 

    $("#date").blur(function(event){
      var date = $('#date').val(); 
      var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      if(date==null || date==""){
          $("#err_date").text("Please Enter Date");
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
        if (!date.match(date_regex) ) {
          $('#err_code').text(" Please Enter Valid Date ");   
          $('#date').focus();
          return false;
        }
        else{
          $("#err_code").text("");
        }
    });
    
    $("#warehouse").change(function(event){
      var warehouse = $('#warehouse').val();
      $('#product_table_body').empty();
      $('#table_data').val('clear');
      $('#last_total').val('');
      $('#grand_total').val('');
      $('#grandtotal').text('0.00');
      $('#totaldiscount').text('0.00');
      $('#lasttotal').text('0.00');
      if(warehouse==""){
        $("#err_warehouse").text("Please Enter Warehouse");
        $('#warehouse').focus();
        return false;
      }
      else{
        $("#err_warehouse").text("");
      }
    });
    $("#biller").change(function(event){
      var biller = $('#biller').val();
      if(biller==""){
        $("#err_biller").text("Please Enter Biller");
        $('#biller').focus();
        return false;
      }
      else{
        $("#err_biller").text("");
      }
    });
    $("#customer").change(function(event){
      var customer = $('#customer').val();
      if(customer==""){
        $("#err_customer").text("Please Enter Customer");
        $('#customer').focus();
        return false;
      }
      else{
        $("#err_customer").text("");
      }
    });
    $("#discount").change(function(event){
      var discount = $('#discount').val();
      if(discount==""){
        $("#err_discount").text("Please Enter Discount");
        $('#discount').focus();
        return false;
      }
      else{
        $("#err_discount").text("");
      }
      if(discount!=""){
        $.ajax({
          url: "<?php echo base_url('sales/getDiscountAjax') ?>/"+discount,
          type: "get",
          dataType: "json",
          success: function(data){
            //alert(data[0].discount_id);
            var type = data[0].discount_type;
            var value = data[0].discount_value;
            var amount = parseInt(data[0].amount);
            var grand_total = $('#grand_total').val();
            $('#discount_type').val(type);
            $('#total_discount').val(value);
            $('#discount_amount').val(amount);
            if(grand_total > 0 && grand_total!=null){
              if(type == "Fixed"){
                var t = grand_total - value;
                if(grand_total < amount){
                  var t = grand_total;
                }  
                $('#lasttotal').text(t);
                $('#last_total').val(t);
                $('#totaldiscount').text(value);
                $('#total_discount').val(value);
                $('#discount_type').val(type);
                $('#discount_amount').val(amount);
                $('#showdiscount').text(" (Rs "+value+")");
              }
              else{
                var total = (grand_total*value)/100;
                var t = grand_total - total;
                $('#totaldiscount').text(total);
                $('#total_discount').val(value);
                $('#discount_type').val('');
                $('#discount_amount').val('');
                $('#lasttotal').text(t);
                $('#last_total').val(t);
                $('#showdiscount').text(" ("+value+"%)");
              }
            }
          }
        });
      }
    });
    $("#product").blur(function(event){
      var sname_regex = /^[a-zA-Z0-9]+$/;
      var product = $('#product').val();
      if(product==null || product==""){
        $("#err_product").text("Please Enter Product Code/Name");
        $('#product').focus();
        return false;
      }
      else{
        $("#err_product").text("");
      }
      if (!product.match(sname_regex) ) {
        $('#err_product').text(" Please Enter Valid Product Code/Name ");  
        $('#product').focus(); 
        return false;
      }
      else{
        $("#err_product").text("");
      }
    });
    $("#address").on("blur keyup",  function (event){
        var address = $('#address').val();
        if(address==null || address==""){
          $("#err_address").text(" Please Enter Address");
          return false;
        }
        else{
          $("#err_address").text("");
        }
    });
    $("#city").change(function(event){
        var city = $('#city').val();
        $('#city').val(city);
        if(city==null || city==""){
          $("#err_city").text("Please Select City ");
          return false;
        }
        else{
          $("#err_city").text("");
        }
    });
    $("#state").change(function(event){
        var state = $('#state').val();
        $('#state').val(state);
        if(state==null || state==""){
          $("#err_state").text("Please Select State ");
          return false;
        }
        else{
          $("#err_state").text("");
        }
    });
  }); 
$('#sales_invoice').change(function(){
      var id = $('#sales_invoice').val();
      if(id==1){
        $('.invoice_type_hide').hide();
        $('#port_code').val('');
        $('#shipping_bill_no').val('');
        $('#shipping_bill_date').val('');
      }
      else{
        $('.invoice_type_hide').show();
      }
    });
</script>
<script src="<?php echo base_url('assets/plugins/autocomplite/') ?>jquery.auto-complete.js"></script>