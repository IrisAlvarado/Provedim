$(document).ready(function () {


    $.ajax({
        url: "backend/perfilAdmin.php",
        // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "GET",
        dataType: "json",
        success: function (respuesta) {
           // console.log(respuesta);
            obtenerFotos(respuesta.idUsuario);

        },
        error: function (error) {
            console.log(error)
        }
    });


});

//funcion para obtener la foto del user logiado
function obtenerFotos(idUsuario){
   // console.log("DOM cargado");
   // 
   var parametros= "codigo="+idUsuario;
                    //alert(parametros);
    //document.getElementById("imgUsuario").innerHTML = " ";
    document.getElementById("imgNP").innerHTML = " ";
    $.ajax({
        url:"backend/editarPerfilAdmin.php?accion=obtenerFoto",
        method:"GET",
        data:parametros,
        dataType:"json",
        success:function(respuesta){
            var contenido = "";
            var foto="";
             console.log(respuesta);
            if (respuesta[0].mensaje=='No tiene Foto') {
                $("#iconU").fadeIn();
               // console.log('no hay img de perfil');
                //contenidoU='<img src="archivos/user.png" class="rounded-left rounded-circle" alt="..." style="width: 180px;height: 200px;">';
                // statement
               // $("#imgUsuario").append(contenidoU);
            } else {
                // statement
                //console.log(respuesta);
                //contenido='<img src="../'+respuesta[0].urlFoto+'" class="rounded-left rounded-circle" alt="..." style="width: 230px;height: 300px;">';
                    /*  */

                foto='<img src="'+respuesta[0].urlFoto+'" alt="..." class="rounded-circle" alt="..." style="width: 50px;height: 50px;">';
                
                //document.getElementById("imgUsuario").innerHTML = " ";
                document.getElementById("imgNP").innerHTML = " ";
                $("#imgNP").append(foto);
                //$("#imgUsuario").append(contenido);
                $("#iconU").fadeOut();
                
            }
            //alert(respuesta[0].urlFoto)
            
        }
    });
}

$("#cerrarSesion").on("click", () => {

    $.ajax({

        url: "backend/cerrarSesion.php",
        // data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "GET",
        dataType: "json",
        success: function (respuesta) {
            if (respuesta.ok) {
                //location.reload();
                window.location.replace("index.php");
            }

        },
        error: function (error) {
            console.log(error)
        }

    });
})