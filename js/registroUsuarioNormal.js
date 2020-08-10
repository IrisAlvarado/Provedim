$("#btnGuardar").on("click", () => {


    let nombres = $("#nombres").val().trim();
    let correo = $("#correo").val().trim();
    let apellidos = $("#apellidos").val().trim();
    let direccion = $("#direccion").val().trim();
    let contrasena = $("#contrasena").val().trim();
    var tipoUsuario = $('input:radio[name=tipo]:checked').val();
    console.log(tipoUsuario);



    let sonNombresValidos = validarNombres(nombres, "avisoNombres");
    let esCorreoValido = validaCorreo(correo);
    let sonApellidosValidos = validarNombres(apellidos, "avisoapellidos");
    let esContrasenaValida = validarContrasena(contrasena);
    let contrato=confirmarContrato();

    if (sonNombresValidos &&
        esCorreoValido &&
        sonApellidosValidos &&
        esContrasenaValida &&
        contrato) {

        console.log("Cumplio todas las validaciones");

        data = `primerNombre=${nombres.split(" ")[0]}&primerApellido=${apellidos.split(" ")[0]}&segundoApellido=${apellidos.split(" ")[1]}&direccion=${direccion}&correo=${correo}&contrasenia=${contrasena}&tipoUs=${tipoUsuario}`;
        alert(data);
        console.log(data);

        $.ajax({
            url: "../backend/registro_usuario.php",
            data: data,
            method: "POST",
            dataType: "json",
            success: function (respuesta) {
                console.log(respuesta);

                if (respuesta.codigo == 1) {
                    //$("#regAdmin").fadeIn();
                   // $("#regAdmin").fadeOut(3000);
                    var url = "http://localhost/Provedim/Provedim/usuarioCV/perfil.php";
                    window.location = url;
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
})
/*
$("#crearCuenta").on("click", () => {
    $(funtion(){
      $('#modalFormularioLogin').modal('toggle');
      return false;
  })
    
})*/

function validarNombres(nombres, idAviso) {


    let cantNombres = nombres.trim().split(" ").length;

    if (cantNombres < 1) {

        $(`#${idAviso}`).fadeIn();
        return false;
    } else if (cantNombres > 2) {
        $(`#${idAviso}`).fadeIn();
        return false;
    } else {
        $(`#${idAviso}`).fadeOut();
        return true;
    }

}

function validaCorreo(correo) {

    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    //prueba si el correo es valido
    let test = re.test(String(correo.trim()).toLowerCase());

    if (test && correo.trim() != "") {
        $("#avisoCorreo").fadeOut();
        $("#avisoCorreoExistente").fadeOut();
        return true;
    } else {
        $("#avisoCorreoExistente").fadeOut();
        $("#avisoCorreo").fadeIn();
        return false;
    }
}




function validarContrasena(contrasena) {

    if (contrasena.trim().length < 8) {
        $("#avisoContrasena").fadeIn();
        return false;
    } else {
        $("#avisoContrasena").fadeOut();
        return true;
    }
}



function confirmarContrato()
{
    //console.log(pass);
    //console.log(conf);
    if($("#contrato").is(":checked"))
    {
        $("#avisoContrato").fadeOut();
        return true;
    }
    else
    {   
        $("#avisoContrato").fadeIn();
        return false;
    }
}



