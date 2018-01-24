<!-- BEGIN CONTENT-->
<div class="content-wrapper">
  <div class="content-header nombre-modulo">
    <h2><i class="fa fa-video-camera"></i> SHOWROOM</h2>
  </div>
  <section ng-app="app-showroom" ng-controller="slides">
    <!-- SLIDE 1 - LISTADO-->
    <div class="row" ng-show="slide==1">
      <!-- Section header -->
      <div class="content-header">
        <ol class="breadcrumb">
          <li><a href="<?=base_url('bi')?>"><i class="fa fa-home"></i> INICIO</a></li>
          <li><a href="#">SHOWROOM </a></li>
        </ol>
      </div>
      <!-- Section body -->
      <div class="content">
        <div id="show-listado" class="panel">
          <div class="panel-heading">
            <div class="panel-title">LISTADO DE SHOWROOM</div>
            <button class="btn btn-primary btn-rounder pull-right" ng-click="slide=2" id="to-formulario">
              <i class="fa fa-plus"></i>
            </button>
          </div>
          <div class="panel-body">
            <table id="tbllistado">
              <thead>
                <tr>
                  <td>Imágen</td>
                  <td>Título</td>
                  <td>ID YouTube</td>
                  <td>Opciones</td>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <td>Imágen</td>
                  <td>Título</td>
                  <td>ID YouTube</td>
                  <td>Opciones</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>    
      </div>
    </div>

     <!-- SLIDE 1 - LISTADO-->
    <div class="row" ng-show="slide==2">
      <!-- Section header -->
      <div class="content-header">
        <ol class="breadcrumb">
          <li><a href="<?=base_url('bi')?>"><i class="fa fa-home"></i> INICIO</a></li>
          <li><a href="#">SHOWROOM </a></li>
          <li><a href="#">FORMULARIO NUEVO / EDICIÓN </a></li>
        </ol>
      </div>
      <!-- Section body -->
      <div class="content">
        <div class="panel-heading">
          <div class="panel-title">FORMULARIO</div>
          <button class="btn btn-primary btn-rounder pull-right" ng-click="slide=1" id="to-listado">
            <i class="fa fa-chevron-left"></i>
          </button>
        </div>
        <div class="panel-body">
          <form class="formularios-crud" id="frmshowroom">
            <input type="hidden" class="Id_Showroom" name="Id_Showroom">
            <div class="spinner">Trabajando...</div>
            <div class="form-gorup">
              <label>URL YouTube</label>
              <input type="text" class="form-control" name="txturl">
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
      </div>
    </div>
  </section>   
</div>