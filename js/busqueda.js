$(document).ready(function () {
    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const busqueda = urlParams.get('busqueda');
    const categoria = urlParams.get("categoria");
    const hasta = urlParams.get("hasta");


    //console.log("Busqueda get")
    //console.log(busqueda);
    //console.log("categoria get")
    //console.log(categoria);
    //console.log("hasta get")
    //console.log(hasta);

    if (busqueda == null && categoria == null) {
        window.location.href = "busqueda.php?categoria=null&busqueda=";
    }

    if (busqueda != null) {
        $("#inputBusqueda").val(busqueda)
    }


    hacerBusqueda(busqueda, categoria, hasta);

    traerDepartamentos();
    traerCategorias();


    $("#desde").val("");
    $("#hasta").val("");

    //fotoPerfil
    traerFotoPerfil();

});

function hacerBusqueda(busqueda, categoria, hasta) {

    dataQuerys = `accion=BusquedaPrincipal${busqueda!=""?`&busqueda=%${busqueda}%`:``}${validarCategoriaNumerica(categoria)?`&categoria=${categoria}`:``}${hasta!=null?`&hasta=${hasta}`:``}`;

    //var listaAnuncios;

    $.ajax({
        url: "backend/busqueda.php",
        method: "POST",
        // async: false,
        // cache: false,
        data: dataQuerys,
        success: function (respuesta) {
            //console.log(respuesta)


            var response = Array();
            if (respuesta == `["null"][]`) {
                response = [];
            } else {
                response = JSON.parse(respuesta)
            }
            //console.log(response);
            if (response.length > 0) {
                $("#noHayDatos").fadeOut();

                generarAnuncios(response);
            } else {
                //alert("No hay datos")
                //TODO:no hay datos mensaje
                $("#anuncios").html("");
                $("#noHayDatos").fadeIn();
            }
        },
        error: function (error) {
            console.error(error)
        }
    });

    //console.log("Respuesta sincrona")
    //console.log(listaAnuncios)



    // if (categoria != "null" && busqueda != "") {
    //     $.ajax({
    //         url: "backend/busqueda.php",
    //         method: "POST",
    //         data: `accion=traerNoNull&busqueda=%${busqueda}%&idcategoria=${categoria}`,
    //         success: function (respuesta) {
    //             let response = JSON.parse(respuesta)
    //             // console.log(response);

    //             generarAnuncios(response);
    //         },
    //         error: function (error) {
    //             console.error(error)
    //         }
    //     });
    // } else if (categoria == "null" && busqueda != "") {
    //     console.log("Categoria null")
    //     $.ajax({
    //         url: "backend/busqueda.php",
    //         method: "POST",
    //         data: `accion=traerCategoriaNull&busqueda=%${busqueda}%`,
    //         success: function (respuesta) {
    //             let response = JSON.parse(respuesta);

    //             generarAnuncios(response);
    //         },
    //         error: function (error) {
    //             console.error(error)
    //         }
    //     });
    // } else if (categoria != "null" && busqueda == "") {
    //     $.ajax({
    //         url: "backend/busqueda.php",
    //         method: "POST",
    //         data: `accion=traerBusquedaNull&idcategoria=${categoria}`,
    //         success: function (respuesta) {
    //             let response = JSON.parse(respuesta)
    //             // console.log(response);

    //             generarAnuncios(response);
    //         },
    //         error: function (error) {
    //             console.error(error)
    //         }
    //     });
    // } else if (categoria == "null" && busqueda == "") {
    //     $.ajax({
    //         url: "backend/busqueda.php",
    //         method: "POST",
    //         data: `accion=traerTodos`,
    //         success: function (respuesta) {
    //             let response = JSON.parse(respuesta);
    //             //console.log(response);

    //             generarAnuncios(response);
    //         },
    //         error: function (error) {
    //             console.error(error)
    //         }
    //     });
    // }
}

