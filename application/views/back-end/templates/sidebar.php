<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if($session['Id_Tipo_Rol'] == 1){ ?> 
            <img src="<?= base_url('public/uploads/usuarios/thumbnail/'.$session['Ruta_Imagen'])?>" class="img-circle" alt="User Image">
          <?php }else{?>
            <img src="<?=$session['Ruta_Imagen']?>" class="img-circle" alt="User Image">
          <?php }?>
        </div>
        <div class="pull-left info">
          <?php if($session['Id_Tipo_Rol'] == 1){ ?> 
            <p><?=$session['Nombres']." ".$session['Ap_Paterno']?></p>
          <?php }else{?>
            <p><?=$session['Nombres']." ".$session['Apellidos']?></p>
          <?php }?>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <?php if(isset($session["permisos"]["BI"])){ ?>
        <li>
          <a href="<?=base_url('bi')?>">
            <i class="fa fa-dashboard"></i> <span>INICIO</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["MIBI"])){ ?>
        <li>
          <a href="<?=base_url('mibi')?>">
            <i class="fa fa-dashboard"></i> <span>INICIO</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["AGEN"])){ ?>
        <li>
          <a href="<?=base_url('agenda')?>">
            <i class="fa fa-calendar"></i> <span>AGENDA</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["MIAGEN"])){ ?>
        <li>
          <a href="<?=base_url('miagenda')?>">
            <i class="fa fa-calendar"></i> <span>MI AGENDA</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["COTI"])){ ?>
        <li>
          <a href="<?=base_url('cotizaciones')?>">
            <i class="fa fa-file-text-o"></i> <span>COTIZACIONES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["MISCOTI"])){ ?>
        <li>
          <a href="<?=base_url('miscotizaciones')?>">
            <i class="fa fa-file-text-o"></i> <span>MIS COTIZACIONES</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["CONT"])){ ?>
        <li>
          <a href="<?=base_url('contactos')?>">
            <i class="fa fa-users"></i> <span>CONTACTOS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["SHROO"])){ ?>
        <li>
          <a href="<?=base_url('showroom')?>">
            <i class="fa fa-video-camera"></i> <span>SHOWROOM</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
        <?php if(isset($session["permisos"]["BLOG"])){ ?>
        <li>
          <a href="<?=base_url('bloger/loginWP')?>">
            <i class="fa fa-wordpress"></i> <span>BLOG</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
         <?php if(isset($session["permisos"]["CAMP"])){ ?>
        <li>
          <a href="<?=base_url('campanas')?>">
            <i class="fa fa-bullhorn"></i> <span>CAMPAÑA LS</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php }?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>