<?php
defined('BASEPATH') OR exit('NO direct script access allowed');
$this->load->view('layout/header');
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('transfer'); ?>"><?php echo $this->lang->line('transfer_listtransfers'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('transfer_add_transfer'); ?></li>
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
              <h3 class="box-title"><?php echo $this->lang->line('transfer_add_transfer'); ?></h3>
            </div>
            <!-- /.box-header -->
            <form role="form" id="form" method="post" action="<?php echo base_url('transfer/addTransfer');?>">
              <div class="box-body general-data">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="date"><?php echo $this->lang->line('transfer_date'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo date("Y-m-d");  ?>">
                          <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="to_warehouse"><?php echo $this->lang->line('transfer_to_warehouse'); ?> <span class="validation-color">*</span></label>
                          <select class="form-control select2" id="to_warehouse" name="to_warehouse" style="width: 100%;">
                            <option value=""><?php echo $this->lang->line('transfer_select'); ?></option>
                            <?php

                              foreach ($warehouse as $row) {
                                echo "<option value='$row->warehouse_id'".set_select('warehouse_id',$row->branch_id).">$row->warehouse_name</option>";
                              }
                            ?>
                          </select>
                          <span class="validation-color" id="err_to_warehouse"><?php echo form_error('to_warehouse'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="from_warehouse"><?php echo $this->lang->line('transfer_from_warehouse'); ?><span class="validation-color">*</span></label>
                          <select class="form-control select2" id="from_warehouse" name="from_warehouse" style="width: 100%;">
                            <option value=""><?php echo $this->lang->line('transfer_select'); ?></option>
                            <?php

                              foreach ($warehouse as $row) {
                                echo "<option value='$row->warehouse_id'".set_select('warehouse_id',$row->branch_id).">$row->warehouse_name</option>";
                              }
                            ?>
                          </select>
                          <span class="validation-color" id="err_from_warehouse"><?php echo form_error('from_warehouse'); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="box-body">
                <div class="row">
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
                      <label><?php echo $this->lang->line('transfer_inventory_items'); ?></label>
                      <div style="overflow-y: auto;">
                        <table class="table items table-striped table-bordered table-condensed table-hover product_table" name="product_data" id="product_data">
                          <thead>
                            <tr>
                              <th style="width: 20px;"><img src="<?php  echo base_url(); ?>assets/images/bin1.png" /></th>
                              <th class="span2" width="20%"><?php echo $this->lang->line('transfer_code'); ?></th>
                              <th class="span2"><?php echo $this->lang->line('transfer_quantity'); ?></th>
                              <th class="span2"><?php echo $this->lang->line('transfer_unit'); ?></th>
                              <th class="span2"><?php echo $this->lang->line('transfer_cost'); ?></th>
                              <th class="span2" width="10%">IGST</th>
                              <th class="span2" width="5%">Inclusive ?</th>
                              <th class="span2"><?php echo $this->lang->line('transfer_sub_total'); ?></th>
                            </tr>
                          </thead>
                          <tbody id="product_table_body">
                            
                          </tbody>
                        </table>
                      </div>
                      <input type="hidden" name="total_value" id="total_value">
                      <input type="hidden" name="total_tax" id="total_tax">
                      <input type="hidden" name="grand_total" id="grand_total">
                      <input type="hidden" name="table_data" id="table_data">
                      <table class="table table-striped table-bordered table-condensed table-hover total_data">
                          <tr>
                            <td align="right" width="80%"><?php echo $this->lang->line('purchase_total_value').'('.$this->session->userdata('symbol').')'; ?></td>
                            <td align='right'><span id="totalValue">&nbsp;0.00</span></td>
                          </tr>
                          <tr>
                            <td align="right"><?php echo $this->lang->line('purchase_total_tax').'('.$this->session->userdata('symbol').')'; ?></td>
                            <td align='right'>
                              <span id="totalTax">&nbsp;0.00</span>
                            </td>
                          </tr>
                          <tr>
                            <td align="right"><?php echo $this->lang->line('purchase_total').'('.$this->session->userdata('symbol').')'; ?> </td>
                            <td align='right'><span id="grandTotal">&nbsp;0.00</span></td>
                          </tr>
                          <tr>
                            <td align="right">Round Off Value<?php echo '('.$this->session->userdata('symbol').')'; ?> </td>
                            <td align='right'><span id="round_off">0.00</span></td>
                          </tr>
                        </table>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                        <label for="note"><?php echo $this->lang->line('transfer_note'); ?> </label>
                        <textarea class="form-control" id="note" name="note"><?php echo set_value('details'); ?></textarea>
                        <span class="validation-color" id="err_details"><?php echo form_error('details'); ?></span>
                      </div>
                    </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-primary"><?php echo $this->lang->line('transfer_add'); ?></button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('transfer')"><?php echo $this->lang->line('product_cancel'); ?></span>
                  </div>
                </div>
              </div>
            </form>
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

  <script type="text/javascript">
  $(document).ready(function() {
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
                    var warehouse_id = $('#from_warehouse').val();                   
                    if(warehouse_id==""){
                      alert("Please Select From Warehouse");
                    }
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
                  var warehouse_id = $('#from_warehouse').val();
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
              var igst = data[0].igst;
              var cgst = data[0].cgst;
              var sgst = data[0].sgst;
              if(tax_value==null){
                tax_value = 0;
              }
              var product = { "product_id" : id,
                              "price" : price
                            };
              product_data[i] = product;

              length = product_data.length - 1 ;

              var igst_input ='<input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0" value="'+igst+'"><input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="'+igst+'">';

              var color;
              data[0].quantity>10?color="green":color="red";
              var newRow = $("<tr>");
              var cols = "";
              cols += "<td><a class='deleteRow'> <img src='<?php  echo base_url(); ?>assets/images/bin3.png' /> </a><input type='hidden' name='id' name='id' value="+i+"><input type='hidden' name='product_id' name='product_id' value="+id+"></td>";
              cols += "<td>"+name+"<br>HSN:"+hsn_sac_code+"</td>";
             
              cols += "<td>"
                      +"<input type='number' class='form-control text-center' value='0' data-rule='quantity' name='qty"+ counter +"' id='qty"+ counter +"' min='1' max='"+data[0].quantity+"'>" 
                      +"<span style='color:"+color+";'>Avai Qty: "+data[0].quantity+"</span>"
                    +"</td>";
              cols += "<td>"+data[0].unit+"</td>";
              cols += "<td>" 
                        +"<span id='price_span'>"
                          +"<input type='number'step='0.01' min='1' class='form-control text-right' name='price"+ counter +"' id='price"+ counter +"' value='"+price
                        +"'>"
                        +"</span>"
                        +"<span id='sub_total' class='pull-right'></span>"
                        +"<input type='hidden' class='form-control text-right' style='' value='0.00' name='linetotal"+ counter +"' id='linetotal"+ counter +"'>"
                      +"</td>";
              cols += '<td>'
                      +igst_input 
                      +'<span id="igst_tax_lbl" class="pull-right" style="color:red;"></span>'
                    +'</td>';
              cols += '<td>'
                      +'<input type="checkbox" id="tax_type" name="tax_type" value="Inclusive">'
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

    $("table.product_table").on("change", 'input[name^="price"], input[name^="qty"],input[name^="igst"],input[name^="cgst"],input[name^="sgst"],input[name^="tax_type"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateDiscountTax($(this).closest("tr"));
        calculateGrandTotal();
    });
    $('table.total_data').on('keyup change','input[name^="discount"],input[name^="shipping_charge"]',function(event){
        discount_shipping_change();
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
      var taxable_value = sales_total;

      var tax_type = row.find("input[name^='tax_type']:checked").val();      
      

      var igst = +row.find("#igst").val();

      if(tax_type =="Inclusive")
      {
        row.find('#product_total').val(taxable_value);

        var igst_tax = taxable_value - (taxable_value / ((igst /100) + 1 ));     
        var tax = igst_tax;
      }
      else
      {       
        tax_type = "Exclusive";
        var igst_tax = taxable_value*igst/100;
        var tax = igst_tax;
        row.find('#product_total').val(taxable_value+tax);
      } 

      row.find('#igst_tax').val(igst_tax);
      row.find('#igst_tax_lbl').text(igst_tax.toFixed(2));

      var key = +row.find('input[name^="id"]').val();
      product_data[key].tax_type = tax_type;
      product_data[key].igst = igst;
      product_data[key].igst_tax = igst_tax;
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
      product_data[key].price = price;
      product_data[key].total = (price * qty).toFixed(2);
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }
    function discount_shipping_change(){
      /*var discount = +$('#discount').val();
      var shipping_charge = +$('#shipping_charge').val();
      if(shipping_charge==""){
        shipping_charge = 0;  
      }
      if(discount==""){
        discount = 0;
      }*/
      var grandTotal = +$('#grand_total').val();
      //var grandTotal = (+grandTotal + +shipping_charge) - +discount;
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#round_off').text((Math.round(grandTotal)-grandTotal).toFixed(2));
    }
    function calculateGrandTotal() {
      var totalValue = 0;
      var grandTax = 0;
      var grandTotal = 0;
      $("table.product_table").find('input[name^="linetotal"]').each(function () {
        totalValue += +$(this).val();
      });
      $("table.product_table").find('input[name^="igst_tax"]').each(function () {
        grandTax += +$(this).val();
      });
      $("table.product_table").find('input[name^="product_total"]').each(function () {
        grandTotal += +$(this).val();
      });
      $('#totalValue').text(totalValue);
      $('#total_value').val(totalValue);
      $('#totalTax').text(grandTax.toFixed(2));
      $('#total_tax').val(grandTax.toFixed(2));
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#grand_total').val(grandTotal.toFixed(2));
      discount_shipping_change();
    }
});

</script>
<script>
  $(document).ready(function(){

    $("#submit").click(function(event){
      var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      var date = $('#date').val();
      var to_warehouse = $('#to_warehouse').val();
      var from_warehouse = $('#from_warehouse').val();
      var grand_total = $('#grand_total').val();


        if(date==null || date==""){
          $("#err_date").text("Please enter date");
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
        if (!date.match(date_regex) ) {
          $('#err_date').text("Please enter valid date ");   
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }

        if(to_warehouse==""){
          $("#err_to_warehouse").text("Please enter (To) warehouse");
          $('#to_warehouse').focus();
          return false;
        }
        else{
          $("#err_to_warehouse").text("");
        }

        if(from_warehouse==""){
          $("#err_from_warehouse").text("Please enter (From) warehouse");
          $('#from_warehouse').focus();
          return false;
        }
        else{
          $("#err_from_warehouse").text("");
        }

        if(from_warehouse === to_warehouse){
        $("#err_to_warehouse").text("Please select different warehouse");
        return false;
      }
      else{
        $("#err_to_warehouse").text("");
      }

        if(grand_total=="" || grand_total==null || grand_total==0.00){
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
          $("#err_date").text("Please enter date");
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
        if (!date.match(date_regex) ) {
          $('#err_date').text(" Please enter valid date ");   
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
    });
    $("#to_warehouse").change(function(event){
        var to_warehouse = $('#to_warehouse').val();
        if(to_warehouse==""){
        $("#err_to_warehouse").text("Please select (To) warehouse");
          $('#to_warehouse').focus();
          return false;
      }
      else{
          $("#err_to_warehouse").text("");
      }
    });
    $("#from_warehouse").change(function(event){
        var from_warehouse = $('#from_warehouse').val();
        var to_warehouse = $('#to_warehouse').val();
        $('#product_table_body').empty();
        $('#table_data').val('clear');
        $('#last_total').val('');
        $('#grand_total').val('');
        $('#grandtotal').text('0.00');
        $('#totaldiscount').text('0.00');
        $('#lasttotal').text('0.00');
        if(from_warehouse === to_warehouse){
          $("#err_from_warehouse").text("Please select different warehouse");
          return false;
        }
        else{
          $("#err_from_warehouse").text("");
        }
        if(from_warehouse==""){
        $("#err_from_warehouse").text("Please select (From) warehouse");
          $('#from_warehouse').focus();
          return false;
      }
      else{
          $("#err_from_warehouse").text("");
      }
    });

  }); 
</script>
<script src="<?php echo base_url('assets/plugins/autocomplite/') ?>jquery.auto-complete.js"></script>