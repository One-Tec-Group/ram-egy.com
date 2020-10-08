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
    </section>
    <section class="invoice">
        <div id="ribbon1">
            <div>
                <i class="fa fa-trash-o"></i>
            </div>
        </div>
        <div id="ribbon2">
            <div>
                <i class="fa fa-edit"></i>
            </div>
        </div>
        <div id="ribbon3">
            <div>
                <i class="fa fa-download"></i>
            </div>
        </div>
        <div id="ribbon4">
            <div>
                <i class="fa fa-envelope-o"></i>
            </div>
        </div>
        <div id="ribbon5">
            <div>
                <i class="fa fa-money"></i>
            </div>
        </div>
        <span class="ribbon-simple"><?php echo $company[0]->name; ?></span>
        <div class="ribbon-wrapper-green">
            <?php if($data[0]->paid_amount == 0.00){ ?>
                <div class="ribbon-red" style="background-color: #EE3818 ">
                    <?php echo $this->lang->line('sales_pending'); ?>
                </div>
            <?php }elseif($data[0]->paid_amount < ($data[0]->total-$data[0]->flat_discount)){ ?>
                <div class="ribbon-yellow" style="background-color: #EED718">
                    Partial
                </div>
            <?php }else{ ?>
                <div class="ribbon-green" style="background-color: #BFDC7A">
                    <?php echo $this->lang->line('sales_complited'); ?>
                </div>
            <?php } ?>
        </div>
    	<div class="row">
    		<div class="col-xs-12">
    			<h2 class="page-header">
    				<small class="pull-right"><?php echo date('d-m-Y',strtotime($data[0]->date)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?></small>
    			</h2>
    		</div>
    	</div>
    	<div class="row invoive-info">
    		<div class="col-sm-4">
    			From
    			<address>
    				<strong><?php echo $data[0]->supplier_name; ?></strong>
    				<br>
    				<?php echo $data[0]->supplier_address; ?>
    				<br>
    				<?php echo $data[0]->supplier_city; ?>
    				<br>
    				<?php echo $data[0]->supplier_state_name; ?>
    				<br>
    				<?php echo $data[0]->supplier_country_name.' - '.$data[0]->supplier_postal_code; ?>
    				<br>
    				Mobile : <?php echo $data[0]->supplier_mobile; ?>
    				<br>
    				Email : <?php echo $data[0]->supplier_email; ?>
    			</address>
    		</div>
    		<div class="col-sm-4">
    			To
    			<address>
    				<strong><?php echo $data[0]->warehouse_name; ?></strong>
    				<br>
    				<?php echo $data[0]->branch_address; ?>
    				<br>
    				<?php echo $data[0]->branch_city; ?>
    				<br>
    				Mobile : <?php echo $company[0]->phone; ?>
    				<br>
    				Email : <?php echo $company[0]->email; ?>
    			</address>
    		</div>
    		<div class="col-sm-4">
    			<address>
	    			<strong>Invoice #<?php echo $data[0]->invoice_no; ?></strong><br>
	    			<strong>Reference No #<?php echo $data[0]->reference_no; ?></strong><br><br>
	    			<strong>Purchase Status :</strong> <span class="label label-success"><?php echo $this->lang->line('purchase_received'); ?></span> <br><br>
	    			<strong>Payment Status &nbsp;:</strong> 
	    					<?php if($data[0]->paid_amount == 0.00){ ?>
	                          <span class="label label-danger"><?php echo $this->lang->line('sales_pending'); ?></span>
	                        <?php }elseif($data[0]->paid_amount < ($data[0]->total-$data[0]->flat_discount)){ ?>
	                          <span class="label label-warning">Partial</span>
	                        <?php }else{ ?>
	                          <span class="label label-success"><?php echo $this->lang->line('sales_complited'); ?></span>
	                        <?php } ?>
	            </address>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-xs-12 table-responsive">
    			<table class="table table-bordered">
    				<thead>
    					<th>No</th>
    					<th width="30%">Description</th>
    					<th>Qty</th>
    					<th>Cost</th>
    					<th>Total Value</th>
    					<th>Discount</th>
    					<th>Taxable Value</th>
    					<th>IGST</th>
    					<th>CGST</th>
    					<th>SGST</th>
    					<th>Total</th>
    				</thead>
    				<tbody>
    					<?php 
            				$i = 1; $tot = 0; $igst=0; $cgst=0; $sgst=0;
            				foreach ($items as $value) { 
            			?>
            			<tr>
            				<td align="center"><?php echo $i;?></td>
            				<td>
            					<?php 
            						echo '<b>'.$value->name.'</b>';
            						if(isset($value->details)){
            							echo " ($value->details)";
            						}
            					?>
            					<br>HSN:<?php echo $value->hsn_sac_code; ?>
            				</td>
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
            				<td colspan="11"></td>
            			</tr>
            			<tr>
            				<td colspan="7" align="right">Total Value(Excluding Tax & Discount)</td>
            				<td colspan="4"><?php echo $tot; ?></td>
            			</tr>
            			<tr>
            				<td colspan="7" align="right">Total Discount</td>
            				<td colspan="4"><?php echo $tot; ?></td>
            			</tr>
            			<tr>
            				<td colspan="7" align="right">IGST</td>
            				<td colspan="4"><?php echo $tot; ?></td>
            			</tr>
            			<tr>
            				<td colspan="7" align="right">CGST</td>
            				<td colspan="4"><?php echo $tot; ?></td>
            			</tr>
            			<tr>
            				<td colspan="7" align="right">SGST</td>
            				<td colspan="4"><?php echo $tot; ?></td>
            			</tr>
            			<tr>
            				<td colspan="7" align="right">Total Amount(Including Tax & Discount)</td>
            				<td colspan="4"><?php echo $tot; ?></td>
            			</tr>
    				</tbody>
    			</table>
    		</div>
    	</div>
    </section>
</div>
<!-- /.content-wrapper -->
<?php
	$this->load->view('layout/footer');
?>