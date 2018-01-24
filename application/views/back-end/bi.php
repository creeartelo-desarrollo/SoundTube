  <div class="content-wrapper" ng-app="app-bi" ng-controller="slides">
    <!-- PRINCIPAL -->
    <div ng-show="slide==1">  
      <section class="content-header">
        <h1>
          INICIO
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        </ol>
      </section>
      <section class="content">
        <!-- CONTADORES -->
        <div class="row" style="overflow: hidden;">
          <!-- CONTACTOS -->
          <a href="<?=base_url('contactos')?>">
            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">CONTACTOS</span>
                  <span class="info-box-number"><?=$cont_conts?></span>
                </div>
              </div>
            </div>
          </a>
          <!-- COTIZACIONES -->
          <a href="<?=base_url('cotizaciones')?>">  
            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-file-text-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">COTIZACIONES</span>
                  <span class="info-box-number"><?=$cont_cotis?></span>
                </div>
              </div>
            </div>
          </a>
          <!-- EVENTOS AGENDADOS -->
          <a href="<?=base_url('agenda')?>">
            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">EVENTOS AGENDADOS</span>
                  <span class="info-box-number"><?=$cont_agen?></span>
                </div>
              </div>
            </div>
          </a>
        </div>
        <!-- GRAFICAS -->
        <div class="row" style="overflow: hidden;">
          <form class="col-md-6 col-sm-6 col-xs-12" id="frmfiltroeventos">
            <h3>NO. EVENTOS AGENDADOS</h3>
            <div class="col-lg-4 col-md-4">
              <label>INICIO</label>
              <input type="text" class="form-control" id="txtfinicio" name="txtfinicio" value="<?=date("Y-m-01")?>">
            </div>
            <div class="col-lg-4 col-md-4">
              <label>FIN</label>
              <input type="text" class="form-control" id="txtffin" name="txtffin" value="<?= date("Y-m-d")?>">
            </div> 
            <button type="button" class="btn btn-primary btn-flat" style="margin-top: 25px" id="btn-filtro-eventos">FILTRAR</button>
            <div style="height: 500px;">
              <canvas id="cnveventos"></canvas>
            </div>
          </form>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <h3>
              VISITAS
              <button class="btn-primary pull-right" type="button" ng-click="slide=3">
                <i class="fa fa-bars"></i>
              </button>
            </h3>
            <div id="mapa-visitas" style="height: 500px; width: 500px"></div>
          </div>
        </div>
        <!-- TABLAS  -->
        <div class="row" style="overflow: hidden;">
          <!-- CONTACTOS CON MAYOR INTERACCION-->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <h3>
              CONTACTOS CON MAYOR INTERACCIÓN 
              <button class="btn-primary pull-right" type="button" ng-click="slide=2">
                <i class="fa fa-bars"></i>
              </button>
            </h3>
            <ul class="list-group">
                <?php foreach ($top_contactos as $tc) { ?>
                  <li class="list-group-item">
                    <span class="badge"><?= $tc["Total"] ?></span>
                    <?= $tc["Nombres"] ." " . $tc["Apellidos"] ?>
                  </li>
                <?php } ?>        
            </ul>
          </div>
          <!-- SERVICIOS MAS COTIZADOS-->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <h3>SERVICIOS MÁS COTIZADOS</h3>
            <?php foreach ($top_cotizados as $tp) { ?>
              <li class="list-group-item">
                <span class="badge"><?= $tp["Score"] ?></span>
                <?= $tp["Pregunta"] ?>
              </li>
            <?php } ?>    
          </div>
          <!-- SERVICIOS MAS AGENDADOS-->
          <div class="col-md-4 col-sm-6 col-xs-12">
            <h3>SERVICIOS MÁS AGENDADOS</h3>
            <?php foreach ($top_agendados as $ta) { ?>
              <li class="list-group-item">
                <span class="badge"><?= $ta["Score"] ?></span>
                <?= $ta["Tipo_Evento"] ?>
              </li>
            <?php } ?>    
          </div>
        </div>
      </section>
    </div>
    <!-- DETALLE CONTACTOS -->
    <div ng-show="slide==2">  
      <section class="content-header">
        <h1>
          INICIO
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a ng-click="slide=1">Contactos con mayor interacción</a></li>
        </ol>
      </section>
      <section class="content">
          <div style="width: 90%; margin: 0 auto">  
            <button type="button" class="btn btn-primary btn-rounded pull-right" ng-click="slide=1">
              <i class="fa fa-chevron-left"></i>
            </button>
            <table id="tbllistado">
              <thead>
                <tr>
                  <td>Contacto</td>
                  <td>Número de cotizaciones</td>
                  <td>Número de eventos</td>
                  <td>Total</td>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <td>Contacto</td>
                  <td>Número de cotizaciones</td>
                  <td>Número de eventos</td>
                  <td>Total</td>
                </tr>
              </tfoot>
            </table>
          </div>
      </section>
    </div>
    <!-- DETALLE VISITAS -->
    <div ng-show="slide==3">  
      <section class="content-header">
        <h1>
          INICIO
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li><a ng-click="slide=1">Visitas</a></li>
        </ol>
      </section>
      <section class="content" style="overflow: hidden;">
        <form class="col-md-6 col-xs-12" id="frmfiltrovisitas">
          <h3>VISITAS</h3>
          <div class="col-lg-4 col-md-4">
            <label>INICIO</label>
            <input type="text" class="form-control" id="txtfiniciov" name="txtfinicio" value="<?=date("Y-m-01")?>">
          </div>
          <div class="col-lg-4 col-md-4">
            <label>FIN</label>
            <input type="text" class="form-control" id="txtffinv" name="txtffin" value="<?= date("Y-m-d")?>">
          </div> 
          <button type="button" class="btn btn-primary btn-flat" style="margin-top: 25px" id="btn-filtro-visitas">FILTRAR</button>
        </form>
        <div class="col-lg-12" style="clear: both;">  
          <button type="button" class="btn btn-primary btn-rounded pull-right" ng-click="slide=1">
            <i class="fa fa-chevron-left"></i>
          </button>
          <table id="tblvisitas">
            <thead>
              <tr>
                <td>Fecha</td>
                <td>Pais</td>
                <td>Región</td>
                <td>Ciudad</td>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td>Fecha</td>
                <td>Pais</td>
                <td>Región</td>
                <td>Ciudad</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </section>
    </div>
</div>
