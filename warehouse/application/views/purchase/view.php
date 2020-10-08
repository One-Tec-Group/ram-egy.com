<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','purchaser','manager');
$p = array('admin','purchaser','manager');
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
        window.location.href='<?php  echo base_url('purchase/delete/'); ?>'+id;
     }
  }
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h5>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('auth/dashboard'); ?>"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line('header_dashboard'); ?></a></li>
          <li><a href="<?php echo base_url('purchase'); ?>"><?php echo $this->lang->line('header_purchase'); ?></a></li>
          <li class="active"><?php echo $this->lang->line('purchase_purchase_details'); ?></li>
        </ol>
      </h5>    
    <section class="content">
      	<div class="row">
	      	<!-- right column -->
	      	<div class="col-md-12">
		        <div class="box">
		        	<!-- <div id="ribbon"><div>4</div></div> -->
		            <div class="box-header with-border ">
		              <h3 class="box-title">Order <b>#<?php echo $data[0]->invoice_no; ?></b></h3>
		              <?php if($data[0]->paid_amount == 0.00){ ?>
		              	<a class=" btn btn-info pull-right" href="<?php echo base_url('purchase/payment/'); ?><?php echo $data[0]->purchase_id; ?>" title="Add Payment">Pay Now</a>
		              <?php }elseif($data[0]->paid_amount < ($data[0]->total-$data[0]->flat_discount)){ ?>
                          <a class=" btn btn-info pull-right" href="<?php echo base_url('purchase/payment/'); ?><?php echo $data[0]->purchase_id; ?>" title="Add Payment">Pay Now</a>
                      <?php }else{ ?>
		              	<button class="btn btn-success pull-right">Paid</button>
		              <?php } ?>
		              <!-- <button type="submit" class="btn btn-sm pull-right">
                        <i class="fa fa-trash-o"></i>
                      </button>
                      <button type="submit" class="btn btn-sm pull-right" style="margin-right: 10px;">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="submit" class="btn btn-sm pull-right" style="margin-right: 10px;">
                        <i class="fa fa-download"></i>
                      </button>
                      <button type="submit" class="btn btn-sm pull-right" style="margin-right: 10px;">
                        <i class="fa fa-envelope-o"></i>
                      </button>
                      <button type="submit" class="btn btn-sm pull-right" style="margin-right: 10px;">
                        <i class="fa fa-money"></i>
                      </button> -->
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body">
		            	<div class="col-sm-12 well well-sm">
			            	<div class="col-sm-5">
			            		<div class="col-sm-2">
			            			<i class="fa fa-3x fa-truck padding010 text-muted"></i>
			            		</div>
			            		<div class="col-sm-10">
			            			<b><h4><?php echo $company[0]->name; ?></h4></b>
				            	
				            		<?php echo $data[0]->warehouse_name; ?>
				            		<br>
				            		<?php echo $data[0]->branch_address; ?>
				            		<br>
				            		<?php echo $data[0]->branch_city; ?>
				            		<br>
				            		<?php echo $this->lang->line('purchase_mobile')." : ".$company[0]->phone; ?>
				            		<br>
				            		<?php echo $this->lang->line('company_setting_email')." : ".$company[0]->email; ?>
			            		</div>
			            	</div>
			            	<div class="col-md-4">
			            		<div class="col-sm-2">
			            			<i class="fa fa-3x fa-building padding010 text-muted"></i>
			            		</div>
			            		<div class="col-sm-10">
			            			<b><h4><?php echo $data[0]->supplier_name ?></h4></b>
				            		
				            		<?php echo $data[0]->supplier_company_name; ?>
				            		<br>
				            		<?php echo $data[0]->supplier_address; ?>
				            		<br>
				            		<?php echo $data[0]->supplier_city; ?>
				            		<br>
				            		<?php echo $this->lang->line('purchase_mobile')." : ".$data[0]->supplier_mobile; ?>
				            		<br>
				            		<?php echo $this->lang->line('company_setting_email')." : ".$data[0]->supplier_email; ?>
			            		</div>
			            	</div>
			            	<div class="col-md-3">
			            		<div class="col-sm-3">
									<i class="fa fa-3x fa-file-text-o padding010 text-muted"></i>
								</div>
								<div class="col-sm-9">
				            		<b><h4><?php echo $data[0]->reference_no; ?></h4></b>
				            		<br>
				            		<b><?php echo $this->lang->line('purchase_date')." : ".$data[0]->date; ?></b>		            	
				            	</div>
			            	</div>
			            </div>
			            <div class="col-sm-12" style="overflow-y: auto;">
			            	<table class="table table-hover table-bordered">
			            		<thead>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_no'); ?></th>
			            			<th width="30%"><?php echo $this->lang->line('product_description'); ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_quantity'); ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('product_cost'),'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('purchase_total_sales'),'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('header_discount'),'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('purchase_taxable_value'),'('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;">IGST<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;">CGST<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;">SGST<?php echo '('.$this->session->userdata('symbol').')'; ?></th>
			            			<th style="text-align: center;"><?php echo $this->lang->line('purchase_total'),'('.$this->session->userdata('symbol').')'; ?></th>
			            		</thead>
			            		<tbody>
			            			<?php 
			            				$i = 1; $tot = 0; $igst=0; $cgst=0; $sgst=0;
			            				foreach ($items as $value) { 
			            			?>
			            			<tr>
			            				<td align="center"><?php echo $i;?></td>
			            				<td><?php echo $value->name; ?><br>HSN:<?php echo $value->hsn_sac_code; ?></td>
			            				<td align="center"><?php echo $value->quantity; ?></td>
			            				<td align="right"><?php echo $value->cost; ?></td>
			            				<td align="right"><?php echo $value->gross_total; ?></td>
			            				<td align="right"><?php echo $value->discount; ?></td>
			            				<td align="right"><?php echo ($value->gross_total-$value->discount); ?></td>
			            				<td align="right"><?php echo $value->igst_tax; ?></td>
			            				<td align="right"><?php echo $value->cgst_tax; ?></td>
			            				<td align="right"><?php echo $value->sgst_tax; ?></td>
			            				<td align="right"><?php echo ($value->gross_total - $value->discount + $value->igst_tax + $value->cgst_tax + $value->sgst_tax); ?></td>
			            			</tr>
			            			<?php 
			            					$i++; 
			            					$tot += $value->gross_total; 
			            					$igst += $value->igst_tax; 
			            					$cgst += $value->cgst_tax;
			            					$sgst += $value->sgst_tax;
			            				} 
			            			?>
			            			<tr>
			            				<td colspan="7" align="right"><b>Total Value(Excluding Tax & Discount)</b><?php echo '('.$this->session->userdata('symbol').')'; ?></td>
			            				<td align="right" colspan="7"><?php echo $tot; ?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="7" align="right"><b>Total Discount</b><?php echo '('.$this->session->userdata('symbol').')'; ?></td>
			            				<td align="right" colspan="7"><?php echo $data[0]->discount_value; ?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="7" align="right"><b>IGST</b><?php echo '('.$this->session->userdata('symbol').')'; ?></td>
			            				<td align="right" colspan="7"><?php echo $igst;?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="7" align="right"><b>CGST</b><?php echo '('.$this->session->userdata('symbol').')'; ?></td>
			            				<td align="right" colspan="7"><?php echo $cgst;?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="7" align="right"><b>SGST</b><?php echo '('.$this->session->userdata('symbol').')'; ?></td>
			            				<td align="right" colspan="7"><?php echo $sgst;?></td>
			            			</tr>
			            			<tr>
			            				<td colspan="7" align="right"><b><?php echo $this->lang->line('purchase_total_amount'); ?>(Including Tax & Discount)</b><?php echo '('.$this->session->userdata('symbol').')'; ?></td>
			            				<td align="right" colspan="7"><?php echo $data[0]->total; ?></td>
			            			</tr>
			            		</tbody>
			            	</table>
			            </div>
			            <div class="col-sm-12">
			            	<div class="buttons">
								<div class="btn-group btn-group-justified">
									<div class="btn-group">
										<a class="tip btn btn-info tip" href="<?php echo base_url('purchase/email/');?><?php echo $data[0]->purchase_id; ?>" title="Email">
											<i class="fa fa-envelope-o"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('company_setting_email'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-success" href="<?php echo base_url('purchase/pdf/');?><?php echo $data[0]->purchase_id; ?>" title="Download as PDF" target="_blank">
											<i class="fa fa-download"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('product_alert_pdf'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-warning tip" href="<?php echo base_url('purchase/edit/'); ?><?php echo $data[0]->purchase_id; ?>" title="Edit">
											<i class="fa fa-edit"></i>
											<span class="hidden-sm hidden-xs"><?php echo $this->lang->line('purchase_edit'); ?></span>
										</a>
									</div>
									<div class="btn-group">
										<a class="tip btn btn-danger bpo" href="javascript:delete_id(<?php echo $data[0]->purchase_id;?>)" title="Delete Purchase">
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