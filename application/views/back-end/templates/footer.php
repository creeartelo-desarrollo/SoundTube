  <footer class="main-footer">
     <b>SoundTube</b> multimedia estudios
  </footer>
<!-- MODAL CHANGE PASSWORD -->
<div class="modal fade" id="mdlcontrasena">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">CAMBIAR CONTRASEÑA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="formularios-crud" id="frmpassw">
        <div class="modal-body">
          <label>Nueva contraseña</label>
          <input type="password" class="form-control" name="pswcontrasena" id="pswcontrasena">
          <label>Confirmar contraseña</label>
          <input type="password" class="form-control" name="pswcontrasenaconf">
          <div class="spinner">Trabajando...</div>        
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-flat" id="btnpsw">Guardar</button>
          <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="<?=base_url('public/libs/jQuery/js/jquery-3.1.1.min.js')?>"></script>
<!-- jQueryUI -->
<script src="<?=base_url('public/libs/jquery-ui/js/jquery-ui.min.js')?>"></script>
<!-- Angular -->
<script src="<?=base_url('public/libs/angular/js/angular.min.js')?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_url('public/libs/bootstrap/js/bootstrap.min.js')?>"></script>
<!-- DataTable -->
<script src="<?= base_url('public/libs/DataTables/js/jquery.dataTables.min.js')?>" type="text/javascript"></script>
<!-- DataTable Responsive -->
<script src="<?= base_url('public/libs/DataTables/extensions/Responsive/js/dataTables.responsive.min.js')?>" type="text/javascript"></script> 
<!-- JQuery-Validator -->
<script src="<?=base_url('public/libs/jquery-validation/js/jquery.validate.min.js')?>"></script>
<script src="<?=base_url('public/libs/jquery-validation/js/localization/messages_es.js')?>"></script>
<!-- Sweet Alert -->
<script src="<?=base_url('public/libs/sweetalert/js/sweetalert.min.js')?>"></script>
<!-- Toastr -->
<script src="<?=base_url('public/libs/toastr/js/toastr.min.js')?>"></script>
<!-- SlimScroll -->
<script src="<?=base_url('public/libs/slimScroll/js/jquery.slimscroll.min.js')?>"></script>
<!-- FastClick -->
<script src="<?=base_url('public/libs/fastclick/js/fastclick.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('public/libs/admin/js/app.min.js')?>"></script>
<!-- Full Calendar -->
<script src="<?=base_url('public/libs/fullcalendar/js/moments.js')?>"></script>
<script src="<?=base_url('public/libs/fullcalendar/js/fullcalendar.min.js')?>"></script>
<!-- ChartJS -->
<script src="<?=base_url('public/libs/chart-js/js/Chart.min.js')?>"></script>
<!-- Vector Map -->
<script src="<?=base_url('public/libs/jquery-vectormap/js/jquery-jvectormap-2.0.3.min.js')?>"></script>
<script src="<?=base_url('public/libs/jquery-vectormap/js/jquery-jvectormap-world-mill-en.js')?>"></script>
<script type="text/javascript">base_url = "<?= base_url() ?>" </script>
<script src="<?=base_url('public/libs/admin/js/'.$libs[0].'.js')?>"></script>
</body>
</html>
