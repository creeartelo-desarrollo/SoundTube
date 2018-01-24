$(function(){
  mostrarNotificaciones();
})

$(document).on("click",".btn-del-reg",function(){
  var Id_Cotizacion = $(this).prev(".Id_Cotizacion").val();
  swal({
    title: 'Espera un momento!',
    text: "Estás seguro de querer eliminar este registro?",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si',
    cancelButtonText: 'No',
    confirmButtonClass: 'btn btn-flat btn-primary',
    cancelButtonClass: 'btn btn-flat btn-danger',
    buttonsStyling: false
  }).then(function () {
    $.ajax({
      url: base_url+"misnotificaciones/eliminarCotizacion",
      data: "Id_Cotizacion="+Id_Cotizacion,
      type: "post",
      success:function(html){
        if(html.substring(0,4) === "_ok:"){
          toastr.success(html.substring(4))
          $("#tbllistado").DataTable().ajax.reload();
        }else{
           swal({   
            title: "Algo salió mal",   
            html: html.substring(4),
            type: "error",   
            confirmButtonText: "Aceptar" 
          });
        }
      }
    })
  }, function (dismiss) {
    toastr.success("Ok. Continuemos...")       
  })
})


// Funciones
function mostrarNotificaciones(){
  $("#tbllistado").DataTable({
    responsive: true,
    columnDefs: [
        { responsivePriority: 1, targets: 1 },
        { responsivePriority: 2, targets: -1 }
    ],
    language: {
      url: base_url+"public/libs/DataTables/json/spanish.json",
    },
    ajax:{
      url: base_url+"misnotificaciones/muestraNotificaciones"
    },
    columns: [
        { data: "Fecha_Envio" },
        { data: "Mensaje" },
        { data: "Id_Notificacion", 
          render: function ( data, type, full, meta ) {
            var opciones = "";
            if(full.Leido == 1){
              opciones += "<a class='btn-mark-noty' target='_blank' title='Marcar como leido'>\
                <i class='fa fa-close'></i>\
              </a>"
            }else if(full.Leido == 0){
              opciones += "<a class='btn-unmark-noty' target='_blank' title='Demarcar como leido'>\
                <i class='fa fa-check'></i>\
              </a>"
            }
            opciones += "<input type='hidden' class='Id_Notificacion' value='"+data+"'/>\
            <a class='btn-del-noty' target='_blank'>\
              <i class='fa fa-trash'></i>\
            </a>";
          return opciones;
        }
      },
    ]
  });
}
// Marcar como leida
$(document).on("click",".btn-mark-noty",function(){
  Id_Notificacion = $(this).next(".Id_Notificacion").val();
  marcarStatus(Id_Notificacion,0);
})
// Desmarcar de leida
$(document).on("click",".btn-unmark-noty",function(){
  Id_Notificacion = $(this).next(".Id_Notificacion").val();
  marcarStatus(Id_Notificacion,1);
})

// Actualiza tabla
// Si se marca como leida una notificación desde el topmenu, se actualiza la tabla
$(document).on("click",".notifications-menu .set-leido",function(){
  $("#tbllistado").DataTable().ajax.reload();
});
// Elimina notificación
$(document).on("click",".btn-del-noty",function(){
  Id_Notificacion = $(this).prev(".Id_Notificacion").val();
  var menunoty = $(".notifications-menu .Id_Notificacion[value="+Id_Notificacion+"]");
  $.ajax({
    url: base_url+"misnotificaciones/eliminarNoty",
    data:"Id_Notificacion="+Id_Notificacion,
    type: "post",
    success: function(html){
       if(html.substring(0,4) == "_ok:"){
        toastr.success(html.substring(4));
        $("#tbllistado").DataTable().ajax.reload();
        actualizaNotys("resta")
        menunoty.closest("li").remove();
      }else if(html.substring(0,4) == "_er:"){
        swal({   
          title: "Algo salió mal",   
          html: html.substring(4),
          type: "error",   
          confirmButtonText: "Aceptar" 
        });
      }
    }
  })
})

// Marcar / Desmarcar Notificación de leida
function marcarStatus(Id_Notificacion,Status){
  var menunoty = $(".notifications-menu .Id_Notificacion[value="+Id_Notificacion+"]");
  $.ajax({
    url: base_url+"misnotificaciones/marcarNoty",
    data:{
      Id_Notificacion: Id_Notificacion,
      Status: Status,
    },
    type: "post",
    success: function(html){
       if(html.substring(0,4) == "_ok:"){
        toastr.success(html.substring(4));
        $("#tbllistado").DataTable().ajax.reload();
        if(Status == 1){
          actualizaNotys("suma")
        }else if(Status == 0){
          actualizaNotys("resta")
        }
        
        menunoty.closest("li").remove();
      }else if(html.substring(0,4) == "_er:"){
        swal({   
          title: "Algo salió mal",   
          html: html.substring(4),
          type: "error",   
          confirmButtonText: "Aceptar" 
        });
      }
    }
  })
}