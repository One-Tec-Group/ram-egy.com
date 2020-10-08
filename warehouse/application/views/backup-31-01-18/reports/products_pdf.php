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
                      <th width="30%"><?php echo $this->lang->line('product_product_name'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('product_product_code'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('reports_purchased'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('reports_sold'); ?></th>
                      <th width="10%"><?php echo $this->lang->line('purchase_total').'('.$this->session->userdata('symbol').')'; ?></th>
                      <th width="10%"><?php echo $this->lang->line('reports_profite_title').'('.$this->session->userdata('symbol').')'; ?></th>
                    </tr>
                </thead>
                  <tbody>
                  <?php 
                      foreach ($data as $row) {
                    ?>
                          <tr>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->code; ?></td>
                            <td><?php echo $row->pquantity; ?></td>
                            <td>
                              <?php 
                                ($row->squantity!=null)? $s = $row->squantity : $s = '0';
                                echo $s;
                              ?>
                            </td>
                            <td align="right">
                              <?php
                                ($row->sptotal!=null)? $s = $row->sptotal: $s = '0';
                                echo round($s);
                              ?>
                            </td>
                            <td align="right">
                              <?php
                                ($row->profit!=null)? $s = $row->profit: $s = '0';
                                echo round($s);
                              ?>
                            </td>
                          </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
              