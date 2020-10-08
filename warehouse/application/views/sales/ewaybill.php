<!DOCTYPE html>
<html>
<head>
	<title>
		EWAY BILL
		
	</title>
	<style type="text/css">
		.table td{
			border: 1px solid black;
		}
		.table th{
			border: 1px solid black;
		}
		.table{
			margin: 10px;
		}
		.footerpad
		{
			padding: 4px;
		}
		.footerpad{
			padding: 5px;
		}
		.minheight{
		    min-height: 1000px;
		}
		.fontS{
			font-size: 11px;
		}
		.fontH{
			font-size: 12px;
		}

	</style>
	<style type="text/css">
	    table { page-break-inside:auto }
	    tr    { page-break-inside:avoid; page-break-after:auto }
	    thead { display:table-header-group }
	    tfoot { display:table-footer-group }
	</style>

</head>
<body>
	<table width="670px" border="1" cellspacing="0" style="border: 0px solid black; border-collapse: collapse;" class="table" cellpadding="2">
		<tr>
			<td colspan="6" style="border: 0px;text-align: right;">Invoice</td>
			<td colspan="8" style="border: 0px;text-align: right;">(ORIGINAL FOR RECIPIENT)</td>
		</tr>

		<tr>
			<td rowspan="3" colspan="6">
				<table>
					<tr>
						<td style="border: 0px;font-size:13px;">
							<?php if(isset($company[0]->logo)){?>
								<img src="<?php echo base_url();?><?php echo $company[0]->logo;?>" width="120" height="60">	
							<?php }else{?>
								<img src="<?php echo base_url();?>/assets/images/logo.png;?>" width="70" height="50">
							<?php } ?>
						</td>
						<td style="border: 0px;font-size: 13px;padding-left: 10px;" valign="top">
							
							<b><?php if(isset($data[0]->biller_name)){echo $data[0]->biller_name;}?></b><br>
							<span style="font-size: 10px;">
								<?php if(isset($data[0]->biller_address)){echo $data[0]->biller_address;}?>
								<br>
								<?php if(isset($data[0]->biller_city)){echo $data[0]->biller_city;}?>
								<br>
								<?php if(isset($data[0]->biller_state)){echo $data[0]->biller_state;}?>
								<br>
								<?php if(isset($data[0]->biller_country)){echo $data[0]->biller_country;}?>
								<br>
								<?php if(isset($data[0]->biller_mobile)){echo $data[0]->biller_mobile;}?>
								<br>
								<?php if(isset($data[0]->biller_email)){echo $data[0]->biller_email;}?>
								<br>
								<?php if(isset($data[0]->biller_gstin)){echo "GSTIN : ".$data[0]->biller_gstin;}?>
							</span>

							
						</td>
					</tr>
				</table>
			</td>
		
			<td valign="top" style="width: 25%;font-size: 13px;" colspan="4">
				Invoice Number<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->reference_no)){echo $data[0]->reference_no;}?></p>
			</td>
			<td valign="top" style="width: 25%;font-size: 13px;" colspan="4">
				Date<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->date)){echo date("d-m-Y", strtotime($data[0]->date));}?></p>
			</td>
		</tr>
		<tr style="font-size: 13px;">
			<td valign="top" colspan="4" style="font-size: 13px;">
				Delivery note<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->note)){echo $data[0]->note;}?></p>
			</td>
			<td valign="top" colspan="4" style="font-size: 13px;">
				Mode / Term of payment<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->payment_method)){echo $data[0]->payment_method;}?> / <?php if(isset($data[0]->due_days)){echo $data[0]->due_days;}?></p>
			</td>
		</tr>

		<tr style="font-size: 13px;">
			<td valign="top" colspan="4" style="font-size: 13px;">
				Supplier's Ref <br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->supplier_ref)){echo $data[0]->supplier_ref;}?></p>
			</td>
			<td valign="top" colspan="4" style="font-size: 13px;">
				Other Reference<br>

			</td>
		</tr>
		<tr>
			<td valign="top" rowspan="" style="text-align:left;font-size: 13px;padding: 10px;" colspan="6">
					<b>Billing Address</b><br>
					<span style="font-size: 12px;"><?php if(isset($data[0]->customer_name)){echo $data[0]->customer_name; }?><br/></span>
					<span style="font-size: 11px;"><?php if(isset($data[0]->customer_address)){echo $data[0]->customer_address; }?><br>
						<?php if(isset($data[0]->customer_city)){echo $data[0]->customer_city; }?><br>
						<?php if(isset($data[0]->customer_state)){echo $data[0]->customer_state; }?> - <?php if(isset($data[0]->customer_postal_code)){echo $data[0]->customer_postal_code;} ?><br>						
						<?php if(isset($data[0]->customer_mobile)){echo $data[0]->customer_mobile;} ?><br>
						<?php if(isset($data[0]->customer_email)){echo $data[0]->customer_email;} ?><br>

						GSTIN/UIN :<?php if(isset($data[0]->customer_gstid)){echo $data[0]->customer_gstid;}?>

					</span>
			</td>
			<td colspan="4" valign="top" style="padding: 10px;">
				<b>Shipping Address</b><br>
				<span style="font-size: 12px;"><?php if(isset($data[0]->customer_name)){echo $data[0]->customer_name; }?></span><br/>
				<span style="font-size: 11px;"><?php if(isset($data[0]->shipping_address)){echo $data[0]->shipping_address; }?></span><br>
				<span style="font-size: 11px;"><?php if(isset($data[0]->shipping_city)){echo $data[0]->shipping_city; }?></span><br>
				<span style="font-size: 11px;"><?php if(isset($data[0]->shipping_state)){echo $data[0]->shipping_state; }?></span><br
				>
				<span style="font-size: 11px;"><?php if(isset($data[0]->shipping_postal_code)){echo $data[0]->shipping_postal_code; }?></span>
			</td>
			<td colspan="4" style="font-size: 11px;" >
				Buyer Order<br><span style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->buyer_order)){echo $data[0]->buyer_order;}?></span>
				<br/>
				Dated<br><span style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->date)){echo date("d-m-Y", strtotime($data[0]->date));}?></span>
				<br/>
				Dispatch Document No<br><span style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->dispatch_document_no)){echo $data[0]->dispatch_document_no;}?></span>
				<br/>
				Delivery note date<br><span style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->delivery_note_date)){echo $data[0]->delivery_note_date;}?></span>
				<br/>
				Dispatch Through<br><span style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->dispatch_through)){echo $data[0]->dispatch_through;}?></span>
			</td>
		</tr>
		<tr>

			<td colspan="14">
				<?php 

					$trans_days = $data[0]->trans_distance/100;
					$valid_till = strtotime("+".$trans_days." day", strtotime($data[0]->trans_doc_date));

				?>
				Eway bill information ( Valid till : <?php echo date("d-m-Y", $valid_till); ?>)
			</td>
		</tr>
		<tr>
			<td style="font-size: 12px; font-weight: bolder;">
				Supply Type
			</td>
			<td style="font-size: 12px; font-weight: bolder;">
				Sub Supply Type
			</td>
			<td style="font-size: 12px; font-weight: bolder;">
				Transport Mode
			</td>
			<td style="font-size: 12px; font-weight: bolder;" colspan="2">
				Transporter Name
			</td>

			<td style="font-size: 12px; font-weight: bolder;" colspan="2">
				Transporter Id
			</td>
			<td style="font-size: 12px; font-weight: bolder;" colspan="2">
				Transporter Doc No
			</td>
			<td style="font-size: 12px; font-weight: bolder;" colspan="2">
				Transporter Doc Date
			</td>
			<td style="font-size: 12px; font-weight: bolder;" >
				Approx Distance
			</td>
			<td style="font-size: 12px; font-weight: bolder;" >
				Vehicle No
			</td>
			<td style="font-size: 12px; font-weight: bolder;">
				Vehicle Type
			</td>
		</tr>
		<tr>
			<td style="font-size: 12px;">
				<?php 
					if($data[0]->supply_type == "O"){
						echo "Outward"; 	
					}else{
						echo "Inward";
					}
				?>
			</td>
			<td style="font-size: 12px;">
				<?php 
					if($data[0]->sub_supply_type == 1){
						echo "Supply"; 	
					}else if($data[0]->sub_supply_type == 2){
						echo "Import"; 	
					}else if($data[0]->sub_supply_type == 3){
						echo "Export"; 	
					}else if($data[0]->sub_supply_type == 4){
						echo "Job Work"; 	
					}else if($data[0]->sub_supply_type == 5){
						echo "For Own Use"; 	
					}else if($data[0]->sub_supply_type == 6){
						echo "Job Work Returns"; 	
					}else if($data[0]->sub_supply_type == 7){
						echo "Sales Return"; 	
					}else if($data[0]->sub_supply_type == 8){
						echo "Others"; 	
					}else if($data[0]->sub_supply_type == 9){
						echo "SKD/CKD"; 	
					}else if($data[0]->sub_supply_type == 10){
						echo "Line Sales"; 	
					}else if($data[0]->sub_supply_type == 11){
						echo "Recipient Not Known"; 	
					}else if($data[0]->sub_supply_type == 12){
						echo "Exhibition or Fairs"; 	
					}else if($data[0]->sub_supply_type == 13){
						echo "Supply"; 	
					}else if($data[0]->sub_supply_type == 14){
						echo "Supply"; 	
					}
				?>
			</td>
			<td style="font-size: 12px;">
				<?php 
					if($data[0]->trans_mode == 1){
						echo "Road"; 	
					}else if($data[0]->trans_mode == 2){
						echo "Rail"; 	
					}else if($data[0]->trans_mode == 3){
						echo "Air"; 	
					}else if($data[0]->trans_mode == 4){
						echo "Ship"; 	
					}
				?>
			</td>
			<td style="font-size: 12px;" colspan="2">
				<?php echo $data[0]->transporter_name; ?>
			</td>

			<td style="font-size: 12px;" colspan="2">
				<?php echo $data[0]->transporter_id; ?>
			</td>
			<td style="font-size: 12px;" colspan="2">
				<?php echo $data[0]->trans_doc_no; ?>
			</td>
			<td style="font-size: 12px;" colspan="2">
				<?php echo date("d-m-Y", strtotime($data[0]->trans_doc_date)); ?>
			</td>
			<td style="font-size: 12px;">
				<?php echo $data[0]->trans_distance; ?>
			</td>
			<td style="font-size: 12px;">
				<?php echo $data[0]->vehicle_no; ?>
			</td>
			<td style="font-size: 12px;">
				<?php echo $data[0]->vehicle_type; ?>
			</td>
		</tr>
		<tr>
			<td colspan="14">
				Items
			</td>
		</tr>
		<tr>
			<th style="text-align: center;font-size: 12px;">SR</th>
			<th style="text-align: center;font-size: 12px;" colspan="3">Item Name / HSN Code</th>
			<th style="text-align: center;font-size: 12px;">Rate</th>
			<th style="text-align: center;font-size: 12px;">Qty</th>
			<th style="text-align: center;font-size: 12px;">Total Sales</th>
			<th style="text-align: center;font-size: 12px;" width="5%">Disc(%)</th>
			<th style="text-align: center;font-size: 12px;">Disc</th>
			<th style="text-align: center;font-size: 12px;">Taxable Value</th>
			<th style="text-align: center;font-size: 12px;">IGST</th>
			<th style="text-align: center;font-size: 12px;">SGST</th>
			<th style="text-align: center;font-size: 12px;">CGST</th>
			<th style="text-align: center;font-size: 12px;">Subtotal</th>
		</tr>
			<?php 
				$i = 1;$tot = 0;$q=0;$igst=0; $cgst=0; $sgst=0;
				foreach ($items as $value) { 
			?>
			<tr>
				<td align="center" class="fontS" width="30px"><?php echo $i; ?></td>
				<td class="fontS" colspan="3" width="200px"><?php echo $value->name.'<br/>HSN : '.$value->hsn_sac_code;; ?></td>
				<td align="right" class="fontS"><?php echo $value->price;?></td>
				<td align="center" class="fontS"><?php echo $value->quantity;?></td>
				<?php 
					if($value->tax_type =="Inclusive"){
				?>
				<td align="right" class="fontS"><?php echo $value->gross_total-$value->discount - $value->igst_tax -$value->cgst_tax -$value->sgst_tax;?></td>
				<?php 
					}else{
				?>
				<td align="right" class="fontS"><?php echo $value->gross_total-$value->discount ;?></td>
				<?php
					}
				?>
				<td align="right" class="fontS"><?php echo $value->discount_value;?></td>
				<td align="right" class="fontS"><?php echo $value->discount;?></td>
				<td align="right" class="fontS"><?php echo $value->gross_total-$value->discount;?></td>
				<td align="right" class="fontS"><?php echo $value->igst_tax;?><br>(<?php echo $value->igst; ?>%)</td>
				<td align="right" class="fontS"><?php echo $value->cgst_tax;?><br>(<?php echo $value->cgst; ?>%)</td>
				<td align="right" class="fontS"><?php echo $value->sgst_tax;?><br>(<?php echo $value->sgst; ?>%)</td>
				<td align="right" class="fontS"><?php echo ($value->gross_total - $value->discount + $value->igst_tax + $value->cgst_tax + $value->sgst_tax); ?></td>
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
				<td colspan="5" align="right" style="font-size: 11px;font-weight: bold;">Total</td>
				<td align="center" style="font-size: 11px;"><?php echo $q; ?></td>
				<td align="right" style="padding: 8px;font-size: 11px;">
					<?php
						echo round($tot);
					?>	
				</td>
				<td></td>
				<td align="right" class="fontS">
					<?php
						echo round($data[0]->discount_value);
					?>
				</td>
				<td align="right" class="fontS">
					<?php
						echo round($data[0]->total-$data[0]->tax_value);
					?>	
				</td>
				<td align="right" class="fontS">
					<?php echo $igst;?>	
				</td>
				<td align="right" class="fontS">
					<?php echo $cgst;?>
				</td>
				<td align="right" class="fontS">
					<?php echo $sgst;?>
				</td>
				<td align="right" class="fontS">
					<?php
						echo round($data[0]->total);
					?>		
				</td>
				
			</tr>
			<tr>
				<td colspan="14" style="padding: 10px;"></td>
			</tr>
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>Shipping Charge</td>
				<td align="right" colspan="2" class="fontH"><?php echo round($data[0]->shipping_charge); ?></td>
			</tr>
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>Total Discount</td>
				<td align="right" colspan="2" class="fontH"><?php echo round($data[0]->discount_value+$data[0]->flat_discount); ?></td>
			</tr>
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>IGST</td>
				<td align="right" colspan="2" class="fontH">
					<?php echo $igst;?>	
				</td>
			</tr>
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>CGST</td>
				<td align="right" colspan="2" class="fontH">
					<?php echo $cgst;?>	
				</td>
			</tr>
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>SGST</td>
				<td align="right" colspan="2" class="fontH">
					<?php echo $sgst;?>	
				</td>
			</tr>
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>Grand Total</td>
				<td align="right" colspan="2" class="fontH"><?php echo round($data[0]->total+$data[0]->shipping_charge-$data[0]->flat_discount); ?></td>
			</tr>
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>Paid</b></td>
				<td align="right" colspan="2" class="fontH">
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
				<td colspan="12" align="right" class="footerpad fontH"><b>Due Amount</b></td>
				<td align="right" colspan="2" class="fontH">
					<?php
						echo round($data[0]->shipping_charge+$data[0]->total-$data[0]->paid_amount-$data[0]->flat_discount);
					?>
				</td>
			</tr>
        <tr>
        	<td colspan="14" valign="top" style="height: 60px;border-bottom: 0px;font-size: 13px;">
        		Due Amount (in Words)<br>
        		<b> INR <?php echo $this->numbertowords->convert_number(round($data[0]->shipping_charge+$data[0]->total-$data[0]->paid_amount-$data[0]->flat_discount)); ?> Only</b><br/>
        		Paid Amount (in Words)<br>
        		<b> INR <?php echo $this->numbertowords->convert_number(round($data[0]->paid_amount+$data[0]->flat_discount)); ?> Only</b>
        	</td>
        </tr>
        <tr>
        	<td colspan="14" style="height: 60px;border-bottom: 0px;font-size: 13px;">
        		<b>Head Office : </b>
        			<span>
        				<?php if(isset($company[0]->name)){echo $company[0]->name;}?>,
			    				<?php if(isset($company[0]->street)){echo $company[0]->street;}?>,
								<?php if(isset($company[0]->city_name)){echo $company[0]->city_name;}?>,
								<?php if(isset($company[0]->state_name)){echo $company[0]->state_name;} ?>
								<?php if(isset($company[0]->country_name)){echo $company[0]->country_name;} ?> - <?php if(isset($company[0]->zip_code)){echo $company[0]->zip_code;}?>
        			</span>
        		<br><p>Company's PAN  : <b><?php if(isset($company[0]->pan)){echo $ccompany[0]->pan;}?></b></td>
        </tr>
        <tr>
        	<td colspan="6" style="border-top:0px;border-right: 0px;font-size: 13px;">
        		Declartion<br>
        		We declare that this invoice shows the actual price of the goods describe and that all paticular are true and correct.
        	</td>
        	<td style="font-size: 10px;" colspan="8" style="border-top: 0px;border-top: 0px;border-left:0px;font-size: 13px;">
        		Company Bank Details
        		<table>
        			<tr>
        				<td style="border: 0px;font-size: 13px;" >Bank Name</td>
          				<td style="border: 0px;font-size: 13px;"><?php if(isset($company[0]->bank_name)){echo $company[0]->bank_name;}?></td>
        			</tr>
        			<tr>
						<td style="border: 0px;font-size: 13px;">A/C No</td>
						<td style="border: 0px;font-size: 13px;"><?php if(isset($company[0]->account_no)){echo $company[0]->account_no;}?></td>
	        		</tr>
        		<tr>
					<td style="border: 0px;font-size: 13px;">Branch code & Ifsc code</td>
					<td style="border: 0px;font-size: 13px;"><?php if(isset($company[0]->branch_ifsccode)){echo $company[0]->branch_ifsccode;}?> </td>
        		</tr>
        		</table>
        	</td>
        </tr>
        <tr>
        	<td colspan="6" style="height: 80px;font-size: 13px;" valign="top">
        		Custom Seal Signature
        		<br>
        		<br>
        	</td>
        	<td colspan="8" valign="top" style="text-align: right;font-size: 13px;">
        		For <?php if(isset($company[0]->name)){echo $company[0]->name;}?>
        		<br>
        		Authorised signatory
        	</td>
        </tr>    
	</table>
	<table>
		<tr>
        	<td colspan="14" style="border:0px;text-align: center;font-size: 13px;"><b>This is Computer Generated Invoice</b></td>
        </tr>
	</table>
</body>
</html>
<script>
  window.print();
</script>