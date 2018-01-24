<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$config["NAME"]?> | Iniciar sesión</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_url('public/libs/bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('public/libs/admin/css/AdminLTE.css')?>">
  <!-- check3 -->
  <link rel="stylesheet" href="<?=base_url('public/libs/toastr/css/toastr.min.css')?>">
  <style type="text/css">
    #bgvideo{
      width: auto;
      height: auto;
      min-width: 100%;
      min-height: 100%;
      top: 0%;
      left: 0%;
      position: fixed;
    }
    #cortina-negra{
      background-color: rgba(0,0,0,0.7);
      width: 100%;
      position: absolute;
      height: 100%;
      top: 0;
      left: 0;
    }
    span.titulo{
      font-weight: 900;
      color: #fff;
    }
    a.abreforogot{
      color: #fff;
      float: right;
      font-size: 16px;
      cursor: pointer;
    }
    .modal {
      color: #fff;
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>
<body class="hold-transition login-page">
<video id="bgvideo" poster="<?=base_url('public/libs/front/images/prueba1.jpg')?>" id="bgvid" playsinline autoplay muted loop>
  <source src="<?=base_url('public/libs/front/images/prueba1.webm')?>" type="video/webm">
</video>
<div id="cortina-negra"></div>
<div class="login-box">
  <div class="login-logo">
    <img src="<?=base_url('public/libs/front/images/'.$config['LOGO'])?>" alt="">
    <span class="titulo">ADMINISTRADOR</span>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <form action="<?=base_url('admin/login')?>" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Usuario" name="txtusuario">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" name="pswcontrasena">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="social-auth-links text-center">
        <button href="#" class="btn btn-primary btn-flat btn-block" type="submit">Ingresar</button>
        <a class="abreforogot" data-toggle="modal" data-target="#mdlcontrasena">Olvidé mi contraseña</a>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- MODAL FORGOT PASSWORD -->
<div class="modal fade" id="mdlcontrasena">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿Olvidaste tu contraseña?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="formularios-crud" id="frmforgot">
        <p>Ingresa tu correo electrónico y te enviaremos una contraseña nueva</p>
        <div class="modal-body">
          <label>Correo electrónico</label>
          <input type="email" class="form-control" name="txtemail">
          <div class="spinner">Trabajando...</div>        
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" id="btnpsw">Enviar</button>
          <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="<?=base_url('public/libs/jQuery/js/jquery-2.2.3.min.js')?>"></script>
<script src="<?=base_url('public/libs/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('public/libs/toastr/js/toastr.min.js')?>"></script>
<!-- JQuery-Validator -->
<script src="<?=base_url('public/libs/jquery-validation/js/jquery.validate.min.js')?>"></script>
<script src="<?=base_url('public/libs/jquery-validation/js/localization/messages_es.js')?>"></script>
<script src="<?=base_url('public/libs/admin/js/app.min.js')?>"></script>
<script type="text/javascript">
  base_url = "<?=base_url()?>"
  toastr.options = {
    "positionClass":"toast-top-full-width",
    "closeButton":true,
    "showDuration":330,
    "hideDuration":330
  }
  $(function()
  {
    <?php
      $msn = $this->session->flashdata("msn");
      $msne = $this->session->flashdata("msne");
      if(isset($msn)){
        echo "toastr.success('".$msn."')";          
      }
      if(isset($msne)){
        echo "toastr.error('".$msne."')";        
      }
    ?>
  });

  // Validación de formulario de recuperación de contraseña
$("#frmforgot").validate({
    rules: {
      txtemail:{
        required:true,
        email: true
      },
    },
    submitHandler: function() {
      $.ajax({
        data: $("#frmforgot").serialize(),
        url: base_url+"admin/recuperarContrasena",
        type: "post",
        beforeSend: function(){
          $("frmforgot .spinner").css("opacity",1);
          able("frmforgot",0);
        },
        success: function(html){
          $("#frmforgot .spinner").css("opacity",0);
          able("frmforgot",1);
          if(html.substring(0,4) === "_er:"){
            toastr.error(html.substring(4));
          }else if(html.substring(0,4) === "_ok:"){
            toastr.success(html.substring(4));
            $("#frmforgot").resetear();
            $("#mdlcontrasena").modal("hide");
          }          
        }
      })
    }
});
</script>
</script>
</body>
</html>
