// Funciones
$(function(){
  mostrarContactos();
})


function mostrarContactos(){
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
      url: base_url+"contactos/muestraContactos"
    },

    columns: [
        { data: "Nombres" },
        { data: "Correo_Electronico" },
        { data: "Estatus",
           render: function ( data, type, full, meta ) {
            if(data == 1)
              return "<span class='activo'>activo</span>";
            else
              return "<span class='inactivo'>inactivo</span>"
           }
        },
        { data: "Id_Contacto", 
          render: function ( data, type, full, meta ) {
          return "<a class='btn btn-success btn-flat btn-show-det'>\
            <i class='fa fa-id-card'></i>\
          </a>\
          <input type='hidden' class='Id_Contacto' value='"+data+"'/>";
        }
      },
    ]
  })
}

$(document).on("click",".btn-show-det",function(){
  var Id_Contacto =  $(this).next(".Id_Contacto").val();
  $.ajax({
    url: base_url+"contactos/showDetalle",
    data: "Id_Contacto="+Id_Contacto,
    type:"post",
    beforeSend: function(){
      $("#modal-detalle .modal-body").html();
    },
    success: function(html){
      $("#modal-detalle").modal("show")
      $("#modal-detalle .modal-body").html(html);
    }
  });
});

$(document).on("change","input[name='optstatus']",function(){
  $.ajax({
    url: base_url+"contactos/modificarContacto",
    data: $("#frmcontacto").serialize(),
    type: "post",
    success: function(html){
      if(html.substring(0,4) == "_ok:"){
        toastr.success(html.substring(4));
        $("#tbllistado").DataTable().ajax.reload();
      }else if(html.substring(0,4) == "_er:"){
        swal({   
          title: "Algo salió mal",   
          html: true,
          text: html.substring(4),   
          type: "error",   
          confirmButtonText: "Aceptar" 
        });
      }
    }
  })
});
