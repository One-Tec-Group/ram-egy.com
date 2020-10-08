<!-- Category Modal -->
<div id="category_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Category</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-9">
            <div class="form-group">
              <label for="category_name">Category Name</label>
              <input type="input" class="form-control" name="category_name" id="category_name">
              <span class="validation-color" id="err_category_name"><?php echo form_error('category_name'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add_category" class="btn btn-info btn-flat pull-left" data-dismiss="modal">ADD</button>
      </div>
    </div>

  </div>
</div>
<script>

</script>
<script>
  $(document).ready(function(){
    var category_name_empty = "Please Enter the Category Name.";
    var category_name_invalid = "Please Enter Valid Category Name";
    var category_name_length = "Please Enter Category Name Minimun 3 Character";
    $("#add_category").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var category_name = $('#category_name').val().trim();
      $('#category_name').val(category_name);
      if(category_name==null || category_name==""){
        $("#err_category_name").text(category_name_empty);
        return false;
      }
      else{
        $("#err_category_name").text("");
      }
      if (!category_name.match(name_regex) ) {
        $('#err_category_name').text(category_name_invalid);   
        return false;
      }
      else{
        $("#err_category_name").text("");
      }
      if (category_name.length < 3) {
        $('#err_category_name').text(category_name_length);  
        return false;
      }
      else{
        $("#err_category_name").text("");
      }
//category name validation complite.
      $.ajax({
        url:"<?php echo base_url('category/add_category_ajax') ?>",
        dataType : 'JSON',
        method : 'POST',
        data:{
            'category_name':$('#category_name').val()
        },
        success:function(result){
          var data = result['data'];
          $('#category').html('');
          $('#subcategory').html('');
          $('#category_id_model').html('');
          $('#category').append('<option value="">Select</option>');
          $('#subcategory').append('<option value="">Select</option>');
          $('#category_id_model').append('<option value="">Select</option>');
          $('#category_name').val('');
          for(i=0;i<data.length;i++){
              $('#category').append('<option value="' + data[i].category_id + '">' + data[i].category_name + '</option>');
          }
          for(i=0;i<data.length;i++){
              $('#category_id_model').append('<option value="' + data[i].category_id + '">' + data[i].category_name + '</option>');
          }
          $('#category').val(result['id']).attr("selected","selected");
        }
      });
    });

    $("#category_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var category_name = $('#category_name').val();
        if(category_name==null || category_name==""){
          $("#err_category_name").text(category_name_empty);
          return false;
        }
        else{
          $("#err_category_name").text("");
        }
        if (!category_name.match(name_regex)) {
          $('#err_category_name').text(category_name_invalid);  
          return false;
        }
        else{
          $("#err_category_name").text("");
        }
        if (category_name.length < 3) {
          $('#err_category_name').text(category_name_length);  
          return false;
        }
        else{
          $("#err_category_name").text("");
        }
    });
   
}); 
</script>