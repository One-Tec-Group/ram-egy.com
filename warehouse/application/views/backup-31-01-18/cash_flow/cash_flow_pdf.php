<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$p = array('admin','accountant','manager');
if(!(in_array($this->session->userdata('type'),$p))){
  redirect('auth/dashboard');
}
?> 
<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/logo23.png'); ?>" />
  <title>Invento | Dashboard</title>
</head>
<body>
  <table width="100%" border="0" style="font-family: arial;">
    <tr>
      <td align="center" style="font-size: 18px">Cash Flow</td>
    </tr>
  </table>
  <br><br>
  <table border="1" width="100%" style="font-family: arial;" cellspacing="0" cellpadding="0">
     <thead>
      <tr>
        <th><?php echo $this->lang->line('product_no'); ?></th>
        <th>To Account</th>
        <th>From Account</th>
        <th>Amount</th>
      </tr>
  </thead>
    <tbody>
    <?php
      $i =1;
      foreach ($data as $row) {
    ?>
      <tr>
        <td align="center" style="padding: 2px;"><?php echo $i; ?></td>
        <td><?php echo $row->to_account; ?></td>
        <td><?php echo $row->from_account; ?></td>
        <td align="right"><?php echo round($row->amount); ?></td>
      </tr>
    <?php
        $i++;
      }
    ?>
    </tbody>
  </table>
</body>
</html>
              