$(window).on("load", function () {  
    obtenerIdUsuario();
    $("#publicaciones").addClass("active");
    //obtenerDatos();
});

function obtenerIdUsuario() {
	
 $.ajax({
  url: "../backend/perfilAdmin.php",
  // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
  method: "GET",
  dataType: "json",
  success: function (respuesta) {
   //console.log(respuesta);
  $("#idUsuario").val(respuesta.idUsuario);
  obtenerDatos(respuesta.idUsuario);
 	//codigo=respuesta.idUsuario;
  },
  error: function (error) {
   console.log(error)
  }
 });
}

function obtenerDatos(idUsuario) {
    var codigo = idUsuario;
    //var codigo = 4;
    //console.log('Este es mi codigo: '+codigo);
    $.ajax({
        url: "../backend/gestionAgregarPub.php",
        data: `accion=obtenerAnuncio`+"&idPersona=" + codigo,
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            var contenidoU='';
            var contenido='';
          if (respuesta.length>0) {
            // statemen
            
            contenido+='<div id="anunciosM" class="row">';
            for (var i = 0; i<respuesta.length; i++){
              contenido+='<div  class="col-md-3 col-12 py-1">'+
             '<div class="card" style="width: 18rem;"><div id="imgAnuncio'+respuesta[i].idAnuncios+'">';
             //'<!--img src="../imgCate/micro3.jpg" class="card-img-top" alt="..."-->';
             obtenerFotosANuncio(respuesta[i].idAnuncios);
             contenido+='</div><div class="card-body">'+
               '<h5 class="card-title">'+respuesta[i].titulo+'</h5>'+
               '<p class="card-text">'+respuesta[i].descripcion+'</p>'+
               '<a href="editarPublicacion.php?idAnuncio='+respuesta[i].idAnuncios+'" class="btn btn-outline-success"><i class="fas fa-pencil-alt fa-1x" ></i></a>'+
               '&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-outline-danger" onclick="eliminarPublicacion('+respuesta[i].idAnuncios+');"><i class="fas fa-trash-alt fa-1x" ></i></button>'+
             '<p id="pRazones'+respuesta[i].idAnuncios+'" style="display:none"><br><spam style="color:red">*</spam>Razon eliminar anuncio:<textarea name="razon" id="razon'+respuesta[i].idAnuncios+'" class="form-control" rows="3"></textarea><br><button type="button" class="btn btn-outline-danger" onclick="eliminar('+respuesta[i].idAnuncios+');">Dar de Baja</button></p><br><p id="msj'+respuesta[i].idAnuncios+'" class="alert alert-danger" style="display:none">Mensaje</p></div></div></div>';

            }
            contenido+='</div>';
            $("#anunciosM").remove();
            $("#anuncios").append(contenido);
          } else {
            // statement
            contenidoU='<div id="anunciosM" class="col-md-12 alert alert-secondary" role="alert">'+
  										'<center> NO TIENE PUBLICACIONES!'+'</center></div>';
            $("#anunciosM").remove();
            $("#anuncios").append(contenidoU);
          }
            
            
        },
        error: function (error) {
            console.log(error)
        }
    });
}

function eliminar(idAnuncio){
  var codigo = idAnuncio;
  var razon=$('#razon'+codigo+'').val();
  alert(codigo+'  '+razon);

   $.ajax({
        url: "../backend/gestionAgregarPub.php",
        data: `accion=eliminarAnuncio`+"&idAnuncio=" + codigo+"&razones="+razon,
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            $("#pRazones"+codigo+"").fadeOut();
            if (respuesta[0].mensaje=="Eliminado exitosamente") {
              // statement
              $("#msj"+codigo+"").html(respuesta[0].mensaje);
              $("#msj"+codigo+"").fadeIn();
              $("#msj"+codigo+"").fadeOut(4000, function(){
                obtenerIdUsuario();
              });
              
            } else {
              // statement
              $("#msj"+codigo+"").html('No se puede eliminar este anuncio');
              $("#msj"+codigo+"").fadeIn();
              $("#msj"+codigo+"").fadeOut(2000);
            }
        },
        error: function (error) {
            console.log(error)
        }
    });
  
}

function eliminarPublicacion(idAnuncio){
	 $("#pRazones"+idAnuncio+"").fadeIn();
}

function obtenerFotosANuncio(idAnuncio){
  var idAnuncios =idAnuncio; 
    //var url = $('#url');
    //console.log('Persona: '+idPersona);

    $.ajax({
        url: "../backend/gestionAgregarPub.php",
        data: `accion=obtenerFotos` + "&idAnuncio=" + idAnuncio,
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            var contenidoD='';
            var contenido='';
            if (respuesta.length>0) {
              // statement
              contenido='<img src="../'+respuesta[0].urlFoto+'" class="card-img-top" alt="...">';
              $("#imgAnuncio"+idAnuncios+"").append(contenido);
            } else {
              // statement
              contenidoD='<img src="../imgCate/refri3.jpg" class="card-img-top" alt="...">';
              console.log('No hay fotos');
              $("#imgAnuncio"+idAnuncios+"").append(contenidoD);
            }
        },
        error: function (error) {
            console.log(error)
        }
    });
}

