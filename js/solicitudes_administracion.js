$(document).ready(function () {

    cargarSolicitudes();

});

function cargarSolicitudes() {
    $.ajax({
        url: "../backend/solicitudes_administracion.php",
        data: "accion=cargarSolicitudes",
        method: "POST",
        success: function (respuesta) {

            let response = JSON.parse(respuesta)
            console.log(response);

            $("#solicitudes tbody").html(" ");

            for (let i = 0; i < response.length; i++) {
                $("#solicitudes tbody").append(
                    `<tr>
                    <td  scope="row">${response[i].idPersona}</td>
                    <td >${response[i].primerNombre} ${response[i].primerApellido}</td>
                    <td >${response[i].correo}</td>
                    <td >${parseInt(response[i].edad)}</td>
                    <td >${response[i].departamento}</td>
                    <td >${response[i].municipio}</td>
                    <td  class="text-align:center;">
                    <button type="button" class="btn btn-outline-danger" style="margin:.5em;" onclick="darDeBaja(${response[i].idPersona})"><i class="fas fa-trash-alt"></i></buton>
                    <button type="button" class="btn btn-outline-success"  style="margin:.5em;" onclick="aceptarSolicitud(${response[i].idPersona})"><i class="fas fa-user-check"></i></button>
                    </td>

                    </tr>`
                );

            }
        },
        error: function (error) {
            console.log(error)
        }
    });
}


function darDeBaja(idPersona) {
    console.log(idPersona)

    $.ajax({
        url: "../backend/solicitudes_administracion.php",
        data: `accion=darDeBaja&idPersona=${idPersona}`,
        method: "POST",
        success: function (respuesta) {

            let response = JSON.parse(respuesta)
            console.log(response);

        },
        error: function (error) {
            console.log(error)
        }
    });

}

function aceptarSolicitud(idPersona) {
    console.log(idPersona)

    $.ajax({
        url: "../backend/solicitudes_administracion.php",
        data: `accion=aceptarSolicitud&idPersona=${idPersona}`,
        method: "POST",
        success: function (respuesta) {

            let response = JSON.parse(respuesta)
            console.log(response);

            cargarSolicitudes();

        },
        error: function (error) {
            console.log(error)
        }
    });
}