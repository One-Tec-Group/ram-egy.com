<!DOCTYPE html>
<html>
<head>
	<title>
		Invoice
		
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
</head>
<body>

	<table width="100%" border="1" cellspacing="0" style="border: 0px solid black; border-collapse: collapse;" class="table" cellpadding="2">
			<tr>
				<td colspan="6" style="border: 0px;text-align: right;">Invoice</td>
				<td colspan="8" style="border: 0px;text-align: right;">(ORIGINAL FOR RECIPIENT)</td>
			</tr>

			<tr>
    			<td rowspan="3" colspan="6" valign="top">
    				<table>
    					<tr>
    						<td style="border: 0px;font-size:13px;" valign="top">
    							<?php if(isset($company[0]->logo)){?>
    								<img src="<?php echo base_url();?><?php echo $company[0]->logo;?>" width="60" height="50">	
    							<?php }else{?>
    								<img src="<?php echo base_url();?>/assets/images/logo.png;?>" width="70" height="50">
    							<?php } ?>
    						</td>
    						<td style="border: 0px;font-size: 13px;" valign="top">
    							<b><?php if(isset($company[0]->name)){echo $company[0]->name;}?></b><br>
			    				
			    					Address :<?php if(isset($company[0]->street)){echo $company[0]->street;}?><br> 
									<?php if(isset($company[0]->city_name)){echo $company[0]->city_name;}?> <br>
									<?php if(isset($company[0]->state_name)){echo $company[0]->state_name;} ?><br>
									<?php if(isset($company[0]->country_name)){echo $company[0]->country_name;} ?> - <?php if(isset($company[0]->zip_code)){echo $company[0]->zip_code;}?><br>
									<?php if(isset($company[0]->phone)){echo $company[0]->phone;} ?><br>
									GSTIN/UIN : <?php if(isset($company[0]->gstin)){echo $company[0]->gstin;} ?><br>
									Email : <?php if(isset($company[0]->email)){echo $company[0]->email;} ?><br>
								
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
			<td valign="top" rowspan="5" style="text-align:left;font-size: 13px;" colspan="6" >
					Supplier<br>
				
					<?php if(isset($data[0]->supplier_company_name)){echo $data[0]->supplier_company_name;} ?><br>
					<?php if(isset($data[0]->supplier_name)){echo $data[0]->supplier_name;} ?><br>
					<?php if(isset($data[0]->supplier_address)){echo $data[0]->supplier_address; }?><br>
					<?php if(isset($data[0]->supplier_city)){echo $data[0]->supplier_city; }?><br>
					<?php if(isset($data[0]->supplier_state_name)){echo $data[0]->supplier_state_name; }?> - <?php if(isset($data[0]->supplier_pin_no)){echo $data[0]->supplier_pin_no;} ?><br>
					<?php if(isset($data[0]->supplier_mobile)){echo $data[0]->supplier_mobile;} ?><br>
					<?php if(isset($data[0]->supplier_email)){echo $data[0]->supplier_email;} ?><br>
					GSTIN/UIN :<?php if(isset($data[0]->supplier_gstin)){echo $data[0]->supplier_gstin;}?><br>
					
				
			</td>
		</tr>		
		<tr>
			<td valign="top" colspan="4" style="font-size: 13px;">
				Supplier Order <br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->buyer_order)){echo $data[0]->buyer_order;}?></p>
			</td>
			<td valign="top" colspan="4" style="font-size: 15px;">
				Dated<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->date)){echo date("d-m-Y", strtotime($data[0]->date));}?></p>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="4" style="font-size: 13px;">
				Despatch Document No<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->dispatch_document_no)){echo $data[0]->dispatch_document_no;}?></p>
			</td>
			<td valign="top" colspan="4" style="font-size: 13px;">
				Delivery note date<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->delivery_note_date)){echo date("d-m-Y", strtotime($data[0]->delivery_note_date));}?></p>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="4" style="font-size: 13px;">
				Despatched Through<br>
				<p style="font-size: 13px;font-weight:bold"><?php if(isset($data[0]->dispatch_through)){echo $data[0]->dispatch_through;}?></p>
			</td>
			<td valign="top" colspan="4" style="font-size: 13px;">
				Destination<br>
				<p style="font-size: 13px;font-weight:bold">
					<?php if(isset($data[0]->shipping_address)){echo $data[0]->shipping_address;}?>
					<?php if(isset($data[0]->shipping_city_name)){echo $data[0]->shipping_city_name;}?>
					<?php if(isset($data[0]->shipping_state_name)){echo $data[0]->shipping_state_name;}?>
					<?php if(isset($data[0]->shipping_country_name)){echo $data[0]->shipping_country_name;}?>
				</p>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="8" style="height: 50px;font-size: 13px;">
				Terms of Delivery<br>
				<p style="font-size: 13px;font-weight:bold"><!-- <?php if(isset($company[0]->terms_condition)){echo $company[0]->terms_condition;}?> --></p>
			</td>
		</tr>

		<tr>
			<th style="text-align: center;font-size: 12px;">SR</th>
			<th style="text-align: center;font-size: 12px;">Item Name</th>
			<th style="font-size: 12px;">Item Description</th>
			<th style="font-size: 12px;">HSN/SAC Code</th>
			<th style="text-align: center;font-size: 12px;">Rate</th>
			<th style="text-align: center;font-size: 12px;">Qty</th>
			<th style="text-align: center;font-size: 12px;">Total Sales</th>
			<th style="text-align: center;font-size: 12px;" width="5%">Disc(%)</th>
			<th style="text-align: center;font-size: 12px;">Disc</th>
			<th style="text-align: center;font-size: 12px;">Taxable Value</th>
			<th style="text-align: center;font-size: 12px;">SGST</th>
			<th style="text-align: center;font-size: 12px;">CGST</th>
			<th style="text-align: center;font-size: 12px;">IGST</th>
			<th style="text-align: center;font-size: 12px;">Subtotal</th>
		</tr>
			<?php 
				$i = 1;$tot = 0;$q=0;$igst=0; $cgst=0; $sgst=0;
				foreach ($items as $value) { 
			?>
			<tr>
				<td align="center" class="fontS"><?php echo $i; ?></td>
				<td class="fontS"><?php echo $value->name; ?></td>
				<td class="fontS"></td>
				<td class="fontS"><?php echo $value->hsn_sac_code; ?></td>
				<td align="right" class="fontS"><?php echo $value->cost;?></td>
				<td align="center" class="fontS"><?php echo $value->quantity;?></td>
				<td align="right" class="fontS"><?php echo $value->gross_total;?></td>
				<td align="right" class="fontS"><?php echo $value->discount_value;?></td>
				<td align="right" class="fontS"><?php echo $value->discount;?></td>
				<td align="right" class="fontS"><?php echo $value->gross_total-$value->discount;?></td>
				<td align="right" class="fontS"><?php echo $value->igst_tax;?></td>
				<td align="right" class="fontS"><?php echo $value->cgst_tax;?></td>
				<td align="right" class="fontS"><?php echo $value->sgst_tax;?></td>
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
						echo $tot;
					?>	
				</td>
				<td></td>
				<td align="right" class="fontS">
					<?php
						echo $data[0]->discount_value;
					?>
				</td>
				<td align="right" class="fontS">
					<?php
						echo $data[0]->total-$data[0]->tax_value;
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
						echo $data[0]->total;
					?>		
				</td>
				
			</tr>
			<tr>
				<td colspan="14" style="padding: 10px;"></td>
			</tr>
			
			<tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>Grand Total</td>
				<td align="right" colspan="2" class="fontH"><?php echo $data[0]->total; ?></td>
			</tr>

			<!-- <tr>
				<td colspan="12" align="right" class="footerpad fontH"><b>Paid</b></td>
				<td align="right" colspan="2" class="fontH">
					<?php
						if($data[0]->paid_amount!=null){
							echo $data[0]->paid_amount;
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
						if($data[0]->paid_amount!=null){
							echo "0";
						}
						else{
							echo $data[0]->total;
						}
					?>
				</td>
			</tr> -->



        <tr>
        	<td colspan="14" valign="top" style="height: 60px;border-bottom: 0px;font-size: 13px;">
        		Paid Amount (in Words)<br>
        		<b> INR <?php echo $this->numbertowords->convert_number($data[0]->total); ?> Only</b>
        	</td>
        </tr>
        <tr>
        	<td colspan="14" style="height: 60px;border-bottom: 0px;font-size: 13px;">Company's PAN  : <b><?php if(isset($company[0]->pan)){echo $ccompany[0]->pan;}?></b></td>
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