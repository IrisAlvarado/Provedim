$(window).on("load", function () {
  const queryString = window.location.search;

  const urlParams = new URLSearchParams(queryString);

  const idAnuncio = urlParams.get('idAnuncio');

    cargarCategorias();
    obtenerIdUsuario();
    
    obtenerFotosANuncio(idAnuncio);
    $("#publicaciones").addClass("active");
});


function cargarCategorias() {
    $.ajax({
        url: "../backend/gestionAgregarPub.php",
        method: "POST",
        data: `accion=seleccionarCategorias`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);
            console.log(response);
            for (let i = 0; i < response.length; i++) {
                $("#slc-categorias").append(
                    `<option value=${response[i].idCategoria}>${response[i].categoria}</option>`
                )
            }
        },
        error: function (error) {
            console.log(error);
        }
    });

}

//funcion para validar registro
function validarRegistro(){

    var idCategorias = $('#slc-categorias').val();
    console.log(idCategorias);
    //var tipo = $('input:radio[name=tipo]:checked').val();
    //var idMoneda = $('input:radio[name=moneda]:checked').val();
    var nombre = validarCampoVacio("titulo");
    var descripcion =validarCampoVacio("descripcion");
    var precio = validarCampoVacio("precio");
    //var idPersona = validarCampoVacio(id_usuario);
 
    var catS=false;
    if (nombre) {
        // statement
        $("#msjTitulo").fadeOut();
    } else {
        // statement
        $("#msjTitulo").fadeIn();
    }

    if (descripcion) {
        $("#msjdescripcion").fadeOut();
    } else {
        $("#msjdescripcion").fadeIn();
    }

    if (precio) {
        $("#msjPrecio").fadeOut();
    } else {
        $("#msjPrecio").fadeIn();
    }

    if (idCategorias=='null') {
        // statement
        console.log('Entro a error');
        $("#msjCate").fadeIn();
        $("#slc-categorias").removeClass('is-valid');
        $("#slc-categorias").addClass('is-invalid');
        catS=false;
    } else {
        // statement
        $("#msjCate").fadeOut();
        $("#slc-categorias").removeClass('is-invalid');
        $("#slc-categorias").addClass('is-valid');
        catS=true;
    }

    if (!(nombre || descripcion  || catS || precio)) {
        // statement
        return false;
    } else {
        // statement
        return true;
    }
}

var validarCampoVacio = function(id){
 
 if ($("#"+id).val() == ""){
  $("#"+id).removeClass('is-valid');
  $("#"+id).addClass('is-invalid');
  return false;
 }
 else{
  $("#"+id).removeClass('is-invalid');
  $("#"+id).addClass('is-valid');
  return true;
 }
};

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
  },
  error: function (error) {
   console.log(error)
  }
 });
}

function obtenerDatos(idUsuario) {
    //var codigo=$("#idUsuario").val();
    //
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const idAnuncio = urlParams.get('idAnuncio');
  var codigo=idUsuario;

    $.ajax({
        url: "../backend/gestionAgregarPub.php",
        data: `accion=obtenerAnuncio`+"&idPersona=" + codigo,
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
          for (var i = 0; i<respuesta.length; i++){
           if (respuesta[i].idAnuncios==idAnuncio) {
              // statement
              console.log(respuesta[i]);
            $('#titulo').val(respuesta[i].titulo);
            $('#descripcion').val(respuesta[i].descripcion);
            $('#idAnuncio').val(respuesta[i].idAnuncio);
            //$('#slc-categorias').val();
            $("#slc-categorias option[value="+respuesta[i].idCategorias+"]").attr("selected",true);
           // $('input:radio[name=tipo]:checked').val();
            $("input[name=tipo][value=" + respuesta[i].tipo + "]").attr('checked', 'checked');
            $('#precio').val(respuesta[i].precio);
    
            $("input[name=moneda][value=" + respuesta[i].idMoneda + "]").attr('checked', 'checked');
    }
            }
         
        },
        error: function (error) {
            console.log(error)
        }
    });

}

