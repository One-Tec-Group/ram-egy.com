<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{
			font-family: arial;
			font-size: 11px;
		}
	</style>
</head>
<body>
	<table width="50%" align="center">
		<tr>
			<td align="center">
				<span>													 
                <b>
    				<?php 
    					if(isset($data[0]->biller_name)){
    						echo $data[0]->biller_name;
    					} 
    				?>
    			</b><br>
        			<?php 
    					if(isset($data[0]->biller_address)){
    						echo $data[0]->biller_address;
    					} 
    				?>
        		<br>
        			<?php 
    					if(isset($data[0]->biller_city)){
    						echo $data[0]->biller_city;
    					} 
    				?>
        		<br>
        			<?php 
    					if(isset($data[0]->biller_country)){
    						echo $data[0]->biller_country;
    					} 
    				?>
        		<br>
        			<?php 
    					if(isset($data[0]->biller_mobile)){
    						echo $this->lang->line('purchase_mobile')." : ".$data[0]->biller_mobile;
    					} 
    				?>
        		<br>
        			<?php 
    					if(isset($data[0]->biller_email)){
    						echo $this->lang->line('company_setting_email')." : ".$data[0]->biller_email;
    					} 
    				?>
    			<br>
					GSTIN/UIN :<?php if(isset($data[0]->customer_gstid)){echo $data[0]->customer_gstid;}?>	
			</span>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td width="40%">Seler Id</td>
						<td><?php
					if(isset($data[0]->invoice_no)){
						echo '<b>Bill No : '.$data[0]->invoice_no.'</b>';
					}
				?>
			</td>
					</tr>
					<tr>
						<td>Customer Name</td>
						<td><?php 
    					if(isset($data[0]->customer_name)){
    						echo $data[0]->customer_name;
    					} 
    				?></td>
					</tr>
					<tr>
						<td>Date</td>
						<td><?php echo "Date : ".date('d/m/y'); ?></td>
					</tr>
				</table>
				<br><br>
			</td>
		</tr>
		<tr>
			<td>

				<table width="100%" cellpadding="0" cellspacing="0"  >
					<tr>
						
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;">S.No</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;">Particular</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;">Price</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;">Qty.</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;">Discount</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;">Total</td>
						
					</tr>
					
					<?php 
						$i = 1;$tot = 0;$q=0;$igst=0; $cgst=0; $sgst=0; $dis = 0;
						foreach ($items as $value) { 
					?>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;"><?php echo $i; ?></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;"><?php echo $value->name; ?></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;"><?php echo $value->price;?></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;"><?php echo $value->quantity;?></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;"><?php echo $value->discount;?></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;"><?php echo $value->gross_total;?></td>						
					</tr>
					<?php 
							$i++;
							$tot += $value->gross_total;
							$q+=$value->quantity; 
							$igst += $value->igst_tax; 
							$cgst += $value->cgst_tax;
							$sgst += $value->sgst_tax;
							$dis += $value->discount;
						} 
					?>										
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Sub Total</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right"><?php echo $tot; ?></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Discount<hr></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right"><?php echo round($data[0]->discount_value+$data[0]->flat_discount); ?><hr></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Total Qty.<?php echo $q;?></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="3" align="right">Total</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right"><?php echo $tot-$data[0]->flat_discount; ?></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">CGST</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right"><?php echo $cgst; ?></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">SGST</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right"><?php echo $sgst; ?></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Roundoff<hr></td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right">
								<?php  
								$r=round($data[0]->total);
							 	($val=$r-($data[0]->total)); 
							 	echo $round = number_format($val, 2, '.', '');
							 	?>
						<br><hr></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Total</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right"><?php echo $data[0]->total;?></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Payment Type</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right"><?php echo $data[0]->mode;?></td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Paid</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right">
							<?php
						if($data[0]->paid_amount!=null){
							echo round($data[0]->paid_amount);
						}
						else{
							echo "0";
						}
					?>	
						</td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="5" align="right">Change Due.</td>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" align="right">
							<?php ($c_tot=$data[0]->total-$data[0]->paid_amount);
							echo $val = number_format($c_tot, 2, '.', '');
							?>	
						</td>
					</tr>
					<tr>
						<td style="font-size: 11px; padding-left: 2px; padding-right: 2px;" colspan="6"><br><br>Inclusive of all taxes</td>
					</tr>
					<tr>
						<td colspan="6" align="center">Thanks for Shopping. Visit Again!</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>