$(document).ready(function () {
  //  console.log("DOM cargado");
    $("#perfil").addClass("active");
 $.ajax({
  url: "../backend/perfilAdmin.php",
  // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
  method: "GET",
  dataType: "json",
  success: function (respuesta) {
     // console.log(respuesta);

    $("#txtNombre").val(respuesta.nombre);
    $("#txtApellidos").val(respuesta.apellidos);
    $("#hNombre").html(respuesta.nombre+" "+respuesta.apellidos);
    $("#txtCorreo").val(respuesta.correo);
    $("#codigo").val(respuesta.idUsuario);
    $("#fecha").html( respuesta.fechaNa);
    obtenerMunicipios(respuesta.idmunicipio);
    obtenerFotos(respuesta.idUsuario);
    obtenerTelefono(respuesta.idUsuario);

     },
     error: function (error) {
         console.log(error)
     }
 });
});

function obtenerDatos(){
 $.ajax({
  url: "../backend/perfilAdmin.php",
  // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
  method: "GET",
  dataType: "json",
  success: function (respuesta) {
     // console.log(respuesta);

    $("#txtNombre").val(respuesta.nombre);
    $("#txtApellidos").val(respuesta.apellidos);
    $("#hNombre").html(respuesta.nombre+" "+respuesta.apellidos);
    $("#txtCorreo").val(respuesta.correo);
    $("#codigo").val(respuesta.idUsuario);
    $("#fecha").html( respuesta.fechaNa);
    obtenerMunicipios(respuesta.idmunicipio);
    //obtenerFotos(respuesta.idUsuario);
    obtenerTelefono(respuesta.idUsuario);

     },
     error: function (error) {
         console.log(error)
     }
 });
}

$("#cerrarSesion").on("click", () => {

    $.ajax({

        url: "../backend/cerrarSesion.php",
        // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "GET",
        dataType: "json",
        success: function (respuesta) {
            if (respuesta.ok) {
                //location.reload();
                window.location.replace("../index.php");
            }

        },
        error: function (error) {
            console.log(error)
        }

    });
})

//funcion que obtiene el munipio 
function obtenerMunicipios(idmunicipio){
   // console.log("DOM cargado");
    document.getElementById("municipios").innerHTML = " ";

    $.ajax({
        url:"../backend/editarPerfilAdmin.php?accion=obtenerMunicipios",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            var contenido = "";
            //console.log(respuesta);
            contenido += '<option value="null">Seleccione un municipio: </option>';
                /*  */
            for (var i = 0; i<respuesta.length; i++){
                
                if (respuesta[i].idMunicipio ==idmunicipio) {
                    contenido += '<option value="'+respuesta[i].idMunicipio+'" selected="selected">'+
                                respuesta[i].nombre+'</option>';
                                obtenerDeptos(respuesta[i].idDeptos);
                }else {
                    contenido += '<option value="'+respuesta[i].idMunicipio+'">'+
                                respuesta[i].nombre+'</option>';
                }
            }
            document.getElementById("municipios").innerHTML = " ";
            $("#municipios").append(contenido);
        }
    });

}
//funcion para obtener el municipio por depto
function obtenerMunicipiosPorDepto(idDepto){
   // console.log("DOM cargado");
    document.getElementById("municipios").innerHTML = " ";
    var parametros="codDepto="+idDepto;
    $.ajax({
        url:"../backend/editarPerfilAdmin.php?accion=obtenerMunDepto",
        method:"GET",
        data: parametros,
        dataType:"json",
        success:function(respuesta){
         console.log(respuesta);
         var contenido = "";
         //console.log(respuesta);
          contenido += '<option value="null">Seleccione un municipio:</option>';
                         
                /*  */
            for (var i = 0; i<respuesta.length; i++){
             contenido += '<option value="'+respuesta[i].idMunicipio+'">'+
                           respuesta[i].nombre+'</option>';
            }
            document.getElementById("municipios").innerHTML = " ";
            $("#municipios").append(contenido);
        }
    });

}
//funcion para seleccionar un municipio por depto
$('#departamentos').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    console.log(valueSelected);

    //console.log('data=' + 'tipo = ' + valueSelected.trim());
    obtenerMunicipiosPorDepto(valueSelected);
    if (valueSelected=='null') {
     console.log('opcion: '+valueSelected);
     $("#municipios").attr('disabled',true);
    } else {
     $("#municipios").attr('disabled',false);
     console.log(' se habilito '+valueSelected);
    }
    
});
//funcion para obtener todos los deptos
function obtenerDeptos(idDeptos){
   // console.log("DOM cargado");
    document.getElementById("departamentos").innerHTML = " ";

    $.ajax({
        url:"../backend/editarPerfilAdmin.php?accion=obtenerDeptos",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            var contenido = "";
            console.log(respuesta);

            contenido += '<option value="null" selected="selected">Seleccione un departamento:</option>';

                /*  */
            for (var i = 0; i<respuesta.length; i++){
                
                if (respuesta[i].idDeptos==idDeptos) {
                    contenido += '<option value="'+respuesta[i].idDeptos+'" selected="selected">'+
                                respuesta[i].nombre+'</option>';
                }else {
                    contenido += '<option value="'+respuesta[i].idDeptos+'">'+
                                respuesta[i].nombre+'</option>';
                }
            }
            document.getElementById("departamentos").innerHTML = " ";
            $("#departamentos").append(contenido);
        }
    });
}


