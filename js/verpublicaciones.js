jQuery(document).ready(function ($) {

    console.log("Cargado DOM");

    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const idpersona = urlParams.get('idpersona');

    if (idpersona == null) {
        window.location.href = "../inicio.php"
    }

    traerPublicaciones(idpersona);

    $("#favoritos").addClass("active");

});

function agregarURL(listaAnuncios) {

    var listaFotos;
    $.ajax({
        url: "../backend/gestion_favoritos.php",
        method: "POST",
        async: false,
        cache: false,
        data: `accion=traerfotos`,
        dataType: "json",
        success: function (respuesta) {
            listaFotos = respuesta;

            //    if (respuesta != `["null"][]`) {
            //        let responsePeticion = JSON.parse(respuesta);
            //
            //        listaFotos = respuesta;
            //    } else {
            //        listaFotos = [];
            //    }


        },
        error: function (error) {
            console.error(error)
        }
    });

    var jsonListaFotos = listaFotos;
    //console.log("Json lista")
    //console.log(jsonListaFotos)


    listaAnuncios.forEach((anuncio => {
        var filtrar = jsonListaFotos.filter(elemento => {
            return anuncio.idAnuncios == elemento.idAnuncios;
        })

        if (filtrar.length > 0) {

            anuncio.fotourl = filtrar[0].urlFoto;
        } else {
            anuncio.fotourl = `img/no_imagen.png`;
        }
    }))




    return listaAnuncios;

}

function traerPublicaciones(idPersona) {

    $.ajax({
        url: "../backend/gestion_favoritos.php",
        method: "POST",
        data: `accion=verpublicaciones&idpersona=${idPersona}`,
        success: (respuesta) => {

            console.log(respuesta);

            if (respuesta != `["null"][]`) {
                let response = JSON.parse(respuesta);

                response = agregarURL(response);

                console.log("Lista de anuncios")
                console.log(response)

                for (let i = 0; i < response.length; i++) {

                    $("#anuncios").append(
                        `
        <div class="col col-lg-3">
            <div class="card" style="width: inherit;">
                <img class="card-img-top" 
                    src="../${response[i].fotourl}" 
                    alt="Card image cap">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col col-lg-12">
                                <strong>${response[i].titulo}</strong>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-lg-12">
                                <div class="container">
                                    <div class="row">
                                        <div class="col col-lg-4 iconoPequeno ">
                                            <i style="display: block;"
                                                class="fas fa-american-sign-language-interpreting iconoTarjeta"> </i>
                                            Vendo
                                        </div>
                                        <div class="col col-lg-4 iconoPequeno ">
                                            <i style="display: block;"
                                                class="fas fa-dollar-sign iconoTarjeta"></i>
                                            L. ${response[i].precio}
                                        </div>
                                        <div class="col col-lg-4 iconoPequeno">
                                            <i style="display: block;"
                                                class="fas fa-location-arrow iconoTarjeta"></i>
                                            ${response[i].municipio}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-lg-12 descripcionAnuncio">
                                <p>${response[i].descripcion}.</p>
                                <a href="detalleAnuncio.php?idAnuncios=${response[i].idAnuncios}"><button type="button" class="btn btn-outline-info">Ver Anuncio</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
                    );
                }

                console.log(response)
            }
        },
        error: (error) => {
            console.error(error);
        }
    });
}