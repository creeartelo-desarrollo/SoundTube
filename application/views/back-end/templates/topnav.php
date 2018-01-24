 <header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url() ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?=base_url('public/libs/admin/img/'.$config['LOGOMIN'])?>" alt="SoubdTube" style="max-width: 70%" ></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?=base_url('public/libs/admin/img/'.$config['LOGO'])?>" alt="SoubdTube" style="max-width: 70%" ></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav"> 
          <?php if(isset($session["permisos"]["NOTY"]) || isset($session["permisos"]["MISNOTY"] )){ ?>
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning" id="num-notys"><?= sizeof($notys) ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">Tienes <?= sizeof($notys) ?> notificaciones</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <?php foreach ($notys as $n) { ?>
                      <li>
                        <a href="#">
                          <?= $n["Mensaje"] ?> 
                        </a>
                        <input type="hidden" class="Id_Notificacion" value="<?= $n['Id_Notificacion']?>">
                        <i class="fa fa-check pull-right set-leido" title="Marcar como leído"></i>
                      </li>
                    <?php } ?>                    
                  </ul>
                </li>
                <li class="footer"><a href="<?= base_url('misnotificaciones')?>">Ver todos</a></li>
              </ul>
            </li>
          <?php } ?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if($session['Id_Tipo_Rol'] == 1){ ?> 
                <img src="./public/uploads/usuarios/thumbnail/<?=$session['Ruta_Imagen']?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?=$session['Nombres']." ".$session['Ap_Paterno']?></span>
              <?php }else{?>
                <img src="<?=$session['Ruta_Imagen']?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?=$session['Nombres']." ".$session['Apellidos']?></span>
              <?php }?>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              <?php if($session['Id_Tipo_Rol'] == 1){ ?> 
                <img src="./public/uploads/usuarios/thumbnail/<?=$session['Ruta_Imagen']?>" class="img-circle" alt="User Image">
                <p>
                  <?=$session['Nombres']." ".$session['Ap_Paterno']?>
                </p>
              <?php }else{?>
                <img src="<?=$session['Ruta_Imagen']?>" class="img-circle" alt="User Image">
                <p>
                  <?=$session['Nombres']." ".$session['Apellidos']?>
                </p>
              <?php }?>               
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" data-toggle="modal" data-target="#mdlcontrasena">CAMBIAR CONTRASEÑA</a>
                  <?php if($session['Id_Tipo_Rol'] == 1){ ?> 
                    <a href="<?=base_url('admin/logout')?>" class="btn btn-default btn-flat">CERRAR SESIÓN</a>
                  <?php }else{?>
                   <a href="<?=base_url('welcome/logout')?>" class="btn btn-default btn-flat">CERRAR SESIÓN</a>
                  <?php }?>     
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>