//valida que un campo no este vacio
var validarCampoVacio = function(id){
 
 if ($("#"+id).val() == ""){
  //$("#"+id).removeClass('is-valid');
  //$("#"+id).addClass('is-invalid');
  return false;
 }
 else{
  ////$("#"+id).removeClass('is-invalid');
  //$("#"+id).addClass('is-valid');
  return true;
 }
};

function validarNombres(nombres) {


    let cantNombres = nombres.trim().split(" ").length;

    if (cantNombres < 2) {

        //$(`#${idAviso}`).fadeIn();
        return false;
    } else if (cantNombres > 3) {
        //$(`#${idAviso}`).fadeIn();
        return false;
    } else {
        //$(`#${idAviso}`).fadeOut();
        return true;
    }

}

function validaCorreo(correo) {

    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    //prueba si el correo es valido
    let test = re.test(String(correo.trim()).toLowerCase());

    if (test && correo.trim() != "") {
       // $("#avisoCorreo").fadeOut();
        //$("#avisoCorreoExistente").fadeIn();
        return true;
    } else {
        //$("#avisoCorreoExistente").fadeOut();
        //$("#avisoCorreo").fadeIn();
        return false;
    }
}




//funcion para obtener la foto del user logiado
function obtenerFotos(idUsuario){
   // console.log("DOM cargado");
   // 
   var parametros= "codigo="+idUsuario;
                   // alert(parametros);
    document.getElementById("imgUsuario").innerHTML = " ";
    document.getElementById("imgNP").innerHTML = " ";
    $.ajax({
        url:"../backend/editarPerfilAdmin.php?accion=obtenerFoto",
        method:"GET",
        data:parametros,
        dataType:"json",
        success:function(respuesta){
            var contenido = "";
            var foto="";
             console.log(respuesta);
            if (respuesta[0].mensaje=='No tiene Foto') {
                $("#iconU").fadeIn();
                console.log('no hay img de perfil');
                contenidoU='<img src="../archivos/user.png" class="rounded-left rounded-circle" alt="..." style="width: 230px;height: 300px;">';
                // statement
                $("#imgUsuario").append(contenidoU);
            } else {
                // statement
                console.log(respuesta);
                contenido='<img src="../'+respuesta[0].urlFoto+'" class="rounded-left rounded-circle" alt="..." style="width: 230px;height: 300px;">';
                    /*  */

                foto='<img src="../'+respuesta[0].urlFoto+'" alt="..." class="rounded-circle" alt="..." style="width: 50px;height: 50px;">';
                
                document.getElementById("imgUsuario").innerHTML = " ";
                document.getElementById("imgNP").innerHTML = " ";
                $("#imgNP").append(foto);
                $("#imgUsuario").append(contenido);
                $("#iconU").fadeOut();
                
            }
            //alert(respuesta[0].urlFoto)
            
        }
    });
}

//cargar foto
function cargarFoto(){
    $.ajax({
        url: "../backend/perfilAdmin.php",
        // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "GET",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
            obtenerFotos(respuesta.idUsuario);
            

        },
        error: function (error) {
            console.log(error)
        }
    });
}

//funcion para obtener el telefono del user logiado
function obtenerTelefono(idUsuario){
   // console.log("DOM cargado");
   // 
   var parametros= "codigo="+idUsuario;
                    //alert(parametros);

    $.ajax({
        url:"../backend/editarPerfilAdmin.php?accion=obtenerTelefono",
        method:"GET",
        dataType:"json",
        success:function(respuesta){
            console.log(respuesta);
            $("#txtTelefono").val(respuesta[0].telefono);
        }
    });
}

document.addEventListener("DOMContentLoaded",()=>{
    let form = document.getElementById('form_subir');

    form.addEventListener("submit",function(event){
        event.preventDefault();
        subir_archivos(this);
    });
});
 
