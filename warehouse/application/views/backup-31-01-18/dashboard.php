<?php 

if(!$this->session->userdata('email')){
  redirect('auth/login');
}
function checkEmpty($table){
  if($table <= 0){
    return '<span class="badge bg-default glyphicon glyphicon-ok"></span>';
  }
  else{
    return '<span class="badge glyphicon glyphicon-ok" style="background-color:#1fcf07"></span>';
  }
}
$this->load->view('layout/header');
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $this->lang->line('header_dashboard'); ?>
        <?php if($demo==0) {?>
        <span class="pull-right"><a href="<?php echo base_url('auth/clearDemoData'); ?>" class="btn btn-danger btn-flat">Clear Demo Data</a></span>
        <?php }?>
      </h1>
    </section>    
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <?php
            if($this->session->userdata('type')=="admin"){
          ?>
          <div class="box">
            <div class="box-body">
              <a class="btn btn-app" href="<?php echo base_url('company_setting'); ?>">
                <?php echo checkEmpty($company_setting->count); ?>
                <i class="fa fa-diamond text-blue"></i> Company Setting
              </a>
              <a class="btn btn-app" href="<?php echo base_url('category/add'); ?>">
                <?php echo checkEmpty($category->count); ?>
                <i class="fa fa-tags text-green"></i> Add Category
              </a>
              <a class="btn btn-app" href="<?php echo base_url('discount/add'); ?>">
                <?php echo checkEmpty($discount->count); ?>
                <i class="fa fa-hourglass text-gray"></i> Add Discount
              </a>
              <a class="btn btn-app" href="<?php echo base_url('branch/add'); ?>">
                <?php echo checkEmpty($branch->count); ?>
                <i class="fa fa-suitcase text-yellow"></i> Add Branch
              </a>
              <a class="btn btn-app" href="<?php echo base_url('brand/add'); ?>">
                <?php echo checkEmpty($brand->count); ?>
                <i class="fa fa-bold text-maroon"></i> Add Brand
              </a>
              <a class="btn btn-app" href="<?php echo base_url('warehouse/add'); ?>">
                <?php echo checkEmpty($warehouse->count); ?>
                <i class="fa fa-university text-suffron"></i> Add Warehouse
              </a>
              <a class="btn btn-app" href="<?php echo base_url('product/add'); ?>">
                <?php echo checkEmpty($product->count); ?>
                <i class="fa fa-cube text-blue"></i> Add Product
              </a>
              <a class="btn btn-app" href="<?php echo base_url('supplier/add'); ?>">
                <?php echo checkEmpty($supplier->count); ?>
                <i class="fa fa-user text-maroon"></i> Add Supplier
              </a>
              <a class="btn btn-app" href="<?php echo base_url('customer/add'); ?>">
                <?php echo checkEmpty($customer->count); ?>
                <i class="fa fa-user text-green"></i> Add Customer
              </a>
              <a class="btn btn-app" href="<?php echo base_url('biller/add'); ?>">
                <?php echo checkEmpty($biller->count); ?>
                <i class="fa fa-user text-red"></i> Add Biller
              </a>
            </div>
          </div>
          <?php
              }
          ?>
          <!-- Application buttons -->
          <div class="box">
            <div class="box-body">
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser" ){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('product/add'); ?>">
                <i class="fa fa-cube text-blue"></i> Add Product
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('purchase/add'); ?>"> 
                <i class="fa fa-square-o text-green"></i> Add Purchase
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="sales_person"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('sales/add'); ?>">
                <i class="fa fa-shopping-cart text-aqua"></i> Add Sales
              </a>
              <a class="btn btn-app" href="<?php echo base_url('quotation/add'); ?>">
                <i class="fa fa-star text-green"></i> Add Quotation
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('transfer/add'); ?>">
                <i class="fa fa-th-large text-yellow"></i> Add Transfer
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('bank_account/add'); ?>">
                <i class="fa fa-desktop text-maroon"></i> Add Bank Account
              </a>
              <a class="btn btn-app" href="<?php echo base_url('biller/add'); ?>">
                <i class="fa fa-user text-red"></i> Add Biller
              </a>
              <a class="btn btn-app" href="<?php echo base_url('auth/create_user'); ?>">
                <i class="fa fa-user text-aqua"></i> Add User
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="sales_person"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('customer/add'); ?>">
                <i class="fa fa-user text-green"></i> Add Customer
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('supplier/add'); ?>">
                <i class="fa fa-user text-maroon"></i> Add Supplier
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser" || $this->session->userdata('type')=="sales_person"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('credit_debit_note/add'); ?>">
                <i class="fa fa-file-o text-yellow"></i> Add C/D Note
              </a>
              <?php
                }
              ?>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="manager"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('category/add'); ?>">
                <i class="fa fa-tags text-green"></i> Add Category
              </a>
              <a class="btn btn-app" href="<?php echo base_url('subcategory/add'); ?>">
                <i class="fa fa-qrcode text-blue"></i> Add Subcategory
              </a>
              <!-- <a class="btn btn-app" href="<?php echo base_url('tax/add'); ?>">
                <i class="fa fa-legal text-aqua"></i> Add Tax
              </a> -->
              <a class="btn btn-app" href="<?php echo base_url('discount/add'); ?>">
                <i class="fa fa-hourglass text-gray"></i> Add Discount
              </a>
              <a class="btn btn-app" href="<?php echo base_url('branch/add'); ?>">
                <i class="fa fa-suitcase text-yellow"></i> Add Branch
              </a>
              <a class="btn btn-app" href="<?php echo base_url('brand/add'); ?>">
                <i class="fa fa-bold text-maroon"></i> Add Brand
              </a>
              <?php
                if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser"){
              ?>
              <a class="btn btn-app" href="<?php echo base_url('warehouse/add'); ?>">
                <i class="fa fa-university text-suffron"></i> Add Warehouse
              </a>
              <?php } ?>
              <a class="btn btn-app" href="<?php echo base_url('expense_category/add'); ?>">
                <i class="fa fa-envelope-o text-yellow"></i> Add Expense category
              </a>
              <a class="btn btn-app" href="<?php echo base_url('uqc/add'); ?>">
                <i class="fa fa-legal text-aqua"></i> Add UQC
              </a>
              <a class="btn btn-app" href="<?php echo base_url('payment_method/add'); ?>">
                <i class="fa fa-th-large text-maroon"></i> Add Payment Method
              </a>
              <?php
                }
              ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-12">
          <!-- /.box -->
        
          <div class="box">
            <div class="box-header with-border">
              <span class="box-title external-event bg-yellow" id="today" style="font-size: 14px;"><?php echo $this->lang->line('dashboard_today'); ?></span>
              <span class="box-title external-event" id="week" style="font-size: 14px;"><?php echo $this->lang->line('dashboard_this_week'); ?></span>
              <span class="box-title external-event" id="month" style="font-size: 14px;"><?php echo $this->lang->line('dashboard_this_month'); ?></span>
              <span class="box-title external-event" id="year" style="font-size: 14px;"><?php echo $this->lang->line('dashboard_this_year'); ?></span>
              <span class="box-title external-event" id="all" style="font-size: 14px;"><?php echo $this->lang->line('dashboard_all_time'); ?></span>
              
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" type="button" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button class="btn btn-box-tool" type="button" data-widget="remove">
                  <i class="fa fa-times"></i>
                </button>
              </div><!-- /box-tools pull-right -->
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12 today">
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <?php 
                          if(isset($todayProduct[0]->item)){
                            echo "<span class='h-font'>".$todayProduct[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_new_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-green">
                      <div class="inner">
                        <?php 
                          if(isset($todayPurchase[0]->item)){
                            echo "<span class='h-font'>".$todayPurchase[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_item'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <?php 
                          if(isset($todaySales[0]->item)){
                            echo "<span class='h-font'>".$todaySales[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sold_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-light-blue">
                      <div class="inner">
                        <?php 
                          if(isset($todayPurchase[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$todayPurchase[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <?php 
                          if(isset($todaySales[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$todaySales[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sales_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                </div><!-- /.col 12 -->

                <div class="col-md-12 week">
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <?php 
                          if(isset($weekProduct[0]->item)){
                            echo "<span class='h-font'>".$weekProduct[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_new_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-green">
                      <div class="inner">
                        <?php 
                          if(isset($weekPurchase[0]->item)){
                            echo "<span class='h-font'>".$weekPurchase[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_item'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <?php 
                          if(isset($weekSales[0]->item)){
                            echo "<span class='h-font'>".$weekSales[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sold_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-light-blue">
                      <div class="inner">
                        <?php 
                          if(isset($weekPurchase[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$weekPurchase[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0</span>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <?php 
                          if(isset($weekSales[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$weekSales[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sales_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                </div><!-- /.col 12 -->

                <div class="col-md-12 month">
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <?php 
                          if(isset($monthProduct[0]->item)){
                            echo "<span class='h-font'>".$monthProduct[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_new_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-green">
                      <div class="inner">
                        <?php 
                          if(isset($monthPurchase[0]->item)){
                            echo "<span class='h-font'>".$monthPurchase[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_item'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <?php 
                          if(isset($monthSales[0]->item)){
                            echo "<span class='h-font'>".$monthSales[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sold_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-light-blue">
                      <div class="inner">
                        <?php 
                          if(isset($monthPurchase[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$monthPurchase[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <?php 
                          if(isset($monthSales[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$monthSales[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sales_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                </div><!-- /.col 12 -->

                <div class="col-md-12 year">
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <?php 
                          if(isset($yearProduct[0]->item)){
                            echo "<span class='h-font'>".$yearProduct[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_new_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-green">
                      <div class="inner">
                        <?php 
                          if(isset($yearPurchase[0]->item)){
                            echo "<span class='h-font'>".$yearPurchase[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_item'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <?php 
                          if(isset($yearSales[0]->item)){
                            echo "<span class='h-font'>".$yearSales[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sold_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-light-blue">
                      <div class="inner">
                        <?php 
                          if(isset($yearPurchase[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$yearPurchase[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <?php 
                          if(isset($yearSales[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$yearSales[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sales_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                </div><!-- /.col 12 -->

                <div class="col-md-12 all">
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <?php 
                          if(isset($allProduct[0]->item)){
                            echo "<span class='h-font'>".$allProduct[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_new_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-green">
                      <div class="inner">
                        <?php 
                          if(isset($allPurchase[0]->item)){
                            echo "<span class='h-font'>".$allPurchase[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_item'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <?php 
                          if(isset($allSales[0]->item)){
                            echo "<span class='h-font'>".$allSales[0]->item."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sold_items'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-light-blue">
                      <div class="inner">
                        <?php 
                          if(isset($allPurchase[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$allPurchase[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_purchase_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                  <div class="col-md-2 col-xs-5">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <?php 
                          if(isset($allSales[0]->value)){
                            echo "<span class='h-font'>".$this->session->userdata('symbol').$allSales[0]->value."</span>"; 
                          }
                          else {
                            echo "<span class='h-font'>".$this->session->userdata('symbol')."0<span class='h-font'>";
                          }
                        ?>
                      </div>
                      <span class="small-box-footer"><?php echo $this->lang->line('dashboard_sales_value'); ?></span>
                    </div>
                  </div><!-- /.col -->
                </div><!-- /.col 12 -->
                <script>
                  $('.week').hide();
                  $('.month').hide();
                  $('.year').hide();
                  $('.all').hide();
                </script>
              </div><!-- /.row -->
            </div>
            <!-- /.box -->
        </div>
        
        <!-- /.col -->

      </div>
      <!-- /.row -->
      <div class="col-md-7"> 
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo $this->lang->line('dashboard_yearly_sales'); ?></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" type="button" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <button class="btn btn-box-tool" type="button" data-widget="remove">
                <i class="fa fa-times"></i>
              </button>
            </div><!-- /box-tools pull-right -->
          </div>
          <div class="box-body" style="overflow-y: auto;">
            <div id="bar_chart"></div>
          </div><!-- box-->
        </div><!-- box -->
      </div><!-- /.col 7-->
      <?php
      if($this->session->userdata('type')=="admin" || $this->session->userdata('type')=="purchaser"){
    ?>  
      <div class="col-md-5"> 
        <div class="box">
          <div class="box-header with-border">
            <select class="form-control select2" id="warehouse" name="warehouse" style="width: 100%;">
              <option value=""><?php echo $this->lang->line('header_warehouse'); ?></option>
              <?php

                foreach ($warehouse as $row) {
                  echo "<option value='$row->warehouse_id'".set_select('warehouse_id',$row->branch_id).">$row->warehouse_name</option>";
                }
              ?>
            </select>
          </div>
          <div class="box-body">
            <div class="col-sm-12">
              <div class="col-sm-6">
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <?php 
                      if(isset($product)){
                        echo "<span class='h-font2' id='pitems'>".$product->count."</span>"; 
                      }
                      else {
                        echo "<span class='h-font'>0<span class='h-font'>";
                      }
                    ?>
                  </div>
                  <span class="small-box-footer"><?php echo $this->lang->line('dashboard_no_of_items'); ?></span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="small-box bg-green">
                  <div class="inner">
                    <?php 
                      if(isset($warehouse_product[0]->warehouse_item)){
                        echo "<span class='h-font2' id='witems'>".$warehouse_product[0]->warehouse_item."</span>"; 
                      }
                      else {
                        echo "<span class='h-font'>0<span class='h-font'>";
                      }
                    ?>
                  </div>
                  <span class="small-box-footer"><?php echo $this->lang->line('dashboard_warehouse_products'); ?></span>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="col-sm-6">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <?php 
                      if(isset($warehouse_product[0]->value)){
                        echo "<span style='font-size:28px;'>".$this->session->userdata('symbol')."</span><span class='h-font2' id='wvalue'>".$warehouse_product[0]->value."</span>"; 
                      }
                      else {
                        echo "<span style='font-size:28px;'>".$this->session->userdata('symbol')."</span><span class='h-font'>0<span class='h-font'>";
                      }
                    ?>
                  </div>
                  <span class="small-box-footer"><?php echo $this->lang->line('dashboard_value_in_warehouse'); ?></span>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="small-box bg-red">
                  <div class="inner">
                    <?php 
                      if(isset($total_sales[0]->total_sales)){
                        echo "<span style='font-size:28px;'>".$this->session->userdata('symbol')."</span><span class='h-font2' id='tsales'>".$total_sales[0]->total_sales."</span>"; 
                      }
                      else {
                        echo "<span style='font-size:28px;'>".$this->session->userdata('symbol')."</span><span class='h-font'>0<span class='h-font'>";
                      }
                    ?>
                  </div>
                  <span class="small-box-footer"><?php echo $this->lang->line('dashboard_total_sales'); ?></span>
                </div>
              </div>
            </div>
          </div><!-- box header-->
        </div><!-- box -->
      </div><!-- /.col 5-->
      <?php } ?>
    </section>
    <!-- /.content -->
  </div>

<?php 
  $this->load->view('layout/footer');
?>
<script>
      $(document).ready(function() {
        var color = "bg-yellow"
        $('#today').click(function(){
          $('#today').addClass(color);
          $('#week').removeClass(color);
          $('#month').removeClass(color);
          $('#year').removeClass(color);
          $('#all').removeClass(color);
          $('.today').show();
          $('.week').hide();
          $('.month').hide();
          $('.year').hide();
          $('.all').hide();
        });
        $('#week').click(function(){
          $('#week').addClass(color);
          $('#today').removeClass(color);
          $('#month').removeClass(color);
          $('#year').removeClass(color);
          $('#all').removeClass(color);
          $('.today').hide();
          $('.week').show();
          $('.month').hide();
          $('.year').hide();
          $('.all').hide();
        });
        $('#month').click(function(){
          $('#month').addClass(color);
          $('#week').removeClass(color);
          $('#today').removeClass(color);
          $('#year').removeClass(color);
          $('#all').removeClass(color);
          $('.today').hide();
          $('.week').hide();
          $('.month').show();
          $('.year').hide();
          $('.all').hide();
        });
        $('#year').click(function(){
          $('#year').addClass(color);
          $('#week').removeClass(color);
          $('#month').removeClass(color);
          $('#today').removeClass(color);
          $('#all').removeClass(color);
          $('.today').hide();
          $('.week').hide();
          $('.month').hide();
          $('.year').show();
          $('.all').hide();
        });
        $('#all').click(function(){
          $('#weallek').addClass(color);
          $('#week').removeClass(color);
          $('#month').removeClass(color);
          $('#year').removeClass(color);
          $('#today').removeClass(color);
          $('.today').hide();
          $('.week').hide();
          $('.month').hide();
          $('.year').hide();
          $('.all').show();
        });
      });
      $('#warehouse').change(function(){
        var id = $(this).val();
        $.ajax({
            url: "<?php echo base_url('auth/getWarehouseData') ?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
              if(data['product'].length == null){
                $('#pitems').text('0');
              }
              else{
                $('#pitems').text(data['product'].length);
              }

              if(data['warehouse_product'][0].warehouse_item == null){
                $('#witems').text('0');
              }
              else{
                $('#witems').text(data['warehouse_product'][0].warehouse_item);
              }

              if(data['warehouse_product'][0].value == null){
                $('#wvalue').text('0');
              }
              else{
                $('#wvalue').text(data['warehouse_product'][0].value);
              }

              if(data['total_sales'][0].total_sales == null){
                $('#tsales').text('0');
              }
              else{
                $('#tsales').text(data['total_sales'][0].total_sales);
              }
              //console.log(data);
            } 
          });
      });
  </script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('auth/product_profit') ?>',
        success: function (data1) {
          var data = new google.visualization.DataTable();
          data.addColumn('string', '<?php echo $this->lang->line('dashboard_month'); ?>');
          data.addColumn('number', '<?php echo $this->lang->line('header_sales'); ?>');
          data.addColumn('number', '<?php echo $this->lang->line('header_purchase'); ?>');
          var jsonData = $.parseJSON(data1);
          for(var i in jsonData){
            data.addRow([jsonData[i].month, parseInt(jsonData[i].sales),parseInt(jsonData[i].purchase)]);
          }
          

          var options = {
            chart: {
              title: '<?php echo $this->lang->line('dashboard_sales_performance'); ?>',
              subtitle: '<?php echo $this->lang->line('dashboard_sales_of_company'); ?>'
            },
            width: 600,
            height: 400,
            axes: {
               x: {
                  0: {side: 'bottom'}
                },
                y:{
                  0:{side: 'left'}
                }
            }
          };
          var chart = new google.charts.Bar(document.getElementById('bar_chart'));
          chart.draw(data, options);
        }
    });
  }
</script>

