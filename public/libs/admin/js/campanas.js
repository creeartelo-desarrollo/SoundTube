// Funciones
$(function(){
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
      url: base_url+"campanas/muestraCampana"
    },

    columns: [
        { data: "Nombre" },
        { data: "Correo_Electronico" },
        { data: "Fecha" },
        { data: "Id_Datos_Promo", 
          render: function ( data, type, full, meta ) {
          return "<button type='button' class='btn btn-success btn-flat btn-detalle'>\
            <input type='hidden' class='Id_Datos_Promo' value='"+data+"'/>\
            <i class='fa fa-bars'></i>\
          </button>";
        }
      },
    ]
  })
});


// ABRE DETALLE DEL CONTACTO
$(document).on("click",".btn-detalle",function(){
  Id_Datos_Promo = $(this).find(".Id_Datos_Promo").val();
  $("#modal-detalle").modal("show");
  $.ajax({
    url: base_url+"campanas/muestraDetalle",
    data: "Id_Datos_Promo="+Id_Datos_Promo,
    type: "post",
    beforeSend:function(){
      $("#modal-detalle .modal-body").html("<div class='spinner' style='opacity:1'>Trabajando...</div>");
    },
    success:function(html){
       $("#modal-detalle .modal-body").html(html);
    }
  })
});