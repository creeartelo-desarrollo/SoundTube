<div class="content-wrapper" ng-app="app-agenda" ng-controller="slides">
    <!-- slider 1 -->
    <div ng-show="slide==1">
      <section class="content-header">
        <h1>
          AGENDA
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> INICIO</a></li>
          <li><a href="#"> AGENDA</a></li>
        </ol>
      </section>
      <section class="content">
        <div style="width: 90%; margin:0 auto">
          <div style="overflow: hidden; margin: 2% 0;">
            <button class="btn btn-primary btn-rounder pull-right" ng-click="slide=2" id="to-formulario">
              <i class="fa fa-plus"></i>
            </button>
          </div>            
          <div id="calendar"></div>
        </div>         
      </section>
    </div>
    <!-- slider 2 -->
    <div ng-show="slide==2">
      <section class="content-header">
        <h1>
          AGENDA
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?=base_url('bi')?>"><i class="fa fa-dashboard"></i> INICIO</a></li>
          <li><a ng-click="slide=1"> AGENDA</a></li>
          <li><a href="#"> NUEVO</a></li>
        </ol>
      </section>
      <section class="content">
        <div style="width: 90%; margin:0 auto">
          <button class="btn btn-primary btn-rounder pull-right" ng-click="slide=1" id="to-listado">
            <i class="fa fa-chevron-left"></i>
          </button>          
          <form id="frmevento" class="formularios-crud">
            <input type="hidden" name="Id_Evento">
            <div class="spinner">Trabajando...</div>
            <div class="col-lg-6 col-md-6">
              <label>CONTACTO</label>
              <select class="form-control" name="cmbcontactos" id="cmbcontactos">
                <option value="0">Indefinido</option>
                <?php foreach ($contactos as $c => $value) { ?>
                    <option value="<?= $value['Id_Contacto'] ?>"><?= $value['Nombres'] . ' ' . $value['Apellidos'] ?></option>
                <?php   }     ?>
              </select>
            </div>
            <div class="col-lg-6 col-md-6">
              <label>NOMBRE DEL SOLICITANTE</label>
              <input type="text" class="form-control" name="txtnombre">
              </select>
            </div>
             <div class="col-lg-6 col-md-6">
              <label>TELÉFONO</label>
              <input type="text" class="form-control" name="txttelefono">
            </div>
            <div class="col-lg-6 col-md-6">
              <label>CORREO ELECTRÓNICO</label>
              <input type="text" class="form-control" name="txtemail">
            </div>            
            <div class="col-lg-6 col-md-6">
              <label>TIPO DE SERVICIO</label>
              <select class="form-control" name="cmbtservicio" id="cmbtservicio">
                <?php foreach ($tservicios as $s => $value) { ?>
                    <option value="<?= $value['Id_Cat_Tipo_Evento'] ?>"><?= $value['Nombre'] ?></option>
                <?php   }     ?>
              </select>
            </div>
            <div class="col-lg-6 col-md-6">
              <label>SALA</label>
              <select class="form-control" name="cmbsalas" id="cmbsalas">
                <?php foreach ($salas as $s => $value) { ?>
                    <option value="<?= $value['Id_Cat_Sala'] ?>"><?= $value['Nombre'] ?></option>
                <?php   }     ?>
              </select>
            </div>
            <div class="col-lg-6 col-md-6">
              <label>FECHA DE INICIO SOLICITADA</label>
              <input type="text" class="form-control" id="txtfinicio" name="txtfinicio">
            </div>
            <div class="col-lg-6 col-md-6">
              <label>FECHA FIN SOLICITADA</label>
              <input type="text" class="form-control" id="txtffin" name="txtffin">
            </div> 
            <div class="col-lg-6 col-md-6">
              <label>ESTATUS</label> <br>
              <div class="radio3 radio-check radio-success radio-inline">
                <input type="radio" id="optstatus1" name="optstatus" value="1" checked="checked">
                <label for="optstatus1">Activo</label>
              </div>
              <div class="radio3 radio-check radio-danger radio-inline">
                <input type="radio" id="optstatus0" name="optstatus" value="0">
                <label for="optstatus0">Inactivo</label>
              </div>
            </div>          
            <div class="col-lg-12 col-md-12">
              <label>OBSERVACIONES</label>
              <textarea class="form-control" name="txaobservaciones"></textarea>
            </div>
            <div class="form-botones">
              <button type="button" class="resetear btn btn-danger btn-flat">
                <i class="fa fa-times-circle-o"></i>
                Cancelar
              </button>
              <button class="btn btn-primary btn-flat" type="submit">
                <i class="fa fa-check-circle-o"></i>
                Guardar
              </button>
            </div>
          </form>
        </div>
      </section>
    </div>
    <!-- slider 3 -->
  </div>

  <!-- Modal -->
  <div class="modal" id="evento-detalle">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Evento</h4>
        </div>
        <div class="modal-body" id="show-evento-detalle" style="padding: 0">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>