<div id="supplier_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4>Add New Warehouse</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label for="supplier_name"><!-- Supplier Name -->
                     <?php echo $this->lang->line('add_supplier_name'); ?>
                   <span class="validation-color">*</span>
                  </label>
                <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?php echo set_value('supplier_name'); ?>">
                <span class="validation-color" id="err_supplier_name"><?php echo form_error('supplier_name'); ?></span>
            </div>
            <div class="form-group">
                <label for="gstid"><!-- GSTIN --> 
                    <?php echo $this->lang->line('add_biller_gst'); ?> 
                    <span class="validation-color">*</span>
                </label>
                <input type="text" class="form-control" id="gstid" name="gstid" value="<?php echo set_value('gstid'); ?>">
                <span style="font-size: 14px; color:blue">Ex. 24XXXXXXXXXX2Z2</span>
                <span class="validation-color" id="err_gstid"><?php echo form_error('gstid'); ?></span>
            </div>
            <div class="form-group">
                <label for="company_name">
                    <?php echo $this->lang->line('add_customer_compname'); ?> 
                    <span class="validation-color">*</span>
                </label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo set_value('company_name'); ?>">
                <span class="validation-color" id="err_company_name"><?php echo form_error('company_name'); ?></span>
            </div>
            <div class="form-group">
                <label for="gstregtype">Gst Registration Type
                    <!-- <?php echo $this->lang->line('biller_lable_country'); ?> --> <span class="validation-color">*</span>
                  </label>
                <select class="form-control select2" id="gstregtype" name="gstregtype" style="width: 100%;">
                  <option value="">
                    <!-- Select -->
                    <?php echo $this->lang->line('add_biller_select'); ?>    
                  </option>
                    <option>Registered</option>
                    <option>Unregistered</option>
                    <option>Composition Scheme</option>
                    <option>Input Service Distributor</option>
                    <option>E-Commerece Operator</option>
                </select>
            </div>
            <div class="form-group">
                  <label for="email"><!-- email --> 
                       <?php echo $this->lang->line('biller_lable_email'); ?> 
                       <span class="validation-color">*</span>
                  </label>
                  <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>">
                  <span class="validation-color" id="err_email"><?php echo form_error('email'); ?></span>
            </div>
            
            
            
            
          </div>

          <div class="col-sm-6">
            <div class="form-group">
                  <label for="country"><!-- Country --> 
                      <?php echo $this->lang->line('biller_lable_country'); ?> <span class="validation-color">*</span>
                  </label>
                  <select class="form-control select2" id="country" name="country" style="width: 100%;">
                    <option value="">
                        <!-- Select -->
                      <?php echo $this->lang->line('add_biller_select'); ?> 
                  </option>
                    <?php
                      $country = $this->db->get('countries')->result();
                      foreach ($country as  $key) {
                    ?>
                    <option 
                      value='<?php echo $key->id ?>' 
                      <?php 
                        if(isset($data[0]->country_id)){
                          if($key->id == $data[0]->country_id){
                            echo "selected";
                          }
                        } 
                      ?>
                    >
                    <?php echo $key->name; ?>
                    </option>
                    <?php
                      }
                    ?>
                  </select>
                  <span class="validation-color" id="err_country"><?php echo form_error('country'); ?></span>
            </div>
            
            <div class="form-group">
                <label for="state"><!-- State --> 
                  <?php echo $this->lang->line('add_biller_state'); ?> 
                  <span class="validation-color">*</span>
                </label>
                <select class="form-control select2" id="state" name="state" style="width: 100%;">
                  <option value=""><!-- Select -->
                      <?php echo $this->lang->line('add_biller_select'); ?>
                  </option>
                </select>
                <span class="validation-color" id="err_state"><?php echo form_error('state'); ?></span>
            </div>
            
            <div class="form-group">
              <label for="state_code">State Code</label>
              <input type="text" class="form-control" id="state_code" name="state_code" value="<?php echo set_value('state_code'); ?>">
              <span class="validation-color" id="err_state_code"><?php echo form_error('state_code'); ?></span>
            </div>
            <div class="form-group">
              <label for="city"><!-- City --> 
                  <?php echo $this->lang->line('biller_lable_city'); ?> 
                  <span class="validation-color">*</span>
              </label>
              <select class="form-control select2" id="city" name="city" style="width: 100%;">
                  <option value=""><!-- Select -->
                      <?php echo $this->lang->line('add_biller_select'); ?>
                  </option>
              </select>
              <span class="validation-color" id="err_city"><?php echo form_error('city'); ?></span>
            </div>
            <div class="form-group">
                <label for="mobile"><!-- Mobile --> 
                    <?php echo $this->lang->line('add_biller_mobile'); ?> 
                    <span class="validation-color">*</span>
                </label>
                <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo set_value('mobile'); ?>">
                <span class="validation-color" id="err_mobile"><?php echo form_error('mobile'); ?></span>
            </div>
            
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="add_supplier" class="btn btn-info btn-flat pull-left" data-dismiss="modal">ADD</button>
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
    $('#country').change(function(){
      var id = $(this).val();
      $('#state').html('<option value="">Select</option>');
      $('#state_code').val('');
      $('#city').html('<option value="">Select</option>');
      $.ajax({
          url: "<?php echo base_url('supplier/getState') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#state').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
    });
   });
