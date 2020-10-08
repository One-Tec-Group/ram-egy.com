

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
  	<div>
    	<table width="100%">
      		<tr>
        		<td widht="5%">
          			<h2>
		            	<?php
		              		if($siteinfos->photo) {
		                  		$array = array(
		                      		"src" => base_url('uploads/images/'.$siteinfos->photo),
		                      		'width' => '25px',
		                      		'height' => '25px',
		                      		'style' => 'margin-top:-8px'
		                  		);
		                  		echo img($array);
		              		}
		              	?>
          			</h2>
        		</td>
				<td widht="75%">
					<h3 class="top-site-header-title"><?php  echo $siteinfos->sname; ?></h3>
				</td>
				<td class="20%">
					<h5 class="top-site-header-create-title"><?php  echo $this->lang->line("invoice_create_date")." : ". date("d M Y"); ?></h5>
				</td>
			</tr>
		</table>
    	<br>
	    <table width="100%">
	      	<tr>
	        	<td width="33%">
	          		<table>
	            		<tbody>
	                		<tr>
	                    		<th class="site-header-title-float"><?php  echo $this->lang->line("invoice_from"); ?></th>
	                		</tr>
			                <?php if(count($siteinfos)) { ?>
			                    <tr>
			                        <td><?=$siteinfos->sname?></td>
			                    </tr>
			                    <tr>
			                        <td><?=$siteinfos->address?></td>
			                    </tr>
			                    <tr>
			                        <td><?=$this->lang->line("invoice_phone"). " : ". $siteinfos->phone?></td>
			                    </tr>
			                    <tr>
			                        <td><?=$this->lang->line("invoice_email"). " : ". $siteinfos->email?></td>
			                    </tr>
			                <?php } ?>
	            		</tbody>
	          		</table>
	        	</td>
	        	<td width="33%">
	            	<table >
	              		<tbody>
	              			<tr>
			                    <th class="site-header-title-float"><?php  echo $this->lang->line("invoice_to"); ?></th>
			                </tr>
			                <tr>
			                    <td><?php  echo $maininvoice->srname; ?></td>
			                </tr>
			                <tr>
			                    <td><?php  echo $this->lang->line("invoice_roll"). " : ". $maininvoice->srroll; ?></td>
			                </tr>
			                <tr>
			                    <td><?php  echo $this->lang->line("invoice_classesID"). " : ". $maininvoice->srclasses; ?></td>
			                </tr>
			                <tr>
			                    <td><?php  echo $this->lang->line("student_registerNO"). " : ". $maininvoice->srregisterNO; ?></td>
			                </tr>
			                <?php if(count($student)) { ?>
				                <tr>
				                  <td><?=$this->lang->line("invoice_email"). " : ". $student->email?></td>
				                </tr>
			                <?php } ?>
	              		</tbody>
	            	</table>
	        	</td>
	        	<td width="34%" style="vertical-align: text-top;">
		          	<table>
		            	<tbody>
		              		<tr>
		                		<td>
		                			<?=$this->lang->line("invoice_invoice").$maininvoice->maininvoiceID?>
		                		</td>
		              		</tr>
		              		<tr>
		                		<td>
				                  	<?php 
				                        $status = $maininvoice->maininvoicestatus;
				                        $setButton = '';
				                        if($status == 0) {
				                            $status = $this->lang->line('invoice_notpaid');
				                            $setButton = 'text-red';
				                        } elseif($status == 1) {
				                            $status = $this->lang->line('invoice_partially_paid');
				                            $setButton = 'text-yellow';
				                        } elseif($status == 2) {
				                            $status = $this->lang->line('invoice_fully_paid');
				                            $setButton = 'text-green';
				                        }

				                        echo $this->lang->line('invoice_status'). " : ". "<span class='".$setButton."'>".$status."</span>";;
				                    ?>
		                		</td>
		              		</tr>
		            	</tbody>
		          	</table>
	        	</td>
	      	</tr>
	    </table>
	    <br>
	    <table class="table table-bordered">
	      	<thead>
		        <tr>
		            <th><?=$this->lang->line('slno')?></th>
		            <th><?=$this->lang->line('invoice_feetype')?></th>
		            <th><?=$this->lang->line('invoice_amount')?></th>
		            <th><?=$this->lang->line('invoice_discount')?></th>
		            <th><?=$this->lang->line('invoice_subtotal')?></th>
		        </tr>
	      	</thead>
	      	<tbody>
	          	<?php $subtotal = 0; $totalsubtotal = 0; $i = 1; if(count($invoices)) { foreach($invoices as $invoice) { $discount = 0; if($invoice->discount > 0) { $discount = (($invoice->amount/100) * $invoice->discount); } $subtotal = ($invoice->amount - $discount); $totalsubtotal += $subtotal;  ?>
		            <tr>
		                <td data-title="<?=$this->lang->line('slno')?>">
		                    <?php echo $i; ?>
		                </td>
		                
		                <td data-title="<?=$this->lang->line('invoice_feetype')?>">
		                    <?=isset($feetypes[$invoice->feetypeID]) ? $feetypes[$invoice->feetypeID] : ''?>
		                </td>
		                
		                <td data-title="<?=$this->lang->line('invoice_amount')?>">
		                    <?=number_format($invoice->amount, 2)?>
		                </td>

		                <td data-title="<?=$this->lang->line('invoice_discount')?>">
		                    <?=number_format($discount, 2)?>
		                </td>
		                <td data-title="<?=$this->lang->line('invoice_subtotal')?>">
		                    <?=number_format($subtotal, 2)?>
		                </td>
		            </tr>
	          	<?php $i++; } } ?>
	      	</tbody>
	      	<tfoot>
	          	<tr>
	              	<td class="pull-right" colspan="4"><b><?=$this->lang->line('invoice_totalamount')?> <?=!empty($siteinfos->currency_code) ? '('.$siteinfos->currency_code.')' : ''?></b></td>
	              	<td><b><?=number_format($totalsubtotal, 2)?></b></td>
	          	</tr>
	          	<tr>
	              	<td class="pull-right" colspan="4"><b><?=$this->lang->line('invoice_paid')?> <?=!empty($siteinfos->currency_code) ? '('.$siteinfos->currency_code.')' : ''?></b></td>
	              	<td><b><?=number_format($grandtotalandpayment['totalpayment'], 2)?></b></td>
	          	</tr> 
	          	<tr>
	              	<td class="pull-right" colspan="4"><b><?=$this->lang->line('invoice_weaver')?> <?=!empty($siteinfos->currency_code) ? '('.$siteinfos->currency_code.')' : ''?></b></td>
	              	<td><b><?=number_format($grandtotalandpayment['totalweaver'], 2)?></b></td>
	          	</tr> 
	          	<tr>
	                <td class="pull-right" colspan="4"><b><?=$this->lang->line('invoice_balance');?> <?=!empty($siteinfos->currency_code) ? '('.$siteinfos->currency_code.')' : ''?></b></td>
	                <td><b><?=number_format(($totalsubtotal - ($grandtotalandpayment['totalpayment'] + $grandtotalandpayment['totalweaver'])), 2)?></b></td>
	            </tr>
	            <tr>
	                <td class="pull-right" colspan="4"><b><?=$this->lang->line('invoice_fine');?> <?=!empty($siteinfos->currency_code) ? '('.$siteinfos->currency_code.')' : ''?></b></td>
	                <td><b><?=number_format($grandtotalandpayment['totalfine'], 2)?></b></td>
	            </tr>
	      	</tfoot>
	    </table>
	   
	    <table width="100%">
	        <tr>
	            <td width="65%" >
	            </td>
	            <td width="35%">
	                <table>
	                    <tr>
	                        <td><?=$this->lang->line('invoice_create_by')?> : <?=$createuser?></td>
	                    </tr>
	                    <tr>
	                        <td><?=$this->lang->line('invoice_date')?> : <?=date('d M Y', strtotime($maininvoice->maininvoicecreate_date))?></td>
	                    </tr>
	                </table>
	            </td>
	        </tr>
	    </table>
  	</div>
</body>
</html>