$(function(){
  mostrarCotizaciones();
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
      url: base_url+"miscotizaciones/eliminarCotizacion",
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
function mostrarCotizaciones(){
  $("#tbllistado").DataTable({
    responsive: true,
    columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 }
    ],
    language: {
      url: base_url+"public/libs/DataTables/json/spanish.json",
    },
    ajax:{
      url: base_url+"miscotizaciones/muestraCotizaciones"
    },
    columns: [
        { data: "Folio" },
        { data: "Fecha" },
        { data: "Id_Cotizacion", 
          render: function ( data, type, full, meta ) {
          return "<a class='btn btn-success btn-flat' href='"+base_url+"miscotizaciones/genPDF/"+full.Folio+"' target='_blank'>\
            <i class='fa fa-paperclip'></i>\
          </a>\
          <input type='hidden' class='Id_Cotizacion' value='"+data+"'/>\
          <a class='btn btn-danger btn-flat btn-del-reg' target='_blank'>\
            <i class='fa fa-trash'></i>\
          </a>";
        }
      },
    ]
  });
}

