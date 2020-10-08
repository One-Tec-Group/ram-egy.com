<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','accountant','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth/dashboard');
}
?> 

                <table border="1">
                   <thead>
                    <tr>
                      <th width="10%"><?php echo $this->lang->line('purchase_date'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('purchase_reference_no'); ?></th>
                      <th width="20%"><?php echo $this->lang->line('reports_biller'); ?></th>
                      <th width="20%"><?php echo $this->lang->line('reports_customer'); ?></th>
                      <th width="30%"><?php echo $this->lang->line('reports_product_qty'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('purchase_total').'('.$this->session->userdata('symbol').')'; ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                      foreach ($sales as $row) {
                    ?>
                    <tr>
                      <td><?php echo $row->date; ?></td>
                      <td><?php echo $row->reference_no; ?></td>
                      <td><?php echo $row->biller_name; ?></td>
                      <td><?php echo $row->customer_name; ?></td>
                      <td>
                      	<?php
                      		foreach ($sales_items as $value) {
                      			foreach ($products as $key) {
	                      			if($row->sales_id == $value->sales_id){
	                      				if($value->product_id == $key->product_id){
	                      					echo $key->name."(".$value->quantity.")<br>";
	                      				}
	                      				
	                      			}
	                      		}
                      		}
                      	?>
                      		
                      </td>
                      <td><?php echo $row->total; ?></td>
                    <?php
                      }
                    ?>
                    </tr>
                  </tbody>
                </table>
<script>
  window.print();
</script>
              