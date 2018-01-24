$(window).load(function(){
  $("#preloader").hide();
})

jQuery.fn.resetear = function () {
  $(this).each (function() { this.reset(); });
  $(this).find("input[type='hidden']").val("");
}
// INICIALIZACIONES   
// Facebook API
window.fbAsyncInit = function() {
  FB.init({
    appId      : '156170141532103',
    cookie     : false,  
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.8' // use graph api version 2.8
  });
};

  // Date Pickers
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
// Full Calendar
$("#calendar").fullCalendar({
 height: 600,
  header: { 
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay',  
  },
  events: base_url+'welcome/mostrarEventos',
  eventClick: function(calEvent, jsEvent, view) {
    Id_Evento = calEvent.id;
    $.ajax({
      url: base_url+"miagenda/mostrarEventoDetalle",
      data:{
        Id_Evento: Id_Evento,
        side: "front",
      },
      type: "post",
      beforeSend: function(){
      },
      success:function(html){
        $("#evento-detalle").html(html);
      }
    })
    $('#ventana-detalle').css("transform","translateX(100%)");    
  }
});
// Validación del formulario de alta de evento
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
        maxlength:200,
        email: true
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
        beforeSend: function(){
          $("#frmevento .spinner").css("opacity",1);
          able("frmevento",0);
        },
        success: function(html){
          $("#frmevento .spinner").css("opacity",0);
          able("frmevento",1);
          msj = html.substring(0,4);
          if(msj === "_er:"){
            fade("error",html.substring(4));
            $("#calendar").fullCalendar('rerenderEvents');
          }else if(msj === "_ok:"){
            fade("success",html.substring(4));
            $("#frmevento").resetear();
          }          
        }
      })
    }
});

// Validación de los formularios de contacto
$("#frmcontacto").validate({
    rules: {
      txtnombre:{
        required:true,
        maxlength:50
      },
      txttelefono:{
        required:true,
        maxlength:45
      },
      txtemail:{
        required:true,
        maxlength:200,
        email: true
      },
      txamensaje:{
        maxlength:255,
        required:true
      },
    },
    submitHandler: function(form) {
      $.ajax({
        data: $("#frmcontacto").serialize(),
        url: base_url+"welcome/sendMailContacto",
        type: "post",
        beforeSend: function(){
          $("#frmcontacto .spinner").css("opacity",1);
          able("frmcontacto",0);
        },
        success: function(html){
          $("#frmcontacto .spinner").css("opacity",0);
          able("frmcontacto",1);
          msj = html.substring(0,4);
          if(msj === "_er:"){
            fade("error",html.substring(4));
          }else if(msj === "_ok:"){
            fade("success",html.substring(4));
            $("#frmcontacto").resetear();
          } 
        }
      })
    }
});

$("#frmcontactowe").validate({
    rules: {
      txtnombre:{
        required:true,
        maxlength:50
      },
      txttelefono:{
        required:true,
        maxlength:45
      },
      txtemail:{
        required:true,
        maxlength:200,
        email: true
      },
      txamensaje:{
        maxlength:255,
        required:true,
      },
    },
    submitHandler: function(form) {
      $.ajax({
        data: $("#frmcontactowe").serialize(),
        url: base_url+"welcome/sendMailContacto",
        type: "post",
        beforeSend: function(){
          $("#frmcontactowe .spinner").css("opacity",1);
          able("frmcontactowe",0);
        },
        success: function(html){
          $("#frmcontactowe .spinner").css("opacity",0);
          able("frmcontactowe",1);
          msj = html.substring(0,4);
          if(msj === "_er:"){
            fade("error",html.substring(4));
          }else if(msj === "_ok:"){
            fade("success",html.substring(4));
            $("#frmcontactowe").resetear();
          } 
        }
      })
    }
});

