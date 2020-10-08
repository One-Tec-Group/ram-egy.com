<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','manager','sales_person');
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
        $(".purchaser").hide('blind', {}, 500)
    }, 5000);
  });
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
         <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> 
                <!-- Dashboard -->
                <?php echo $this->lang->line('header_dashboard'); ?>
              </a>
          </li>
          <li class="active">
            <!-- Billers -->
            People
            
          </li>
        </ol>
      </h5> 
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
  <div class="col-xs-12">
        <?php 
          if ($this->session->flashdata('success') != ''){ 
        ?>
        <div class="callout callout-success purchaser">    
          <p><?php echo $this->session->flashdata('success');?></p>
        </div>
        <?php
          }
        ?>

        <?php 
          if ($this->session->flashdata('fail') != ''){ 
        ?>
        <div class="callout callout-success purchaser">    
          <p><?php echo $this->session->flashdata('fail');?></p>
        </div>
        <?php
          }
        ?>

      <div class="box">
        <div class="box-body">
          <ul class="nav nav-tabs bordered"><!-- available classes "bordered", "right-aligned" -->
              <?php 
                if($user_group[0]->name == "admin"){
              ?>   
              <li class="active">
                  <a href="#Users" data-toggle="tab">
                      <span class="visible-xs"><i class="fa fa-user"></i></span>
                      <span class="hidden-xs">Admin</span>
                  </a>
              </li>
              <?php
                }
              ?>
              <?php 
                if($user_group[0]->name == "admin"){
              ?>   
              <li>
                  <a href="#Biller" data-toggle="tab">
                      <span class="visible-xs"><i class="fa fa-home"></i></span>
                      <span class="hidden-xs">Biller</span>
                  </a>
              </li>
              <?php
                }
              ?>
              <?php 
                if($user_group[0]->name == "admin" ||  $user_group[0]->name == "purchaser"){
              ?>   
              <li>
                  <a href="#Supplier" data-toggle="tab">
                      <span class="visible-xs"><i class="fa fa-home"></i></span>
                      <span class="hidden-xs">Supplier</span>
                  </a>
              </li>
              <?php
                }
              ?>
              <?php 
                if($user_group[0]->name == "admin"){
              ?> 
              <li>
                  <a href="#accountant" data-toggle="tab">
                      <span class="visible-xs"><i class="fa fa-home"></i></span>
                      <span class="hidden-xs">Accountant</span>
                  </a>
              </li>

              <li>
                  <a href="#purchaser" data-toggle="tab">
                      <span class="visible-xs"><i class="fa fa-home"></i></span>
                      <span class="hidden-xs">Purchaser</span>
                  </a>
              </li>
              <?php
                }
              ?>
              <?php
                if($user_group[0]->name == "admin" ||  $user_group[0]->name == "sales_person"){
              ?> 
              <li>
                  <a href="#Customer" data-toggle="tab">
                      <span class="visible-xs"><i class="fa fa-home"></i></span>
                      <span class="hidden-xs">Customer</span>
                  </a>
              </li> 
              <?php
                }
              ?>            
          </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="Users">
            <div id="table-1_wrapper" class="dataTables_wrapper form-inline" role="grid">
              <div id="myDiagramDiv" style="width:100%; height:300px">
               <div class="box no-border">
               <div class="box-header with-border">
              
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('auth/create_user');?>" title="Add New Category" onclick="">
                <!-- Add New User -->
                Add New Admin                
              </a>
            </div>
                <!-- /.box-header -->
                <div class="box-body">
                <table id="index" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php  foreach ($users as $user):

                        foreach ($user->groups as $group){ }                         
                        if ($group->name=='admin') 
                        {                        
                  ?>
                  <tr>
                    <td></td>
                    <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    
                    <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                    <td><?php echo anchor("auth/edit_user/".$user->id, 'Edit') ;?></td>
                  </tr>
                <?php } endforeach;?>
                <tfoot>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </tfoot>
              </table>
                </div>
                <!-- /.box-body -->
            </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="Biller">
            <div class="col-md-12">
            <div class="box no-border">
                <div class="box-header with-border">
                  
                  <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('biller/add');?>" title="PDF"> <!-- Add New Biller --> 
                      <?php echo $this->lang->line('biller_btn_add'); ?>
                  </a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="example" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th><!-- No -->
                          <?php echo $this->lang->line('biller_lable_no'); ?>
                      </th>
                      <th><!-- Name -->
                          <?php echo $this->lang->line('biller_lable_name'); ?>
                      </th>
                      <th><!-- Company -->
                          <?php echo $this->lang->line('biller_lable_company'); ?>                    
                      </th>
                      <th><!-- Phone -->
                          <?php echo $this->lang->line('biller_lable_phone'); ?>
                      </th>
                      <th><!-- Email Address -->
                          <?php echo $this->lang->line('biller_lable_email'); ?>
                      </th>
                      <th><!-- city -->
                          <?php echo $this->lang->line('biller_lable_city'); ?>
                      </th>
                      <th><!-- Country -->
                          <?php echo $this->lang->line('biller_lable_country'); ?>
                      </th>
                      <th><!-- Warehouse -->
                          <?php echo $this->lang->line('biller_lable_warehouse'); ?>
                      </th>
                      <th><!-- Actions -->
                          <?php echo $this->lang->line('biller_lable_action'); ?>
                      </th>

                    </tr>
                    </thead>
                    <tbody>
                      <?php 
                          foreach ($billers as $row) {
                             $id= $row->biller_id;
                        ?>
                        <tr>
                          <td></td>
                          <td><?php echo $row->biller_name; ?></td>
                          <td><?php echo $row->company_name; ?></td>
                          <td><?php echo $row->mobile ?></td>
                          <td><?php echo $row->email ?></td>
                          <td><?php echo $row->ctname ?></td>
                          <td><?php echo $row->cname ?></td>
                          <td><?php echo $row->warehouse_name ?></td>
                          <td>
                              <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                              <a href="<?php echo base_url('biller/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                              <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                          </td>
                        <?php
                          }
                        ?>
                    <tfoot>
                    <tr>
                      <th><!-- No -->
                          <?php echo $this->lang->line('biller_lable_no'); ?>
                      </th>
                      <th><!-- Name -->
                          <?php echo $this->lang->line('biller_lable_name'); ?>
                      </th>
                      <th><!-- Company -->
                          <?php echo $this->lang->line('biller_lable_company'); ?>                    
                      </th>
                      <th><!-- Phone -->
                          <?php echo $this->lang->line('biller_lable_phone'); ?>
                      </th>
                      <th><!-- Email Address -->
                          <?php echo $this->lang->line('biller_lable_email'); ?>
                      </th>
                      <th><!-- city -->
                          <?php echo $this->lang->line('biller_lable_city'); ?>
                      </th>
                      <th><!-- Country -->
                          <?php echo $this->lang->line('biller_lable_country'); ?>
                      </th>
                      <th><!-- Warehouse -->
                          <?php echo $this->lang->line('biller_lable_warehouse'); ?>
                      </th>
                      <th><!-- Actions -->
                          <?php echo $this->lang->line('biller_lable_action'); ?>
                      </th>
                    </tr>
                    </tfoot>
                  </table>
                </div>
                <!-- /.box-body -->
            </div>
          
            </div>
          </div>
          
          <div class="tab-pane" id="Supplier">
           <div class="col-md-12">
           <div class="box no-border">
            <div class="box-header with-border">
              
              <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('supplier/add');?>" title="PDF"> <!-- Add New Suppliers --> 
                  <?php echo $this->lang->line('supplier_btn_add'); ?>
              </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><!-- No -->
                      <?php echo $this->lang->line('biller_lable_no'); ?>
                  </th>
                  <th><!-- Name -->
                      <?php echo $this->lang->line('biller_lable_name'); ?>
                  </th>
                  <th><!-- Company -->
                      <?php echo $this->lang->line('biller_lable_company'); ?>                    
                  </th>
                  <th><!-- Phone -->
                      <?php echo $this->lang->line('biller_lable_phone'); ?>
                  </th>
                  <th><!-- Email Address -->
                      <?php echo $this->lang->line('biller_lable_email'); ?>
                  </th>
                  <th><!-- city -->
                      <?php echo $this->lang->line('biller_lable_city'); ?>
                  </th>
                  <th><!-- Country -->
                      <?php echo $this->lang->line('biller_lable_country'); ?>
                  </th>
                  <th><!-- Actions -->
                      <?php echo $this->lang->line('biller_lable_action'); ?>
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                      foreach ($suppliers as $row) {
                         $id= $row->supplier_id;
                    ?>
                    <tr>
                      <td></td>
                      <td><?php echo $row->supplier_name; ?></td>
                      <td><?php echo $row->company_name; ?></td>
                      <td><?php echo $row->mobile ?></td>
                      <td><?php echo $row->email ?></td>
                      <td><?php echo $row->ctname ?></td>
                      <td><?php echo $row->cname ?></td>
                      <td>
                          <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                          <a href="<?php echo base_url('supplier/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                          <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                      </td>
                    <?php
                      }
                    ?>
                <tfoot>
                <tr>
                  <th><!-- No -->
                      <?php echo $this->lang->line('biller_lable_no'); ?>
                  </th>
                  <th><!-- Name -->
                      <?php echo $this->lang->line('biller_lable_name'); ?>
                  </th>
                  <th><!-- Company -->
                      <?php echo $this->lang->line('biller_lable_company'); ?>                    
                  </th>
                  <th><!-- Phone -->
                      <?php echo $this->lang->line('biller_lable_phone'); ?>
                  </th>
                  <th><!-- Email Address -->
                      <?php echo $this->lang->line('biller_lable_email'); ?>
                  </th>
                  <th><!-- city -->
                      <?php echo $this->lang->line('biller_lable_city'); ?>
                  </th>
                  <th><!-- Country -->
                      <?php echo $this->lang->line('biller_lable_country'); ?>
                  </th>
                  <th><!-- Actions -->
                      <?php echo $this->lang->line('biller_lable_action'); ?>
                  </th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
           </div>
          </div>
          </div>

          <div class="tab-pane" id="accountant">
            <div class="col-md-12">
              <div class="box no-border">
                  <div class="box-header with-border">                  
                    <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('accountant/add');?>" title="PDF"> <!-- Add New Biller --> 
                       Add New Accountant
                    </a>
                  </div>
                  <!-- /.box-header -->
              <div class="box-body">
                <table id="example3" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php  foreach ($users as $user):

                        foreach ($user->groups as $group){ }                         
                        if ($group->name=='accountant') 
                        {                        
                  ?>
                  <tr>
                    <td></td>
                    <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    
                    <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                    <td><?php echo anchor("accountant/edit/".$user->id, 'Edit') ;?></td>
                  </tr>
                <?php } endforeach;?>
                <tfoot>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
          </div>
        </div>
          <div class="tab-pane" id="purchaser">
            <div class="col-md-12">
              <div class="box no-border">
                  <div class="box-header with-border">                  
                    <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('purchaser/add');?>" title="PDF"> <!-- Add New Purchaser --> 
                        Add New Purchaser
                    </a>
                  </div>
                  <!-- /.box-header -->
              <div class="box-body">
                <table id="example4" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </thead>
                <tbody>
                  <?php  foreach ($users as $user):

                        foreach ($user->groups as $group){ }                         
                        if ($group->name=='purchaser') 
                        {                        
                  ?>
                  <tr>
                    <td></td>
                    <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                    <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                    
                    <td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
                    <td><?php echo anchor("purchaser/edit/".$user->id, 'Edit') ;?></td>
                  </tr>
                <?php } endforeach;?>
                <tfoot>
                <tr>
                  <th>
                      <?php echo $this->lang->line('product_no'); ?>
                  </th>
                  <th><!-- First Name -->
                      <?php echo $this->lang->line('user_lable_fname'); ?>
                  </th>
                  <th><!-- Last Name -->
                      <?php echo $this->lang->line('user_lable_lname'); ?>
                  </th>
                  <th><!-- Email -->
                      <?php echo $this->lang->line('user_lable_email'); ?>
                  </th>
                  
                  <th><!-- Status -->
                      <?php echo $this->lang->line('user_lable_status'); ?>
                  </th>
                  <th><!-- Action -->
                      <?php echo $this->lang->line('user_lable_action'); ?>
                  </th>
                </tr>
                </tfoot>
              </table>
            </div>
            </div>
          </div>
          </div>
          <div class="tab-pane" id="Customer">
            <div class="col-md-12">
              <div class="box no-border">
                <div class="box-header with-border">
                
                  <a class="btn btn-sm btn-info pull-right" style="margin: 10px" href="<?php echo base_url('customer/add');?>"> 
                      <!-- Add New Customer -->
                      <?php echo $this->lang->line('customer_btn_add'); ?>  
                   </a>
                </div>
                    <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th><!-- No -->
                            <?php echo $this->lang->line('biller_lable_no'); ?>
                        </th>
                        <th><!-- Name -->
                            <?php echo $this->lang->line('biller_lable_name'); ?>
                        </th>
                        <th><!-- Company -->
                            <?php echo $this->lang->line('biller_lable_company'); ?>                    
                        </th>
                        <th><!-- Phone -->
                            <?php echo $this->lang->line('biller_lable_phone'); ?>
                        </th>
                        <th><!-- Email Address -->
                            <?php echo $this->lang->line('biller_lable_email'); ?>
                        </th>
                        <th><!-- city -->
                            <?php echo $this->lang->line('biller_lable_city'); ?>
                        </th>
                        <th><!-- Country -->
                            <?php echo $this->lang->line('biller_lable_country'); ?>
                        </th>
                        <th><!-- Actions -->
                            <?php echo $this->lang->line('biller_lable_action'); ?>
                        </th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php 
                            foreach ($customer as $row) {
                               $id= $row->customer_id;
                          ?>
                          <tr>
                            <td></td>
                            <td><?php echo $row->customer_name; ?></td>
                            <td><?php echo $row->company_name; ?></td>
                            <td><?php echo $row->mobile ?></td>
                            <td><?php echo $row->email ?></td>
                            <td><?php echo $row->ctname ?></td>
                            <td><?php echo $row->cname ?></td>
                            <td>
                                <!-- <a href="" title="View Details" class="btn btn-xs btn-warning"><span class="fa fa-eye"></span></a>&nbsp;&nbsp; -->
                                <a href="<?php echo base_url('customer/edit/'); ?><?php echo $id; ?>" title="Edit" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;
                                <a href="javascript:delete_id(<?php echo $id;?>)" title="Delete" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                            </td>
                          <?php
                            }
                          ?>
                      <tfoot>
                      <tr>
                        <th><!-- No -->
                            <?php echo $this->lang->line('biller_lable_no'); ?>
                        </th>
                        <th><!-- Name -->
                            <?php echo $this->lang->line('biller_lable_name'); ?>
                        </th>
                        <th><!-- Company -->
                            <?php echo $this->lang->line('biller_lable_company'); ?>                    
                        </th>
                        <th><!-- Phone -->
                            <?php echo $this->lang->line('biller_lable_phone'); ?>
                        </th>
                        <th><!-- Email Address -->
                            <?php echo $this->lang->line('biller_lable_email'); ?>
                        </th>
                        <th><!-- city -->
                            <?php echo $this->lang->line('biller_lable_city'); ?>
                        </th>
                        <th><!-- Country -->
                            <?php echo $this->lang->line('biller_lable_country'); ?>
                        </th>
                        <th><!-- Actions -->
                            <?php echo $this->lang->line('biller_lable_action'); ?>
                        </th>
                      </tr>
                      </tfoot>
                    </table>
              </div>
                <!-- /.box-body -->
            </div>  
           </div>
          </div>

          
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.box -->
      </div>
        <!--/.col (right) -->
                            
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
  $this->load->view('layout/footer');
?>
