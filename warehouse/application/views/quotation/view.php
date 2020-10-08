<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','sales_person','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth');
}
  $this->load->view('layout/header');
?>
<script type="text/javascript">
  function delete_id(id)
  {
     if(confirm('<?php echo $this->lang->line('product_delete_conform'); ?>'))
     {
        window.location.href='<?php  echo base_url('quotation/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('quotation'); ?>">Quotation</a></li>
          <li class="active">Quotation Details</li>
        </ol>
      </h5>    
    </section>
    <!-- Main content -->
    <section class="content">
      	<div class="row">
	      	<!-- right column -->
	      	<div class="col-md-12">
		        <div class="box">
		            <div class="box-header with-border">
		              <h3 class="box-title">Quotation Details</h3>
		              <?php
		              	if(isset($check_invoice->quotation_id)){
		              		if($check_invoice->quotation_id==null){
		              ?>
		              			<a class="btn btn-sm btn-info pull-right"  href="<?php echo base_url('quotation/generate_invoice/');?><?php echo $data[0]->quotation_id; ?>">Generate Invoice</a>
		              <?php	
		              		}
		              	}
		              	else{
		              ?>
		              	<a class="btn btn-sm btn-info pull-right"  href="<?php echo base_url('quotation/generate_invoice/');?><?php echo $data[0]->quotation_id; ?>">Generate Invoice</a>
		              <?php
		              	}
		              ?>
		              
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		            	<div class="col-sm-12 well well-sm">
			            	<div class="col-sm-4">
			            		<div class="col-sm-2">
			            			<i class="fa fa-3x fa-truck padding010 text-muted"></i>
			            		</div>
			            		<div class="col-sm-10">
			            			<b><h4>
			            				<?php 
			            					if(isset($data[0]->customer_name)){
			            						echo $data[0]->customer_name;
			            					} 
			            				?>
			            				<br/><span style="font-size: 12px;">(Customer)</span>
			            			</h4></b>
				            			<?php 
			            					if(isset($data[0]->customer_address)){
			            						echo $data[0]->customer_address;
			            					} 
			            				?>
				            		<br>
				            			<?php 
			            					if(isset($data[0]->customer_city)){
			            						echo $data[0]->customer_city;
			            					} 
			            				?>
		            				<br>
				            			<?php 
			            					if(isset($data[0]->customer_state)){
			            						echo $data[0]->customer_state;
			            					} 
			            				?>
				            		<br>
				            			<?php 
			            					if(isset($data[0]->customer_country)){
			            						echo $data[0]->customer_country;
			            					} 
			            				?>
				            		<br>
				            		<br>
				            			<?php 
			            					if(isset($data[0]->customer_mobile)){
			            						echo $this->lang->line('purchase_mobile')." : ".$data[0]->customer_mobile;
			            					}else{
			            						echo $this->lang->line('purchase_mobile')." : Not Available";
			            					} 
			            				?>
				            		<br>
				            			<?php 
			            					if(isset($data[0]->customer_email)){
			            						echo $this->lang->line('company_setting_email')." : ".$data[0]->customer_email;
			            					}else{
			            						echo $this->lang->line('company_setting_email')." : Not Available";
			            					} 
			            				?>

			            		</div>
			            	</div>
			            	<div class="col-sm-4">
			            		<div class="col-sm-2">
			            			<i class="fa fa-3x fa-building padding010 text-muted"></i>
			            		</div>
			            		<div class="col-sm-10">
			            			<b><h4><?php echo $data[0]->biller_name ?><br/><span style="font-size: 12px;">(Branch Office)</span></h4></b>
				            		<?php echo $data[0]->biller_address; ?>
				            		<br>
				            		<?php echo $data[0]->biller_city; ?>
				            		<br>
				            		<?php echo $data[0]->biller_country; ?>
				            		<br><br>
				            		<?php echo $this->lang->line('purchase_mobile')." : ".$data[0]->biller_mobile; ?>
				            		<br>
				            		<?php echo $this->lang->line('company_setting_email')." : ".$data[0]->biller_email; ?>
			            		</div>
			            	</div>
			            	<div class="col-sm-4">
			            		<div class="col-sm-2">
									<i class="fa fa-3x fa-building-o padding010 text-muted"></i>
								</div>
								<div class="col-sm-10">
									<b><h4><?php echo $company[0]->name; ?><br/><span style="font-size: 12px;">(Head Office)</span></h4></b>
				            		<?php echo $company[0]->street; ?>
				            		<br>
				            		<?php echo $company[0]->city_name; ?>
				            		<br>
				            		<?php echo $company[0]->state_name; ?>
				            		<br>
				            		<?php echo $company[0]->country_name; ?>
				            		<br><br>
				            		<?php echo $this->lang->line('purchase_mobile')." : ".$company[0]->phone; ?>
				            		<br>
				            		<?php echo $this->lang->line('company_setting_email')." : ".$company[0]->email; ?>
			            		</div>
			            	</div>
			            </div>
			            <div class="col-sd-12">
			            	<div class="col-sm-4">
			            		<div class="col-sm-2">
			            			<i class="fa fa-3x fa-file-text-o padding010 text-muted"></i>
			            		</div>
			            		<div class="col-sm-10">
			            			<b><h4><?php echo $data[0]->reference_no; ?></h4></b>
				            		
				            		<b><?php echo $this->lang->line('purchase_date')." : ".$data[0]->date; ?></b>
				            		<br>
				            		<br>
			            		</div>
			            	</div>
			            	
			            </div>
			            <div class="col-sm-12" style="overflow-y: auto;">
			            	<table class="table table-hover table-bordered">
			            		<thead>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_no'); ?></th>
			            			<th width="20%"><?php echo $this->lang->line('product_description'); ?></th>			            			
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_quantity'); ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_cost').'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('purchase_total_sales').'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('header_discount').'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('purchase_taxable_value').'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;">IGST<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;">CGST<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;">SGST<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('purchase_total').'('.$this->session->userdata('symbol').')'; ?></th>
			            		</thead>
			            		<tbody>
			            			<?php $i = 1;  $tot = 0; $igst=0; $cgst=0; $sgst=0;
			            				foreach ($items as $value) { ?>
			            			<tr>
			            				<td align="center"><?php echo $i;?></td>
			            				<td><?php echo "HSN:".$value->hsn_sac_code.'<br/>'.$value->name.'('.$value->code.')'; ?></td>
			            				<td align="center"><?php echo $value->quantity; ?></td>
			            				<td align="right"><?php echo $value->price; ?></td>
			            				<td align="right"><?php echo $value->gross_total; ?></td>
			            				<td align="right"><?php echo $value->discount; ?></td>
			            				<td align="right">
			            					<?php 
			            						if($value->tax_type == "Inclusive"){
			            							echo $value->gross_total - $value->discount - $value->igst_tax - $value->cgst_tax - $value->sgst_tax;
			            						}else{
			            							echo $value->gross_total - $value->discount + $value->igst_tax + $value->cgst_tax + $value->sgst_tax;	
			            						}

			            					?>
			            				</td>
			            				<td align="right"><?php echo $value->igst_tax; ?>(<?php echo $value->igst; ?>%)</td>
			            				<td align="right"><?php echo $value->cgst_tax; ?>(<?php echo $value->cgst; ?>%)</td>
			            				<td align="right"><?php echo $value->sgst_tax; ?>(<?php echo $value->sgst; ?>%)</td>
			            				<td align="right"><?php if($value->tax_type == "Inclusive") {echo $value->gross_total - $value->discount; }else{echo $value->gross_total - $value->discount + $value->igst_tax + $value->cgst_tax + $value->sgst_tax; } ?></td>
			            			</tr>
			            			<?php $i++;// $tot += $value->gross_total;

			            					//$tot += $value->gross_total; 
			            					$igst += $value->igst_tax; 
			            					$cgst += $value->cgst_tax;
			            					$sgst += $value->sgst_tax;

			            					if($value->tax_type == "Inclusive"){
			            						$tot += $value->gross_total - $value->discount - $cgst - $sgst - $igst; 	
			            					}else{
			            						$tot += $value->gross_total - $value->discount ; 	
			            					}

			            			 	} 

			            			 ?>
			            			<tr>
			            				<td colspan="8" align="right"><b><?php echo $this->lang->line('purchase_total_value'); ?></b></td>
			            				<td align="right" colspan="3"><?php echo $this->session->userdata('symbol').$tot; ?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="8" align="right"><b><?php echo $this->lang->line('purchase_total_discount'); ?></b></td>
			            				<td align="right" colspan="3"><?php echo $this->session->userdata('symbol').$data[0]->discount_value;?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="8" align="right"><b><?php echo $this->lang->line('purchase_total_tax'); ?></b></td>
			            				<td align="right" colspan="3"><?php echo $this->session->userdata('symbol').$data[0]->tax_value;?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="8" align="right"><b>Shipping Charge</b></td>
			            				<td align="right" colspan="3"><?php echo $this->session->userdata('symbol').$data[0]->shipping_charge;?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="8" align="right"><b><?php echo $this->lang->line('sales_balance'); ?></b></td>
			            				<td align="right" colspan="3"><?php echo $this->session->userdata('symbol').($data[0]->shipping_charge+$data[0]->total); ?></td>
			            			</tr>
			            		</tbody>
			            	</table>
			            </div>
			            <!-- <div class="col-sm-6" style="padding-bottom:10px;">
			            	<button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">
								<i class="fa fa-money"></i>
								Pay by Paypal
							</button>
			            </div> -->
			            <div class="col-sm-12">
			            	<div class="buttons">
								<div class="btn-group btn-group-justified">
									
									<div class="btn-group">
										<a class="tip btn btn-info tip" href="<?php echo base_url('quotation/email/'); ?><?php echo $data[0]->quotation_id; ?>" title="Email">
											<i class="fa fa-envelope-o"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('company_setting_email'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('quotation/pdf/');?><?php echo $data[0]->quotation_id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('product_alert_pdf'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('quotation/print1/');?><?php echo $data[0]->quotation_id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs">Print<!-- <?php echo $this->lang->line('product_alert_pdf'); ?> --></span>
										</a>
									</div>
									<?php if(isset($check_invoice->quotation_id)){
											if($check_invoice->quotation_id==null){ ?>
									<div class="btn-group">
										<a class="tip btn btn-warning tip" href="<?php echo base_url('quotation/edit/'); ?><?php echo $data[0]->quotation_id; ?>" title="Edit">
											<i class="fa fa-edit"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('purchase_edit'); ?></span>
										</a>
									</div>
									<?php }}else{
									?>
										<div class="btn-group">
										<a class="tip btn btn-warning tip" href="<?php echo base_url('quotation/edit/'); ?><?php echo $data[0]->quotation_id; ?>" title="Edit">
											<i class="fa fa-edit"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('purchase_edit'); ?></span>
										</a>
									</div>
									<?php
										} ?>
									<div class="btn-group">
										<a class="tip btn btn-danger bpo" href="javascript:delete_id(<?php echo $data[0]->quotation_id;?>)" title="Delete Purchase">
											<i class="fa fa-trash-o"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('purchase_delete'); ?></span>
										</a>
									</div>
								</div>
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