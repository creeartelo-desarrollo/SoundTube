<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_url('public/libs/bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('public/libs/admin/css/AdminLTE.min.css')?>">
  <!-- check3 -->
  <link rel="stylesheet" href="<?=base_url('public/libs/check3/css/checkbox3.min.css')?>">
  <style type="text/css">
    #videobg{
      width: auto;
      height: auto;
      min-width: 100%;
      min-height: 100%;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translateX(-50%) translateY(-50%);
      z-index: -1;
    }
  </style>
</head>
<body class="hold-transition login-page">
<video autoplay  poster="<?=base_url('public/front/images/poster.jpg') ?>" id="videobg" loop>
    <source src="<?=base_url('public/front/images/video.mp4') ?>" type="video/mp4">
</video>
<div class="login-box">
  <div class="login-logo">
    <img src="<?=base_url('public/front/images/logo.png')?>" alt="">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <form action="../../index2.html" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>- O -</p>
      <a href="<?=$login_url?>" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Inicia sesión con Facebook</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="#">Olvidé mi contraseña</a><br>
    <a href="register.html" class="text-center">Registrarme</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?=base_url('public/libs/jQuery/js/jquery-2.2.3.min.js')?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url('public/libs/bootstrap/js/bootstrap.min.js')?>"></script>
</script>
</body>
</html>