function agregarURL(listaAnuncios) {

    var listaFotos;
    $.ajax({
        url: "backend/busqueda.php",
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
    console.log("Json lista")
    console.log(jsonListaFotos)


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

function generarAnuncios(response) {


    response = agregarURL(response);




    $("#anuncios").html("");
    $("#segundaFila").html("")

    for (let i = 0; i < 2; i++) {
        $("#anuncios").append(`
        <div class="col col-lg-4" style="margin:1em; flex: 0 0 32% !important; max-width: 32% !important;">
            <div class="card" style="width: inherit;">
                <img class="card-img-top" style="height: 14em !important; object-fit: cover !important;"
                    src="${response[i].fotourl}"
                    alt="Card image cap">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col col-lg-12 tituloAnuncio" style="color:#984B43;">
                                <strong>${response[i].titulo}</strong>
                                <hr>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col col-lg-12">
                                <div class="container">
                                    <div class="row" >
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
                                <button type="button" class="btn btn-outline-info" onclick="verArticulo(${response[i].idAnuncios})">Ver Artículo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `);
    }
    for (let i = 2; i < response.length; i++) {
        $("#segundaFila").append(`
        <div class="col col-lg-3">
            <div class="card" style="width: inherit;">
                <img class="card-img-top" style="height: 14em !important; object-fit: cover !important;"
                    src="${response[i].fotourl}"
                    alt="Card image cap">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col col-lg-12 tituloAnuncio" style="color:#984B43;">
                                <strong>${response[i].titulo}</strong>
                                <hr>
                            </div>
                        </div>
                        <div class="row" class="iconos-row">
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
                                <button type="button" class="btn btn-outline-info" onclick="verArticulo(${response[i].idAnuncios})">Ver Artículo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `);
    }
}

function verArticulo(idAnuncios) {
    window.location.href = `usuarioCV/detalleAnuncio.php?idAnuncios=${idAnuncios}`;
}

function traerDepartamentos() {


    $.ajax({
        url: "backend/Select_Deptos_Municipios.php",
        method: "POST",
        data: `data=departamentos`,
        success: function (respuesta) {
            let response = JSON.parse(respuesta);
            console.log(response);

            $("#departamentos").html("");
            $("#departamentos").append(`<option value="null" class="form-control">Selecciona un departamento</option>`);
            for (let i = 0; i < response.length; i++) {
                //console.log("entra for")
                $("#departamentos").append(`
                <option value=${response[i].idDepartamento}>${response[i].nombre}</option>
                `);
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}

function traerMunicipios() {
    let idDepartamento = $("#departamentos option:selected").val();
    //console.log(idDepartamento);

    $("#municipios").html("");
    $("#municipios").append(`<option value="null" selected>Seleccione un municipio</option>`);

    if (idDepartamento != "null") {

        $.ajax({
            url: "backend/Select_Deptos_Municipios.php",
            method: "POST",
            data: `data=municipios&idDepartamento=${idDepartamento}`,
            success: function (respuesta) {
                let response = JSON.parse(respuesta);
                //console.log(response);


                for (let i = 0; i < response.length; i++) {
                    //console.log("entra for")
                    $("#municipios").append(`
                    <option value=${response[i].idMunicipio}>${response[i].nombre}</option>
                    `);
                }
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

}

function busquedaDetallada() {

    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const busqueda = urlParams.get('busqueda');
    const categoria = urlParams.get("categoria");


    let departamento = $("#departamentos option:selected").val();
    let municipio = $("#municipios option:selected").val();

    //precios
    let desde = $("#desde").val();
    let hasta = $("#hasta").val();

    var tipo = $("input[name=servicios]");
    console.log("Radios")

    //console.log(tipo.filter(":checked").val())

    var tipoCheckeado = tipo.filter(":checked").val();
    console.log(tipoCheckeado)

    let servicio = $("input[name='servicios']:checked").val();

    //console.log(departamento);
    //console.log(municipio);
    //console.log(desde);
    //console.log(hasta);
    //console.log(servicio);

    let data = `accion=filtros${departamento!="null"?`&idDepartamento=${departamento}`:``}${municipio!="null"?`&idMunicipio=${municipio}`:``}${validarValorNumerico(desde, "#mensajeDesde")?`&desde=${desde}`:``}${validarValorNumerico(hasta, "#mensajeHasta")?`&hasta=${hasta}`:``}${validarCategoriaNumerica(categoria)?`&categoria=${categoria}`:``}${busqueda!=""?`&busqueda=%${busqueda}%`:``}${tipoCheckeado!=null?`&tipo=${tipoCheckeado}`:``}`;
    console.log(data.trim());

    $.ajax({
        url: "backend/busqueda.php",
        method: "POST",
        datatype: "json",
        data: data.trim(),
        success: (respuesta) => {
            //         //console.log(respuesta)

            var response = Array();


            if (respuesta == `["null"][]`) {
                response = [];
            } else {
                response = JSON.parse(respuesta)
            }
            console.log(response);
            if (response.length > 0) {
                $("#noHayDatos").fadeOut();
                generarAnuncios(response);
            } else {
                //             //alert("No hay datos")
                $("#anuncios").html("");
                $("#noHayDatos").fadeIn();
            }

            //         // let response = JSON.parse(respuesta);
            //         // console.log(response);

            generarAnuncios(response);
        },
        error: (error) => {
            console.log(error);
        }
    });


}

$("#btn-filtros").on("click", () => {
    busquedaDetallada();
});

function validarValorNumerico(numero, idMensaje) {

    let esNumero = isNaN(numero) ? false : true;
    let estaVacio = numero == "" ? true : false;

    if (estaVacio) {
        $(idMensaje).fadeOut();
        return false;
    } else {
        if (!esNumero) {
            $(idMensaje).fadeIn();
            return false;
        } else {
            $(idMensaje).fadeOut();
            return true;
        }
    }
}

function validarCategoriaNumerica(numero) {

    let esNumero = isNaN(numero) ? false : true;
    let estaVacio = numero == "" ? true : false;

    if (estaVacio) {
        return false;
    } else {
        if (!esNumero) {
            return false;
        } else {
            return true;
        }
    }
}


$("#ordenamiento").on("change", function () {

    const queryString = window.location.search;

    const urlParams = new URLSearchParams(queryString);

    const busqueda = urlParams.get('busqueda');
    const categoria = urlParams.get("categoria");


    let departamento = $("#departamentos option:selected").val();
    let municipio = $("#municipios option:selected").val();

    //precios
    let desde = $("#desde").val();
    let hasta = $("#hasta").val();



    let servicio = $("input[name='servicios']:checked").val();


    let opcionSeleccionadaOrden = $("#ordenamiento :selected").val();
    let dataParametros = `${departamento!="null"?`idDepartamento=${departamento}`:``}${municipio!="null"?`&idMunicipio=${municipio}`:``}${validarValorNumerico(desde, "#mensajeDesde")?`&desde=${desde}`:``}${validarValorNumerico(hasta, "#mensajeHasta")?`&hasta=${hasta}`:``}${servicio!=null?`&servicio=${servicio}`:``}${validarCategoriaNumerica(categoria)?`&categoria=${categoria}`:``}${busqueda!=""?`&busqueda=%${busqueda}%`:``}`;



    if (opcionSeleccionadaOrden != "null") {
        var data = "";

        switch (opcionSeleccionadaOrden) {
            case "nuevos":
                data = `&tipo=fecha&orden=nuevos&accion=ordenar`;
                break;
            case "viejos":
                data = `&tipo=fecha&orden=viejos&accion=ordenar`;
                break;
            case "admin":
                data = `&tipo=tipousuario&tipousuario=admin&accion=ordenar`;
                break;
            case "normal":
                data = `&tipo=tipousuario&tipousuario=normal&accion=ordenar`;
                break;
            case "mejor":
                data = `&tipo=mejor&accion=ordenarPorCalificacion`;
                break;
            case "peor":
                data = `&tipo=peor&accion=ordenarPorCalificacion`;
                break;
        }



        var queryCompleto = dataParametros += data;
        //console.log(queryCompleto)


        $.ajax({
            url: "backend/busqueda.php",
            data: queryCompleto,
            method: "POST",
            success: function (respuesta) {
                //console.log(respuesta)

                if (respuesta == `["null"][]`) {
                    //alert("No hay datos")

                    //TODO:mostrar mensaje de no hay datos
                } else {
                    let response = JSON.parse(respuesta)
                    console.log(response);

                    generarAnuncios(response)

                }
            },
            error: function (error) {
                console.error(error)
            }
        });
    }



});


function traerCategorias() {

    $.ajax({
        url: "backend/inicio.php",
        method: "POST",
        data: "accion=Traercategorias",
        success: function (respuesta) {
            let response = JSON.parse(respuesta);

            const queryString = window.location.search;

            const urlParams = new URLSearchParams(queryString);

            const categoria = urlParams.get('categoria');



            if (categoria == "null") {
                $("#categoriasElementos").append(`
                <option value="null" selected>Todas</option>`);

                for (let i = 0; i < response.length; i++) {
                    $("#categoriasElementos").append(`
                    <option value="${response[i].idCategorias}">${response[i].descripcion}</option>`);
                }
            } else {

                $("#categoriasElementos").append(`
                <option value="null" >Todas</option>`);
                for (let i = 0; i < response.length; i++) {
                    if (categoria == response[i].idCategorias) {
                        $("#categoriasElementos").append(`
                        <option value="${response[i].idCategorias}" selected>${response[i].descripcion}</option>`);
                    } else {
                        $("#categoriasElementos").append(`
                        <option value="${response[i].idCategorias}">${response[i].descripcion}</option>`);
                    }
                }
            }


        },
        error: function (error) {
            console.error(error)
        }

    });
}


$("#login-button").on("click", () => {
    let correo = $("#correo").val();
    let contrasena = $("#contrasena").val();

    //console.log(correo + ", " + contrasena);

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

    /*Funcion que valida si el campo está vacío */
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
        correo: correo.toLowerCase(), //$("#correo").val().toLowerCase(),
        password: contrasena //$("#contrasena").val()
    };

    var respuestaGlobal;


    $.ajax({
        url: "backend/login.php",
        data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
        method: "POST",
        dataType: "json",
        success: async function (respuesta) {
            respuestaGlobal = respuesta;

            // alert(respuesta.mensaje);

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
                location.reload();
            } else if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 0) {

                //console.log("contrasena incorrecta");

                document.getElementById("contrasena").classList.remove("is-valid");
                document.getElementById("contrasena").classList.add("is-invalid");
                $("#avisoContrasena").fadeIn();
                $("#aviso").fadeOut();

            } else if (respuesta.existe == 0 && respuesta.contrasenaCorrecta ==
                0) {
                //console.log(" No existe el usuario");


                document.getElementById("correo").classList.remove("is-valid");
                document.getElementById("correo").classList.add("is-invalid");

                document.getElementById("contrasena").classList.remove("is-valid");
                document.getElementById("contrasena").classList.add("is-invalid");


                $("#aviso").fadeIn();
            } else if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 1 && respuesta.estadoRegistro == 0) {
                //console.log(respuesta.mensaje)

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

$("#btn-busqueda").on("click", () => {
    //console.log("click");

    let categoriaSeleccionada = $("#categoriasElementos :selected").val();
    //console.log(categoriaSeleccionada);

    let busqueda = $("#inputBusqueda").val();
    //console.log(busqueda)

    if (categoriaSeleccionada != "null" && busqueda != "") {
        window.location.href = `busqueda.php?categoria=${categoriaSeleccionada}&busqueda=${busqueda}`;
    } else if (categoriaSeleccionada == "null" && busqueda != "") {
        window.location.href = `busqueda.php?categoria=null&busqueda=${busqueda}`;
    } else if (categoriaSeleccionada != "null" && busqueda == "") {
        window.location.href = `busqueda.php?categoria=${categoriaSeleccionada}&busqueda=`;
    } else if (categoriaSeleccionada == "null" && busqueda == "") {
        window.location.href = `busqueda.php`;
    }
})

function traerFotoPerfil() {
    console.log("Llamado a funcion traer perfil")
    $.ajax({
        url: "backend/busqueda.php",
        data: `accion=getFotoPerfil`,
        method: "POST",
        success: function (respuesta) {
            console.log(respuesta);

            if (respuesta != `["null"][]`) {
                let response = JSON.parse(respuesta);
                console.log(response)


                $("#imgNP").html(`
                <img id="img-perfil" src="${response[0].urlFoto}">`)
            } else {
                $("#imgNP").html(`
               <div class="iconoPerfil"> <i class="fas fa-user"></i></div>`)
            }
        },
        error: function (errror) {
            console.log("Caer en error")
            console.error(error);
        }
    });
}

function cerrarSesion() {
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
}

$("#cerrarSesion").on("click", function () {
    cerrarSesion();
})