var app = angular.module("app-bi",[]);
  app.controller("slides",function($scope) {
  $scope.slide = 1;
});

  // Funciones
$(function(){
  $.ajax({
    url: base_url+"bi/muestraVisitasCiudad",
    dataType: "json",
    success: function(data){
      datamarkers = [];
      for (var i = 0; i < data.length; i++) {
        datamarkers.push({
          latLng: [data[i].Latitud, data[i].Longitud], 
          name: data[i].Ciudad + "(" + data[i].Score + ")" 
        });
      }
      
      $('#mapa-visitas').vectorMap({
        backgroundColor: '#366CB4',
        markerStyle: {
          initial: {
            fill: '#F8E23B',
            stroke: '#383f47'
          }
        },
        markers: datamarkers,
      });
    }
  })

  

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
        url: base_url+"bi/muestraInteraccionContactos"
      },
      columns: [
          { data: "Nombres",
            render: function ( data, type, full, meta ) {
              return full.Nombres + full.Apellidos
            }
          },
          { data: "Numcotis" },
          { data: "Numeventos" },
          { data: "Id_Cotizacion", 
            render: function ( data, type, full, meta ) {
            return parseInt(full.Numeventos) + parseInt(full.Numcotis);
          }
        },
      ]
    });
    
    // $.when( $.ajax( base_url+"bi/muestraInteraccionContactos" )).then(function( data, textStatus, jqXHR ) {
    //   traerVisitas();
    //   $.when( $.ajax( base_url+"bi/muestraVisitasFechas" )).then(function( data, textStatus, jqXHR ) {
    //     traerEventos();
    //   });
    });


// INICIALIZACION DE LOS PICKERS
  // Pickers de eventos
  $("#txtfinicio").datepicker({
      dateFormat: "yy-mm-dd",
      timeFormat: "HH:mm",
      language: "es",
      onSelect: function (selectedDate) {
        var orginalDate = new Date(selectedDate);
        var monthsAddedDate = new Date(new Date(orginalDate).setMonth(orginalDate.getMonth() + 3));
        $("#txtffin").datepicker("option", 'minDate', selectedDate);
      }
  });
  $("#txtffin").datepicker({
    dateFormat: "yy-mm-dd",
    timeFormat: "HH:mm",
    language: "es",
  });

 // Pickers de visitas
  $("#txtfiniciov").datepicker({
      dateFormat: "yy-mm-dd",
      timeFormat: "HH:mm",
      language: "es",
      onSelect: function (selectedDate) {
        var orginalDate = new Date(selectedDate);
        var monthsAddedDate = new Date(new Date(orginalDate).setMonth(orginalDate.getMonth() + 3));
        $("#txtffin").datepicker("option", 'minDate', selectedDate);
      }
  });
 $("#txtffinv").datepicker({
    dateFormat: "yy-mm-dd",
    timeFormat: "HH:mm",
    language: "es",
  });
// Filtra eventos por fechas
$(document).on("click","#btn-filtro-eventos",function(){
  Fecha_Inicio = $("#txtfinicio").val();
  Fecha_Fin    = $("#txtffin").val();
  traerEventos(Fecha_Inicio,Fecha_Fin);
})

$(document).on("click","#btn-filtro-visitas",function(){
  $("#tblvisitas").DataTable().destroy();
  $("#tblvisitas tbody").remove();
  Fecha_Inicio = $("#txtfiniciov").val();
  Fecha_Fin    = $("#txtffinv").val();
  console.log(Fecha_Inicio)
   console.log(Fecha_Fin)
  traerVisitas(Fecha_Inicio,Fecha_Fin);
})
// Funciones
// Trae eventos en un rango de fechas
function traerEventos(Fecha_Inicio,Fecha_Fin)
{
  $.ajax
  ({
    url: base_url+"bi/muestraAgendaEnRango/",
    data: {
      Fecha_Inicio: Fecha_Inicio,
      Fecha_Fin: Fecha_Fin,
    },
    dataType: "json",
    type: "post",
    success: function(data)
    {
      var etiquetas = [];
      var scores = [];
      for(var i = 0; i<data.length; i++)
      {
        mes = data[i].Fecha_Inicio.substring(5,7);
        switch(mes) {
          case "01":
              etiqueta = "Enero";
              break;
          case "02":
              etiqueta = "Febrero";
              break;
          case "03":
              etiqueta = "Marzo";
              break;
          case "04":
              etiqueta = "Abril";
              break;
          case "05":
              etiqueta = "Mayo";
              break;
          case "06":
              etiqueta = "Junio";
              break;
          case "07":
              etiqueta = "Julio";
              break;
          case "08":
              etiqueta = "Agosto";
              break;
          case "09":
              etiqueta = "Septiembre";
              break;
          case "10":
              etiqueta = "Octubre";
              break;
          case "11":
              etiqueta = "Noviembre";
              break;
          case "12":
              etiqueta = "Diciembre";
              break;
        }
        etiqueta += " " + data[i].Fecha_Inicio.substring(0,4);
        etiquetas.push(etiqueta);
        scores.push(data[i].Score);
      }
      
      $(function() 
      {
        var ctx, data, myLineChart, options;
        // Chart.defaults.global.responsive = true;
        ctx = $('#cnveventos').get(0).getContext('2d');
        config = 
        {
          type: 'line',
          data: {
          labels: etiquetas,
          datasets: [
            {
              label: "No. Eventos",
              fill: true,
              backgroundColor: "rgba(26, 188, 156,0.2)",
              borderColor: "#1ABC9C",
              pointBackgroundColor: "#1ABC9C",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "#1ABC9C",
              data: scores,
              responsive: true
            },]
          },
          options:{
            scales: {
              xAxes: [{
                  display: false
              }],

          } 
        }
    
        };
        myLineChart = new Chart(ctx, config);
      });   
    }
  });
}

// Trae visitas en un rango de fechas
function traerVisitas(Fecha_Inicio,Fecha_Fin)
{
  $("#tblvisitas").DataTable({
    responsive: true,
    language: {
      url: base_url+"public/libs/DataTables/json/spanish.json",
    },
    ajax:{
      url: base_url+"bi/muestraVisitasFechas/",
      data:{
        Fecha_Inicio: Fecha_Inicio,
        Fecha_Fin: Fecha_Fin
      },
      type: "post",
    },
    columns: [
      { data: "Fecha_Ejecucion" },
      { data: "Pais" },
      { data: "Region"}, 
      { data: "Ciudad"}
    ]
  })
}

