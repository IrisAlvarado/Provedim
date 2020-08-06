jQuery(document).ready(function ($) {

    console.log("Cargado DOM");
    traerFavoritos();
    $("#favoritos").addClass("active");
});


function traerFavoritos() {
    $.ajax({
        url: "../backend/gestion_favoritos.php",
        method: "POST",
        data: "accion=getfavoritos",
        success: (respuesta) => {
            console.log(respuesta)

            if (respuesta != `["null"][]`) {

                let response = JSON.parse(respuesta)

                $("#favoritos").html("");

                for (let i = 0; i < response.length; i++) {
                    var elemento = response[i];
                    $("#favoritos").append(`
                <div class="card" style="width: inherit;">
                    <img class="card-img-top" style="height: 10em;object-fit: contain; "
                        src="https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/user_male2-512.png"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">${elemento.primerNombre} ${elemento.segundoNombre} ${elemento.primerApellido}</h5>
                        <i class="fas fa-archive  fa-2x"></i>
                        <p class="card-text">
                            </p>
                        <a href="verpublicaciones.php?idpersona=${elemento.idPersona}" class="btn btn-outline-primary">Ver publicaciones</a>
                        <button type="button" class="btn btn-outline-danger" id="btn-eliminar" onclick="eliminarFavorito(${elemento.idPersona})">Eliminar</button>
                    </div>
                </div>
                    `);
                }
            } else {
                $("#mensaje").fadeIn();
            }

        },
        error: (error) => {
            console.error(error);
        }
    });
}

function eliminarFavorito(favorito) {
    console.log(favorito)

    $.ajax({
        url: "../backend/gestion_favoritos.php",
        method: "POST",
        data: `accion=eliminar&favorito=${favorito}`,
        success: function (respuesta) {
            console.log(respuesta)

            let response = JSON.parse(respuesta)

            if (response.codigo == 1) {
                traerFavoritos();
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}