// Validación del formulario de login
$("#frmlogin").validate({
    rules: {
      txtemail:{
        required:true,
        email: true
      },
      pswcontrasena:{
        required:true,
      },
    },
    submitHandler: function() {
      $.ajax({
        data: $("#frmlogin").serialize(),
        url: base_url+"welcome/login",
        type: "post",
        beforeSend: function(){
          $("frmlogin .spinner").css("opacity",1);
          able("frmlogin",0);
        },
        success: function(html){
          $("#frmlogin .spinner").css("opacity",0);
          able("frmlogin",1);
          if(html.substring(0,4) === "_er:"){
            fade("error",html.substring(4));
          }else if(html.substring(0,4) === "_ok:"){
            fade("success",html.substring(4));
            location.reload();
          }          
        }
      })
    }
});

// Validación del formulario de registro
$("#frmregistro").validate({
    rules: {
      txtemail:{
        required:true,
        email: true,
        maxlength: 150
      },
      txtnombres:{
        required:true,
        maxlength: 150,
      },
      txtapellidos:{
        required:true,
        maxlength: 150,
      },
      cmbsexo:{
        required:true,
        maxlength: 1,
      },
      txtfecha_nacimiento:{
        required:true,
        dateISO: true,
      },
      pswcontrasena:{
        required:true,
        minlength: 6,
        maxlength:12,
      },
      pswcontrasenaconf:{
        required:true,
        minlength: 6,
        maxlength:12,
        equalTo: "#pswcontrasena"
      },
    },
    submitHandler: function() {
      $.ajax({
        data: $("#frmregistro").serialize(),
        url: base_url+"welcome/registro",
        type: "post",
        beforeSend: function(){
          $("#frmregistro .spinner").css("opacity",1);
          able("frmregistro",0);
        },
        success: function(html){
          $("#frmregistro .spinner").css("opacity",0);
          able("frmregistro",1);
          if(html.substring(0,4) === "_er:"){
            fade("error",html.substring(4));
          }else if(html.substring(0,4) === "_ok:"){
            fade("success",html.substring(4));
            location.reload();
          }          
        }
      })
    }
});

// Validación de formulario de recuperación de contraseña
$("#frmforgot").validate({
    rules: {
      txtemail:{
        required:true,
        email: true
      },
    },
    submitHandler: function() {
      $.ajax({
        data: $("#frmforgot").serialize(),
        url: base_url+"welcome/recuperarContrasena",
        type: "post",
        beforeSend: function(){
          $("#frmforgot .spinner").css("opacity",1);
          able("frmforgot",0);
        },
        success: function(html){
          $("#frmforgot .spinner").css("opacity",0);
          able("frmforgot",1);
          if(html.substring(0,4) === "_er:"){
            fade("error",html.substring(4));
          }else if(html.substring(0,4) === "_ok:"){
            fade("success",html.substring(4));
            $("#frmforgot").resetear();
            $("#frmforgot .regresar").click();
          }          
        }
      })
    }
});
// cierra todo
$(document).on("click","#logotipo",function(){
  $(".contenidos").css("transform","translate(0,0)")
});
// abre registro
$(document).on("click","#openregistrarme",function(){
  $("#frmlogin").css("transform","translateX(-100%)");
  $("#frmregistro").css("transform","translate(0)");
});
// regresa desde registro
$(document).on("click","#frmregistro .regresar",function(){
  $("#frmlogin").css("transform","translateX(0%)");
  $("#frmregistro").css("transform","translateX(100%)");
});
// abre olvidé mi contraseña
$(document).on("click","#openforgot",function(){
 $("#frmforgot").css("transform","translateX(100%)");
 $("#frmlogin").css("transform","translateX(100%)");
});
// regresa desde olvidé mi contraseña
$(document).on("click","#frmforgot .regresar",function(){
 $("#frmforgot").css("transform","translate(0%)");
 $("#frmlogin").css("transform","translate(0%)");
});
// reinicia todo login
$(document).on("click","#ventana-login span.close",function(){
  $("#ventana-login .regresar").click();
  $("#ventana-login form").resetear();
  $(".completa").hide();
});

