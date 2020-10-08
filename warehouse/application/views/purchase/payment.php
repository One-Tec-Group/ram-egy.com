<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager','purchaser');
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
          <li><a href="<?php echo base_url('purchase'); ?>">purchase</a></li>
          <li class="active">Add Receipt</li>
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
              <h3 class="box-title">Payment Voucher</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('receipt/addReceipt');?>">
                <div class="col-md-6">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-6">
                        <?php
                          if($p_reference_no==null){
                              $no = sprintf('%06d',intval(1));
                          }
                          else{
                            foreach ($p_reference_no as $value) {
                              $no = sprintf('%06d',intval($value->id)+1); 
                            }
                          }
                        ?>
                        <div class="form-group">
                          <label for="reference_no"><?php echo $this->lang->line('purchase_reference_no'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control" id="reference_no" name="reference_no" value="PM-<?php echo $no;?>" readonly>
                          <input type="hidden" name="type" value="P">
                          <span class="validation-color" id="err_reference_no"><?php echo form_error('reference_no'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="from_ac">From A/C<span class="validation-color">*</span></label>
                          <select name="from_ac" id="from_ac" class="form-control select2">
                            <?php
                              foreach ($from_ledger as $row) {
                                echo "<option value='$row->id'>$row->title</option>";
                              }
                            ?>
                          </select>
                          <span class="validation-color" id="err_from_ac"><?php echo form_error('from_ac'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="invoice">Payment Order No</label>
                          <input class="form-control" id="invoice" name="invoice" value="<?php echo $data[0]->invoice_no; ?>" readonly>
                          <input type="hidden" id="invoice" name="invoice" value="<?php echo $data[0]->invoice_id; ?>">
                          <span class="validation-color" id="err_invoice"><?php echo form_error('invoice'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="branch">Branch
                              <span class="validation-color">*</span>
                          </label>
                          <input class="form-control" value="<?php echo  $data[0]->branch_name; ?>" readonly>
                          <input type="hidden" id="branch" name="branch" value="<?php echo  $data[0]->branch_id; ?>" readonly>
                          <span class="validation-color" id="err_branch"><?php echo form_error('branch'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="to_ac">To A/C</label>
                          <input class="form-control" value="<?php echo $to_ledger->title; ?>" readonly>
                          <input type="hidden" id="to_ac" name="to_ac" value="<?php echo $to_ledger->id; ?>">
                          <span class="validation-color" id="err_to_ac"><?php echo form_error('to_ac'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="date"><?php echo $this->lang->line('purchase_date'); ?><span class="validation-color">*</span></label>
                          <input type="text" class="form-control datepicker" id="date" name="date" value="<?php echo date("Y-m-d");  ?>">
                          <span class="validation-color" id="err_date"><?php echo form_error('date'); ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="well">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="amount"><?php echo $this->lang->line('sales_amount'); ?><span class="validation-color">*</span></label>
                          <input type="number" class="form-control" id="amount" name="amount" value='<?php echo round($data[0]->total-$data[0]->paid_amount-$data[0]->flat_discount);?>'  max='<?php echo round($data[0]->total-$data[0]->paid_amount);?>' min="0">
                          <span class="validation-color" id="err_amount"><?php echo form_error('amount'); ?></span>
                        </div>
                        <div class="form-group">
                          <label for="description">Description</label>
                          <input type="text" class="form-control" id="description" name="description">
                          <span class="validation-color" id="err_description"><?php echo form_error('description'); ?></span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="paying_by">Mode Of Receipt<span class="validation-color">*</span></label>
                          <select class="form-control select2" id="paying_by" name="paying_by" style="width: 100%;">
                            <option value="">Select</option>
                            <?php                           
                              foreach ($payment_method as $row) {
                            ?>
                              <option value="<?php echo $row->name; ?>"><?php echo $row->name;?></option>
                            <?php
                              }
                            ?> 
                          </select>
                          <span class="validation-color" id="err_paying_by"><?php echo form_error('paying_by'); ?></span>
                        </div>
                        <div id = "hide">
                          <div class="form-group">
                            <label for="bank_name"><?php echo $this->lang->line('payment_bank_name'); ?><span class="validation-color">*</span></label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo set_value('bank_name'); ?>">
                            <span class="validation-color" id="err_bank_name"><?php echo form_error('bank_name'); ?></span>
                          </div>
                          <div class="form-group">
                            <label for="cheque_no"><?php echo $this->lang->line('payment_cheque_no'); ?><span class="validation-color">*</span></label>
                            <input type="text" class="form-control" id="cheque_no" name="cheque_no" value="<?php echo set_value('cheque_no'); ?>">
                            <span class="validation-color" id="err_cheque_no"><?php echo form_error('cheque_no'); ?></span>
                          </div>
                          <div class="form-group">
                            <label for="cheque_date">Cheque Date</label>
                            <input type="text" class="form-control datepicker" id="cheque_date" name="cheque_date" value="<?php echo set_value('cheque_date'); ?>">
                            <span class="validation-color" id="err_cheque_date"><?php echo form_error('cheque_date'); ?></span>
                          </div>
                        </div>
                        <script>$('#hide').hide();</script>
                      </div>
                    </div>
                  </div>
                </div>
                    
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('sales_pay'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('purchase/view/<?php echo $data[0]->purchase_id; ?>')"><?php echo $this->lang->line('product_cancel'); ?></span>
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
    $this->load->view('layout/footer');
  ?>
  <script>
  $(document).ready(function(){
    var date_empty = "Please Enter Date.";
    var date_invalid = "Please Enter Valid Date";
    var paying_by_empty = "Please Enter Paying Mode.";
    var bank_name_empty = "Please Enter Bank Name.";
    var bank_name_invalid = "Please Enter Valid Bank Name";
    var bank_name_length = "Please Enter Bank Name Minimun 3 Character";
    var cheque_no_empty = "Please Enter Cheque No.";
    var cheque_no_invalid = "Please Enter Valid Cheque No";
    $("#submit").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var num_regex = /^[0-9]+$/;
      var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      var date = $('#date').val().trim();
      var paying_by = $('#paying_by').val();
      var bank_name = $('#bank_name').val().trim();
      var cheque_no = $('#cheque_no').val().trim();
      if(date==null || date==""){
        $("#err_date").text(date_empty);
        return false;
      }
      else{
        $("#err_date").text("");
      }
      if (!date.match(date_regex) ) {
        $('#err_date').text(date_invalid);   
        return false;
      }
      else{
        $("#err_date").text("");
      }
//date validation complite.
      if(paying_by==null || paying_by==""){
        $("#err_paying_by").text(paying_by_empty);
        return false;
      }
      else{
        $("#err_paying_by").text("");
      }

      if(paying_by=="Cheque"){
        if(bank_name == null || bank_name == ""){
          $('#err_bank_name').text(bank_name_empty);
          return false;
        }
        else{
          $('#err_bank_name').text('');
        }
        if (!bank_name.match(name_regex) ) {
          $('#err_bank_name').text(bank_name_invalid);   
          return false;
        }
        else{
          $("#err_bank_name").text("");
        }
        if (bank_name.length < 3) {
          $('#err_bank_name').text(bank_name_length);  
          return false;
        }
        else{
          $("#err_bank_name").text("");
        }

        if(cheque_no == null || cheque_no == ""){
          $('#err_cheque_no').text(cheque_no_empty);
          return false;
        }
        else{
          $('#err_cheque_no').text('');
        }
        if (!cheque_no.match(num_regex) ) {
          $('#err_cheque_no').text(cheque_no_invalid);   
          return false;
        }
        else{
          $("#err_cheque_no").text("");
        }
      }
    });

    $("#date").on("blur keyup",  function (event){
      var date_regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      var date = $('#date').val().trim();
      if(date==null || date==""){
        $("#err_date").text(date_empty);
        return false;
      }
      else{
        $("#err_date").text("");
      }
      if (!date.match(date_regex) ) {
        $('#err_date').text(date_invalid);   
        return false;
      }
      else{
        $("#err_date").text("");
      }
    });
    $("#paying_by").on("change",  function (event){
      $('#hide').hide();
      var paying_by = $('#paying_by').val();
      if(paying_by==null || paying_by==""){
        $("#err_paying_by").text(paying_by_empty);
        return false;
      }
      else{
        if(paying_by == "Cheque"){
          $('#hide').show();
        }
        $("#err_paying_by").text("");
      }
    });
   $("#bank_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var bank_name = $('#bank_name').val().trim();
      if(bank_name == null || bank_name == ""){
        $('#err_bank_name').text(bank_name_empty);
        return false;
      }
      else{
        $('#err_bank_name').text('');
      }
      if (!bank_name.match(name_regex) ) {
        $('#err_bank_name').text(bank_name_invalid);   
        return false;
      }
      else{
        $("#err_bank_name").text("");
      }
      if (bank_name.length < 3) {
        $('#err_bank_name').text(bank_name_length);  
        return false;
      }
      else{
        $("#err_bank_name").text("");
      }
    });
   $("#cheque_no").on("blur keyup",  function (event){
      var num_regex = /^[0-9]+$/;
      var cheque_no = $('#cheque_no').val().trim();
      if(cheque_no == null || cheque_no == ""){
        $('#err_cheque_no').text(cheque_no_empty);
        return false;
      }
      else{
        $('#err_cheque_no').text('');
      }
      if (!cheque_no.match(num_regex) ) {
        $('#err_cheque_no').text(cheque_no_invalid);   
        return false;
      }
      else{
        $("#err_cheque_no").text("");
      }
    });
}); 
</script>
<script>
    $('#branch').change(function(){
      var id = $(this).val();
      $.ajax({
          url: "<?php echo base_url('receipt/getAccount') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            $('#from_ac').html('');
            $('#to_ac').html('');
            for(i=0;i<data.length;i++){
              $('#from_ac').append('<option value="' + data[i].id + '">' + data[i].title +' ('+data[i].group_title+ ')' + '</option>');
            }
            for(i=0;i<data.length;i++){
               $('#to_ac').append('<option value="' + data[i].id + '">' + data[i].title +' ('+data[i].group_title+ ')' + '</option>');
            }
          }
        });
    });
    $('#invoice').change(function(){
      var id = $(this).val();
      $.ajax({
          url: "<?php echo base_url('receipt/getAmount') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            $('#amount').val(data.sales_amount);
            $('#customer').val(data.customer_name);
          }
        });
    });
</script>