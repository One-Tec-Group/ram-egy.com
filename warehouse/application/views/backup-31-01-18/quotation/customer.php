<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4><!-- <?php echo $this->lang->line('product_hsn_sac_lookup'); ?> -->
          Add New Customer
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
                      <label for="customer_name">
                        <?php echo $this->lang->line('add_customer_cname'); ?>
                      </label>
                      <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo set_value('customer_name'); ?>">
                      <span class="validation-color" id="err_customer_name"><?php echo form_error('customer_name'); ?></span>
                    </div>
                    <div class="form-group">
                      <label for="gstin">GSTIN</label>
                      <input type="text" class="form-control" id="gstin" name="gstin" value="<?php echo set_value('gstin'); ?>">
                      <span class="validation-color" id="err_gstid"><?php echo form_error('gstid'); ?></span>
                    </div>
                  <div class="form-group">
                    <label for="address1">
                        <?php echo $this->lang->line('add_biller_address'); ?> 
                    </label>
                    <textarea class="form-control" id="address1" rows="4" name="address1"><?php echo set_value('address'); ?></textarea>
                    <span class="validation-color" id="err_address1"><?php echo form_error('address1'); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <?php
                      $country=$this->db->get('countries')->result();
                  ?>
                  <div class="form-group">
                    <label for="country"><!-- Country --> 
                      <?php echo $this->lang->line('biller_lable_country'); ?>
                    </label>
                    <select class="form-control select2" id="country1" name="country1" style="width: 100%;">
                      <option value=""><?php echo $this->lang->line('add_biller_select'); ?></option>
                      <?php
                        foreach ($country as  $key) {
                      ?>
                      <option value='<?php echo $key->id ?>' <?php if($key->id == 101){ echo "selected";}?>>
                          <?php echo $key->name; ?>
                      </option>
                      <?php
                        }
                      ?>
                    </select>
                    <span class="validation-color" id="err_country1"><?php echo form_error('country'); ?></span>
                  </div>
                    <?php
                        /*$country=$this->db->get('states')->where('s.country_id')->result();*/
                        $country= $this->db->select('s.*')
                        ->from('states s')
                        ->join('countries c','c.id = s.country_id')
                        ->where('s.country_id',101)
                        ->get()
                        ->result();
                    ?>
                  <div class="form-group">
                    <label for="state"><!-- State --> 
                      <?php echo $this->lang->line('add_biller_state'); ?> 
                    </label>
                    <select class="form-control select2" id="state1" name="state1" style="width: 100%;">
                      <option value=""><!-- Select -->
                        <?php echo $this->lang->line('add_biller_select'); ?>
                      </option>
                          <?php
                            foreach ($country as  $key) {
                          ?>
                          <option value='<?php echo $key->id ?>' <?php if($key->id == 101){ echo "selected";}?>>
                              <?php echo $key->name; ?>
                          </option>
                          <?php
                            }
                          ?>
                    </select>
                    <span class="validation-color" id="err_state1"><?php echo form_error('state'); ?></span>
                  </div>
                  <?php
                      $this->db->select('c.*')
                         ->from('cities c')
                         ->join('states s','s.id = c.state_id')
                         ->where('c.state_id',12)
                         ->get()
                         ->result();
                    ?>
                  <div class="form-group">
                    <label for="city"><!-- City --> 
                      <?php echo $this->lang->line('biller_lable_city'); ?> 
                    </label>
                    <select class="form-control select2" id="city1" name="city1" style="width: 100%;">
                      <option value=""><!-- Select -->
                        <?php echo $this->lang->line('add_biller_select'); ?>
                      </option>
                    </select>
                    <span class="validation-color" id="err_city1"><?php echo form_error('city'); ?></span>
                  </div>

                  <div class="form-group">
                    <label for="mobile"><!-- Mobile --> 
                        <?php echo $this->lang->line('add_biller_mobile'); ?> 
                    </label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo set_value('mobile'); ?>">
                    <span class="validation-color" id="err_mobile"><?php echo form_error('mobile'); ?></span>
                  </div>
                </div>
                
                <div class="col-sm-12">
                  <div class="box-footer">
                    <button type="submit" id="btn_submit" class="btn btn-info" class="close"  data-dismiss="modal">&nbsp;&nbsp;&nbsp;<!-- Add -->
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

