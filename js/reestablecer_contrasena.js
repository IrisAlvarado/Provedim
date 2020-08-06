$(document).ready(function () {
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const valid = urlParams.get('valid');

    if (valid == null) {
        window.location.href = "inicio.php"
    }
});


function enviarCorreo() {

    var correo = $("#correo").val().trim().toLowerCase();

    var esCorreoValido = validaCorreo(correo);


    console.log(correo)

    if (esCorreoValido) {
        $.ajax({
            url: "backend/reestablecer_contrasena.php",
            method: "POST",
            data: `accion=enviarcorreo&correo=${correo.trim()}`,
            success: function (respuesta) {
                console.log(respuesta)

                let response = JSON.parse(respuesta);

                if (response.ok) {
                    $("#avisoCorreo-noexiste").fadeOut()
                    $("#div-codigo").fadeIn();
                    $("#enviar-correo").fadeOut();
                    $("#verificar-codigo").fadeIn();

                    $("#correo").prop("disabled", true);

                } else {
                    $("#avisoCorreo-noexiste").fadeIn()
                }
            },
            error: function (error) {
                console.error(error);
            }
        })
    }

    //enviarcorreo
}

function verificarCodigo() {


    var codigo = $("#codigo").val().trim();
    var correo = $("#correo").val().trim().toLowerCase();



    if (codigo != "" && correo != "") {

        $("#avisocodigo").fadeOut();

        $.ajax({
            url: "backend/reestablecer_contrasena.php",
            method: "POST",
            data: `accion=verificarcodigo&correo=${correo}&codigo=${codigo}`,
            success: function (respuesta) {
                console.log(respuesta)

                let response = JSON.parse(respuesta)


                if (response.ok) {
                    $("#verificar-codigo").fadeOut();
                    $("#div-contrasena").fadeIn();
                    $("#cambiar-contrasena").fadeIn();

                    $("#codigo").prop("disabled", true);
                } else {
                    $("#avisocodigo").fadeIn();
                }
            },
            error: function (erorr) {
                console.error(error);
            }
        });
    } else {
        $("#avisocodigo").fadeIn();
    }
    console.log(codigo)
}

function cambiarContrasena() {
    var contrasena = $("#contrasena").val().trim();
    var correo = $("#correo").val().trim().toLowerCase();

    esContrasenaValida = validarContrasena(contrasena)

    console.log(contrasena)

    if (esContrasenaValida) {
        $("#cambiar-contrasena").prop("disabled", true);
        $.ajax({
            url: "backend/reestablecer_contrasena.php",
            method: "POST",
            data: `accion=cambiarcontrasena&correo=${correo}&contrasena=${contrasena}`,
            success: async function (respuesta) {
                console.log(respuesta);

                let response = JSON.parse(respuesta)

                if (response.ok) {
                    console.log("Se cambió la contraseña correctamente.")

                    $("#aviso-correcto").fadeIn()

                    await sleep(1500)
                    window.location.href = `inicio.php`;
                }
            }
        });
    }


}

function validaCorreo(correo) {

    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    //prueba si el correo es valido
    let test = re.test(String(correo.trim()).toLowerCase());

    if (test && correo.trim() != "") {
        $("#avisoCorreo").fadeOut();

        return true;
    } else {

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

function sleep(time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

$("#verificar-codigo").on("click", verificarCodigo)

$("#enviar-correo").on("click", enviarCorreo)

$("#cambiar-contrasena").on("click", cambiarContrasena)