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
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('product'); ?>"><?php echo $this->lang->line('header_product'); ?></a></li>
          <li class="active">Add products by CSV</li>
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
              <h3 class="box-title">Add products by CSV</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-lg-12">
                  <form action="<?php echo base_url('transfer/import_csv'); ?>" class="form-horizontal" data-toggle="validator" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                    <input type="hidden" name="token" value="b83dfa00669b155a37f921dd34e01d69" />  
                      <div class="row">
                        <div class="col-md-12">
                          <div class="well well-small">
                            <a href="<?php echo base_url('assets/csv/sample_products1.csv') ?>" class="btn btn-primary btn-flat pull-right"><i class="fa fa-download"></i> Download Sample File</a>
                            <span class="text-warning">The first line in downloaded csv file should remain as it is. Please do not change the order of columns.</span>
                            <br/>The correct column order is <span class="text-info">(Code, Quantity)</span> &amp; you must follow this.<br>Please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM).<p>The images should be uploaded in <strong>uploads</strong> folder.</p>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="from_warehouse"><?php echo $this->lang->line('transfer_from_warehouse'); ?><span class="validation-color">*</span></label>
                            <select class="form-control select2" id="from_warehouse" name="from_warehouse" style="width: 100%;">
                              <option value=""><?php echo $this->lang->line('transfer_select'); ?></option>
                                <?php

                                  foreach ($warehouse as $row) {
                                ?>
                                    <option value='<?php echo $row->warehouse_id?>'>
                                      <?php echo $row->warehouse_name ;?>
                                      <?php 
                                        if($row->primary_warehouse == 1){
                                          echo " (Primary Warehouse)";
                                        }
                                      ?>
                                    </option>
                                                
                                <?php        
                                  }
                                ?>
                            </select>
                            <span class="validation-color" id="err_from_warehouse"><?php echo form_error('from_warehouse'); ?></span>
                          </div>
                          <div class="form-group">
                            <label for="to_warehouse"><?php echo $this->lang->line('transfer_to_warehouse'); ?> <span class="validation-color">*</span></label>
                            <select class="form-control select2" id="to_warehouse" name="to_warehouse" style="width: 100%;">
                              <option value=""><?php echo $this->lang->line('transfer_select'); ?></option>
                              <?php

                                foreach ($warehouse as $row) {
                              ?>
                                  <option value='<?php echo $row->warehouse_id?>'>
                                    <?php echo $row->warehouse_name ;?>
                                    <?php 
                                      if($row->primary_warehouse == 1){
                                        echo " (Primary Warehouse)";
                                      }
                                    ?>
                                  </option>
                                              
                              <?php        
                                }
                              ?>
                            </select>
                            <span class="validation-color" id="err_to_warehouse"><?php echo form_error('to_warehouse'); ?></span>
                          </div>
                        
                        
                          <div class="form-group">
                            <label for="csv_file">Upload File</label>
                            <input type="file" data-browse-label="Browse ..." name="csv" class="form-control file" data-show-upload="false" data-show-preview="false" id="csv" required="required" accept=".csv"/>
                          </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <input type="submit" name="import" value="Import"  class="btn btn-primary" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>        
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
<script>
  $(document).ready(function(){

    $("#submit").click(function(event){
      var to_warehouse = $('#to_warehouse').val();
      var from_warehouse = $('#from_warehouse').val();

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
