<div id="warehouse_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Add New Warehouse</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-9">
            <div class="form-group">
              <label for="branch"><!-- Select Branch --> 
                  <?php echo $this->lang->line('add_biller_select_branch'); ?>
                <span class="validation-color">*</span></label>
              <select class="form-control select2" id="branch" name="branch" style="width: 100%;">
                <option value=""><!-- Select -->
                  <?php echo $this->lang->line('add_biller_select'); ?>
                </option>
                <?php
                  $data = $this->db->get_where('branch',array('delete_status'=>0))->result();
                  foreach ($data as $row) {
                    echo "<option value='$row->branch_id'".set_select('branch',$row->branch_id).">$row->branch_name</option>";
                  }
                ?>
              </select>
              <span class="validation-color" id="err_branch_id"><?php echo form_error('branch'); ?></span>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label for="warehouse_name"><!-- Warehouse Name -->
                  <?php echo $this->lang->line('add_warehouse_name'); ?>
               <span class="validation-color">*</span></label>
              <input type="text" class="form-control" id="warehouse_name" name="warehouse_name" value="<?php echo set_value('warehouse_name'); ?>">
              <span class="validation-color" id="err_warehouse_name"><?php echo form_error('warehouse_name'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add_warehouse" class="btn btn-info btn-flat pull-left" data-dismiss="modal">ADD</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $("#add_warehouse").click(function(event){
      var name_regex = /^[-\sa-zA-Z]+$/;
      var branch_id = $('#branch').val();
      var warehouse_name = $('#warehouse_name').val();


        if(branch_id==""){
          $("#err_branch_id").text("Please Select Branch.");
          return false;
        }
        else{
          $("#err_branch_id").text("");
        }
//branch id validation complite.

        if(warehouse_name==null || warehouse_name==""){
          $("#err_warehouse_name").text("Please Enter Warehouse Name.");
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
        if (!warehouse_name.match(name_regex) ) {
          $('#err_warehouse_name').text(" Please Enter Valid Warehouse Name  ");   
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
//warehouse name validation complite.
        $.ajax({
        url:"<?php echo base_url('warehouse/add_warehouse_ajax') ?>",
        dataType : 'JSON',
        method : 'POST',
        data:{
            'branch':$('#branch').val(),
            'warehouse_name':$('#warehouse_name').val()
        },
        success:function(result){
          var data = result['data'];
          $('#warehouse').html('');
          $('#warehouse').append('<option value="">Select</option>');
          $('#warehouse_name').val('');
          for(i=0;i<data.length;i++){
              $('#warehouse').append('<option value="' + data[i].warehouse_id + '">' + data[i].warehouse_name + '</option>');
          }
          $('#warehouse').val(result['id']).attr("selected","selected");
        }
      });
        
    });

    $("#branch").change(function(event){
        var branch_id = $('#branch').val();
        if(branch_id==""){
          $("#err_branch_id").text(" Please Select Branch.");
          return false;
        }
        else{
          $("#err_branch_id").text("");
        }
    });

    $("#warehouse_name").on("blur keyup", function(){
        var name_regex = /^[-\sa-zA-Z]+$/;
        var warehouse_name = $('#warehouse_name').val();
        if(warehouse_name==null || warehouse_name==""){
          $("#err_warehouse_name").text("Please Enter Warehouse Name.");
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
        if (!warehouse_name.match(name_regex) ) {
          $('#err_warehouse_name').text(" Please Enter Valid Warehouse Name  ");   
          return false;
        }
        else{
          $("#err_warehouse_name").text("");
        }
    });
   
}); 
</script>