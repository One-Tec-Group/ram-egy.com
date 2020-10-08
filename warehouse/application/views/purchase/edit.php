<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','purchaser','manager');
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
          <li><a href="<?php echo base_url('purchase'); ?>"><?php echo $this->lang->line('header_purchase'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('purchase_edit_purchase'); ?></li>
        </ol>
      </h5>    
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
      <form role="form" id="form" method="post" action="<?php echo base_url('purchase/editPurchase');?>">
      
      <div class="col-sm-12">
          <div class="box">

            <div class="box-header with-border general">
               <h3 class="box-title">Edit Purchase</h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
            </div>
            <div class="box-body general-data" style="">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                          <label for="date"><?php echo $this->lang->line('purchase_date'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo $data[0]->date;?>">
                          <input type="hidden" name="purchase_id" value="<?php echo $data[0]->purchase_id;?>">
                          <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                    </div>  
                  </div> 
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="warhouse"><?php echo $this->lang->line('purchase_select_warehouse'); ?> <span class="validation-color">*</span>
                      </label>
                      <a href="#" title="this is demo data" class="pull-right"><img src="<?php echo base_url('assets/images').'/info.png' ?>"/></a>

                      <select class="form-control select2" id="warehouse" name="warehouse" style="width: 100%;" disabled>
                        <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                        <?php  
                          foreach ($warehouse as $row) {
                        ?>
                            <option value='<?php echo $row->warehouse_id; ?>' <?php if($data[0]->warehouse_id==$warehouse_details[0]->warehouse_id) echo "selected"; ?>><?php echo $row->warehouse_name." - ".$row->branch_name; ?></option>
                        <?php 
                          }
                        ?> 
                      </select>  
                      <input type="hidden" name="warehouse" id="warehouse" value="<?php echo $data[0]->warehouse_id ?>">                      
                      <input type="hidden" name="warehouse_state_id" id="warehouse_state_id" value="<?php echo $warehouse_details[0]->warehouse_state_id; ?>">
                      
                      <span class="validation-color" id="err_warehouse"><?php echo form_error('warehouse');?></span>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                          <label for="reference_no"><?php echo $this->lang->line('purchase_reference_no'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control" id="reference_no" name="reference_no" value="<?php echo $data[0]->reference_no;?>" readonly>
                          <span class="validation-color" id="err_reference_no"><?php echo form_error('reference_no'); ?></span>
                        </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                          <label for="supplier">Supplier<span class="validation-color">*</span></label><!-- <a href="" data-toggle="modal" data-target="#supplier_model" class="pull-right">+ Add New Supplier</a> -->
                          <select class="form-control select2" id="supplier" name="supplier" style="width: 100%;" disabled>
                            <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                            <?php
                                  foreach ($supplier as  $key) {
                                  ?>
                                          <option value='<?php echo $key->supplier_id ?>' <?php if($key->supplier_id == $data[0]->supplier_id){echo "selected";} ?>><?php echo $key->supplier_name ?></option>
                                  <?php
                                      }
                                  ?>
                          </select>
                          <input type="hidden" name="supplier_state_id" id="supplier_state_id" value="<?php echo $supplier[0]->state_id; ?>">
                          <input type="hidden" name="supplier" id="supplier" value="<?php echo $data[0]->supplier_id; ?>">
                          <span class="validation-color" id="err_supplier"><?php echo form_error('supplier'); ?></span>
                        </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="box-header with-border billing">
                <h3 class="box-title">Billing & Shipping Address</h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
            </div>
            <div class="box-body billing-data">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-6">
                    <h5><b>Billing Address ( Company Address )</b></h5>
                        <span id="billing_address"><?php echo $company[0]->street; ?></span>
                    <br><span id="billing_city"><?php echo $company[0]->city_name; ?></span>
                    <br><span id="billing_state"><?php echo $company[0]->state_name; ?></span>
                    <br><span id="billing_country"><?php echo $company[0]->country_name; ?></span>
                  </div>
                  <div class="col-sm-6">
                    <h5><b>Shipping Address ( Warehouse Address )</b> <a href="" data-toggle="modal" data-target="#change_shipping_address">Change</a></h5>
                <?php  
                    foreach ($warehouse as $row) {
                      if($row->primary_warehouse != 1) continue;
                ?>
                        <span id="shipping-address"><?php echo $warehouse[0]->address; ?></span>
                    <br><span id="shipping-city"><?php echo $warehouse[0]->city_name; ?></span>
                    <br><span id="shipping-state"><?php echo $warehouse[0]->state_name; ?></span>
                    <br><span id="shipping-country"><?php echo $warehouse[0]->country_name; ?></span>
                <?php 
                    }      
                ?>
                  </div>
                </div>
              </div>
            </div>   
            <div class="box-header with-border supplier">
               <h3 class="box-title">Supplier & Transportation Details</h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
            </div>
            <div class="box-body supplier-data" style="">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-3">
                    <div class="form-group">
                          <label for="supplier_ref">Supplier Invoice</label>
                          <input type="text" class="form-control" id="supplier_ref" name="supplier_ref" value="<?php echo $data[0]->supplier_ref; ?>">
                          <span class="validation-color" id="err_supplier_ref"><?php echo form_error('supplier_ref'); ?></span>
                        </div>
                  </div>                    
                  <div class="col-sm-3">
                    <div class="form-group">
                          <label for="buyer_order">Supplier Order</label>
                          <input type="text" class="form-control" id="buyer_order" name="buyer_order" value="<?php echo $data[0]->buyer_order; ?>" >
                          <span class="validation-color" id="err_buyer_order"><?php echo form_error('buyer_order'); ?></span>
                        </div>  
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                          <label for="dispatch_document_no">Dispatch Document No</label>
                          <input type="text" class="form-control" id="dispatch_document_no" name="dispatch_document_no" value="<?php echo $data[0]->dispatch_document_no; ?>">
                          <span class="validation-color" id="err_dispatch_document_no"><?php echo form_error('dispatch_document_no'); ?></span>
                        </div>  
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                          <label for="delivery_note_date">Delivery Note Date</label>
                          <input type="text" class="form-control datepicker" id="delivery_note_date" name="delivery_note_date" value="<?php echo $data[0]->delivery_note_date; ?>">
                          <span class="validation-color" id="err_delivery_note_date"><?php echo form_error('delivery_note_date'); ?></span>
                        </div>  
                  </div>
                  <div class="col-sm-3">
                  <div class="form-group">
                          <label for="dispatch_through">Received Via</label>
                          <input type="text" class="form-control" id="dispatch_through" name="dispatch_through" value="<?php echo $data[0]->dispatch_through; ?>">
                          <span class="validation-color" id="err_dispatch_through"><?php echo form_error('dispatch_through'); ?></span>
                        </div>  
                  </div>                                       
                </div>
              </div>
            </div>
            <div class="box-header with-border others">
                <h3 class="box-title">Others</h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
            </div>
            <div class="box-body others-data">
              <div class="col-sm-12">
              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="rack_no">Rack No.</label>
                    <input type="text" class="form-control" id="rack_no" name="rack_no" value="<?php echo $data[0]->rack_no; ?>">
                    <span class="validation-color" id="err_rack_no"><?php echo form_error('rack_no'); ?></span>
                  </div>  
                </div>                    
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="discount">Discount</label>
                    <input class="form-control" id="discount" name="discount" value="<?php echo $data[0]->flat_discount; ?>">
                  </div>  
                </div>                                     
              </div>
              </div>
            </div>         
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">  
                <div class="col-sm-12">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-12 search_product_code">
                        <input id="input_product_code" class="form-control" autofocus type="text" name="input_product_code" placeholder="Enter Product Code/Name">
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
                          <th class="span2" width="5%">Inclusive ?</th>
                          <th class="span2" width="10%"><?php echo $this->lang->line('purchase_total'); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $i=0;
                          $tot=0;
                          foreach ($items as  $key) {
                          ?>
                          <tr>
                            <td>
                              <a class='deleteRow1'> <img src='<?php  echo base_url(); ?>assets/images/bin3.png' /> </a><input type='hidden' name='id' name='id' value="<?php echo $i ?>">
                              <input type='hidden' name='product_id' name='product_id' value="<?php echo $key->product_id ?>">
                            </td>
                            <td><?php echo $key->name; ?><br>HSN: <?php echo $key->hsn_sac_code; ?></td>
                            <td><?php echo $key->unit ?></td>
                            <td>
                              <input type="number" class="form-control text-center" value="<?php echo $key->quantity ?>" data-rule="quantity" name='qty' id='qty' min="1">
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
                                    <option value='<?php echo $dis->discount_id ?>' 
                                  <?php if($key->discount_id == $dis->discount_id){echo "selected";} ?>>
                                    <?php echo $dis->discount_name.'('.$dis->discount_value.')' ?></option>
                                  <?php
                                    } 
                                  ?>
                                </select>
                              </div>
                            </td>
                            <td align="right">
                              <span id="taxable_value"><?php echo $key->gross_total - $key->discount ?></span>
                            </td>
                            <?php if($supplier[0]->state_id == $warehouse_details[0]->warehouse_state_id){ ?>
                            <td>
                              <input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0" value="<?php echo $key->igst; ?>" disabled>
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
                            <?php }else{
                            ?>
                            <td>
                              <input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0" value="<?php echo $key->igst; ?>">
                              <input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="<?php echo $key->igst_tax; ?>">
                              <span id="igst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->igst_tax; ?></span>
                            </td>
                            <td>
                              <input type="number" step="0.01" name="cgst" id="cgst" class="form-control" max="100" min="0" value="<?php echo $key->cgst; ?>" disabled>
                              <input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control" value="<?php echo $key->cgst_tax; ?>">
                              <span id="cgst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->cgst_tax; ?></span>
                            </td>
                            <td>
                              <input type="number" step="0.01" name="sgst" id="sgst" class="form-control" max="100" min="0" value="<?php echo $key->sgst; ?>" disabled>
                              <input type="hidden" name="sgst_tax" id="sgst_tax" class="form-control" value="<?php echo $key->sgst_tax; ?>">
                              <span id="sgst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->sgst_tax; ?></span>
                            </td>
                            <?php
                              } 
                            ?>
                            <td>
                              <input type="checkbox" id="tax_type" name="tax_type" value="Inclusive"
                              <?php 
                                if($key->tax_type == "Inclusive") echo ' checked';
                              ?> 
                              >
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
                            //echo "<pre>";
                            //print_r($product_data);
                            $grandtotal = $data[0]->total;
                            $product = json_encode($product_data);

                          ?>
                      </tbody>
                    </table>
                    <input type="hidden" name="total_value" id="total_value" value='<?php echo $tot; ?>'>
                    <input type="hidden" name="total_discount" id="total_discount" value='<?php echo $data[0]->discount_value; ?>'>
                    <input type="hidden" name="total_tax" id="total_tax" value='<?php echo $data[0]->tax_value; ?>'>
                    <input type="hidden" name="grand_total" id="grand_total" value='<?php echo $data[0]->total; ?>'>
                    <input type="hidden" name="table_data" width="100%" id="table_data" value='<?php echo $product; ?>'>
                    <input type="hidden" name="table_data1" id="table_data1">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                      <tr>
                        <td align="right" width="80%"><?php echo $this->lang->line('purchase_total_value'); ?></td>
                        <td align='right'><?php echo $this->session->userdata('symbol'); ?><span id="totalValue"><?php echo $tot; ?></span></td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total_discount'); ?></td>
                        <td align='right'>
                          <?php echo $this->session->userdata('symbol'); ?><span id="totalDiscount"><?php echo $data[0]->discount_value; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total_tax'); ?></td>
                        <td align='right'>
                          <?php echo $this->session->userdata('symbol'); ?><span id="totalTax"><?php echo $data[0]->tax_value; ?></span>
                        </td>
                      </tr>
                      <tr>
                        <td align="right"><?php echo $this->lang->line('purchase_total'); ?></td>
                        <td align='right'><?php echo $this->session->userdata('symbol'); ?><span id="grandTotal"><?php echo $data[0]->total; ?></span></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                      <label for="details"><?php echo $this->lang->line('purchase_note'); ?></label>
                      <textarea class="form-control" id="note" name="note"><?php echo $data[0]->note;?></textarea>
                      <span class="validation-color" id="err_details"><?php echo form_error('details'); ?></span>
                    </div>
                  </div>
                </div>                
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info"><?php echo $this->lang->line('product_update'); ?></button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('purchase')"><?php echo $this->lang->line('product_cancel'); ?></span>
                  </div>
                </div>
                <div id="change_shipping_address" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>New Shipping Address</h4>
                      </div>
                      <div class="modal-body">
                        <div class="control-group">                     
                          <div class="controls">
                            <div class="tabbable">
                              <div class="box-body">
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
                                        <?php
                                          $country = $this->db->get('countries')->result();
                                          foreach ($country as  $key) {
                                        ?>
                                        <option 
                                          value='<?php echo $key->id ?>' 
                                          <?php 
                                            /*if(isset($data[0]->country_id)){
                                              if($key->id == $data[0]->country_id){
                                                echo "selected";
                                              }
                                            }*/ 
                                          ?>
                                        >
                                        <?php echo $key->name; ?>
                                        </option>
                                        <?php
                                          }
                                        ?>
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
                                  <div class="col-sm-12">
                                    <div class="box-footer">                                  
                                      <button id="btn_shipping_change" class="btn btn-info" class="close"  data-dismiss="modal">&nbsp;&nbsp;&nbsp;Change&nbsp;&nbsp;&nbsp;</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
    include('warehouse.php');
    include('supplier.php');

    $this->load->view('layout/product_footer');
    include('assign_warehouse.php');
  ?>
<script type="text/javascript">
  
  $('#btn_shipping_change').click(function(){
    $.ajax({
      url : '<?php echo base_url('customer/customer_sort_data') ?>',
      dataType : 'JSON',
      method : 'POST',
      data:{
          'country':$("#country").val(),
          'state':$("#state").val(),
          'city':$("#city").val()
      },
      success : function(data){
        $('#shipping-address').text($("#address").val());
        $('#shipping-city').text(data.city);
        $('#shipping-state').text(data.state);
        $('#shipping-country').text(data.country);
        $('#shipping-postal_code').text('');
      }
    }); 
  });
  
  $('#form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });
</script>
 
<script>
$(document).ready(function(){
    var i = <?php echo $i++; ?>;
    var product_data = new Array();
    var existing_product_id = new Array();
    existing_product_id = JSON.parse($("#table_data").val());

    //product_data = JSON.parse($("#table_data").val());
    var counter = <?php echo count($items); ?>;
    var mapping = { };
     $(function(){
            $('#input_product_code').autoComplete({
                minChars: 1,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    $.ajax({
                      url: "<?php echo base_url('purchase/getBarcodeProducts') ?>/"+term,
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
                  $.ajax({
                    url:"<?php echo base_url('purchase/getProductUseCode') ?>/"+mapping[str[0]],
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
              var price = data[0].cost;
              // var tax_id = data[0].tax_id;
              // var tax_value = data[0].tax_value;
              var igst = data[0].igst;
              var cgst = data[0].cgst;
              var sgst = data[0].sgst;
              // if(tax_value==null){
              //   tax_value = 0;
              // }
              var product = { 
                              "product_id" : id,
                              "cost" : price
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
              var biller_state_id = $('#warehouse_state_id').val();
              var supplier_state_id = $('#supplier_state_id').val();
              if(biller_state_id==supplier_state_id){
                var igst_input ='<input name="igst" id="igst" class="form-control" value="0" readonly><input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="0">';
                var cgst_input ='<input type="number" step="0.01" name="cgst" id="cgst" class="form-control" max="100" min="0" value="'+cgst+'"><input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control" value="'+cgst+'">';
                var sgst_input ='<input type="number" step="0.01" name="sgst" id="sgst" class="form-control" max="100" min="0" value="'+sgst+'"><input type="hidden" name="sgst_tax" id="sgst_tax" class="form-control" value="'+sgst+'">';
              }
              else{
                var igst_input ='<input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0" value="'+igst+'"><input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="'+igst+'">';
                var cgst_input ='<input name="cgst" id="cgst" class="form-control" value="0" readonly><input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control" value="0">';
                var sgst_input ='<input name="sgst" id="sgst" class="form-control" value="0" readonly><input type="hidden" name="sgst_tax" id="sgst_tax" class="form-control" value="0">';
              }
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
                      +igst_input 
                      +'<span id="igst_tax_lbl" class="pull-right" style="color:red;"></span>'
                    +'</td>';
              cols += '<td>'
                      +cgst_input
                      +'<span id="cgst_tax_lbl" class="pull-right" style="color:red;"></span>'
                    +'</td>';
              cols += '<td>'
                      +sgst_input
                      +'<span id="sgst_tax_lbl" class="pull-right" style="color:red;"></span>'
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
              //alert('add row function'+$('#table_data').val());
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

    $("table.product_table").on("change", 'input[name^="price"], input[name^="qty"],input[name^="igst"],input[name^="cgst"],input[name^="sgst"],input[name^="tax_type"]', function (event) {
        //alert('on click of taxtype')
        calculateRow($(this).closest("tr"));
        calculateDiscountTax($(this).closest("tr"));
        calculateGrandTotal();
        //alert('on click of taxtype finish')
       
        //alert('on change of other parameter other than in discount table data'+$('#table_data').val());

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
            //alert('with discount');
            calculateRow(row);
            calculateDiscountTax(row,data[0].discount_value);
            calculateGrandTotal();
            //alert('on change table data'+$('#table_data').val());
          }
        });
      }
      else{
        row.find('#discount_value').val('0');
        // alert('without discount');
        // alert('discount change beging');
        calculateRow(row);
        calculateDiscountTax(row,0);
        calculateGrandTotal();
        // alert('discount change end');
      }
    });

    function calculateRow(row) {
      // alert('in calculate row ');
      var key = +row.find('input[name^="id"]').val();
      var price = +row.find('input[name^="price"]').val();
      var qty = +row.find('input[name^="qty"]').val();
      var product_id = +row.find('input[name^="product_id"]').val();
      row.find('input[name^="linetotal"]').val((price * qty).toFixed(2));
      row.find('#sub_total').text((price * qty).toFixed(2));
      //alert(key +" "+ price+" "+qty);
      if(product_data[key]==null){
        var temp = {
          "product_id" : product_id,
          "cost" : price,
          "quantity" : qty,
          "total" : (price * qty).toFixed(2)
        };
        product_data[key] = temp;
      }
      product_data[key].quantity = qty;
      product_data[key].cost = price;
      product_data[key].total = (price * qty).toFixed(2);
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);

    }

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
    
      var igst = +row.find("#igst").val();
      var cgst = +row.find("#cgst").val();
      var sgst = +row.find("#sgst").val();

    
    
      var tax_type = row.find("input[name^='tax_type']:checked").val();      

      if(tax_type =="Inclusive")
      {
        //row.find('#product_total').val(taxable_value);
        var taxable_value = (sales_total - total_discount)*100/(100 + igst + cgst + sgst);
        var igst_tax = taxable_value*igst/100;
        var cgst_tax = taxable_value*cgst/100;
        var sgst_tax = taxable_value*sgst/100;     
        var tax = igst_tax+cgst_tax+sgst_tax;

        row.find('#taxable_value').text((taxable_value).toFixed(2));
        row.find('#product_total').val((taxable_value + tax).toFixed(2));
    
      }
      else
      {       
        tax_type = "Exclusive";
        var taxable_value = sales_total - total_discount;
        var igst_tax = taxable_value*igst/100;
        var cgst_tax = taxable_value*cgst/100;
        var sgst_tax = taxable_value*sgst/100;
        var tax = igst_tax+cgst_tax+sgst_tax;
        
        row.find('#product_total').val((taxable_value+tax).toFixed(2));
        row.find('#taxable_value').text(taxable_value.toFixed(2));
      } 

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
      product_data[key].tax_type = tax_type;
      product_data[key].igst = igst;
      product_data[key].igst_tax = igst_tax;
      product_data[key].cgst = cgst;
      product_data[key].cgst_tax = cgst_tax;
      product_data[key].sgst = sgst;
      product_data[key].sgst_tax = sgst_tax;
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }
    
    function calculateGrandTotal() {
      // alert('in grand total');
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

      $('#totalValue').text(totalValue.toFixed(2));
      $('#total_value').val(totalValue.toFixed(2));
      $('#totalDiscount').text(totalDiscount.toFixed(2));
      $('#total_discount').val(totalDiscount.toFixed(2));
      $('#totalTax').text(grandTax.toFixed(2));
      $('#total_tax').val(grandTax.toFixed(2));
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#grand_total').val(grandTotal.toFixed(2));
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }

    $('#country').change(function(){
      var id = $(this).val();
      //alert(id);
      $('#state').html('<option value="">Select</option>');
      //$('#state_code').val('');
      $('#city').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('supplier/getState') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#state').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
      });
    });

    $('#state').change(function(){
      var id = $(this).val();
      var country = $('#country').val();
      $('#city').html('<option value="">Select</option>');
      //$('#state_code').val('');
      $.ajax({
          url: "<?php echo base_url('supplier/getCity') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#city').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
      /*$.ajax({
          url: "<?php //echo base_url('biller/getStateCode') ?>/"+id+'/'+country,
          type: "GET",
          dataType: "TEXT",
          success: function(data){
            $('#state_code').val(data);
          }
        });*/
    });

    $("#submit").click(function(event){
      var name_regex = /^[a-zA-Z]+$/;
      var sname_regex = /^[a-zA-Z0-9]+$/;
      var num_regex = /^[0-9]+$/;
      var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      var date = $('#date').val();
      var warehouse = $('#warehouse').val();
      var supplier = $('#supplier').val();
      var grand_total = $('#grand_total').val();
      var table_data = $('#table_data').val();
      var table_data_array = new Array();
      
      table_data_array = JSON.parse(table_data);
      for(i = 0 ; i < table_data_array.length ; i++){
        if(table_data_array[i] == "delete"){
          table_data_array[i] = existing_product_id[i];
        }
      }
      
      $('#table_data').val(JSON.stringify(table_data_array));
    
        if(date==null || date==""){
          $("#err_date").text("Please Enter Date");
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
        if (!date.match(date_regex) ) {
          $('#err_date').text(" Please Enter Valid Date ");   
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
//date codevalidation complite.
       

//warehouse code validation complite.

        if(supplier==""){
          $("#err_supplier").text("Please Enter Supplier");
          $('#supplier').focus();
          return false;
        }
        else{
          $("#err_supplier").text("");
        }
//supplier code validation complite.

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
          $("#err_date").text("Please Enter Date");
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
        }
        if (!date.match(date_regex) ) {
          $('#err_date').text(" Please Enter Valid Date ");   
          $('#date').focus();
          return false;
        }
        else{
          $("#err_date").text("");
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
        $.ajax({
          url: "<?php echo base_url('purchase/getBillerState') ?>/"+biller,
          type: "GET",
          dataType: "json",
          success: function(data){
            $('#biller_state_id').val(data.state);
            $('#warehouse').val(data.warehouse);
          }
        });
      }
    });

    $("#supplier").change(function(event){
      var supplier = $('#supplier').val();
      if(supplier==""){
        $("#err_supplier").text("Please Enter Supplier");
        $('#supplier').focus();
        return false;
      }
      else{
        $.ajax({
          url: "<?php echo base_url('purchase/getSupplierState') ?>/"+supplier,
          type: "GET",
          dataType: "text",
          success: function(data){
            $('#supplier_state_id').val(data);
          }
        });
        $("#err_supplier").text("");
      }
    });

});

</script>


<script>
  $('.billing').show();
  $('.billing-data').show();
  $('.supplier-data').hide();
  $('.others-data').hide();
</script>
<script>
  $('.general').click(function(){
    $('.general-data').toggle('slow');
  });
  $('.billing').click(function(){
    $('.billing-data').toggle('slow');
  });
  $('.supplier').click(function(){
    $('.supplier-data').toggle('slow');
  });
  $('.others').click(function(){
    $('.others-data').toggle('slow');
  });
</script>
<script src="<?php echo base_url('assets/plugins/autocomplite/') ?>jquery.auto-complete.js"></script>