function editarDatos(){
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const idAnuncios = urlParams.get('idAnuncio');

  if (validarRegistro()==true) {

   var nombre = $('#titulo').val();
    var descripcion = $('#descripcion').val();
    var idCategorias = $('#slc-categorias').val();
    var tipo = $('input:radio[name=tipo]:checked').val();
    var precio = $('#precio').val();
    var idPersona = $('#idUsuario').val();
    var idMoneda = $('input:radio[name=moneda]:checked').val();
    var idAnuncio =idAnuncios; 
    //var url = $('#url');
    //console.log('Persona: '+idPersona);

    $.ajax({
        url: "../backend/gestionAgregarPub.php",
        data: `accion=editar` + "&nombre=" + nombre + "&descripcion=" + descripcion + "&idCategoria=" + idCategorias + "&tipo=" + tipo + "&precio=" + precio +
            "&idPersona=" + idPersona + "&idMoneda=" + idMoneda+ "&idAnuncio=" + idAnuncio,
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            $("#msjAviso").html(respuesta[0].mensaje);
            $("#msjAviso").fadeIn();
            $("#msjAviso").fadeOut(4000);

            if (respuesta[0].mensaje=='Edicion exitosa') {
              // statement
              var url = "http://localhost/Compra-y-venta-de-toda-papada-Back/usuarioCV/publicaciones.php";
              window.location = url;
            } 
        },
        error: function (error) {
            console.log(error)
        }
    });
  } else {
   // statement
   //alert("Campos requeridos");
  }
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
              console.log(respuesta);
              for (var i = 0; i<respuesta.length; i++){
                contenido+='<div class="card col-md-4 py-1">'+
                '<figure class="figure">'+
                '<img src="../'+respuesta[i].urlFoto+'" class="figure-img img-fluid rounded" alt="..." style="width: 200px;height: 200px;>'+
                '<figcaption class="figure-caption text-right">'+
                '<br><button type="button" class="btn btn-outline-danger" onclick="eliminarImagen('+respuesta[i].idFotos+')"><i class="fas fa-trash-alt fa-1x" ></i></button>'+
                '&nbsp;&nbsp;<p class="alert alert-danger" id="msjDelete'+respuesta[i].idFotos+'" style="display:none">Foto eliminada</p></figcaption></figure></div>';
              }
              $("#imgAnuncio").append(contenido);
            } else {
              // statement
              // 
  
              
              
                  contenidoD='<div class="col-md-4">'+
              '<img src="../imgCate/micro3.jpg"></div>'+
              '<div class="col-md-4"><img src="../imgCate/microondas.jpg">'+
              '</div><div class="col-md-4">'+
              '<img src="../imgCate/micro2.jpg"></div>'+
              '<div class="col-md-4"><img src="../imgCate/micro4.jpg">'+
              '</div>';
              
              console.log('No hay fotos');
              $("#imgAnuncio").html();
              $("#imgAnuncio").append(contenidoD);
            }
        },
        error: function (error) {
            console.log(error)
        }
    });
}

function eliminarImagen(idImagen){

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const idAnuncio = urlParams.get('idAnuncio');

  var codigo = idImagen;
  
  //alert(parametros);
  $.ajax({
    url:"../backend/gestionAgregarPub.php",
    method:"POST",
    data:`accion=eliminarAnuncio`+"&idAnuncio="+codigo,
    dataType:"json",
    success:function(respuesta){
      console.log(respuesta);

      if (respuesta[0].mensaje=='Eliminada exitosamente') {

      $("#msjDelete"+codigo+"").html(respuesta[0].mensaje);
      $("#msjDelete"+codigo+"").fadeIn();
      //$("#msjDelete"+codigo+"").fadeOut(4000);
      $("#msjDelete"+codigo+"").fadeOut(4000,function(){
       // window.location.replace("editarPublicacion.php");
        location.reload();
      });

      //obtenerFotosANuncio(idAnuncio);
        
        //obtenerIdUsuario();
        
      //
      }
      
    }
  });
}

/*INSERT INTO `fotosanuncio` 
(`idFotos`, `cantidad`, `urlFoto`, `idAnuncios`) VALUES ('1', '1', 'imgCate/b1.jpg', '1'), ('2', '1', 'imgCate/bati1.jpg', '1'), 
('3', '1', 'imgCate/bati2.jpg', '1'), 
('4', '1', 'imgCate/batidora.jpg', '1'), 
('5', '1', 'imgCate/micro2.jpg', '1');*/