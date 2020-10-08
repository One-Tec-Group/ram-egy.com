<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>RAM Warehouse | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition ">

  <div class="login-box">
    <div class="login-logo">
      <?php
        $data = $this->db->get('company_settings')->row();
        if($data!=""){
          if($data->logo){
      ?>
        <b> <img src="<?php echo base_url($data->logo); ?>" width="50%"/></b><?php } else{?><img src="<?php echo base_url(); ?>/assets/images/logo.png" width="50%"/><?php }?><br><h5><?php if(isset($data->site_short_name)){  echo $data->site_short_name;}else{ echo "Accounting | Billing | Inventory Management System";} ?></h5>
      <?php }else{
      ?>
        <b> <img src="<?php echo base_url(); ?>/assets/images/logo2.png" width="50%"/></b><br><h5>Accounting | Billing | Inventory Management System</h5>
      <?php
        }
      ?>
    </div>
    <!-- /.login-logo -->

    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <div id="infoMessage"><?php echo $message;?></div>
      <!-- <form action="../../index2.html" method="post"> -->
      <?php echo form_open("auth/login");?>
        <div class="form-group has-feedback">
          <!-- <input type="email" class="form-control" placeholder="Email"> -->
          <?php echo form_input($identity,'','class="form-control" placeholder="Email"');?>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <!-- <input type="password" class="form-control" placeholder="Password"> -->
          <?php echo form_input($password,'','class="form-control" placeholder="Password"');?>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label>
                <!-- <input type="checkbox"> --> Remember Me
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button> -->
            <?php echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-success btn-block btn-flat"');?>
          </div>
          <!-- /.col -->
        </div>
      <?php echo form_close();?>

      <!-- </form> -->

      <!-- <a href="#">I forgot my password</a><br> -->
      <a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
     <!--  <a href="register.html" class="text-center">Register a new membership</a> -->
      <br><br><br>
      <div class="col-xs-4"></div>
        </div>
    <!-- /.login-box-body -->
  </div>

<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url();?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
