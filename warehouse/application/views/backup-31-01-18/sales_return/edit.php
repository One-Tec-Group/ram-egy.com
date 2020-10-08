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
          <li><a href="<?php echo base_url('sales_return'); ?>"><?php echo $this->lang->line('header_sales_return'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('sales_return_edit_sales_return'); ?></li>
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
              <h3 class="box-title"><?php echo $this->lang->line('sales_return_edit_sales_return'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('sales_return/editSalesReturn');?>">
                <?php foreach($data as $row){?>
                <div class="col-md-6">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="date"><?php echo $this->lang->line('purchase_date'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo $row->date;?>">
                          <input type="hidden" name="sale_return_id" value="<?php echo $row->id;?>">
                          <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="reference_no"><?php echo $this->lang->line('purchase_reference_no'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control" id="reference_no" name="reference_no" value="<?php echo $row->reference_no;?>" readonly>
                          <span class="validation-color" id="err_reference_no"><?php echo form_error('reference_no'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="warehouse"><?php echo $this->lang->line('purchase_select_warehouse'); ?><span class="validation-color">*</span></label>
                          <?php  
                          $type_u=$this->session->userdata('type');
                          if ($type_u=='sales_person') { ?>

                            <input type="text" value="<?php echo $warehouse[0]->warehouse_name;?>" class="form-control datepicker" disabled>
                            <input type="hidden" name="warehouse" id="warehouse" value="<?php echo $warehouse[0]->warehouse_id;?>" >
                            <input type="hidden" name="biller" id="biller" value="<?php echo $biller;?>" >
                            <input type="hidden" name="biller_state_id" id="biller_state_id" value="<?php echo $biller_state_id;?>" >
                          <?php  }
                          else if($type_u=='admin'){ ?>
                               
                            <select class="form-control select2" id="warehouse" name="warehouse" style="width: 100%;">
                              <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                            <?php                           
                              foreach ($warehouse as $row) {
                            ?>
                              <option value="<?php echo $row->warehouse_id; ?>" <?php if($row->warehouse_id==$data[0]->warehouse_id) echo "selected disabled"; ?>><?php echo $row->warehouse_name;?></option>
                            <?php
                              }
                            ?> 
                          </select>
                          <span class="validation-color" id="err_warehouse"><?php echo form_error('warehouse');?></span>
                         <?php } ?>
                          
                        </div>
                        <div class="form-group">
                          <label for="discount">Discount</label>
                          <input class="form-control" id="discount" name="discount" value="<?php echo $row->flat_discount; ?>">
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
                          <label for="customer"><?php echo $this->lang->line('sales_select_customer'); ?> <span class="validation-color">*</span></label>
                          <select class="form-control select2" id="customer" name="customer" style="width: 100%;">
                            <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                            <?php
                            foreach ($customer as  $key) {
                            ?>
                                    <option value='<?php echo $key->customer_id ?>' <?php if($key->customer_id == $row->customer_id){echo "selected";} ?>><?php echo $key->customer_name ?></option>
                            <?php
                                }
                            ?>
                          </select>
                          <input type="hidden" id="customer_state_id" name="customer_state_id" value="<?php echo $customer_state_id; ?>">
                          <span class="validation-color" id="err_customer"><?php echo form_error('customer');?></span>
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

                <div class="col-md-12">
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
                        <?php
                          $tot=0;
                          $i=0;
                         // $product_data = [];
                          foreach ($items as  $key) {
                          ?>
                          <tr>
                            <td>
                              <a class='deleteRow1'> <img src='<?php  echo base_url(); ?>assets/images/bin3.png' /> </a><input type='hidden' name='id' name='id' value="<?php echo $i ?>"><input type='hidden' name='product_id' name='product_id' value="<?php echo $key->product_id ?>"></td>
                              <td><?php echo $key->name; ?><br>HSN: <?php echo $key->hsn_sac_code; ?></td>
                              <td><?php echo $key->unit ?></td>
                              <td><input type="number" class="form-control text-center" value="<?php echo $key->quantity ?>" data-rule="quantity" name='qty' id='qty' min="1" max="<?php echo $key->quantity+$key->warehouses_quantity ?>">
                              </td>
                              <td>
                                <input type='number' step='0.01' class='form-control text-right' name='price' id='price' value='<?php echo $key->cost ?>'>
                                <span id='sub_total' class='pull-right'><?php echo round($key->gross_total); ?></span>
                                <input type='hidden' class='form-control' style='' value='<?php echo $key->gross_total ?>' name='linetotal' id='linetotal' readonly>
                              </td>
                              <td align="right">
                              <input type="hidden" id="discount_value" name="discount_value" value="<?php echo $key->discount_value;?>">
                              <input type="hidden" id="hidden_discount" name="hidden_discount" value="<?php echo $key->discount;?>">
                              <div class="form-group">
                                <select class="form-control" id="item_discount" name="item_discount" style="width: 100%;">
                                  <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                                  <?php foreach ($discount as $dis) {
                                  ?>
                                    <option value='<?php echo $dis->discount_id ?>' <?php if($key->discount_id == $dis->discount_id){echo "selected";} ?>><?php echo $dis->discount_name.'('.$dis->discount_value.')' ?></option>
                                  <?php
                                    } 
                                  ?>
                                </select>
                              </div>
                            </td>
                            <td align="right">
                              <span id="taxable_value"><?php echo $key->gross_total - $key->discount ?></span>
                            </td>
                            <td>
                              <input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0" value="<?php echo $key->igst; ?>">
                              <input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="<?php echo $key->igst_tax; ?>">
                              <span id="igst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->igst_tax; ?></span>
                            </td>
                            <td>
                              <input type="number" step="0.01" name="cgst" id="cgst" class="form-control" max="100" min="0" value="<?php echo $key->cgst; ?>">
                              <input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control" value="<?php echo $key->cgst_tax; ?>">
                              <span id="cgst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->cgst_tax; ?></span>
                            </td>
                            <td>
                              <input type="number" step="0.01" name="sgst" id="sgst" class="form-control" max="100" min="0" value="<?php echo $key->sgst; ?>">
                              <input type="hidden" name="sgst_tax" id="sgst_tax" class="form-control" value="<?php echo $key->sgst_tax; ?>">
                              <span id="sgst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->sgst_tax; ?></span>
                            </td>
                            <td align="right">
                              <input type="text" class="form-control text-right" id="product_total" name="product_total" value=" <?php echo $key->gross_total - $key->discount + $key->igst_tax + $key->cgst_tax + $key->sgst_tax ?>" readonly>
                            </td>
                        </tr>
                        <?php
                            $product_data[$i] = $key->product_id;
                            //array_push($product_data,$product);
                            $i++;
                            $tot += $key->gross_total;
                          }
                          if($items!=null){
                            $grandtotal = $row->total;
                            $product = json_encode($product_data);
                          }
                          
                        ?>
                      </tbody>
                    </table>
                    <input type="hidden" name="total_value" id="total_value" value='<?php echo $tot; ?>'>
                    <input type="hidden" name="total_discount" id="total_discount" value='<?php echo $row->discount_value; ?>'>
                    <input type="hidden" name="total_tax" id="total_tax" value='<?php echo $row->tax_value; ?>'>
                    <input type="hidden" name="grand_total" id="grand_total" value='<?php echo $row->total; ?>'>
                    <input type="hidden" name="table_data" id="table_data" value='<?php echo $product ?>'>
                    <input type="hidden" name="table_data1" id="table_data1">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <tr>
                        <td align="right" width="80%"><?php echo $this->lang->line('purchase_total_value'); ?></td>
                        <td align='right'><?php echo $this->session->userdata('symbol'); ?><span id="totalValue"><?php echo $tot; ?></span></td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total_discount'); ?> </td>
                        <td align='right'>
                          <?php echo $this->session->userdata('symbol'); ?><span id="totalDiscount"><?php echo $row->discount_value; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total_tax'); ?> </td>
                        <td align='right'>
                          <?php echo $this->session->userdata('symbol'); ?><span id="totalTax"><?php echo $row->tax_value; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total'); ?> </td>
                        <td align='right'><?php echo $this->session->userdata('symbol'); ?><span id="grandTotal"><?php echo $row->total; ?></span></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-md-12">
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
                              <textarea class="col-md-12 form-control" id="note" name="note" value=""></textarea>
                              <span style="color:red;" id="err_note"></span>
                            </div>
                            <div class="tab-pane active" id="internal_note">
                              <textarea class="col-md-12 form-control" id="note" name="internal_note" value=""></textarea>
                              <span style="color:red;" id="err_note"></span>
                            </div>
                          </div>
                        </div>
                      </div> <!-- /controls -->       
                  </div> <!-- /control-group -->  
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info"><?php echo $this->lang->line('product_update'); ?></button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('sales_return')"><?php echo $this->lang->line('product_cancel'); ?></span>
                  </div>
                </div>
                <?php } ?>
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
    $this->load->view('layout/footer');
  ?>

<script>
$(document).ready(function(){
    var i = <?php echo $i++; ?>;
    var product_data = new Array();
    var counter = <?php echo count($items); ?>;
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

    $("table.product_table").on("click", "a.deleteRow1", function (event) {
        deleteRow1($(this).closest("tr"));
        $(this).closest("tr").remove();
        calculateGrandTotal();
    });

    function deleteRow(row){
      var id = +row.find('input[name^="id"]').val();
      //var array_id = product_data[id].product_id;
      product_data.splice(id, 1);
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
    }

    function deleteRow1(row){
      var id = +row.find('input[name^="id"]').val();
      product_data[id] = 'delete';
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
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
            calculateRow(row);
            calculateDiscountTax(row,data[0].discount_value);
            calculateGrandTotal();
          }
        });
      }
      else{
        row.find('#discount_value').val('0');
        calculateRow(row);
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
      $('#table_data1').val(table_data);
    }
    
    function calculateRow(row) {
      var key = +row.find('input[name^="id"]').val();
      var price = +row.find('input[name^="price"]').val();
      var qty = +row.find('input[name^="qty"]').val();
      var product_id = +row.find('input[name^="product_id"]').val();
      row.find('input[name^="linetotal"]').val((price * qty).toFixed(2));
      row.find('#sub_total').text((price * qty).toFixed(2));
      if(product_data[key]==null){
        var temp = {
          "product_id" : product_id,
          "price" : price,
          "quantity" : qty,
          "total" : (price * qty).toFixed(2)
        };
        product_data[key] = temp;
      }
      product_data[key].quantity = qty;
      product_data[key].total = (price * qty).toFixed(2);
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
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
      $('#total_discount').val(totalDiscount.toFixed(2));
      $('#totalTax').text(grandTax.toFixed(2));
      $('#total_tax').val(grandTax.toFixed(2));
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#grand_total').val(grandTotal.toFixed(2));
    }
});

</script>

<!-- datepicker  -->
<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "auto",
        todayBtn: true,
        todayHighlight: true,  
    });

});
</script>
<!-- close datepicker  -->


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
      var cusomer = $('#cusomer').val();
      var discount = $('#discount').val();
      var note = $('#note').val();
      var internal_note = $('#internal_note').val();
      var grand_total = $('#grand_total').val();
      

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
      var warehouse_change = $("#warehouse_change").val();
      $('#warehouse_change').val('yes');
      $('#product_table_body').empty();
      $('#table_data1').val('clear');
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
        $.ajax({
          url: "<?php echo base_url('sales_return/getCustomerStateIdAjax') ?>/"+customer,
          type: "get",
          dataType: "json",
          success: function(data){
            $("#customer_state_id").val(data);
            // alert($("#customer_state_id").val());
            // alert($("#biller_state_id").val());
            
          }
        });
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
          url: "<?php echo base_url('sales_retuen/getDiscount') ?>/"+discount,
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
          },
          error: function(xhr, status, error) {
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
      if (!date.match(sname_regex) ) {
        $('#err_product').text(" Please Enter Valid Product Code/Name ");  
        $('#product').focus(); 
        return false;
      }
      else{
        $("#err_product").text("");
      }
    });

  }); 
</script>
<script src="<?php echo base_url('assets/plugins/autocomplite/') ?>jquery.auto-complete.js"></script>