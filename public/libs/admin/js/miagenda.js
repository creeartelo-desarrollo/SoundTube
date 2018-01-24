var app = angular.module("app-agenda",[]);
  app.controller("slides",function($scope) {
  $scope.slide = 1;
});

$("#calendar").fullCalendar({
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay',
    locale: 'es'
  },
  events: base_url+'miagenda/mostrarEventos',
  eventClick: function(calEvent, jsEvent, view) {
    Id_Evento = calEvent.id;
    $.ajax({
      url: base_url+"miagenda/mostrarEventoDetalle",
      data:{
        Id_Evento: Id_Evento,
        side: "back",
      },
      type: "post",
      beforeSend: function(){
      },
      success:function(html){
        $("#show-evento-detalle").html(html);
      }
    })
    $('#evento-detalle').modal('show');    
  }
});
// INICIALIZACION DE LOS PICKERS
  d = new Date();
  $("#txtfinicio").datetimepicker({
      dateFormat: "yy-mm-dd",
      timeFormat: "HH:mm",
      showSecond: false,
      showMillisec: false,
      minDate: new Date(d.getFullYear(), d.getMonth(), d.getDate()),
      language: "es",
      onSelect: function (selectedDate) {
        $("#txtffin").datepicker("option", 'minDate', selectedDate);
      }
  });
 $("#txtffin").datetimepicker({
    dateFormat: "yy-mm-dd",
    timeFormat: "HH:mm",
    showSecond: false,
    showMillisec: false,
    minDate: new Date(d.getFullYear(), d.getMonth(), d.getDate()),
    language: "es",
  });
 /*  =======================================
     VALIDACIONES
  */ 
$(function(){
  $("#frmevento").validate({
    rules: {
      txtnombre:{
        required:true,
        maxlength:50
      },
      cmbtservicio:{
        required:true,
        min:0
      },
      txttelefono:{
        required:true,
        maxlength:45
      },
      txtemail:{
        required:true,
        maxlength:200
      },
      txtfinicio:{
        required:true,
        date: true
      },
      txtffin:{
        required:true,
        date:true,
      },
      txaobservaciones:{
        maxlength:255
      },
    },
    submitHandler: function(form) {
      $.ajax({
        data: $("#frmevento").serialize(),
        url: base_url+"miagenda/guardarEvento",
        type: "post",
        beforeSend:function(){
          $("#frmevento .spinner").css("opacity",1);
          able("frmevento",0);
        },
        success: function(html){
          console.log(html)
          msj = html.substring(0,4);
          $("#frmevento .spinner").css("opacity",0);
          able("frmevento",1);
          if(msj === "_er:"){
            swal({   
              title: "Algo salió mal",   
              html: html.substring(4),   
              type: "error",   
              confirmButtonText: "Aceptar" 
            });
            $("#calendar").fullCalendar('refetchEvents');
          }else if(msj === "_ok:"){
            toastr.success(html.substring(4))
            $("#frmevento").resetear();
            $("#to-listado").click();
          }          
        }
      })
    }
  });
})

$(document).on("click",".btn-edit-reg",function(){
  Id_Evento = $(this).prev(".Id_Evento").val();
  $.ajax({
    url: base_url+"miagenda/mostrarEvento",
    data: "Id_Evento="+Id_Evento,
    type: "post",
    dataType: "json",
    success: function(data){
      $("#frmevento [name=Id_Evento]").val(data.Id_Evento);
      $("#frmevento [name=txtnombre]").val(data.Nombre);
      $("#frmevento [name=cmbtservicio]").val(data.Id_Cat_Tipo_Evento);
      $("#frmevento [name=txttelefono]").val(data.Telefono);
      $("#frmevento [name=txtemail]").val(data.Correo_Electronico);
      $("#frmevento [name=txttelefono]").val(data.Telefono);
      $("#frmevento [name=txtffin]").val(data.Fecha_Fin);
      $("#frmevento [name=txaobservaciones]").val(data.Observaciones);
      $("#evento-detalle").modal("hide");
      $("#to-formulario").click()
    }
  })
})

$(document).on("click",".btn-del-reg",function(){
  Id_Evento = $(this).next(".Id_Evento").val();
  swal({
    title: "Espera un momento",
    text: "¿Estás seguro que quieres eliminar este evento?",
    type: "warning",
    showCancelButton: true,
    cancelButtonText: "No",
    confirmButtonText: "Si",
    confirmButtonClass: 'btn btn-primary mi-btn',
    cancelButtonClass: 'btn btn-danger mi-btn',
    buttonsStyling: false
  }).then(function () {
    $.ajax({
      url: base_url+"miagenda/eliminarEvento",
      data: "Id_Evento="+Id_Evento,
      type: "post",
      success: function(html){
        if(html.substring(0,4) == "_ok:"){
          toastr.success("Se ha eliminado el evento");
          $("#evento-detalle").modal("hide");
          $("#calendar").fullCalendar('refetchEvents');
        }else{
          swal(
            "Uh oh!",
            "No hemos podido eliminar el evento, intenta recargar la página",
            "error"
          )
        }
      }
    })
  }, function (dismiss) {
    toastr.info("O.K. Continuemos...");
  })
});

// Resetea los formularios
$(document).on("click","form button.resetear",function(){
  swal({
    title: "Espera un momento",
    text: "¿Estas seguro que quieres abandonar tu registro?",   
    type: "warning",   
    confirmButtonText: "Si",
    showCancelButton: true,
    cancelButtonText: "No",   
  }).then(function () {
    $("#to-listado").click();
    toastr.info("Se ha abandonado la captura de tu registro");
  }, function (dismiss) {
    toastr.info("O.K.! Continuemos...");
  });
});

// Limpia los formularios par un nuevo registro
$(document).on("click","#to-listado",function(){
  $("#frmevento").resetear();
});