</script>
<script>
$(document).ready(function(){
    $('#state').change(function(){
      var id = $(this).val();
      var country = $('#country').val();
      $('#city').html('<option value="">Select</option>');
      $('#state_code').val('');
      $.ajax({
          url: "<?php echo base_url('supplier/getCity') ?>/"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data){
            for(i=0;i<data.length;i++){
              $('#city').append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
            }
          }
        });
      $.ajax({
          url: "<?php echo base_url('biller/getStateCode') ?>/"+id+'/'+country,
          type: "GET",
          dataType: "TEXT",
          success: function(data){
            $('#state_code').val(data);
          }
        });
    });
});
</script>
<script>
  $(document).ready(function(){
    $("#add_supplier").click(function(event){
      var name_regex = /^[a-zA-Z\s]+$/;
      var sname_regex = /^[-a-zA-Z\s]+$/;
      var mobile_regex = /^[6-9][0-9]{9}$/; 
      var postal_regex = /^[1-9][0-9]{5}$/
      //indian mobile number  /^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1}){0,1}98(\s){0,1}(\-){0,1}(\s){0,1}[1-9]{1}[0-9]{7}$/
      var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      var supplier_name = $('#supplier_name').val();
      var company_name = $('#company_name').val();
      var address = $('#address').val();
      var city = $('#city').val();
      var state = $('#state').val();
      var postal_code = $('#postal_code').val();
      var country = $('#country').val();
      var mobile = $('#mobile').val();
      var email = $('#email').val();



        if(supplier_name==null || supplier_name==""){
          $("#err_supplier_name").text("Please Enter Supplier Name");
          return false;
        }
        else{
          $("#err_supplier_name").text("");
        }
        if (!supplier_name.match(name_regex) ) {
          $('#err_supplier_name').text(" Please Enter Valid Supplier Name ");   
          return false;
        }
        else{
          $("#err_supplier_name").text("");
        }
//customer name validation complite.

        if(company_name==null || company_name==""){
          $("#err_company_name").text("Please Enter Company Name.");
          return false;
        }
        else{
          $("#err_company_name").text("");
        }
        if (!company_name.match(sname_regex) ) {
          $('#err_company_name').text(" Please Enter Valid Company Name ");   
          return false;
        }
        else{
          $("#err_company_name").text("");
        }
//company name validation complite.

        /*if(address==null || address==""){
          $("#err_address").text(" Please Enter Address");
          return false;
        }
        else{
          $("#err_address").text("");
        }*/
//Address validation complite.
        
        if(country==null || country==""){
          $("#err_country").text("Please Select Country ");
          return false;
        }
        else{
          $("#err_country").text("");
        }
//country validation complite.
      
        if(state==null || state==""){
          $("#err_state").text("Please Select State ");
          return false;
        }
        else{
          $("#err_state").text("");
        }
//state validation complite.
        
         if(city==null || city==""){
          $("#err_city").text("Please Select City ");
          return false;
        }
        else{
          $("#err_city").text("");
        }
//city validation complite.

       /* if(postal_code==null || postal_code==""){
          $("#err_postal_code").text("Please Enter Postal Code.");
          return false;
        }
        else{
          $("#err_postal_code").text("");
        }
        if (!postal_code.match(postal_regex) ) {
          $('#err_postal_code').text(" Please Enter Valid Postal Code ");   
          return false;
        }
        else{
          $("#err_postal_code").text("");
        }*/
//postal code validation complite.
        
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
        
        if(email==null || email==""){
          $("#err_email").text("Please Enter Email.");
          return false;
        }
        else{
          $("#err_email").text("");
        }
        if (!email.match(email_regex) ) {
          $('#err_email').text(" Please Enter Valid Email Address ");   
          return false;
        }
        else{
          $("#err_email").text("");
        }
//email validation complite.
    $.ajax({
        url:"<?php echo base_url('supplier/add_supplier_ajax') ?>",
        dataType : 'JSON',
        method : 'POST',
        data:{
            'supplier_name':$('#supplier_name').val(),
            'company_name':$('#company_name').val(),
            'city':$('#city').val(),
            'country':$('#country').val(),
            'state':$('#state').val(),
            'mobile':$('#mobile').val(),
            'email':$('#email').val(),
            'gstid':$('#gstid').val(),
            'gstregtype':$('#gstregtype').val()
        },
        success:function(result){
          var data = result['data'];
          $('#supplier').html('');
          $('#supplier').append('<option value="">Select</option>');
          $('#warehouse_name').val('');
          for(i=0;i<data.length;i++){
              $('#supplier').append('<option value="' + data[i].supplier_id + '">' + data[i].supplier_name + '</option>');
          }
          $('#supplier').val(result['id']).attr("selected","selected");
        }
      });
    });

    $("#supplier_name").on("blur keyup",  function (event){
        var name_regex = /^[a-zA-Z\s]+$/;
        var supplier_name = $('#supplier_name').val();
        $('#supplier_name').val(supplier_name);
        if(supplier_name==null || supplier_name==""){
          $("#err_supplier_name").text("Please Enter Supplier Name");
          return false;
        }
        else{
          $("#err_supplier_name").text("");
        }
        if (!supplier_name.match(name_regex) ) {
          $('#err_supplier_name').text(" Please Enter Valid Supplier Name ");   
          return false;
        }
        else{
          $("#err_supplier_name").text("");
        }
    });
    $("#company_name").on("blur keyup",  function (event){
        var sname_regex = /^[-a-zA-Z\s]+$/;
        var company_name = $('#company_name').val();
        $('#company_name').val(company_name);
        if(company_name==null || company_name==""){
          $("#err_company_name").text("Please Enter Company Name.");
          return false;
        }
        else{
          $("#err_company_name").text("");
        }
        if (!company_name.match(sname_regex) ) {
          $('#err_company_name').text(" Please Enter Valid Company Name ");   
          return false;
        }
        else{
          $("#err_company_name").text("");
        }
    });
    $("#address").on("blur keyup",  function (event){
        var address = $('#address').val();
        if(address==null || address==""){
          $("#err_address").text(" Please Enter Address");
          return false;
        }
        else{
          $("#err_address").text("");
        }
    });
    $("#city").change(function(event){
        var city = $('#city').val();
        $('#city').val(city);
        if(city==null || city==""){
          $("#err_city").text("Please Select City ");
          return false;
        }
        else{
          $("#err_city").text("");
        }
    });
    $("#state").change(function(event){
        var state = $('#state').val();
        $('#state').val(state);
        if(state==null || state==""){
          $("#err_state").text("Please Select State ");
          return false;
        }
        else{
          $("#err_state").text("");
        }
    });
    $("#postal_code").on("blur keyup",  function (event){
        var postal_regex = /^[1-9][0-9]{5}$/
        var postal_code = $('#postal_code').val();
        $('#postal_code').val(postal_code);
        if(postal_code==null || postal_code==""){
          $("#err_postal_code").text("Please Enter Postal Code.");
          return false;
        }
        else{
          $("#err_postal_code").text("");
        }
        if (!postal_code.match(postal_regex) ) {
          $('#err_postal_code').text(" Please Enter Valid Postal Code ");   
          return false;
        }
        else{
          $("#err_postal_code").text("");
        }
    });
    $("#country").change(function(event){
        var country = $('#country').val();
        $('#country').val(country);
        if(country==null || country==""){
          $("#err_country").text("Please Select Country");
          return false;
        }
        else{
          $("#err_country").text("");
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
    $("#email").on("blur keyup",  function (event){
        var email_regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var email = $('#email').val();
        $('#email').val(email);
        if(email==null || email==""){
          $("#err_email").text("Please Enter Email.");
          return false;
        }
        else{
          $("#err_email").text("");
        }
        if (!email.match(email_regex) ) {
          $('#err_email').text(" Please Enter Valid Email Address ");   
          return false;
        }
        else{
          $("#err_email").text("");
        }
    });
   
}); 
</script>