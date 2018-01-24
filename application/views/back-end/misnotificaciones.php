<!-- BEGIN CONTENT-->
<div class="content-wrapper">
  <div class="content-header nombre-modulo">
    <h2><i class="fa fa-bell"></i> NOTIFICACIONES</h2>
  </div>
  <section ng-controller="slides">
    <!-- SLIDE 1 - LISTADO-->
    <div class="row">
      <!-- Section header -->
      <div class="content-header">
        <ol class="breadcrumb">
          <li><a href="<?=base_url('bi')?>"><i class="fa fa-home"></i> INICIO</a></li>
          <li><a href="#">NOTIFICACIONES </a></li>
        </ol>
      </div>
      <!-- Section body -->
      <div class="content">
        <div id="show-listado" class="panel">
          <div class="panel-heading">
            <div class="panel-title">LISTADO DE NOTIFICACIONES</div>
          </div>
          <div class="panel-body">
            <table id="tbllistado">
              <thead>
                <tr>
                  <td>Fecha</td>
                  <td>Mensaje</td>
                  <td>Opciones</td>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <td>Fecha</td>
                  <td>Mensaje</td>
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