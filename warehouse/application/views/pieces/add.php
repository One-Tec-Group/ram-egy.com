<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>
  <div class="content-wrapper">
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('pieces'); ?>"><?php echo $this->lang->line('header_pieces'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('pieces_add_piece'); ?></li>
        </ol>
      </h5>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $this->lang->line('pieces_add_new_piece'); ?></h3>
            </div>
            <div class="box-body">
              <div class="row">
                <form role="form" id="form" method="post" action="<?php echo base_url('pieces/addPiece');?>" encType="multipart/form-data">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="code"><?php echo $this->lang->line('pieces_piece_code'); ?><span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="code" name="code" value="<?php echo set_value('code'); ?>">
                      <span class="validation-color" id="err_code"><?php echo form_error('code'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="name"><?php echo $this->lang->line('pieces_piece_name'); ?> <span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>">
                      <span class="validation-color" id="err_name"><?php echo form_error('name'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="hsn_sac_code"><?php echo $this->lang->line('product_hsn_sac_code'); ?></label>
                      <input type="text" class="form-control" id="hsn_sac_code" name="hsn_sac_code" value="<?php echo set_value('hsn_sac_code'); ?>">
                      <a href="" data-toggle="modal" data-target="#myModal"><?php echo $this->lang->line('product_hsn_sac_lookup'); ?></span></a>
                      <span class="validation-color" id="err_hsn_sac_code"><?php echo form_error('hsn_sac_code'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="unit"><?php echo $this->lang->line('pieces_piece_unit'); ?> </label>
                      <select class="form-control select2" id="unit" name="unit">
                        <option value="">Select</option>
                        <?php
                          foreach ($uqc as $value) {
                            echo "<option value='$value->uom - $value->description'".set_select('brand',$value->id).">$value->uom - $value->description</option>";
                          }
                        ?>
                      </select>
                      <span class="validation-color" id="err_unit"><?php echo form_error('unit'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="size"><?php echo $this->lang->line('pieces_piece_size'); ?> </label>
                      <input type="text" class="form-control" id="size" name="size" value="<?php echo set_value('size'); ?>">
                      <span class="validation-color" id="err_size"><?php echo form_error('size'); ?></span>
                    </div>

                    <div class="form-group">
                        <label for="image"><?php echo $this->lang->line('pieces_piece_image'); ?> </label>
                        <input type="file" class="" id="image" name="image" value="<?php echo set_value('image'); ?>">
                        <span class="validation-color" id="err_image"><?php echo form_error('image'); ?></span>
                    </div>
                  </div>
                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="cost"><?php echo $this->lang->line('pieces_piece_cost'); ?> <span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="cost" name="cost" value="<?php echo set_value('cost'); ?>">
                      <span class="validation-color" id="err_cost"><?php echo form_error('cost'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="price"><?php echo $this->lang->line('pieces_piece_price'); ?> <span class="validation-color">*</span></label>
                      <input type="text" class="form-control" id="price" name="price" value="<?php echo set_value('price'); ?>">
                      <span class="validation-color" id="err_price"><?php echo form_error('price'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="alert_quantity"><?php echo $this->lang->line('product_alert_quantity'); ?> </label>
                      <input type="text" class="form-control" id="alert_quantity" name="alert_quantity" value="<?php echo set_value('alert_quantity'); ?>">
                      <span class="validation-color" id="err_alert_quantity"><?php echo form_error('alert_quantity'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="opening_stock">Opening Stock</label>
                      <input type="text" class="form-control" id="opening_stock" name="opening_stock" value="<?php echo set_value('opening_stock'); ?>">
                      <span class="validation-color" id="err_igst"><?php echo form_error('opening_stock'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="igst">IGST %</label>
                      <input type="text" class="form-control" id="igst" name="igst" value="<?php echo set_value('igst'); ?>">
                      <span class="validation-color" id="err_igst"><?php echo form_error('igst'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="cgst">CGST %</label>
                      <input type="text" class="form-control" id="cgst" name="cgst" value="<?php echo set_value('cgst'); ?>">
                      <span class="validation-color" id="err_cgst"><?php echo form_error('cgst'); ?></span>
                    </div>

                    <div class="form-group">
                      <label for="sgst">SGST %</label>
                      <input type="text" class="form-control" id="sgst" name="sgst" value="<?php echo set_value('sgst'); ?>">
                      <span class="validation-color" id="err_sgst"><?php echo form_error('sgst'); ?></span>
                    </div>

                  </div>
                  </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="submit" class="btn btn-info">&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('product_add'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('product')"><?php echo $this->lang->line('product_cancel'); ?></span>
                  </div>
                </div>
                </form>
          </div>
        </div>
      </div>
    </section>
  </div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><?php echo $this->lang->line('product_hsn_sac_lookup'); ?></h4>
      </div>
      <div class="modal-body">
        <div class="control-group">
          <div class="controls">
            <div class="tabbable">
              <ul class="nav nav-tabs">
                <li>
                  <a href="#hsn" data-toggle="tab"><?php echo $this->lang->line('product_hsn'); ?></a>
                </li>
                <li class="active">
                  <a href="#sac" data-toggle="tab"><?php echo $this->lang->line('product_sac'); ?></a>
                </li>
              </ul>
              <br>
              <div class="tab-content">
                <div class="tab-pane" id="hsn">
                 <div class="form-group">
                  <?php echo $this->lang->line('product_chapter'); ?>
                  <select class="form-control select2" id="chapter" name="chapter" style="width: 40%;">
                    <?php
                      foreach ($chapter as $row) {
                        echo "<option value='$row->id'> Chapter $row->id $row->chapter</option>";
                      }
                    ?>
                  </select>
                </div>
                  <table id="index1" class="table table-bordered table-striped product_table1">
                    <thead>
                      <th><?php echo $this->lang->line('product_no'); ?></th>
                      <th><?php echo $this->lang->line('product_hsn_code'); ?></th>
                      <th><?php echo $this->lang->line('product_description'); ?></th>
                      <th></th>
                    <thead>
                    <tbody id="product_table_body">
                      <?php
                        foreach ($hsn as $value) {
                      ?>
                        <tr>
                          <td></td>
                          <td><span id="accounting_code1"><?php echo $value->itc_hs_codes ?></span></td>
                          <td><?php echo $value->description ?></td>
                          <td align="center"><span class="btn btn-info apply1" class="close" data-dismiss="modal"><?php echo $this->lang->line('product_apply'); ?></span></td>
                        </tr>
                      <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane active" id="sac">
                  <table id="index" class="table table-bordered table-striped product_table">
                    <thead>
                      <th><?php echo $this->lang->line('product_no'); ?></th>
                      <th><?php echo $this->lang->line('product_sac_code'); ?></th>
                      <th><?php echo $this->lang->line('product_description'); ?></th>
                      <th></th>
                    <thead>
                    <tbody>
                      <?php
                        foreach ($sac as $value) {
                      ?>
                        <tr>
                          <td></td>
                          <td><span id="accounting_code"><?php echo $value->accounting_code ?></span></td>
                          <td><?php echo $value->description ?></td>
                          <td align="center"><span class="btn btn-info apply" class="close" data-dismiss="modal"><?php echo $this->lang->line('product_apply'); ?></span></td>
                        </tr>
                      <?php
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('product_close'); ?></button>
      </div>
    </div>

  </div>
</div>
  <?php
    include('brand.php');
    $this->load->view('layout/product_footer');
  ?>
<script>
    $("table.product_table").on("click", "span.apply", function (event) {
        var row = $(this).closest("tr");
        var code = +row.find('#accounting_code').text();
        $('#hsn_sac_code').val(code);
        $('#myModal').modal('hide');
    });
    $("table.product_table1").on("click", "span.apply1", function (event) {
        var row = $(this).closest("tr");
        var code = +row.find('#accounting_code1').text();
        $('#hsn_sac_code').val(code);
        $('#myModal').modal('hide');
    });

    $('#chapter').change(function(){
      var id = $(this).val();
      $.ajax({
          url: "<?php echo base_url('product/getHsnData') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            var table = $('#index1').DataTable();
            table.destroy();
            $('#product_table_body').empty();
            for(i=0;i<data.length;i++){
              var newRow = $("<tr>");
              var cols = "";
              cols += "<td></td>";
              cols += "<td><span id='accounting_code1'>"+ data[i].itc_hs_codes+"</span></td>";
              cols += "<td>"+data[i].description+"</td>";
              cols += "<td align='center'><span class='btn btn-info apply1' class='close' data-dismiss='modal'>Apply</span></td>";
              cols += "</tr>";
              newRow.append(cols);
              $("table.product_table1").append(newRow);
            }
                  $(document).ready(function() {
                    var t = $('#index1').DataTable( {
                      "columnDefs": [ {
                          "searchable": false,
                          "orderable": false,
                          "targets": 0
                      } ],
                      "order": [[ 1, 'asc' ]]
                    });

                    t.on( 'order.dt search.dt', function () {
                      t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                          cell.innerHTML = i+1;
                      });
                    }).draw();
                  });
          }
        });
    });

</script>

 <script>
  $(document).ready(function(){
    $("#submit").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var p_name_regex = /^[-a-zA-Z0-9\s]+$/;
      var sname_regex = /^[a-zA-Z0-9]+$/;
      var num_regex = /^\$?[0-9]+(\.[0-9][0-9])?$/;
      var snum_regex = /^[0-9]+$/;
      var code = $('#code').val();
      var name = $('#name').val();
      var unit = $('#unit').val();
      var size = $('#size').val();
      var cost = $('#cost').val();
      var price = $('#price').val();
      var alert_quantity = $('#alert_quantity').val();
      var tax = $('#tax').val();
      var image = $('#image').val();
      var details = $('#details').val();


        if(code==null || code==""){
          $("#err_code").text("Please Enter Product Code.");
          return false;
        }
        else{
          $("#err_code").text("");
        }
        if(name==null || name==""){
          $("#err_name").text("Please Enter Product Name.");
          return false;
        }
        else{
          $("#err_name").text("");
        }
        if (!name.match(p_name_regex) ) {
          $('#err_name').text(" Please Enter Valid Product Name ");
          return false;
        }
        else{
          $("#err_name").text("");
        }

        if(cost==null || cost==""){
          $("#err_cost").text("Please Enter Product Cost");
          return false;
        }
        else{
          $("#err_cost").text("");
        }
        if (!cost.match(num_regex) ) {
          $('#err_cost').text(" Please Enter Valid Product Cost. (Ex - 1000 or 100.10)");
          return false;
        }
        else{
          $("#err_cost").text("");
        }
        if(price==null || price==""){
          $("#err_price").text("Please Enter Product Price");
          return false;
        }
        else{
          $("#err_price").text("");
        }
        if (!price.match(num_regex) ) {
          $('#err_price').text(" Please Enter Valid Product Price. (Ex - 1000 or 100.10)");
          return false;
        }
        else{
          $("#err_price").text("");
        }
    });

    $("#code").on("blur keyup",  function (event){
        var num_regex = /^[0-9]+$/;
        var code = $('#code').val();
        if(code==null || code==""){
          $("#err_code").text("Please Enter Product Code.");
          return false;
        }
        else{
          $("#err_code").text("");
        }
    });

    $("#name").on("blur keyup",  function (event){
        var name_regex = /^[-a-zA-Z0-9\s]+$/;
        var name = $('#name').val();
        if(name==null || name==""){
          $("#err_name").text("Please Enter Product Name.");
          return false;
        }
        else{
          $("#err_name").text("");
        }
        if (!name.match(name_regex) ) {
          $('#err_name').text(" Please Enter Valid Product Name ");
          return false;
        }
        else{
          $("#err_name").text("");
        }
    });

    $("#cost").on("blur keyup",  function (event){
        var num_regex = /^\$?[0-9]+(\.[0-9][0-9])?$/;
        var cost = $('#cost').val();
        if(cost==null || cost==""){
          $("#err_cost").text("Please Enter Product Cost");
          return false;
        }
        else{
          $("#err_cost").text("");
        }
        if (!cost.match(num_regex) ) {
          $('#err_cost').text(" Please Enter Valid Product Cost. (Ex - 1000 or 100.10)");
          return false;
        }
        else{
          $("#err_cost").text("");
        }
    });
    $("#price").on("blur keyup",  function (event){
        var num_regex = /^\$?[0-9]+(\.[0-9][0-9])?$/;
        var price = $('#price').val();
        if(price==null || price==""){
          $("#err_price").text("Please Enter Product Price");
          return false;
        }
        else{
          $("#err_price").text("");
        }
        if (!price.match(num_regex) ) {
          $('#err_price').text(" Please Enter Valid Product Price. (Ex - 1000 or 100.10)");
          return false;
        }
        else{
          $("#err_price").text("");
        }
    });

});
</script>
