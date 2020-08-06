$("#registro-button").on("click", () => {


    let nombres = $("#nombres").val().trim();
    let correo = $("#correo").val().trim();
    let apellidos = $("#apellidos").val().trim();
    let fechaNacimiento = $("#fechaNacimiento").val();
    let contrasena = $("#contrasena").val().trim();
    let telefono = parseInt($("#telefono").val().trim());
    let municipioSeleccionado = $("#municipios option:selected").val().trim();




    let sonNombresValidos = validarNombres(nombres, "avisoNombres");
    let esCorreoValido = validaCorreo(correo);
    let sonApellidosValidos = validarNombres(apellidos, "avisoapellidos");
    let esFechaNacimientoValida = validarFechaNacimiento(fechaNacimiento);
    let esContrasenaValida = validarContrasena(contrasena);
    let esMunicipioValido = validarMunicipioSeleccionado(municipioSeleccionado)
    let esTelefonoValido = validarTelefono(telefono);




    if (sonNombresValidos &&
        esCorreoValido &&
        sonApellidosValidos &&
        esFechaNacimientoValida &&
        esContrasenaValida &&
        esMunicipioValido &&
        esTelefonoValido) {

        console.log("Cumplio todas las validaciones");

        data = `primerNombre=${nombres.split(" ")[0]}&segundoNombre=${nombres.split(" ")[1]}&primerApellido=${apellidos.split(" ")[0]}&segundoApellido=${apellidos.split(" ")[1]}&correo=${correo}&fechaNac=${fechaNacimiento}&contrasenia=${contrasena}&idMunicipio=${municipioSeleccionado}&telefono=${telefono}`;

        console.log(data)

        $.ajax({
            url: "../backend/registro_usuario_administrador.php",
            data: data,
            method: "POST",
            dataType: "json",
            success: function (respuesta) {
                console.log(respuesta);

                if (respuesta.codigo == 1) {
                    //$("#regAdmin").fadeIn();
                    // $("#regAdmin").fadeOut(3000);
                    var url = "http://localhost/Compra-y-venta-de-toda-papada-Back/administracion/index.php";
                    window.location = url;
                }
            },
            error: function (error) {
                console.log(error)
            }
        });
    }



})

function validarNombres(nombres, idAviso) {


    let cantNombres = nombres.trim().split(" ").length;

    if (cantNombres < 2) {

        $(`#${idAviso}`).fadeIn();
        return false;
    } else if (cantNombres > 3) {
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

function validarFechaNacimiento(fechaNacimiento) {

    if (fechaNacimiento != "") {
        let diasNacimiento = Date.parse(fechaNacimiento.trim()) / (1000 * 60 * 60 * 24);

        let diasActual = Date.now() / (1000 * 60 * 60 * 24);

        let diferencia = diasActual - diasNacimiento;


        if (diferencia <= 6570) {
            $("#avisoFechaNacimiento2").fadeOut();
            $("#avisoFechaNacimiento").fadeIn();
            return false;

        } else {
            $("#avisoFechaNacimiento").fadeOut();
            $("#avisoFechaNacimiento2").fadeOut();

            return true;
        }
    } else {
        $("#avisoFechaNacimiento").fadeOut();
        $("#avisoFechaNacimiento2").fadeIn();

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

function validarTelefono(telefono) {

    if (isNaN(telefono)) {
        $("#avisoTelefono").fadeIn();
        return false;
    } else {
        $("#avisoTelefono").fadeOut();
        return true;
    }
}

function validarMunicipioSeleccionado(idMunicipio) {
    if (idMunicipio == "null") {
        return false

    } else {
        return true;
    }
}


$(document).ready(() => {

    console.log("DOM cargado");

    document.getElementById("departamentos").innerHTML = " ";

    console.log('data="' + 'departamentos"');

    $.ajax({


        url: "../backend/Select_Deptos_Municipios.php",
        data: 'data=' + 'departamentos', //+ "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);

            document.getElementById("departamentos").innerHTML += `<option selected="selected" value="null">
            Selecciona un departamento</option>`;


            for (let i = 0; i < respuesta.length; i++) {

                document.getElementById("departamentos").innerHTML +=
                    ` <option value="${respuesta[i].idDepartamento}">${respuesta[i].nombre}</option>`
            }
        },

        error: function (error) {
            console.log(error);
        }

    });




});


$('#departamentos').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    console.log(valueSelected);

    console.log('data=' + 'municipios&idMunicipio=' + valueSelected.trim());


    $.ajax({
        url: "../backend/Select_Deptos_Municipios.php",
        data: 'data=' + 'municipios&idDepartamento=' + valueSelected.trim(), //+ "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "POST",
        dataType: "json",
        success: function (respuesta) {
            console.log(respuesta);

            document.getElementById("municipios").innerHTML = "";

            document.getElementById("municipios").innerHTML += `<option selected="selected" value="null">
            Selecciona un municipio</option>`;


            for (let i = 0; i < respuesta.length; i++) {

                document.getElementById("municipios").innerHTML +=
                    ` <option value="${respuesta[i].idMunicipio}">${respuesta[i].nombre}</option>`
            }
        },

        error: function (error) {
            console.log(error);
        }
    });
});