// Escribiendo soundtube
var i = 0;
setInterval(function(){
  i++;
  if(i == 4){
    $("#escribiendo").html("SoundTube está escribiendo");
    i = 0;
  }else{
    $("#escribiendo").append(".");
  }
},300);
// Agrega clase para distorsionar mensaje
$(function(){
  setInterval(function(){
    $(".contenidos .mensaje h2").addClass("distorsionado");
    setTimeout(function(){
      $(".contenidos .mensaje h2").removeClass("distorsionado");
    }, 3000);
  },9000);
});

// DESPLIEGUE DE VENTANAS
// Abre Ventana Login
$(document).on("click",".login",function(){
  $("#ventana-login").css({transform: "translateY(0%)"})
});
// Abre servicios
$(document).on("click","#menuservicios li a", function(){
  servicio = $(this).attr("class")
  $(".servicios").css({transform: "translateX(0%)"});
  $("#"+servicio).css({transform: "translateX(-100%)"});
  $("#menuservicios li a").each(function(){
    $(this).removeClass("active");
    $(this).find("svg circle").show();
    // Regresa menu (EN RESPONSIVO A LA DERECHA)
    $("#menuservicios.mobile").css("right","-1000px");
    
  })
  $(this).addClass("active");
  $(this).find("svg circle").hide();  
})
// Abre Cotizador
$(document).on("click",".show-cotizador",function(){
  $(".contenidos").css({transform: "translate(0,0)"});
  $("#cotizador").css({transform: "translateY(100%)"});
  $("#conversacion").html("");
  data = {Id_Pregunta : 0}
  traerPregunta(data);  
});

// Abre agenda
$(document).on("click",".show-agenda",function(){
  $(".contenidos").css({transform: "translate(0,0)"});
  $("#agenda").css({transform: "translateX(100%)"});
});

// Abre Formulario de Agenda
$(document).on("click",".solicitar-agenda",function(){
  $("#ventana-agendar").css({transform: "translateX(100%)"})
});

// ABRE INICIAR SESIÓN
$(document).on("click",".login",function(){
  $("#ventana-login").css({transform: "translateY(100%)"})
});

// ABRE VENTANA DE CONTACTO
$(document).on("click",".contacto",function(){
  $(".contenidos").css({transform: "translate(0,0)"});
  $("#ventana-contacto").css({transform: "translateY(100%)"});
});

// ABRE FORMULARIO DE CONTACTO NOSOTROS (MOBIL)
$(document).on("click","#toformwe",function(){
  $("#contacto .rec-mapa").addClass("open")
});
// ABRE FORMULARIO DE CONTACTO  (MOBIL)
$(document).on("click","#frmcontacto button[type=reset], #frmcontactowe button[type=reset]",function(){
  $(this).closest(".rec-mapa").removeClass("open")
});

// CIERRA FORMULARIO DE CONTACTO  (MOBIL)
$(document).on("click","#toform",function(){
  $("#ventana-contacto .rec-mapa").addClass("open")
});
// ABRE NOSOTROS
$(document).on("click","#mnunosotros",function(){
  $("#nosotros").css({transform: "translateY(100%)"});
});
// ABRE SHOWROOM
$(document).on("click","#mnushowsroom",function(){
  $("#showroom").css({transform: "translateY(-100%)"});
});
// Cierra menu servicios
$(document).on("click","#menuservicios span.close",function(){
  $("#menuservicios.mobile").css("right","-1000px");  
})
// Cierra los .ventana
$(document).on("click",".contenidos .close",function(){
  $(this).closest(".contenidos").css({transform: "translate(0%)"})
  $("#menuservicios li a").each(function(){
    $(this).removeClass("active");
    $(this).find("svg circle").show();
  });
  $("#frame").attr("src","");
});
// ABRE VIDEO SHOWROOM
$(document).on("click",".listado-video",function(){
  var video = $(this).attr("data-video");
  var link = "https://www.youtube.com/embed/"+video+"?autoplay=1&wmode=transparent&rel=0&enablejsapi=1&showinfo=0";
  $("#ver-video").css({transform: "translateX(100%)"});
  $("#frame").attr("src",link)
})
// DESAPARECE BOTÓN DE SERVICIOS EN HOVER
$(document).on("mouseenter","#menuservicios ul li a",function(){
  $("#mnuservicios").hide();
  $(this).find("svg circle").attr("r","0");
});
$(document).on("mouseleave","#menuservicios ul li a",function(){
  $("#mnuservicios").show();
  $(this).find("svg circle").attr("r","12");
})
// ABRE MENU SERVICIOS EN MOBIL
$(document).on("click","#mnuserviciosmb",function(){
  $("#menuservicios").css("right",0);
  $("#menuservicios").addClass("mobile");
})
// CONTESTA EN EN LA CONVERSACIÓN CON EL COTIZADOR
$(document).on("click","#conversacion button",function(){
    if($(this).closest("form").valid()) {
      var data = $(this).closest("form").serialize();     
      traerPregunta(data);

      $(this).closest("form").find("[name='Id_Pregunta']").prop('disabled', true);
      $(this).closest("form").find("img.regresar").remove();
      $(this).remove();
    }
});

