<div id="assignWarehouse" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><!-- <?php echo $this->lang->line('product_hsn_sac_lookup'); ?> -->
          Assign Warehouse
        </h4>
      </div>
      <div class="modal-body">
        <div class="control-group">                     
          <div class="controls">
            <div class="tabbable">
              <div class="box-body">
                <div class="row">
                  <form>
                  <div class="col-md-6">
                    <div class="form-group">
                    <label for="user_id"><?php echo $this->lang->line('assign_warehouse_user_name'); ?> <span class="validation-color">*</span></label>
                    <select class="form-control select2" id="user_id" name="user_id" style="width: 100%;">
                      <option value=""><?php echo $this->lang->line('assign_warehouse_select'); ?></option>
                      <?php
                        foreach ($user as $value) {
                      ?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->first_name." ".$value->last_name; ?></option>
                      <?php
                        }
                      ?>
                    </select>
                    <span class="validation-color" id="err_user_id"><?php echo form_error('user_id'); ?></span>
                  </div>
                    <div class="form-group">
                    <label for="warehouse_id1"><?php echo $this->lang->line('assign_warehouse_warehouse_name'); ?> <span class="validation-color">*</span></label>
                    <select class="form-control select2" id="warehouse_id1" name="warehouse_id1" style="width: 100%;">
                      <option value=""><?php echo $this->lang->line('assign_warehouse_select'); ?></option>
                      
                    </select>
                    <span class="validation-color" id="err_warehouse_id"><?php echo form_error('warehouse_id1'); ?></span>
                  </div>
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="btn_asw_submit" class="btn btn-info" class="close"  data-dismiss="modal">&nbsp;&nbsp;&nbsp;<!-- Add -->
                        <?php echo $this->lang->line('add_user_btn'); ?>&nbsp;&nbsp;&nbsp;</button>
                    <!-- <span class="btn btn-default" id="cancel" style="margin-left: 2%" onclick="cancel('customer')">
                      <?php echo $this->lang->line('add_user_btn_cancel'); ?></span> -->
                  </div>
                </div>
              </form>
              </div>
          <!-- /.box-body -->
              </div>
                <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('product_close'); ?></button>
                </div> -->
            </div>
          </div>
        </div> <!-- /controls -->       
      </div> <!-- /control-group --> 
    </div>
  </div>
</div>

<script type="text/javascript">
    $('#user_id').change(function(){
      var id = $(this).val();
      $('#warehouse_id1').html('');
      $('#warehouse_id1').append('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('assign_warehouse/getWarehouse') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              //alert(data[i].sub_category_name);
                $('#warehouse_id1').append('<option value="' + data[i].warehouse_id + '">' + data[i].warehouse_name + '</option>');
             
            }
            //console.log(data);
          } 
        });

    });

</script>

<script>
  $(document).ready(function(){
    $("#btn_asw_submit").click(function(event){
      var user_id = $('#user_id').val();
      var warehouse_id = $('#warehouse_id1').val();

        if(user_id==""){
          $("#err_user_id").text("Select the User Name.");
          return false;
        }
        else{
          $("#err_user_id").text("");
        }
        if(warehouse_id==""){
          $("#err_warehouse_id").text("Select the Warehouse Name.");
          return false;
        }
        else{
          $("#err_warehouse_id").text("");
        }
        $.ajax({
        url : '<?php echo base_url('assign_warehouse/assign_warehouse_sort') ?>',
        dataType : 'JSON',
        method : 'POST',
        data:{
            'user_id':$('#user_id').val(),
            'warehouse_id':$('#warehouse_id1').val()
        },
        success : function(result){
          alert();
        }
      });
        
    });

    $("#user_id").change(function(event){
        var user_id = $('#user_id').val();
        if(user_id==""){
          $("#err_user_id").text("Select the User Name.");
          return false;
        }
        else{
          $("#err_user_id").text("");
        }
    });

    $("#warehouse_id1").change(function(event){
        var warehouse_id = $('#warehouse_id').val();
        if(warehouse_id==""){
          $("#err_warehouse_id").text("Select the Warehouse Name.");
          return false;
        }
        else{
          $("#err_warehouse_id").text("");
        }
    });
    
   
}); 
</script>
      
    