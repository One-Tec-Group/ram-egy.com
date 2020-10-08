<!DOCTYPE html>
<html>
<head>
	<title>POS</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<table width="50%" align="center">
		<tr>
			<td align="center" colspan="2">
				<!-- <?php
					if(isset($company[0]->name)){
						echo $company[0]->name,'<br>';
					}
					if(isset($company[0]->street)){
						echo $company[0]->street,',';
					}
					if(isset($company[0]->city_name)){
						echo $company[0]->city_name.'<br>';
					}
					if(isset($company[0]->gstin)){
						echo 'GSTIN : '.$company[0]->gstin;
					}
				?> -->
				<span>				
				<b>
    				<?php 
    					if(isset($company[0]->logo)){
    						?>			            						
    						<img src="<?php echo base_url().$company[0]->logo;?>"  width="50" height="50">
    				<?php	} 
    				?>
    			</b><br>					 
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
			</span>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2" height="50px">
				<?php
					if(isset($data[0]->invoice_no)){
						echo '<b>Bill No : '.$data[0]->invoice_no.'</b>';
					}
				?>
			</td>
		</tr>
		<tr>
			<td><?php echo "Date : ".date('d/m/y'); ?></td>
			<td align="right"><?php echo "Time : ".date("h:i:s a"); ?></td>
		</tr>
		<tr>
			<td height="30px;"></td>
		</tr>
		<tr>
			<td colspan="2" style="border-left: none;border-right: none;" >
				<table class="table" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center" style="border-left: none;border-right: none;"><hr>SN<hr></td>
						<td align="center" style="border-left: none;border-right: none;"><hr>ITEM<hr></td>
						<td align="center" style="border-left: none;border-right: none;"><hr>QTY<hr></td>
						<td align="center" style="border-left: none;border-right: none;"><hr>RATE<hr></td>
						<td align="center" style="border-left: none;border-right: none;"><hr>AMT<hr></td>
					</tr>
					<?php 
						$i = 1;$tot = 0;$q=0;$igst=0; $cgst=0; $sgst=0;
						foreach ($items as $value) { 
					?>
					<tr>
						<td align="center" style="border-left: none;border-top: none;border-bottom: : none;border-right: none;" valign="top"><?php echo $i; ?></td>
						<td style="border-left: none;border-top: none;border-bottom: : none;border-right: none;"><?php echo $value->name; ?></td>
						<td align="center" style="border-left: none;border-top: none;border-bottom: : none;border-right: none;"><?php echo $value->quantity;?></td>
						<td align="right" style="border-left: none;border-top: none;border-bottom: : none;border-right: none;"><?php echo $value->price;?></td>
						<td align="right" style="border-left: none;border-top: none;border-bottom: : none;border-right: none;"><?php echo $value->gross_total;?></td>
					</tr>
					<?php 
							$i++;
							$tot += $value->gross_total;
							$q+=$value->quantity; 
							$igst += $value->igst_tax; 
							$cgst += $value->cgst_tax;
							$sgst += $value->sgst_tax;
						} 
					?>
					<tr>
						<td colspan="5" style="border-left: none;border-bottom: : none;border-right: none;"><hr></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="padding: 5px;"><b>ITEM VALUE : </b></td>
			<td style="padding: 5px;" align="right"><?php echo $tot; ?></td>
		</tr>
		<tr>
			<td style="padding: 5px;">IGST : </td>
			<td style="padding: 5px;" align="right"><?php echo $igst;?>	</td>
		</tr>
		<tr>
			<td style="padding: 5px;">SGST : </td>
			<td style="padding: 5px;" align="right"><?php echo $sgst; ?></td>
		</tr>
		<tr>
			<td style="padding: 5px;">CGST : </td>
			<td style="padding: 5px;" align="right"><?php echo $cgst; ?></td>
		</tr>
		<tr>
			<td style="padding: 5px;">TOTAL AMT : </td>
			<td style="padding: 5px;" align="right"><?php echo $data[0]->total+$data[0]->shipping_charge-$data[0]->flat_discount; ?></td>
		</tr>
		<tr>
			<td style="padding: 5px;">Amount Tendered : </td>			
			<?php if($data[0]->paid_amount == 0.00 || $data[0]->paid_amount == 0){ ?>
			<td style="padding: 5px;" align="right">( - ) 0.00</td>
		<?php  }else{ ?>
			<td style="padding: 5px;" align="right">( - ) <?php echo ($data[0]->paid_amount); ?></td>
		<?php } ?>
		</tr>
		<tr>
			<td style="padding: 5px;">Balance : </td>			
			<td style="padding: 5px;" align="right"><?php echo ($data[0]->total-$data[0]->paid_amount); ?></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<table border="0" class="table" width="100%">
					<tr>
						<td style="border-left: none;border-right: none;padding: 2px;"><hr>AMOUNT WILL NOT BE REFUNDED<hr></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="font-size: 28px;" style="padding: 5px;"><h3>*Rs. 
				<?php echo $data[0]->total+$data[0]->shipping_charge-$data[0]->flat_discount; ?></h3></td>
		</tr>
		<tr>
			<td colspan="2" align="center" style="padding: 5px;">***THANK YOU***</td>
		</tr>
	</table>
</body>
</html>