$(document).on("click","img.regresar",function(){
  $(this).closest("form").prev(".turno-servidor").prev(".turno-cliente").remove();
  $(this).closest("form").prev(".turno-servidor").remove();
  $(this).closest("form").remove();
  $.ajax({
    url: base_url+"welcome/descotizar",
    success:function(html){
      $("#conversacion").append(html);
      var h = $("#cotizador")[0].scrollHeight
      $("#conversacion").scrollTop(h); 
    }
  })
});

// ABRE PDF DE LA ÚLTIMA COTIZACIÓN
$(document).on("click",".eport-pdf",function(){
  $("#cotizador").css({transform: "translateY(100%)"})
  window.open(base_url+"welcome/genPDF")
});
// ABRE AGENDAR
$(document).on("click",".ir-agenda",function(){
  $("#cotizador").css({transform: "translateY(0%)"})
  $("#agenda").css({transform: "translateX(100%)"})
});
// LIMPIA COTIZACIÓN
$(document).on("click",".nueva-cot",function(){
  $("#conversacion").html("");
  data = {Id_Pregunta : 0}
  traerPregunta(data);
});

// FUNCIONES
// facebook data login
function fbData(accion) {
   FB.login(function() {
   FB.api('/me', {fields: 'id,name,gender,email,picture,first_name,last_name,age_range,link,locale,timezone,updated_time,verified,birthday'},function(response) {
    if(response && !response.error){
        var birthday = "";
        var email    = "";
        if(response.email){
          email = response.email;
        }
        if(response.birthday){
          var d = new Date(response.birthday);
          birthday = d.getFullYear()+ "/" + (d.getMonth() + 1) + "/" + d.getDate();  
        }
          
        // Si es login se envian los datos a php para validarlos
        if(accion == "login"){
          $.ajax({
           data:{
             "nombre": response.first_name,
             "apellidos": response.last_name,
             "email": email,
             "fecha_nacimiento": birthday,
             "genero": response.gender,
             "imagen": response.picture.data.url,
             "origen": "F",
           },
           type: "post",
           url: base_url+"welcome/login",
           beforeSend: function(){
             $("#frmlogin .spinner").css("opacity",1);
           }, 
           success: function(html){
             $("#frmlogin .spinner").css("opacity",0); 
             if(html.substring(0,4) == "_er:"){
               fade("error",html.substring(4));
             }else if(html.substring(0,4) == "_ok:"){
               fade("success",html.substring(4));
               location.reload();
             }
           }
          });
        // Si es registro se envían los datos al formulario de registro
        }else if(accion == "registro"){
          $("#frmregistro input[name='txtemail']").val(email);
          $("#frmregistro input[name='txtfecha_nacimiento']").val(birthday);  
          $("#frmregistro input[name='txtnombres']").val(response.first_name);
          $("#frmregistro input[name='txtapellidos']").val(response.last_name);
          $("#frmregistro select[name='cmbsexo']").val(response.gender);
          $("#frmregistro input[name='imagen']").val(response.picture.data.url);
          $("#frmregistro input[name='origen']").val("F");
          $(".completa").show();
        }
      }else{
        fade("error","Uh oh! Tenemos problemas para conectarnos, intentalo más tarde");
      }
    });
  }, {scope: 'email,user_birthday'});
}

