<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
      body{
        font-family: arial;
        font-size: 20px;
      }
      table, th, td, tr{
        padding: 10px;
      }
      table{
        width: 70%;
        height: 70%;
      }
  </style>
</head>
<body>
	<table width="100%" border="1" cellspacing="0" style="border: 0px solid black; border-collapse: collapse;" cellpadding="2">
				<tr>
					<td colspan="8" align="center"><?php if(isset($company[0]->logo)){?>
    								<img src="<?php echo base_url();?><?php echo $company[0]->logo;?>">	
    							<?php }else{?>
    								<img src="<?php echo base_url();?>/assets/images/logo.png;?>" width="70" height="50">
    							<?php } ?></td>
					<td colspan="5">Address:
								<?php if(isset($company[0]->street)){echo $company[0]->street;}?>,
								<?php if(isset($company[0]->city_name)){echo $company[0]->city_name;}?>,
								<?php if(isset($company[0]->state_name)){echo $company[0]->state_name;} ?>
								<?php if(isset($company[0]->country_name)){echo $company[0]->country_name;} ?> - <?php if(isset($company[0]->zip_code)){echo $company[0]->zip_code;}?><br>
									mob.:<?php if(isset($company[0]->phone)){echo $company[0]->phone;}?><br>
									Email:<?php if(isset($company[0]->email)){echo $company[0]->email;}?>
					</td>
				</tr>
				<tr>
					<td colspan="8" style="border-top: none;border-bottom: none;border-right: none;">Invoice No:<?php if(isset($data[0]->invoice_no)){echo $data[0]->invoice_no;}?></td>
					<td colspan="5" style="border-top: none;border-bottom: none;border-left: none;">date :<?php if(isset($data[0]->date)){echo $data[0]->date;}?></td>
				</tr>
				<tr>
					<td colspan="8" style="border-top: none;border-bottom: none;border-right: none;">Name : <?php if(isset($data[0]->customer_name)){echo $data[0]->customer_name;}?></td>
					<td colspan="5" style="border-top: none;border-bottom: none;border-left: none;">GST No : <?php if(isset($data[0]->customer_gstid)){echo $data[0]->customer_gstid;}?></td>
				</tr>
				<tr>
					<td colspan="8" style="border-top: none;border-bottom: none;border-right: none;">City : <?php if(isset($data[0]->customer_city)){echo $data[0]->customer_city; }?></td>
					<td colspan="5" style="border-top: none;border-bottom: none;border-left: none;">State  : <?php if(isset($data[0]->customer_state)){echo $data[0]->customer_state; }?></td>
				</tr>
				<tr>
					<td colspan="13" style="border-top:none;" >Address:33</td>
				</tr>
				<tr>
					<td>S.No</td>
					<td width="25%" colspan="2">Product/HSN</td>
					
					<td>Quantity</td>
					<td>Rate</td>
					<td>Amount</td>
					<td>CGST%</td>
					<td>Amount</td>
					<td>SGST%</td>
					<td>Amount</td>
					<td>IGST%</td>
					<td>Amount</td>
					<td>Total Amount</td>
				</tr>
				<?php 
					$i = 1;$tot = 0;$q=0;$igst=0; $cgst=0; $sgst=0;
					foreach ($items as $value) { 
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td colspan="2"><?php echo $value->name.'<br/> HSN:'.$value->hsn_sac_code; ?></td>
					<td><?php echo $value->quantity;?></td>
					<td><?php echo $value->price;?></td>
					<td><?php echo $value->gross_total;?></td>
					<td><?php echo $value->cgst; ?></td>
					<td><?php echo $value->cgst_tax;?></td>
					<td><?php echo $value->sgst; ?></td>
					<td><?php echo $value->sgst_tax;?></td>
					<td><?php echo $value->igst; ?></td>
					<td><?php echo $value->igst_tax;?></td>
					<td><?php echo ($value->gross_total - $value->discount + $value->igst_tax + $value->cgst_tax + $value->sgst_tax); ?></td>
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
					<td colspan="13" align="right">Round Off Amount : <?php echo number_format(round($data[0]->total) - $data[0]->total, 2, '.', ''); ?></td>
				</tr>
				<tr>
					<td colspan="13" align="right">
						Final Total Amount : <?php echo round($data[0]->total); ?>	
					</td>
				</tr>
				<tr>
					<td colspan="13" align="left">
						Due Amount (in Words)<br>
		        		<b> INR <?php echo $this->numbertowords->convert_number(round($data[0]->shipping_charge+$data[0]->total-$data[0]->paid_amount-$data[0]->flat_discount)); ?> Only</b><br/>
		        		Paid Amount (in Words)<br>
		        		<b> INR <?php echo $this->numbertowords->convert_number(round($data[0]->paid_amount+$data[0]->flat_discount)); ?> Only</b>

					</td>
				</tr>
				<tr>
					<td colspan="13" style="border-right: none;"><b style="text-align: left;">Our Bank Details -</b> </td>
					
				</tr>
				<tr>
					<td colspan="13">Name : <?php if(isset($company[0]->name)){echo $company[0]->name;}?><br>
							Bank Name : <?php if(isset($company[0]->bank_name)){echo $company[0]->bank_name;}?><br>
							Account No : <?php if(isset($company[0]->account_no)){echo $company[0]->account_no;}?><br>
							IFSC Code : <?php if(isset($company[0]->branch_ifsccode)){echo $company[0]->branch_ifsccode;}?>
					</td>
				</tr>
				<tr>
					<td colspan="9" style="border-top: none;border-right: none;" valign="top">
						<span style="color:#a4a09f;">TERMS & CONDITIONS</span><br><?php if(isset($company[0]->terms_condition)){echo $company[0]->terms_condition;}?>
					</td>
					<td style="border-left: none;" align="right" colspan="4" align="center" valign="top">
						<span style="font-size: 12px;">Certified that the Particulars given above are true and correct.</span>
						<br>For, <?php if(isset($company[0]->name)){echo $company[0]->name;}?>
						<br>
						<br>
						<br>Authorized Signatory
					</td>
				</tr>
				<!-- <tr>
					<td colspan="9" style="border-top: none;border-bottom: none;border-right: none;">
						1. Good once sold cannot be taken back.
					</td>
					<td align="right" colspan="4" style="border-top: none;border-bottom: none;border-left: none;">For, Maa Sulochana Offset</td>
				</tr>
				<tr>
					<td colspan="9" style="border-top: none;border-bottom: none;border-right: none;">
						2. Payment withing 7 days.
					</td>
					<td style="font-size: 12px;border-top: none;border-bottom: none;border-left: none;" align="right" colspan="4"></td>
				</tr>
				<tr>
					<td colspan="9" style="border-top: none;border-bottom: none;border-right: none;">
						3. Delay in payment will be charge 3% interest per month of bill amount.
					</td>
					<td style="font-size: 12px;border-top: none;border-bottom: none;border-left: none;" align="right" colspan="4"></td>
				</tr>
				<tr>
					<td colspan="9" style="border-top: none;border-bottom: none;border-right: none;">
						4. Subject to Raipur Jurisdiction.
					</td>
					<td style="font-size: 12px;border-top: none;border-bottom: none;border-left: none;" align="right" colspan="4"></td>
				</tr>
				<tr>
					<td colspan="9" style="border-top: none;border-right: none;">
						5. E. & O. E.
					</td>
					<td style="border-top: none;border-left: none;" align="right" colspan="4">Authorized Signatory</td>
				</tr> -->
			</table>

</body>
</html>