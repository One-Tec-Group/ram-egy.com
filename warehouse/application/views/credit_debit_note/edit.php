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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <!-- Dashboard --> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('credit_debit_note'); ?>">Credit/Debit Note</a></li>
          <li class="active">Edit Credit/Debit Note</li>
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
              <h3 class="box-title">Edit Credit/Debit Note</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" id="form" method="post" action="<?php echo base_url('credit_debit_note/EditCreditDebitNote');?>">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="invoice">Select Invoice<span class="validation-color">*</span></label>
                    <select id="invoice" name="invoice" class="form-control select2">
                      <?php
                        foreach ($invoice as  $value) {
                      ?>
                          <option value='<?php echo $value->id ?>' <?php if($value->id == $data->invoice_id){echo "selected";} ?>><?php echo $value->invoice_no ?></option>
                      <?php
                        }
                      ?>
                    </select>
                    <span class="validation-color" id="err_invoice"><?php echo form_error('invoice'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="r_v_no"> Note/Refund Voucher Number <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="r_v_no" name="r_v_no" value="<?php echo $data->note_or_refund_voucher_no; ?>">
                    <input type="hidden" name="id" value="<?php echo $data->id; ?>">
                    <span class="validation-color" id="err_r_v_no"><?php echo form_error('r_v_no'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="r_v_date"> Note/Refund Voucher Date <span class="validation-color">*</span></label>
                    <input type="text" class="form-control datepicker" id="r_v_date" name="r_v_date" value="<?php echo $data->note_or_refund_voucher_date; ?>">
                    <span class="validation-color" id="err_r_v_date"><?php echo form_error('r_v_date'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="r_v_value"> Note/Refund Voucher Value <span class="validation-color">*</span></label>
                    <input type="text" class="form-control" id="r_v_value" name="r_v_value" value="<?php echo $data->note_or_refund_voucher_value; ?>">
                    <span class="validation-color" id="err_r_v_value"><?php echo form_error('r_v_value'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="document">Select Document Type<span class="validation-color">*</span></label>
                    <select id="document" name="document" class="form-control select2">
                      <option value="D" <?php if($data->document_type=="D"){ echo "selected";}?>>Debit Note</option>
                      <option value="C" <?php if($data->document_type=="C"){ echo "selected";}?>>Credit Note</option>
                      <option value="R" <?php if($data->document_type=="R"){ echo "selected";}?>>Refund Voucher</option>
                    </select>
                    <span class="validation-color" id="err_document"><?php echo form_error('document'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="reason">Reason for Issue Document<span class="validation-color">*</span></label>
                    <select id="reason" name="reason" class="form-control select2">
                      <option value="1" <?php if($data->reason_for_issue_document=="1"){ echo "selected";}?>>Sales Retun/Purchase Return</option>
                      <option value="2" <?php if($data->reason_for_issue_document=="2"){ echo "selected";}?>>Post Sale Discount</option>
                      <option value="3" <?php if($data->reason_for_issue_document=="3"){ echo "selected";}?>>DIficiency in Service</option>
                      <option value="4" <?php if($data->reason_for_issue_document=="4"){ echo "selected";}?>>Correction of Invoice</option>
                      <option value="5" <?php if($data->reason_for_issue_document=="5"){ echo "selected";}?>>Change in POS(Place of Supply)</option>
                      <option value="6" <?php if($data->reason_for_issue_document=="6"){ echo "selected";}?>>Finalization of Provisional assessment</option>
                      <option value="7" <?php if($data->reason_for_issue_document=="7"){ echo "selected";}?>>Others</option>
                    </select>
                    <span class="validation-color" id="err_reason"><?php echo form_error('reason'); ?></span>
                  </div>
                  <div class="form-group">
                    <label for="pre_gst">Pre GST</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="pre_gst" id="pre_gst" value="Y" <?php if($data->pre_gst=="Y"){ echo "checked";}?>>
                    <span class="validation-color" id="errpre_gst"><?php echo form_error('pre_gst'); ?></span>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('credit_debit_note')"><!-- Cancel --><?php echo $this->lang->line('category_cancel'); ?></span>
                  </div>
                </div>
              </form>
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

  <!-- /.content-wrapper -->
<?php
  $this->load->view('layout/footer');
?>