// INICIALIZAR MAPA
  function initMap() {
    var mapOptions = {
      zoom: 14,
      center: new google.maps.LatLng(20.607412999895605, -103.4221201),
      scrollwheel: false,
      zoomControl: false,
      styles: [{"stylers":[{"visibility":"on"},{"saturation":-100},{"gamma":0.54}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#4d4946"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"gamma":0.48}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"gamma":7.18}]}]
    };
    
    var mapElement = document.getElementById('mapa');
    var mapElement2 = document.getElementById('mapa-2');
    var map = new google.maps.Map(mapElement, mapOptions);
    var map2 = new google.maps.Map(mapElement2, mapOptions);
    
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(20.609302, -103.42126300000001),
        map: map,
        icon: base_url+"public/libs/front/images/marker.png",
        title: 'SoundTube'
    });
    
    var marker2 = new google.maps.Marker({
        position: new google.maps.LatLng(20.609302, -103.42126300000001),
        map: map2,
        icon: base_url+"public/libs/front/images/marker.png",
        title: 'SoundTube'
    });

      
      var infowindow = new google.maps.InfoWindow({
        content: "<p style='color:#000'><strong>SoundTube</strong> <br /> Calle Sonora Nº276 <br> Col. El Mante, cp 45235 <br> Zapopan, Jalisco  <br> MÉXICO</p>"
      });

      var infowindow2 = new google.maps.InfoWindow({
        content: "<p style='color:#000'><strong>SoundTube</strong> <br /> Calle Sonora Nº276 <br> Col. El Mante, cp 45235 <br> Zapopan, Jalisco  <br> MÉXICO</p>"
      });

      marker.addListener('click', function() {
        infowindow.open(map, marker);
     });

      marker2.addListener('click', function() {
        infowindow2.open(map2, marker2);
     });

    $(document).on("click","#zoomIn",function(){
        var zi = map.getZoom()
        var zf = zi + 0.5;
        map.setZoom(zf);
        c = map.getCenter();
      })

      $(document).on("click","#zoomOut",function(){
        var zi = map.getZoom()
        var zf = zi - 0.5;
        map.setZoom(zf);
      })

       $(document).on("click","#zoomIn-2",function(){
        var zi = map2.getZoom()
        var zf = zi + 0.5;
        map2.setZoom(zf);
        c = map2.getCenter();
      })

      $(document).on("click","#zoomOut-2",function(){
        var zi = map2.getZoom()
        var zf = zi - 0.5;
        map2.setZoom(zf);
      })
  }

// TRAER PREGUNTA COTIZADOR
function traerPregunta(data){
  $.ajax({
    url:base_url+"welcome/mostrarPregunta",
    type: "post",
    data: data,
    beforeSend:function(){
      $("#escribiendo").show();
    },
    success: function(html){
      setTimeout(function(){
        $("#conversacion").append(html);
        $("#escribiendo").hide();
        var h = $("#cotizador")[0].scrollHeight
        $("#conversacion").scrollTop(h);            
      },3000);          
    },
  })
}

function fade(alert, text, duration){
  duration || ( duration = 6000 );
  $(".alert-"+alert).html(text);
  $(".alert-"+alert).show("bounce",function(){
    setTimeout(function(){
      $(".alert-"+alert).hide("bounce");
    },duration)
  })
}

function able(form,status){
  if(status == 0)
    $("#"+form+" input, #"+form+" input, #"+form+" textarea, #"+form+" button, #"+form+" select").attr("disabled", true);
  else
    $("#"+form+" input, #"+form+" input, #"+form+" textarea, #"+form+" button, #"+form+" select").attr("disabled", false);
}



// facebook sdk
 // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));