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
      url: base_url+"cotizaciones/muestraCotizaciones"
    },

    columns: [
        { data: "Folio" },
        { data: "Fecha" },
        { data: "Nombres" },
        { data: "Id_Cotizacion", 
          render: function ( data, type, full, meta ) {
          return "<a class='btn btn-success btn-flat' href='"+base_url+"cotizaciones/genPDF/"+full.Folio+"' target='_blank'>\
            <i class='fa fa-paperclip'></i>\
          </a>\
           <input type='hidden' class='Id_Cotizacion' value='"+data+"'/>";
        }
      },
    ]
  })
});
