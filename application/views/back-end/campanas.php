<!-- BEGIN CONTENT-->
<div class="content-wrapper">
  <div class="content-header nombre-modulo">
    <h2><i class="fa fa-file-text-o"></i> CAMPAÑA LS</h2>
  </div>
  <section ng-controller="slides">
    <!-- SLIDE 1 - LISTADO-->
    <div class="row">
      <!-- Section header -->
      <div class="content-header">
        <ol class="breadcrumb">
          <li><a href="<?=base_url('bi')?>"><i class="fa fa-home"></i> INICIO</a></li>
          <li><a href="#">MENSAJES </a></li>
        </ol>
      </div>
      <!-- Section body -->
      <div class="content">
        <div id="show-listado" class="panel">
          <div class="panel-heading">
            <div class="panel-title">LISTADO DE MENSAJES</div>
          </div>
          <div class="panel-body">
            <table id="tbllistado">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Correo Electrónico</th>
                  <th>Fecha</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Correo Electrónico</th>
                  <th>Fecha</th>
                  <th>Opciones</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>    
      </div>
    </div>
  </section>       
</div>



<div class="modal fade" id="modal-detalle">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalle de Contacto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>