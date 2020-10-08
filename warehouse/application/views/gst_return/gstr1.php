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
          <li class="active">GSTR1</li>
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
              <h3 class="box-title"><!-- List Category -->
                  GSTR1
              </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form method="post" action="<?php echo base_url('gst_return/gstr1') ?>">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="month">Month</label>
                    <select id="month" name="month" class="form-control select2">
                      <?php
                        for($i=1;$i<=12;$i++){
                      ?>
                        <option value="<?php echo sprintf('%02d',intval($i)) ?>" <?php if(isset($month)){ if(sprintf('%02d',intval($i)) == $month) {echo "selected";} }?>><?php echo sprintf('%02d',intval($i)) ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="year">Year</label>
                    <select id="year" name="year" class="form-control select2">
                      <?php
                        for($i=2017;$i<=date('Y');$i++){
                      ?>
                        <option value="<?php echo sprintf('%04d',intval($i)) ?>" <?php if(isset($year)){ if(sprintf('%04d',intval($i)) == $year) {echo "selected";} }?>><?php echo sprintf('%04d',intval($i)) ?></option>
                      <?php
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <input type="submit" name="submit" value="submit" class="btn btn-info btn-flat pull-left">
                    <?php if(isset($data) && $data!=null){ ?>
                      <input type="submit" name="submit" value="CSV" class="btn btn-success btn-flat pull-right">
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    
                  </div>
                </div>
                
                <div class="col-md-12">
                  <div class="form-group">
                    <?php if(isset($data) && $data!=null){ ?>
                    <table class="table table-bordered table-striped table-responsive">
                      <thead>
                        <th>Invoice No</th>
                        <th>Dates</th>
                        <th>Customer Name</th>
                        <th>Customer GSTIN</th>
                        <th>Phone</th>
                        <th>Rate</th>
                        <th>Discount Value</th>
                        <th>CGST</th>
                        <th>SGST</th>
                        <th>IGST</th>
                        <th>Tax Amount</th>
                        <th>Sales Amount</th>
                      </thead>
                      <tbody>
                        <?php foreach ($data as $row) { ?>
                            <tr>
                              <td><?php echo $row->InvoiceNo; ?></td>
                              <td><?php echo $row->Dates; ?></td>
                              <td><?php echo $row->Customer_Name; ?></td>
                              <td><?php echo $row->Customer_GSTIN; ?></td>
                              <td><?php echo $row->Phone; ?></td>
                              <td align="right"><?php echo $row->Rate; ?></td>
                              <td align="right"><?php echo $row->DiscountValue; ?></td>
                              <td align="right"><?php echo $row->CGST; ?></td>
                              <td align="right"><?php echo $row->SGST; ?></td>
                              <td align="right"><?php echo $row->IGST; ?></td>
                              <td align="right"><?php echo $row->TaxAmount; ?></td>
                              <td align="right"><?php echo $row->SalesAmount; ?></td>
                            </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <?php }else{ ?>
                    <table class="table table-bordered table-striped">
                      <thead>
                        <td align="center" style="font-size: 18px;">No Data Found</td>
                      </thead>
                    </table>
                    <?php } ?>
                  </div>
                </div>
                
              </form>
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
  <!-- <div class="col-md-12">
                  <br><br>
                  <div class="">
                    <input type="submit" name="submit" value="b2b" id="gstr1b2b" class="btn btn-info btn-flat">
                    <input type="submit" name="submit" value="b2cs" id="gstr1b2cs" class="btn bg-orange btn-flat">
                    <input type="submit" name="submit" value="b2cl" id="gstr1b2cl" class="btn btn-success btn-flat">
                    <input type="submit" name="submit" value="cdnr" id="gstr1cdnr" class="btn bg-purple btn-flat">
                    <input type="submit" name="submit" value="cdnur" id="gstr1cdnur" class="btn bg-maroon btn-flat">
                    <input type="submit" name="submit" value="exp" id="gstr1exp" class="btn bg-olive btn-flat">
                    <input type="submit" name="submit" value="exemp" id="gstr1exemp" class="btn btn-warning btn-flat">
                    <input type="submit" name="submit" value="hsn" id="gstr1hsn" class="btn btn-danger btn-flat">
                  </div>
                </div> -->
<?php
  $this->load->view('layout/footer');
?>
