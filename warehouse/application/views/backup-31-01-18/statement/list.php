<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li class="active">Statement</li>
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- right column -->
      <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Statement</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <form method="post" action="<?php echo base_url('statement/getStatements'); ?>">
                    <div class="form-group col-md-3">
                      <select class="select2 form-control" name="year">
                        <?php for($i=date('Y');$i>=2015;$i--){
                          echo "<option value='$i'>$i</option>";
                        }?>
                      </select>
                    </div>
                    <div class="form-group col-md-3">
                      <select class="select2 form-control" name="customer" id="customer">
                          <option>Select Customer</option>
                        <?php foreach ($customers as $row): ?>
                          <option value="<?php echo $row->customer_id; ?>"><?php echo $row->customer_name; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <input type="submit" name="submit" class="btn btn-info btn-flat" value="Submit">
                    </div>
                    <div class="col-md-3">
                      <button type="submit" class="btn btn-sm pull-right">
                        <i class="fa fa-file-pdf-o"></i>
                      </button>
                      <button type="submit" class="btn btn-sm pull-right" style="margin-right: 10px;">
                        <i class="fa fa-print"></i>
                      </button>
                    </div>
                  </form>
                </div>
                <div class="col-md-12">
                  <span style="font-size: 18px;">Customer Statement For <?php echo $company[0]->name; ?></span>
                </div>
                <div class="col-md-12">
                  <div style="border:1px solid #e3e3e3;border-radius: 3px;" class="col-md-12">
                    <div class="col-md-12" style="border-bottom:1px solid #e3e3e3;">
                      <p class="pull-right">
                        <span style="font-size: 16px;" class="pull-right"><br>
                          <?php
                            if(isset($customer_data->customer_name)){
                              echo strtoupper($customer_data->customer_name);
                            }
                          ?>
                        </span><br>
                        <span class="pull-right">
                          <?php
                            if(isset($customer_data->address)){
                              echo $customer_data->address;
                            }
                          ?>
                        </span><br>
                        <span class="pull-right">
                          <?php
                            if(isset($customer_data->city_name)){
                              echo $customer_data->city_name;
                            }
                            if(isset($customer_data->postal_code)){
                              echo ',',$customer_data->postal_code;
                            }
                          ?>
                        </span><br><br><br>
                        <span class="pull-right">
                          <?php
                            if(isset($customer_data->country_name)){
                              echo $customer_data->country_name;
                            }
                          ?>
                        </span><br>
                        <span class="pull-right">
                          <?php
                            if(isset($customer_data->mobile)){
                              echo $customer_data->mobile;
                            }
                          ?>
                        </span>
                      </p>
                    </div>
                    <div class="col-md-7">
                      <p>To:</p>
                      <?php echo $company[0]->name; ?><br>
                      <?php echo $company[0]->street; ?><br>
                      <?php echo $company[0]->city_name; ?>,<?php echo $company[0]->state_name; ?><br>
                      <?php echo $company[0]->country_name; ?>,<?php echo $company[0]->zip_code; ?><br>
                    </div>
                    <div class="col-md-5" style="border-bottom:1px solid #e3e3e3;">
                      <p class="pull-right">
                      <span style="font-size: 18px;font-weight: bold;" class="pull-right">Account Summery</span><br>
                      01/01/<?php if(isset($year)){ echo $year;} ?> To 31/12/<?php if(isset($year)){ echo $year;} ?></p>
                    </div>
                    <div class="col-md-5">
                     <p>
                       <span>Beginning Balance : </span><span class="pull-right">0.00</span><br>
                       <span>Invoice Amount : </span><span class="pull-right"><?php if(isset($data->invoice_amount)){ echo round($data->invoice_amount);} ?></span><br>
                       <span>Amount Paid : </span><span class="pull-right"><?php if(isset($data->paid_amount)){ echo round($data->paid_amount);} ?></span><br>
                       <span>Balance Due : </span><span class="pull-right"><?php if(isset($data->invoice_amount)){ echo round($data->invoice_amount-$data->paid_amount);} ?></span>
                     </p>
                    </div>
                    <div class="col-md-12">
                      <p><center>Showing all invoices and Payments between 01/01/<?php if(isset($year)){ echo $year;} ?> and 31/12/<?php if(isset($year)){ echo $year;} ?></center></p>
                    </div>
                    <div class="col-md-12" style="overflow-y: hidden;">
                      <table class="table table-bordered table-striped table-hover">
                        <thead>
                          <th>Date</th>
                          <th width="50%">Details</th>
                          <th>Amount</th>
                          <th>Payments</th>
                          <th>Amount</th>
                        </thead>
                        <tbody>
                          <tr>
                            <td>01/01/<?php if(isset($year)){ echo $year;} ?></td>
                            <td>Beginning Balance</td>
                            <td align="right">0.00</td>
                            <td></td>
                            <td align="right">0.00</td>
                          </tr>
                          <?php if(isset($invoice_data)){
                                  $i = 0; 
                                  foreach ($invoice_data as $row){
                          ?>
                            <tr>
                              <td><?php echo date('d/m/Y',strtotime($row->invoice_date)); ?></td>
                              <td>
                                  <?php 
                                    if($row->delete_status==0){
                                  ?>
                                      Invoice <b>#<a href="<?php echo base_url('sales/view/').$row->sales_id;?>"><?php echo $row->invoice_no; ?></a></b>
                                  <?php
                                    }
                                    else{
                                      echo "Invoice <b>#$row->invoice_no</b> ";
                                    }
                                  ?>
                                  
                              </td>
                              <td align="right"><?php echo number_format((float)$row->sales_amount, 2,'.', ''); ?></td>
                              <td></td>
                              <td align="right">
                                <?php $i += $row->sales_amount; echo number_format((float)$i, 2,'.', ''); 
                                ?>
                              </td>
                            </tr>
                            <?php
                              foreach ($payment_data as $value) {
                                if($value->sales_id == $row->sales_id){
                            ?>
                                <tr>
                                  <td><?php echo date('d/m/Y',strtotime($row->invoice_date)); ?></td>
                                  <td>Payment <b>(<?php echo $value->voucher_no; ?>)</b> to invoice <b>#<?php echo $value->invoice_no; ?></b> - <?php echo date('d/m/Y',strtotime($value->voucher_date)); ?></td>
                                  <td></td>
                                  <td align="right"><?php echo number_format((float)$value->amount, 2,'.', ''); ?></td>
                                  <td align="right"><?php $i -= $value->amount; echo number_format((float)$i, 2,'.', ''); ?></td>
                                </tr>
                            <?php
                                }
                              }
                            ?>
                            <?php
                              foreach ($invoice_delete_data as $value) {
                                if($value->sales_id == $row->sales_id){
                            ?>
                                <tr>
                                  <td><?php echo date('d/m/Y',strtotime($row->invoice_date)); ?></td>
                                  <td>Invoice #<?php echo $value->invoice_no ?> Canceled</td>
                                  <td></td>
                                  <td align="right"><?php echo number_format((float)$value->sales_amount, 2,'.', ''); ?></td>
                                  <td align="right"><?php $i -= $value->sales_amount; echo number_format((float)$i, 2,'.', ''); ?></td>
                                </tr>
                            <?php
                                }
                              }
                            ?>
                          <?php
                              foreach ($credit_note as $value) {
                                if($value->sales_id == $row->sales_id){
                            ?>
                                <tr>
                                  <td><?php echo date('d/m/Y',strtotime($row->invoice_date)); ?></td>
                                  <td>Credit Note #<?php echo $value->invoice_no ?></td>
                                  <td align="right"><?php echo number_format((float)$value->amount, 2,'.', ''); ?></td>
                                  <td></td>
                                  <td align="right"><?php $i += $value->amount; echo number_format((float)$i, 2,'.', ''); ?></td>
                                </tr>
                            <?php
                                }
                              }
                            ?>
                          <?php } }?>
                          </tr><tr>
                            <td colspan="3" align="right">Balance Due</td>
                            <td></td>
                            <td align="right"><b><?php if(isset($data->invoice_amount)){ echo round($data->invoice_amount-$data->paid_amount);}else{ echo "0.00";}?></b></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
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
