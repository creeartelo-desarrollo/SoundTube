<!-- BEGIN CONTENT-->
<div class="content-wrapper">
  <div class="content-header nombre-modulo">
    <h2><i class="fa fa-users"></i> CONTACTOS</h2>
  </div>
  <section ng-controller="slides">
    <div class="row">
      <!-- Section header -->
      <div class="content-header">
        <ol class="breadcrumb">
          <li><a href="<?=base_url('bi')?>"><i class="fa fa-home"></i> INICIO</a></li>
          <li><a href="#">CONTACTOS </a></li>
        </ol>
      </div>
      <!-- Section body -->
      <div class="content">
        <div id="show-listado" class="panel">
          <div class="panel-heading">
            <div class="panel-title">LISTADO DE CONTACTOS</div>
          </div>
          <div class="panel-body">
            <table id="tbllistado">
              <thead>
                <tr>
                  <td>Nombres</td>
                  <td>Correo Electrónico</td>
                  <td>Estatus</td>
                  <td>Opciones</td>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <td>Nombres</td>
                  <td>Correo Electrónico</td>
                  <td>Estatus</td>
                  <td>Opciones</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>    
      </div>
    </div>
  </section>       
</div>

<!-- MODAL DETALLE -->
<div class="modal" id="modal-detalle">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">CONTACTO</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>