function subir_archivos(form){

    let peticion= new XMLHttpRequest();


     $.ajax({
        url: "../backend/perfilAdmin.php",
        // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "GET",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);
           var codigo=respuesta.idUsuario;
            //enviar datos
            peticion.open('post','../backend/subirImgAdmin.php?cod='+codigo+'');
            peticion.send(new FormData(form));
            $("#msj").fadeIn();
            $("#msj").fadeOut(2000);
        },
        error: function (error) {
            console.log(error)
        }
    });
}


function editarPerfil(){

 var edit=validarEditar();
 console.log(edit);
 if (edit==true) { 
  
  var nombres=$("#txtNombre").val();
  var apellidos=$("#txtApellidos").val();
  var parametros=`primerNombre=${nombres.split(" ")[0]}&segundoNombre=${nombres.split(" ")[1]}&primerApellido=${apellidos.split(" ")[0]}&segundoApellido=${apellidos.split(" ")[1]}&`
      +"deptos="+$("#departamentos").val()+"&"+
      "mun="+$("#municipios").val()+"&"+
      "codigo="+$("#codigo").val()+"&"+
      "cel="+$("#txtTelefono").val()+"&"+
      "correo="+$("#txtCorreo").val();
      //$("#prueba").html(parametros);
     //alert(parametros);
     console.log(parametros);
  $.ajax({
   url:"../backend/editarPerfilAdmin.php?accion=editar",
   method:"GET",
   data:parametros,
   dataType:"json",
   success:function(respuesta){
    //console.log(respuesta);
    alert(respuesta[0].mensaje);
    if (respuesta[0].mensaje=='Edicion exitosa') {
     //alert(respuesta[0].mensaje);
     obtenerDatos();
    }
    $("#msjEditar").html(respuesta[0].mensaje);
     $("#msjEditar").fadeIn();
     $("#msjEditar").fadeOut(2000);
    
   }
  });
  //window.location.replace("categorias.php");
 } 
}
 
function validarEditar(){
 var deptos=$("#departamentos option:selected").val();
 var municipio=$("#municipios option:selected").val();
 var nombre=$("#txtNombre").val();
 console.log(nombre);
 var nombres=validarNombres(nombre);
 var apellido=$("#txtApellidos").val();
 var apellidos=validarNombres(apellido);
 var correos=$("#txtCorreo").val();
 var correo=validaCorreo(correos);
 var celular=$("#txtTelefono").val();
 var cel=validarTelefono(celular);
 
 console.log(nombres+" ape "+apellidos);

 var mun=false;
 var dep=false;
 if (nombres) {
  // statement
  $("#msjNombre").fadeOut();
  console.log('Nobre correcto');
 } else {
  // statement
  $("#msjNombre").fadeIn();
  console.log("nombre incorrecto");
 }

 if (apellidos) {
  $("#msjApellidos").fadeOut();
 } else {
  $("#msjApellidos").fadeIn();
 }

 if (correo) {
  $("#msjCorreo").fadeOut();
 } else {
  $("#msjCorreo").fadeIn();
 }

 if (cel) {
  $("#msjTelefono").fadeOut();
 } else {
  $("#msjTelefono").fadeIn();
 }

 if (deptos=='null') {
  // statement
  $("#msjDepto").fadeIn();
  //$("#departamentos").removeClass('is-valid');
  //$("#departamentos").addClass('is-invalid');
  //catS=false;
 } else {
  // statement
  $("#msjDepto").fadeOut();
  //$("#departamentos").removeClass('is-invalid');
  //$("#departamentos").addClass('is-valid');
   dep=true;
 }

 if (municipio=='null') {
  // statement
  console.log('municipio '+municipio+" funciona")
  $("#msjMunicipio").fadeIn();
  //$("#municipios").removeClass('is-valid');
  //$("#municipios").addClass('is-invalid');
  //catS=false;
 } else {
  // statement
  $("#msjMunicipio").fadeOut();
  //$("#municipios").removeClass('is-invalid');
  //$("#municipios").addClass('is-valid');
  mun=true;
 }

console.log(mun+"  "+ dep)
 if (true==(nombres && apellidos  && correo && cel && dep && mun)) {
  // statement
  console.log('todo correcto');
  return true;
  
 } else {
  // statement
  console.log('todo incorrecto');
  return false;
  
 }
}

function validarTelefono(cel) {

    if (cel.trim().length < 8) {
        //$("#avisoContrasena").fadeIn();
        return false;
    } else if(cel.trim().length > 8){
        //$("#avisoContrasena").fadeOut();
        return false;
    }else {
     return true;
    }
}