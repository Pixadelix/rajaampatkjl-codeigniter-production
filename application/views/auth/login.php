<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo ucwords(strtolower(PROJECT_NAME)); ?> | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        .login-logo,
        .login-logo a {
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        .login-logo img {
            width: 100%;
            margin-bottom: 48px;
        }
		.login-page {
            background: url(<?php echo base_url(COVER_LOGIN_PAGE); ?>) !important;
            background-size: cover !important;
        }

        .login-box-body {
            background: rgba(0, 0, 0, .6) !important;
            box-shadow: 1px 1px 3px 1px rgba(0, 0, 0, 0.25);
            color: #fff !important;
        }

        .login-box-body a {
            color: #0ff;
        }
		
		.color-overlay {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			-webkit-box-shadow: inset 0 0 100px 100px rgba(0,0,0,.6);
			box-shadow: inset 0 0 100px 100px rgba(0,0,0,.6);
		}
		
		

    </style>
    <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/bootstrap.min.css'); ?>">

    <!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"-->
    <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/plugins/iCheck/all.css'); ?>">
    <link rel="shortcut icon" href="/favico.ico">
    <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/skins/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('/assets/static/adminlte/css/rajaampat.css'); ?>">
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page skin-blue">
	<div class="color-overlay">
            <?php // echo analytics_tracking(); ?>
            <div class="login-box">
                <div class="login-logo">
                    <img src="<?php echo base_url(LOGO_300);?>"><br/>
                </div>

                <!-- /.login-logo -->
                <div class="login-box-body">
                    <p class="login-box-msg">
                        <?php // echo info_message(); ?>
                    </p>

                    <form action="<?php echo base_url('/user/auth/login'); ?>" method="post">
                        <div class="form-group has-feedback">
                            <input id="identity" name="identity" class="form-control" placeholder="Username">
                            <span class="fa fa-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                            <span class="fa fa-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="checkbox icheck">
                                    <label>
              <input id="remember" name="remember" type="checkbox" value="1"> Remember Me
            </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <a href="<?php echo base_url('/user/auth/forgot_password'); ?>">I forgot my password</a><br>

                </div>
                <!-- /.login-box-body -->
            </div>
            <!-- /.login-box -->


            <script src="<?php echo base_url('/assets/static/adminlte/js/jquery-2.2.4.min.js'); ?>"></script>
            <script src="<?php echo base_url('/assets/static/adminlte/js/bootstrap.min.js'); ?>"></script>
            <script src="<?php echo base_url('/assets/static/adminlte/js/icheck.min.js'); ?>"></script>
            <script>
                $(function() {
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-purple',
                        radioClass: 'iradio_square-purple',
                        increaseArea: '20%' // optional
                    });
                });

            </script>
	</div>
</body>

</html>