<script>
    $('#country1').change(function(){
      var id = $(this).val();
      $('#state1').html('<option value="">Select</option>');
      $('#city1').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('customer/getState') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#state1').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
</script>
<script>
    $('#state1').change(function(){
      var id = $(this).val();
      $('#city1').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('customer/getCity') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#city1').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
</script>
<script>
  $(document).ready(function(){
    $("#btn_submit").click(function(event){
      var name_regex = /^[a-zA-Z\s]+$/;
      var mobile_regex = /^[6-9][0-9]{9}$/; 
      var customer_name = $('#customer_name').val();
      var address = $('#address1').val();
      var city = $('#city1').val();
      var state = $('#state1').val();
      var country = $('#country1').val();
      var mobile = $('#mobile').val();

      if(customer_name==null || customer_name==""){
        $("#err_customer_name").text("Please Enter Customer Name.");
        return false;
      }
      else{
        $("#err_customer_name").text("");
      }
      if (!customer_name.match(name_regex) ) {
        $('#err_customer_name').text(" Please Enter Valid Customer Name ");   
        return false;
      }
      else{
        $("#err_customer_name").text("");
      }
//customer name validation complite.

      if(address==null || address==""){
        $("#err_address1").text(" Please Enter Address");
        return false;
      }
      else{
        $("#err_address1").text("");
      }
//Address validation complite.
        
      if(country==null || country==""){
        $("#err_country1").text("Please Select Country ");
        return false;
      }
      else{
        $("#err_country1").text("");
      }
//country validation complite.
      
      if(state==null || state==""){
        $("#err_state1").text("Please Select State ");
        return false;
      }
      else{
        $("#err_state1").text("");
      }
//state validation complite.
        
      if(city==null || city==""){
        $("#err_city1").text("Please Select City ");
        return false;
      }
      else{
        $("#err_city1").text("");
      }
//city validation complite.
        
      if(mobile==null || mobile==""){
        $("#err_mobile").text("Please Enter Mobile.");
        return false;
      }
      else{
        $("#err_mobile").text("");
      }
      if (!mobile.match(mobile_regex) ) {
        $('#err_mobile').text(" Please Enter Valid Mobile ");   
        return false;
      }
      else{
        $("#err_mobile").text("");
      }
//mobile validation complite.
      $.ajax({
      url : '<?php echo base_url('customer/add_customer_sort') ?>',
      dataType : 'JSON',
      method : 'POST',
      data:{
          'customer_name':$('#customer_name').val(),
          'gstin':$('#gstin').val(),
          'address':$("#address1").val(),
          'country':$("#country1").val(),
          'state':$("#state1").val(),
          'city':$("#city1").val(),
          'mobile':$('#mobile').val()
      },
      success : function(result){
        var data = result['data'];
        $('#customer').html('');
        $('#customer').append('<option value="">Select</option>');
        for(i=0;i<data.length;i++){
            $('#customer').append('<option value="' + data[i].customer_id + '">' + data[i].customer_name + '</option>');
        }
        $('#customer').val(result['id']).attr("selected","selected");
      }
    });
    });

    $("#customer_name").on("blur keyup",  function (event){
        var name_regex = /^[a-zA-Z\s]+$/;
        var customer_name = $('#customer_name').val();
        if(customer_name==null || customer_name==""){
          $("#err_customer_name").text("Please Enter Customer Name.");
          return false;
        }
        else{
          $("#err_customer_name").text("");
        }
        if (!customer_name.match(name_regex) ) {
          $('#err_customer_name').text(" Please Enter Valid First Name ");   
          return false;
        }
        else{
          $("#err_customer_name").text("");
        }
    });
    $("#address1").on("blur keyup",  function (event){
      var address = $('#address1').val();
      if(address==null || address==""){
        $("#err_address1").text(" Please Enter Address");
        return false;
      }
      else{
        $("#err_address1").text("");
      }
        
    });
    $("#city1").change(function(event){
        var city = $('#city1').val();
        if(city==null || city==""){
          $("#err_city1").text("Please Select City ");
          return false;
        }
        else{
          $("#err_city1").text("");
        }
    });
    $("#state1").change(function(event){
        var state = $('#state1').val();
        if(state==null || state==""){
          $("#err_state1").text("Please Select State ");
          return false;
        }
        else{
          $("#err_state1").text("");
        }
    });
    $("#country1").change(function(event){
        var country = $('#country1').val();
        if(country==null || country==""){
          $("#err_country1").text("Please Select Country");
          return false;
        }
        else{
          $("#err_country1").text("");
        }
    });
    $("#mobile").on("blur keyup",  function (event){
        var mobile_regex = /^[6-9][0-9]{9}$/;
        var mobile = $('#mobile').val();
        $('#mobile').val(mobile);
        if(mobile==null || mobile==""){
          $("#err_mobile").text("Please Enter Mobile.");
          return false;
        }
        else{
          $("#err_mobile").text("");
        }
        if (!mobile.match(mobile_regex) ) {
          $('#err_mobile').text(" Please Enter Valid Mobile ");   
          return false;
        }
        else{
          $("#err_mobile").text("");
        }
    });  
}); 
</script>