
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Welcome to Ram Gymnastics</title>
        <link rel="icon" href="http://ram-egy.com/uploads/untitled_1_UFJ_icon.ico" type="image/png">
        <link rel="stylesheet" href="<?= base_url("assets/login/fontawesome/css/font-awesome.min.css"); ?>">
        <link rel="stylesheet" href="<?= base_url("assets/login/toastr.min.css"); ?>">
        <link rel="stylesheet" href="<?= base_url("assets/login/bootstrap.min.css"); ?>" id="bscss">
        <link rel="stylesheet" href="<?= base_url("assets/login/app.min.css"); ?>" id="maincss">
        <script src="<?= base_url("assets/login/jquery/dist/jquery.min.js"); ?>"></script>
    </head>
    <style>
        body {
            background-color: #ffffff;
        }
        .left-login {
            height: auto;
            min-height: 100%;
            /* background: #fff; */
            background: rgb(235,33,136);
            background: linear-gradient(180deg, rgba(235,33,136,1) 0%, rgba(8,10,82,1) 90%);
            -webkit-box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
            -moz-box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
            box-shadow: 2px 0px 7px 1px rgba(0, 0, 0, 0.08);
        }
        .left-login-panel {
            -webkit-box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
            -moz-box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
            box-shadow: 0px 0px 28px -9px rgba(0, 0, 0, 0.74);
        }
        .login-center {
            background: #fff;
            width: 400px;
            margin: 0 auto;
        }
        @media only screen and (max-width: 380px) {
            .login-center {
                width: 320px;
                padding: 10px;
            }
            .wd-xl {
                width: 260px;
            }
        }
    </style>
    <body >
        <div class="col-lg-4 col-sm-6 left-login">
            <div class="wrapper col-lg-10" style="margin: 20% 0 0 auto">
                <div class="block-center mt-xl wd-xl login-form-div">
                    <div class="text-center" style="margin-bottom: 20px">
                        <img style="width: 100%;" src="<?= base_url("uploads/images/ram-gym-logo.png"); ?>" class="m-r-sm">
                    </div>
                    <div class="error_login">
                    </div>
                    <form data-parsley-validate="" novalidate="" method="post">
                        <div class="form-group has-feedback">
                            <input type="text" name="username" required="true" class="form-control" placeholder="Username"/>
                            <span class="fa fa-envelope form-control-feedback text-white"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" name="password" required="true" class="form-control" placeholder="Password"/>
                            <span class="fa fa-lock form-control-feedback text-white"></span>
                        </div>
                        <div class="clearfix">
                            <div class="checkbox c-checkbox pull-left mt0">
                                <label><input type="checkbox" value="" name="remember"><span class="fa fa-check"></span>Remember Me</label>
                            </div>
                            <div class="pull-right"><a href="http://ram-egy.com/login/forgot_password" class="text-muted">Forgot password?</a></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat pull-right">Sign in <i class="fa fa-arrow-right"></i></button>
                    </form>
                    <br/><br/>
                    <div class="p-lg text-center">
                        <span style="color:#FFF;">&copy;</span>
                        <span><a style="color:#FFF;"> Ram For Sport Service's</a></span>
                        <br/>
                        <span><?= (date("Y")-1) . "-" . date("Y");?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <div class="col-lg-8 col-sm-6 hidden-xs" style="
              background: #080A52;
              background: url(http://ram-egy.com//uploads/ce2f4431288385_564a2fe33c51c.jpg) no-repeat center center fixed;
             -webkit-background-size: cover;
             -moz-background-size: cover;
             -o-background-size: cover;
             background-size: cover;min-height: 100%;">
        </div>

        <script src="<?= base_url("assets/login/toastr.min.js"); ?>"></script>
        <script src="<?= base_url("assets/login/bootstrap/dist/js/bootstrap.min.js"); ?>"></script>
        <script src="<?= base_url("assets/login/jQuery-Storage-API/jquery.storageapi.min.js"); ?>"></script>
        <script src="<?= base_url("assets/login/parsleyjs/parsley.min.js"); ?>"></script>
    </body>
</html>
