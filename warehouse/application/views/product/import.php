<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
$this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('Sure To Remove This Record ?'))
     {
        window.location.href='<?php  echo base_url('biller/delete/'); ?>'+id;
     }
  }
  $(function() {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function() {
        $(".import-fail").hide('blind', {}, 500)
    }, 5000);
    setTimeout(function() {
        $(".import-success").hide('blind', {}, 500)
    }, 5000);
  });
</script>
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
         <?php 
                if ($this->session->flashdata('success') != ''){ 
              ?>
              <div class="alert alert-success import-success">    
                <p><?php echo $this->session->flashdata('success');?></p>
              </div>
              <?php
                }
              ?>

              <?php 
                if ($this->session->flashdata('fail') != ''){ 
              ?>
              <div class="alert alert-danger import-fail">    
                <p><?php echo $this->session->flashdata('fail');?></p>
              </div>
              <?php
                }
              ?>
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add products by CSV</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-lg-12">
                  <form action="<?php echo base_url('product/import_csv'); ?>" class="form-horizontal" data-toggle="validator" role="form" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                      <input type="hidden" name="token" value="b83dfa00669b155a37f921dd34e01d69" />  
                      <div class="row">
                        <div class="col-md-12">
                          <div class="well well-small">
                            <a href="<?php echo base_url('assets/csv/sample_products.csv') ?>" class="btn btn-primary btn-flat pull-right"><i class="fa fa-download"></i> Download Sample File</a>
                            <span class="text-warning">The first line in downloaded csv file should remain as it is. Please do not change the order of columns.</span>
                            <br/>The correct column order is <span class="text-info">(Code,Name,Hsn Sac Code,Unit,Size,Cost, Price, Opening Qty, Alert Quantity,Details, IGST, CGST, SGST)</span> &amp; you must follow this.<br>Please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM).<p>The images should be uploaded in <strong>uploads</strong> folder.</p>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="category"><?php echo $this->lang->line('product_select_category'); ?> <span class="validation-color">*</span></label>
                            <span class="pull-right"><a href="<?php echo base_url('category/add'); ?>">+ Add New Category</a></span>
                            <select class="form-control select2" id="category" name="category" style="width: 100%;">
                              <?php
                                foreach ($category as $row) {
                                  echo "<option value='$row->category_id'".set_select('category',$row->category_id).">$row->category_name</option>";
                                }
                              ?>
                            </select>
                            <span class="validation-color" id="err_category"><?php echo form_error('category'); ?></span>
                          </div>
                          <div class="form-group">
                            <label for="csv_file">Upload File</label>
                            <input type="file" data-browse-label="Browse ..." name="csv" class="form-control file" data-show-upload="false" data-show-preview="false" id="csv" required="required" accept=".csv"/>
                          </div>
                          <div class="form-group">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="update_records" value="yes"> Overwrite the product details if product exist in the database.
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          
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
  $('#category').change(function(){
      var id = $(this).val();
      $('#subcategory').html('');
      $.ajax({
          url: "<?php echo base_url('product/getSubcategory') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              //alert(data[i].sub_category_name);
                $('#subcategory').append('<option value="' + data[i].sub_category_id + '">' + data[i].sub_category_name + '</option>');
             
            }
            //console.log(data);
          } 
        });
    });
</script>
