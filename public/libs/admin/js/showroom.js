var app = angular.module("app-showroom",[]);
  app.controller("slides",function($scope) {
  $scope.slide = 1;
});

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
      url: base_url+"showroom/muestraShowroom"
    },
    columns: [
        { data: "Ruta_Imagen",
          render: function ( data, type, full, meta ) {
            return "<img src='"+base_url+"public/uploads/showroom/"+data+"' class='img-responsive'/>";
          }
        },
        { data: "Titulo" },
        { data: "Id_Video" },
        { data: "Id_Showroom",
          render: function ( data, type, full, meta ) {
           return "<a class='btn btn-success btn-flat btn-edit'>\
            <i class='fa fa-pencil'></i>\
          </a>\
          <input type='hidden' class='Id_Showroom' value='"+data+"'/>\
          <a class='btn btn-danger btn-flat btn-delete'>\
            <i class='fa fa-trash'></i>\
          </a>";
        }
      },
    ]
  });

  $("#frmshowroom").validate({
    rules: {
      txturl:{
        required:true,
        maxlength:300,
        url: true
      },
    },
    submitHandler: function(form) {
      $.ajax({
        data: $("#frmshowroom").serialize(),
        url: base_url+"showroom/guardarShowroom",
        type: "post",
        beforeSend:function(){
          $("#frmshowroom .spinner").css("opacity",1);
          able("frmshowroom",0);
        },
        success: function(html){
          msj = html.substring(0,4);
          if(msj === "_er:"){
            $("#frmshowroom .spinner").css("opacity",0);
            able("frmshowroom",1);
            swal({   
              title: "Algo salió mal",   
              html: html.substring(4),   
              type: "error",   
              confirmButtonText: "Aceptar" 
            });
          }else if(msj === "_ok:"){
            $("#tbllistado").DataTable().ajax.reload();
            toastr.success(html.substring(4))
            $("#frmshowroom").resetear();
            $("#to-listado").click();
            $("#tbllistado").DataTable().ajax.reload();
          }          
        }
      })
    }
  });
});

// Traer datos al formulario de edición
$(document).on("click",".btn-edit",function(){
  Id_Showroom = $(this).next(".Id_Showroom").val();
  $.ajax({
    url: base_url+"showroom/mostrarShowroomByID",
    type: "post",
    data: "Id_Showroom="+Id_Showroom,
    dataType: "json",
    success:function(data){
      $("#frmshowroom .Id_Showroom").val(data.Id_Showroom);
      $("#frmshowroom input[name=txturl]").val(data.Id_Video);
      $("#to-formulario").click();
    }
  })
});

// Elimina registro
$(document).on("click",".btn-delete",function(){
  Id_Showroom = $(this).prev(".Id_Showroom").val();
  swal({
    title: "Espera un momento",
    text: "¿Estas seguro que quieres eliminar este registro?",   
    type: "warning",   
    confirmButtonText: "Si",
    showCancelButton: true,
    cancelButtonText: "No",   
  }).then(function () {
    $.ajax({
      url: base_url+"showroom/eliminarShowroom",
      type: "post",
      data: "Id_Showroom="+Id_Showroom,
      success:function(html){
        if(html.substring(0,4) === "_er:"){
          swal({   
            title: "Algo salió mal",   
            html: html.substring(4),   
            type: "error",   
            confirmButtonText: "Aceptar" 
          });
        }else if(html.substring(0,4) === "_ok:"){
          toastr.success(html.substring(4))
          $("#tbllistado").DataTable().ajax.reload();
        }
      }
    })
   }, function (dismiss) {
    toastr.info("O.K.! Continuemos...");
  });
});

// Resetea los formularios
$(document).on("click",".form-botones button.resetear",function(){
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
  $("#frmshowroom").resetear();
});


