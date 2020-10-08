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
          <li><a href="<?php echo base_url('sales'); ?>"><?php echo $this->lang->line('header_sales'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('sales_edit_sales'); ?></li>
        </ol>
      </h5>    
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
        <div class="col-sm-12">
          <form role="form" id="form" method="post" action="<?php echo base_url('sales/editSales');?>">
            <div class="box">
              <div class="box-header with-border general">
                <h3 class="box-title"><?php echo "Reference No : ".$data[0]->reference_no; ?>
                </h3>
                <span class="pull-right-container">
                  <i class="glyphicon glyphicon-chevron-right pull-right"></i>
                </span>
              </div>
              <div class="box-body general-data">
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="date"><?php echo $this->lang->line('purchase_date'); ?><span class="validation-color">*</span></label>
                        <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo $data[0]->date;  ?>">
                        <input type="hidden" name="sales_id" value="<?php echo $data[0]->sales_id;?>">
                        <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="warehouse"><?php echo $this->lang->line('purchase_select_warehouse'); ?> <span class="validation-color">*</span></label>
                        <select class="form-control select2" id="user_id" name="user_id" style="width: 100%;" disabled>
                          <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                          <?php
                            foreach ($warehouse as  $key) {
                          ?>
                            <option value='<?php echo $key->user_id; ?>' <?php if($key->warehouse_id == $data[0]->warehouse_id){echo "selected";} ?>><?php echo $key->warehouse_name ?></option>
                          <?php
                            }
                          ?>  
                        </select>
                        <input type="hidden" name="biller_state_id" id="biller_state_id" value="<?php echo $biller_state_id;?>">
                        <input type="hidden" name="biller" id="biller" value="<?php echo $biller_id;?>">
                        <input type="hidden" name="warehouse" id="warehouse" value="<?php echo $data[0]->warehouse_id;?>">
                        <span class="validation-color" id="err_warehouse"><?php echo form_error('warehouse');?></span>
                      </div>
                    </div>
                    <!--
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="biller"><?php // echo $this->lang->line('sales_select_biller'); ?> <span class="validation-color">*</span></label>
                        <select class="form-control select2" id="biller" name="biller" style="width: 100%;">
                          <option value=""><?php // echo $this->lang->line('product_select'); ?></option>
                          <?php
                          //foreach ($biller as  $key) {
                          ?>
                                  <option value='<?php // echo $key->biller_id ?>' <?php // if($key->biller_id == $data[0]->biller_id){echo "selected";} ?>><?php // echo $key->biller_name ?></option>
                          <?php
                             // }
                          ?>
                        </select>
                        <input type="hidden" name="biller_state_id" id="biller_state_id" value="<?php // echo $data[0]->biller_state_id;?>">
                        <span class="validation-color" id="err_biller"><?php // echo form_error('biller');?></span>
                      </div>
                    </div>
                  -->
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="customer">Customer <span class="validation-color">*</span></label><!-- <a href="" data-toggle="modal" data-target="#myModal" class="pull-right">+</a> -->
                        <select class="form-control select2" id="customer_id" name="customer_id" style="width: 100%;" disabled>
                          <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                          <?php
                          foreach ($customer as  $key) {
                          ?>
                                  <option value='<?php echo $key->customer_id ?>' <?php if($key->customer_id == $data[0]->customer_id){echo "selected";} ?>><?php echo $key->customer_name ?></option>
                          <?php
                              }
                          ?>
                        </select>
                        <input type="hidden" name="shipping_state_id" id="shipping_state_id" value="<?php echo $shipping_state_id; ?>">
                        <input type="hidden" name="customer" id="customer" value="<?php echo $data[0]->customer_id; ?>">

                        <span class="validation-color" id="err_customer"><?php echo form_error('customer');?></span>
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
                      <h5><b>Billing Address</b></h5>
                          <span id="billing_address"><?php echo $data[0]->billing_address; ?></span>
                      <br><span id="billing_city"><?php echo $data[0]->billing_city; ?></span>
                      <br><span id="billing_state"><?php echo $data[0]->billing_state; ?></span>
                      <br><span id="billing_country"><?php echo $data[0]->billing_country; ?></span>
                      <br><span id="billing_postal_code"><?php echo $data[0]->billing_postal_code; ?></span>
                    </div>
                    <div class="col-sm-6">
                      <h5><b>Shipping Address</b> <a href="" data-toggle="modal" data-target="#change_shipping_address">Change</a></h5>
                          <span id="shipping-address"><?php echo $data[0]->shipping_address; ?></span>
                      <br><span id="shipping-city"><?php echo $data[0]->shipping_city; ?></span>
                      <br><span id="shipping-state"><?php echo $data[0]->shipping_state; ?></span>
                      <br><span id="shipping-country"><?php echo $data[0]->shipping_country; ?></span>
                      <br><span id="shipping-postal_code"><?php echo $data[0]->shipping_postal_code; ?></span>
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
              <div class="box-body supplier-data">
                <div class="col-sm-12">
                  <div class="">
                    <div class="row">
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="supply_type">Transportation Mode</label>
                          <select id="supply_type" name="supply_type" class="form-control select2" style="width: 100%;">
                            <option value="O" <?php if(isset($data[0]->supply_type)){ if($data[0]->supply_type == "O") echo "selected"; }?>>Outward Supply</option>
                            <option value="I" <?php if(isset($data[0]->supply_type)){ if($data[0]->supply_type == "I") echo "selected"; }?>>Inward Supply</option>
                          </select>
                          <span class="validation-color" id="err_supply_type"><?php echo form_error('supply_type'); ?></  span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="sub_supply_type">Transportation Mode</label>
                          <select id="sub_supply_type" name="sub_supply_type" class="form-control select2" style="width: 100%;">
                            <option value="1" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "1") echo "selected";} ?>>Supply</option>
                            <option value="2" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "2") echo "selected";} ?>>Import</option>
                            <option value="3" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "3") echo "selected";} ?>>Export</option>
                            <option value="4" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "4") echo "selected";} ?>>Job Work</option>
                            <option value="5" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "5") echo "selected";} ?>>For Own Use</option>
                            <option value="6" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "6") echo "selected";} ?>>Job work Returns</option>
                            <option value="7" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "7") echo "selected";} ?>>Sales Return</option>
                            <option value="8" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "8") echo "selected";} ?>>Others</option>
                            <option value="9" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "9") echo "selected";} ?>>SKD/CKD</option>
                            <option value="10" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "10") echo "selected";} ?>>Line Sales</option>
                            <option value="11" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "11") echo "selected";} ?>>Recipient  Not Known</option>
                            <option value="12" <?php if(isset($data[0]->sub_supply_type)){ if($data[0]->sub_supply_type == "12") echo "selected";} ?>>Exhibition or Fairs</option>
                          </select>
                          <span class="validation-color" id="err_sub_supply_type"><?php echo form_error('sub_supply_type'); ?></  span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="trans_mode">Transportation Mode</label>
                          <select id="trans_mode" name="trans_mode" class="form-control select2" style="width: 100%;">
                            <option value="1" <?php if(isset($data[0]->trans_mode)){ if($data[0]->trans_mode == "1") echo "selected"; }?>>Road</option>
                            <option value="2" <?php if(isset($data[0]->trans_mode)){ if($data[0]->trans_mode == "2") echo "selected"; }?>>Rail</option>
                            <option value="3" <?php if(isset($data[0]->trans_mode)){ if($data[0]->trans_mode == "3") echo "selected"; }?>>Air</option>
                            <option value="4" <?php if(isset($data[0]->trans_mode)){ if($data[0]->trans_mode == "4") echo "selected"; }?>>Ship</option>
                          </select>
                          <span class="validation-color" id="err_trans_mode"><?php echo form_error('trans_mode'); ?></  span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="trans_distance">Approx Dist to Transport (Km)</label>
                          <input type="text" class="form-control" id="trans_distance" name="trans_distance" value="<?php if(isset($data[0]->trans_distance)){ echo $data[0]->trans_distance;} ?>" placeholder="150">
                          <span class="validation-color" id="err_trans_distance"><?php echo form_error('trans_distance'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="transporter_name">Transporter Name</label>
                          <input type="text" class="form-control" id="transporter_name" name="transporter_name" value="<?php if(isset($data[0]->transporter_name)){ echo $data[0]->transporter_name; }?>">
                          <span class="validation-color" id="err_transporter_name"><?php echo form_error('transporter_name'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="transporter_id">Transporter Id </label>
                          <input type="text" class="form-control" id="transporter_id" name="transporter_id" value="<?php if(isset($data[0]->transporter_id)){ echo $data[0]->transporter_id; }?>" placeholder="Eg. 29AMRPV8729L1Z1">
                          <span class="validation-color" id="err_transporter_id"><?php echo form_error('transporter_id'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="trans_doc_no">Transporter Doc No</label>
                          <input type="text" class="form-control" id="trans_doc_no" name="trans_doc_no" value="<?php if(isset($data[0]->trans_doc_no)){ echo $data[0]->trans_doc_no; }?>" placeholder="Eg. TA120">
                          <span class="validation-color" id="err_trans_doc_no"><?php echo form_error('trans_doc_no'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="trans_doc_date">Transporter Doc Date</label>
                          <input type="text" class="form-control datepicker" id="trans_doc_date" name="trans_doc_date" value="<?php if(isset($data[0]->trans_doc_date)){ echo $data[0]->trans_doc_date; }?>">
                          <span class="validation-color" id="err_trans_doc_date"><?php echo form_error('trans_doc_date'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="vehicle_no">Vehicle No</label>
                          <input type="text" class="form-control" id="vehicle_no" name="vehicle_no" value="<?php if(isset($data[0]->vehicle_no)){ echo $data[0]->vehicle_no; }?>">
                          <span class="validation-color" id="err_vehicle_no"><?php echo form_error('vehicle_no'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="vehicle_type">Vehicle Type</label>
                          <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" value="<?php if(isset($data[0]->vehicle_type)){  echo $data[0]->vehicle_type; }?>">
                          <span class="validation-color" id="err_vehicle_type"><?php echo form_error('vehicle_type'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="supplier_ref">Supplier Reference</label>
                          <input type="text" class="form-control" id="supplier_ref" name="supplier_ref" value="<?php echo $data[0]->supplier_ref; ?>">
                          <span class="validation-color" id="err_supplier_ref"><?php echo form_error('supplier_ref'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="buyer_order">Buyer Order</label>
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
                          <label for="dispatch_through">Dispatched Through</label>
                          <input type="text" class="form-control" id="dispatch_through" name="dispatch_through" value="<?php echo $data[0]->dispatch_through; ?>">
                          <span class="validation-color" id="err_dispatch_through"><?php echo form_error('dispatch_through'); ?></span>
                        </div>
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
                  <div class="">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Sales Type</label>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="sales_type" id="sales_type" value="0" <?php if($data[0]->sales_type==0){ echo 'checked';} ?>> Through E-commerce &nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="sales_type" id="sales_type" value="1" <?php if($data[0]->sales_type==1){ echo 'checked';} ?>> Other than E-commerce 
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <input type="checkbox" class="" id="gst_payable" name="gst_payable" value="Y" <?php if($data[0]->gst_payable=='Y'){ echo 'checked';} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
                          <label for="gst_payable">GST Payable On Reverse Charge</label>
                          <span class="validation-color" id="err_gst_payable"><?php echo form_error('gst_payable'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="sales_invoice">Invoice Type</label>
                          <select id="sales_invoice" name="sales_invoice" class="form-control select2" style="width: 100%;">
                            <option value="1" <?php if($data[0]->sales_invoice==1){ echo 'selected';} ?>>Regular</option>
                            <option value="2" <?php if($data[0]->sales_invoice==2){ echo 'selected';} ?>>SEZ Supplies with Payment</option>
                            <option value="3" <?php if($data[0]->sales_invoice==3){ echo 'selected';} ?>>SEZ Supplies without Payment</option>
                            <option value="4" <?php if($data[0]->sales_invoice==4){ echo 'selected';} ?>>Deemed Export</option>
                          </select>
                          <span class="validation-color" id="err_shipping_charge"><?php echo form_error('shipping_charge'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-9 invoice_type_hide">
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="port_code">Port Code</label>
                            <input type="text" name="port_code" id="port_code" class="form-control" value="<?php echo $data[0]->port_code; ?>">
                            <span class="validation-color" id="err_port_code"><?php echo form_error('port_code'); ?></span>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="shipping_bill_no">Shipping Bill Number</label>
                            <input type="text" name="shipping_bill_no" id="shipping_bill_no" class="form-control" value="<?php echo $data[0]->shipping_bill_no; ?>">
                            <span class="validation-color" id="err_shipping_bill_no"><?php echo form_error('shipping_bill_no'); ?></span>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="shipping_bill_date">Shipping Bill Date</label>
                            <input type="text" name="shipping_bill_date" id="shipping_bill_date" class="form-control datepicker" value="<?php echo $data[0]->shipping_bill_date; ?>">
                            <span class="validation-color" id="err_shipping_bill_date"><?php echo form_error('shipping_bill_date'); ?></span>
                          </div>
                        </div>
                      </div>
                      <?php
                        if($data[0]->sales_invoice==1){
                      ?>
                        <script>
                          $('.invoice_type_hide').hide();
                        </script>
                      <?php
                        }
                      ?>
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
                            <th class="span2" width="5%">Inclusive ?</th>
                            <th class="span2" width="10%"><?php echo $this->lang->line('purchase_total'); ?></th>
                          </tr>
                        </thead>
                        <tbody id="product_table_body">
                          <?php
                          $i=0;
                          $tot=0;
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
                                <input type='number' step='0.01' class='form-control text-right' name='price' id='price' value='<?php echo $key->price ?>'>
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
                                <span id="taxable_value">
                                  <?php 
                                    if($key->tax_type == "Inclusive"){
                                      echo $key->gross_total - $key->discount - $key->igst_tax - $key->cgst_tax - $key->sgst_tax ;   
                                    }else{
                                      echo $key->gross_total - $key->discount ;   
                                    }
                                  ?>
                                </span>
                              </td>
                              <?php 
                                if($biller_state_id==$data[0]->shipping_state_id){
                              ?>
                              <td>
                                <input name="igst" id="igst" class="form-control" max="100" min="0" value="0" readonly>
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
                              <?php
                                }
                                else{
                              ?>
                              <td>
                                <input type="number" step="0.01" name="igst" id="igst" class="form-control" max="100" min="0" value="<?php echo $key->igst; ?>">
                                <input type="hidden" name="igst_tax" id="igst_tax" class="form-control" value="<?php echo $key->igst_tax; ?>">
                                <span id="igst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->igst_tax; ?></span>
                              </td>
                              <td>
                                <input name="cgst" id="cgst" class="form-control" max="100" min="0" value="0" readonly>
                                <input type="hidden" name="cgst_tax" id="cgst_tax" class="form-control" value="<?php echo $key->cgst_tax; ?>">
                                <span id="cgst_tax_lbl" class="pull-right" style="color:red;"><?php echo $key->cgst_tax; ?></span>
                              </td>
                              <td>
                                <input name="sgst" id="sgst" class="form-control" max="100" min="0" value="0" readonly>
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
                                <input type="text" class="form-control text-right" id="product_total" name="product_total" value=" <?php if($key->tax_type == "Inclusive") {echo $key->gross_total - $key->discount; }else{echo $key->gross_total - $key->discount + $key->igst_tax + $key->cgst_tax + $key->sgst_tax; } ?>" readonly>
                              </td>
                          </tr>
                          <?php
                              $product_data[$i] = $key->product_id;
                              //array_push($product_data,$product);
                              $i++;
                              //$tot += $key->gross_total;

                              if($key->tax_type == "Inclusive"){
                                $tot += $key->gross_total - $key->discount - $key->igst_tax - $key->cgst_tax - $key->sgst_tax ; 
                              }else{
                                $tot += $key->gross_total - $key->discount; 
                              }
                            }


                            if($items!=null){
                              $grandtotal = $data[0]->total;
                              $product = json_encode($product_data);
                            }
                            
                          ?>
                        </tbody>
                      </table>
                      
                      <input type="hidden" name="total_value" id="total_value" value='<?php echo $tot; ?>'>
                      <input type="hidden" name="total_discount" id="total_discount" value='<?php echo $data[0]->discount_value; ?>'>
                      <input type="hidden" name="total_tax" id="total_tax" value='<?php echo $data[0]->tax_value; ?>'>
                      <input type="hidden" name="grand_total" id="grand_total" value='<?php echo $data[0]->total-$data[0]->shipping_charge+$data[0]->flat_discount; ?>'>
                      <input type="hidden" name="table_data" id="table_data" value='<?php echo $product ?>'>
                      <input type="hidden" name="table_data1" id="table_data1">
                      <table class="table table-striped table-bordered table-condensed table-hover total_data">
                        <tr>
                          <td align="right" width="80%"><?php echo $this->lang->line('purchase_total_value').'('.$this->session->userdata('symbol').')'; ?></td>
                          <td align='right'><span id="totalValue"><?php echo $tot; ?></span></td>
                        </tr>
                        <tr>
                          <td align="right">Product Discount<?php echo '('.$this->session->userdata('symbol').')'; ?></td>
                          <td align='right'><span id="totalDiscount"><?php echo $data[0]->discount_value; ?></span>
                          </td>
                        </tr>
                        <tr>
                          <td align="right"><?php echo $this->lang->line('purchase_total_tax').'('.$this->session->userdata('symbol').')'; ?> </td>
                          <td align='right'><span id="totalTax"><?php echo $data[0]->tax_value; ?></span>
                          </td>
                        </tr>
                        <tr>
                          <td align="right">General Discount<?php echo '('.$this->session->userdata('symbol').')'; ?></td>
                          <td align='right'>
                            <input type="number" step="0.01" class="form-control text-right" id="discount" name="discount" value="<?php echo $data[0]->flat_discount; ?>" autocomplete="off">
                          </td>
                        </tr>
                        <tr>
                          <td align="right">Shipping Charge<?php echo '('.$this->session->userdata('symbol').')'; ?></td>
                          <td align='right'>
                            <input type="number" class="form-control text-right" id="shipping_charge" name="shipping_charge" value="<?php echo $data[0]->shipping_charge; ?>" autocomplete="off">
                          </td>
                        </tr>
                        <tr>
                          <td align="right"><?php echo $this->lang->line('purchase_total').'('.$this->session->userdata('symbol').')'; ?> </td>
                          <td align='right'><span id="grandTotal"><?php echo $data[0]->total; ?></span></td>
                        </tr>
                        <tr>
                          <td align="right">Round Off Value<?php echo '('.$this->session->userdata('symbol').')'; ?> </td>
                          <td align='right'><span id="round_off"><?php echo round(round($data[0]->total)-($data[0]->total),2); ?></span></td>
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
                      <button type="submit" id="submit" class="btn btn-info"><?php echo $this->lang->line('product_update'); ?></button>
                      <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('sales')"><?php echo $this->lang->line('product_cancel'); ?></span>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
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
                                      foreach ($country as  $key) {
                                    ?>
                                    <option 
                                      value='<?php echo $key->id ?>' 
                                      <?php 
                                        if(isset($data[0]->shipping_country_id)){
                                          if($key->id == $data[0]->shipping_country_id){
                                            echo "selected";
                                          }
                                        } 
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
                                    <?php
                                      foreach ($state as  $key) {
                                    ?>
                                    <option 
                                      value='<?php echo $key->id ?>' 
                                      <?php 
                                        if(isset($data[0]->shipping_state_id)){
                                          if($key->id == $data[0]->shipping_state_id){
                                            echo "selected";
                                          }
                                        } 
                                      ?>
                                    >
                                    <?php echo $key->name; ?>
                                    </option>
                                  <?php
                                    }
                                  ?>
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
                                      <?php
                                        foreach ($city as  $key) {
                                      ?>
                                      <option 
                                        value='<?php echo $key->id ?>' 
                                        <?php 
                                          if(isset($data[0]->shipping_city_id)){
                                            if($key->id == $data[0]->shipping_city_id){
                                              echo "selected";
                                            }
                                          } 
                                        ?>
                                      >
                                      <?php echo $key->name; ?>
                                      </option>
                                      <?php
                                        }
                                      ?>
                                  </select>
                                  <span class="validation-color" id="err_city"><?php echo form_error('city'); ?></span>
                                </div>
                                <div class="form-group">
                                  <label for="address"><!-- Address --> 
                                      <?php echo $this->lang->line('add_biller_address'); ?> 
                                      <span class="validation-color">*</span>
                                  </label>
                                  <textarea class="form-control" id="address" rows="4" name="address"><?php echo $data[0]->shipping_address; ?></textarea>
                                  <span class="validation-color" id="err_address"><?php echo form_error('address'); ?></span>
                                </div>
                                <div class="form-group">
                                  <label for="postal_code"><?php echo "Postal Code" ?> <span class="validation-color">*</span>
                                  </label>
                                  <input type="text" class="form-control" id="postal_code" autocomplete="off" name="postal_code" value="<?php echo $data[0]->shipping_postal_code; ?>" required>
                                  <span class="validation-color" id="err_postal_code"><?php echo form_error('postal_code'); ?></span>
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
        <!--/.col (right) -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
  $('.billing-data').hide();
  $('.supplier-data').hide();
  $('.others-data').hide();
</script>
<?php
  $this->load->view('layout/product_footer');
?>
<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
<?php 
  include('customer.php');
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
        $('#shipping-postal_code').text($('#postal_code').val());
        $('#shipping_state_id').val($("#state").val());
      }
    }); 
  });
</script>
<script>
  $(document).ready(function(){
    $('#customer').change(function(){
      var customer_id = $(this).val();
      $.ajax({
          url: "<?php echo base_url('sales/getCustomerData') ?>/"+customer_id,
          type: "POST",
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

            $('#shipping_state_id').val(data['data'].shipping_state_id);

            $('#billing_address').text(data['data'].address);
            $('#billing_city').text(data['data'].city_name);
            $('#billing_state').text(data['data'].state_name);
            $('#billing_country').text(data['data'].country_name);
            $('#billing_postal_code').text(data['data'].postal_code);

            $('#shipping-address').text(data['data'].address);
            $('#shipping-city').text(data['data'].city_name);
            $('#shipping-state').text(data['data'].state_name);
            $('#shipping-country').text(data['data'].country_name);
            $('#shipping-postal_code').text(data['data'].postal_code);

            $('.billing').show();
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
    var i = <?php echo $i++; ?>;
    var product_data = new Array();
    var counter = <?php echo count($items); ?>;
    var existing_product_id = new Array();
    
    existing_product_id = JSON.parse($("#table_data").val());
  
    var mapping = { };
    $(function(){
            $('#input_product_code').autoComplete({
                minChars: 1,
                cache: false,
                source: function(term, suggest){
                    term = term.toLowerCase();
                    var warehouse_id = $('#warehouse').val();
                    if(warehouse_id==""){
                      alert("Please Select Warehouse");
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
              // var tax_id = data[0].tax_id;
              // var tax_value = data[0].tax_value;
              alert(data[0].igst + " " + data[0].cgst+ " " + data[0].sgst)
              var igst = data[0].igst;
              var cgst = data[0].cgst;
              var sgst = data[0].sgst;
              // if(tax_value==null){
              //   tax_value = 0;
              // }
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

              var biller_state_id = $('#biller_state_id').val();
              var shipping_state_id = $('#shipping_state_id').val();

              if(biller_state_id==shipping_state_id){
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
                      +"<input type='number' class='form-control text-center' value='0' data-rule='quantity' name='qty"+ counter +"' id='qty"+ counter +"' min='1' max='"+data[0].quantity+"'>" 
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

      var igst = +row.find("#igst").val();
      var cgst = +row.find("#cgst").val();
      var sgst = +row.find("#sgst").val();

      var tax_type = row.find("input[name^='tax_type']:checked").val();  
      
      if(tax_type =="Inclusive")
      {
      
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
      product_data[key].discount = +total_discount.toFixed(2);
      product_data[key].discount_value = +row.find('#discount_value').val();
      product_data[key].discount_id = +row.find('#item_discount').val();
      product_data[key].tax_type = tax_type;
      product_data[key].igst = igst;
      product_data[key].igst_tax = +igst_tax.toFixed(2);
      product_data[key].cgst = cgst;
      product_data[key].cgst_tax = +cgst_tax.toFixed(2);
      product_data[key].sgst = sgst;
      product_data[key].sgst_tax = +sgst_tax.toFixed(2);
      
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
      product_data[key].price = price;
      product_data[key].total = (price * qty).toFixed(2);
      var table_data = JSON.stringify(product_data);
      $('#table_data1').val(table_data);
    }
    function discount_shipping_change(){
      var discount = +$('#discount').val();
      var shipping_charge = +$('#shipping_charge').val();
      if(shipping_charge==""){
        shipping_charge = 0;  
      }
      if(discount==""){
        discount = 0;
      }
      var grandTotal = +$('#grand_total').val();
      var grandTotal = (+grandTotal + +shipping_charge) - +discount;
      $('#grandTotal').text(grandTotal.toFixed(2));
      $('#round_off').text((Math.round(grandTotal)-grandTotal).toFixed(2));
    }
    function calculateGrandTotal() {
      var totalValue = 0;
      var totalDiscount = 0;
      var grandTax = 0;
      var grandTotal = 0;

      $("table.product_table").find('span[id^="taxable_value"]').each(function () {
        totalValue += +$(this).text();                                
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
      discount_shipping_change();
      var table_data = JSON.stringify(product_data);
      $('#table_data').val(table_data);
    }
    $("#submit").click(function(event){
      var name_regex = /^[a-zA-Z]+$/;
      var sname_regex = /^[a-zA-Z0-9]+$/;
      var num_regex = /^[0-9]+$/;
      var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      var date = $('#date').val();
      var reference_no = $('#reference_no').val();
      var warehouse = $('#warehouse').val();
      var biller = '<?php echo $biller_id; ?>';
      var product = $('#product').val();
      var cusomer = $('#cusomer').val();
      var discount = $('#discount').val();
      var note = $('#note').val();
      var internal_note = $('#internal_note').val();
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
      // alert($('#table_data').val(JSON.stringify(table_data_array)));
      // return false;

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

        /*if(biller==""){
          $("#err_biller").text("Please Enter Biller");
          $('#biller').focus();
          return false;
        }
        else{
          $("#err_biller").text("");
        }*/
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
      
         /*if(discount==""){
          $("#err_discount").text("Please Enter Discount");
          $('#discount').focus();
          return false;
        }
        else{
          $("#err_discount").text("");
        }*/
//discount code validation complite.

        if(grand_total=="" || grand_total==null || grand_total==0.00){;
          $("#err_product").text("Please Select Product");
          $('#product').focus();
          return false;
        }
        else{
          $("#err_product").text("");
        }

    }); 
});

</script>

<!-- datepicker  -->
<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.js')?>"></script>
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
    
    $("#user_id").change(function(event){
      var user_id = $('#user_id').val();
      var warehouse_change = $("#warehouse_change").val();
      $('#warehouse_change').val('yes');
      $('#product_table_body').empty();
      $('#table_data1').val('clear');
      $('#last_total').val('');
      $('#grand_total').val('');
      $('#grandtotal').text('0.00');
      $('#totaldiscount').text('0.00');
      $('#lasttotal').text('0.00');
      if(user_id=="Select"){
        $("#err_warehouse").text("Please Select Warehouse");
        $('#users_id').focus();
        return false;
      }
      else{
        $("#err_user_id").text("");
        $.ajax({
          url: "<?php echo base_url('sales/getBillerWarehouseDetailsAjax') ?>/"+user_id,
          type: "GET",
          dataType: "json",
          success: function(data){
            
            $('#biller').val(data[0].biller_id);
            $('#warehouse').val(data[0].warehouse_id);
            $('#biller_state_id').val(data[0].biller_state_id);

          }
        });
        
      }
    });
    /*$("#biller").change(function(event){
      var biller = $('#biller').val();
      if(biller==""){
        $("#err_biller").text("Please Enter Biller");
        $('#biller').focus();
        return false;
      }
      else{
        $("#err_biller").text("");
        $.ajax({
          url: "<?php //echo base_url('purchase_return/getBillerState') ?>/"+biller,
          type: "GET",
          dataType: "TEXT",
          success: function(data){
            $('#biller_state_id').val(data);
          }
        });
      }
    });*/
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
    /*$("#discount").change(function(event){
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
    });*/
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