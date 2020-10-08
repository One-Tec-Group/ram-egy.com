<div id="brand_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Add New Brand</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-9">
            <div class="form-group">
              <label for="brand_name">Brand Name</label>
              <input type="text" name="brand_name" id="brand_name" class="form-control">
              <span class="validation-color" id="err_brand_name"><?php echo form_error('brand_name'); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add_brand" class="btn btn-info btn-flat pull-left" data-dismiss="modal">ADD</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    var brand_name_empty = "Please Enter the Brand Name.";
    var brand_name_invalid = "Please Enter Valid Brand Name";
    $("#add_brand").click(function(event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var brand_name = $('#brand_name').val();
      if(brand_name==null || brand_name==""){
        $("#err_brand_name").text(brand_name_empty);
        return false;
      }
      else{
        $("#err_brand_name").text("");
      }
      if (!brand_name.match(name_regex)) {
        $('#err_brand_name').text(brand_name_invalid);  
        return false;
      }
      else{
        $("#err_brand_name").text("");
      }
      $.ajax({
        url:"<?php echo base_url('brand/add_brand_ajax') ?>",
        dataType: 'JSON',
        method:'POST',
        data:{
          'brand_name':$('#brand_name').val()
        },
        success:function(result){
          var data = result['data'];
          $('#brand').html('');
          $('#brand_name').val('');
          $('#brand').append('<option value="">Select</option>');
          for(i=0;i<data.length;i++){
              $('#brand').append('<option value="' + data[i].id + '">' + data[i].brand_name + '</option>');
          }
          $('#brand').val(result['id']).attr("selected","selected");
        }
      });
    });

    $("#brand_name").on("blur keyup",  function (event){
      var name_regex = /^[-a-zA-Z\s]+$/;
      var brand_name = $('#brand_name').val();
        if(brand_name==null || brand_name==""){
          $("#err_brand_name").text(brand_name_empty);
          return false;
        }
        else{
          $("#err_brand_name").text("");
        }
        if (!brand_name.match(name_regex)) {
          $('#err_brand_name').text(brand_name_invalid);  
          return false;
        }
        else{
          $("#err_brand_name").text("");
        }
    });
   
}); 
</script>