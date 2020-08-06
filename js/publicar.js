$("#btn-publicar").on("click", () => {

    $.ajax({
        url: "backend/publicar.php",
        method: "GET",
        dataType: "json",
        success: function (respuesta) {
            if (respuesta.acceder) {
                console.log("ESTA LOGUEADO")
                document.getElementById('btn-ventana').style.display = 'none';
                window.location.replace("usuarioCV/agregarPublicacion.php"); //------------------------------URL DE AGREGAR PUBLICACIONES
            } else {
                console.log("NO ESTA LOGUEADO O NO ESTA REGISTRADO")
            }
        },
        error: function (error) {
            console.log("Hay un error....!!!!!")
            console.log(error)
        }

    });
})

$("#login-button2").on("click", () => {
    let correo = $("#correo2").val();
    let contrasena = $("#contrasena").val();

    console.log(correo + ", " + contrasena);

    /*|||||||||||||||||VALIDACIONES|||||||||||||||||||||| */
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    //prueba si el correo es valido
    var esCorreoValido = re.test(String(correo).toLowerCase());

    var esContrasenaValida = contrasena.length > 6;

    if (correo != "" && contrasena != "") {
        login(correo, contrasena);

    } else {
        alert("No puede dejar Campos Vacios")
    }

});

function validarCampoVacio(id) {
    if (document.getElementById(id).value == "") {
        document.getElementById(id).classList.remove("is-valid");
        document.getElementById(id).classList.add("is-invalid");
        return false;
    } else {
        document.getElementById(id).classList.remove("is-invalid");
        document.getElementById(id).classList.add("is-valid");
        return true;
    }
}

function validarEmail(email, emailId) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (re.test(String(email).toLowerCase())) {
        //console.log("Correo valido " + email);
        document.getElementById(emailId).classList.remove("is-invalid");
        document.getElementById(emailId).classList.add("is-valid");

    } else {
        //console.log("Correo invalido " + email);
        document.getElementById(emailId).classList.remove("is-valid");
        document.getElementById(emailId).classList.add("is-invalid");

    }
}

async function login(correo, contrasena) {
    data = {
        correo: correo.toLowerCase(),
        password: contrasena
    };
    var respuestaGlobal;
    $.ajax({
        url: "backend/login.php",
        data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena,
        method: "POST",
        dataType: "json",
        success: async function (respuesta) {
            respuestaGlobal = respuesta;
            console.log(respuesta);
            if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 1 && respuesta.estadoRegistro == 1) {

                console.log("Logueado Exitosamente");

                document.getElementById("correo").classList.remove("is-invalid");
                document.getElementById("correo").classList.add("is-valid");

                document.getElementById("contrasena").classList.remove("is-invalid");
                document.getElementById("contrasena").classList.add("is-valid");
                $("#aviso").fadeOut();
                $("#avisoContrasena").fadeOut();


                await sleep(500);
                //location.reload();
                // console.log('Entro a :'+respuesta.usuario);
                //console.log(respuesta);
                if (respuesta.usuario == 1) {
                    var url = "/administracion/index.php";
                    window.location = url;
                } else {
                    //   var url = "http://localhost/Compra-y-venta-de-toda-papada-Back/usuarioCV/perfil.php";
                    //   window.location = url;
                    location.reload();
                    console.log('Entro como comprador');
                }
            } else if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 0) {

                console.log("contrasena incorrecta");

                document.getElementById("contrasena").classList.remove("is-valid");
                document.getElementById("contrasena").classList.add("is-invalid");
                $("#avisoContrasena").fadeIn();
                $("#aviso").fadeOut();

            } else if (respuesta.existe == 0 && respuesta.contrasenaCorrecta ==
                0) {
                console.log(" No existe el usuario");


                document.getElementById("correo").classList.remove("is-valid");
                document.getElementById("correo").classList.add("is-invalid");

                document.getElementById("contrasena").classList.remove("is-valid");
                document.getElementById("contrasena").classList.add("is-invalid");


                $("#aviso").fadeIn();
            } else if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 1 && respuesta.estadoRegistro == 0) {
                console.log(respuesta.mensaje)

                $("#mensajeDadodeBaja").fadeIn();
            }
        },
        error: function (error) {
            console.log(error);
            alert("Ocurrió un error.");
        }
    });
}

function sleep(time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}