<!--Subcategory  Modal -->
<div id="subcategory_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Subcategory</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-9">
            <div class="form-group">
              <label for="category_id_model"></label>
              <select name="category_id_model" id="category_id_model" class="select2 form-control" style="width: 100%;">
                <option value=""><?php echo $this->lang->line('product_select'); ?></option>
                  <?php
                    foreach ($category as $row) {
                      echo "<option value='$row->category_id'>$row->category_name</option>";
                    }
                  ?>
              </select>
              <span class="validation-color" id="err_category_id_model"><?php echo form_error('category_id_model'); ?></span>
            </div>
            <div class="form-group">
              <label for="subcategory_name">Subcategory Name</label>
              <input type="input" class="form-control" name="subcategory_name" id="subcategory_name">
              <span class="validation-color" id="err_subcategory_name"><?php echo form_error('subcategory_name'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add_subcategory" class="btn btn-info btn-flat pull-left" data-dismiss="modal">ADD</button>
      </div>
    </div>

  </div>
</div>
<script>
$(document).ready(function(){
    var subcategory_name_empty = "Please Enter Subcategory.";
    var subcategory_name_invalid = "Please Enter Valid Subategory Name";
    var subcategory_name_length = "Please Enter Subcategory Name Minimun 3 Character";
    var category_select = "Please Select Category."
    $("#add_subcategory").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var subcategory_name = $('#subcategory_name').val().trim();
      var category = $('#category_id_model').val();

      if(category == "" || category == null){
        $('#err_category_id_model').text(category_select);
        return false;
      }
      else{
        $('#err_category_id_model').text("");
      }
//select category validation copmlite.

      $('#subcategory_name').val(subcategory_name);
      if(subcategory_name==null || subcategory_name==""){
        $("#err_subcategory_name").text(subcategory_name_empty);
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (!subcategory_name.match(name_regex) ) {
        $('#err_subcategory_name').text(subcategory_name_invalid);   
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (subcategory_name.length < 3) {
        $('#err_subcategory_name').text(subcategory_name_length);  
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
//subcategory name validation complite.
      $.ajax({
        url:"<?php echo base_url('subcategory/add_subcategory_ajax') ?>",
        dataType: 'JSON',
        method:'POST',
        data:{
          'subcategory_name':$('#subcategory_name').val(),
          'category_id_model':$('#category_id_model').val(),
          'category_id':$('#category').val()
        },
        success:function(result){
          var data = result['data'];
          var category = result['data'];
          $('#subcategory').html('');
          $('#subcategory_name').val('');
          $('#subcategory').append('<option value="">Select</option>');
          for(i=0;i<data.length;i++){
              $('#subcategory').append('<option value="' + data[i].sub_category_id + '">' + data[i].sub_category_name + '</option>');
          }
          $('#category').val($('#category_id_model').val()).attr("selected","selected");
          $('#subcategory').val(result['subcategory_id']).attr("selected","selected");
        }
      });
    });

    $("#subcategory_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var subcategory_name = $('#subcategory_name').val();
      if(subcategory_name==null || subcategory_name==""){
        $("#err_subcategory_name").text(subcategory_name_empty);
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (!subcategory_name.match(name_regex) ) {
        $('#err_subcategory_name').text(subcategory_name_invalid);   
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
      if (subcategory_name.length < 3) {
        $('#err_subcategory_name').text(subcategory_name_length);  
        return false;
      }
      else{
        $("#err_subcategory_name").text("");
      }
    });
    $('#category').change(function(){
      var category = $('#category_id_model').val();
      if(category == "" || category == null){
        $('#err_category').text(category_select);
      }
      else{
        $('#err_category').text("");
      }
    });
}); 
</script>