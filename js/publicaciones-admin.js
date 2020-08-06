var publicaciones = [];

$(window).on("load", function () {
    cargarTabla();
    cargarCategorias();
    cargarUsuarios();
    selectTiempoUsuarioNormal();
    selectTiempoUsuarioAministrador();
    selectTiempoUsuarioEmpresa()


})


function darDeBaja(idAnuncio) {

    $.ajax({
        url: "../backend/publicaciones_admin.php",
        data: `idAnuncio=${idAnuncio}&accion=darDeBaja`,
        method: "POST",
        success: function (respuesta) {

            // console.log(JSON.parse(respuesta))

            console.log(respuesta)

            cargarTabla();
        },
        error: function (respuesta) {
            console.log(error);
        }
    });

}

function cargarTabla() {
    $.ajax({
        url: "../backend/publicaciones_admin.php",
        data: `accion=getPublicaciones`,
        method: "POST",
        success: function (respuesta) {

            let response = JSON.parse(respuesta);


            publicaciones = response;


            console.log(response.length);

            $("#tablaPublicaciones>tbody").html(" ");

            for (let i = 0; i < response.length; i++) {

                $("#tablaPublicaciones>tbody").append(
                    `<tr>  
                <td>${response[i].nombreProducto}</td>
                <td>${response[i].tipoProducto}</td>
                <td>${response[i].categoria}</td>
                <td>${response[i].descripcion}</td>
                <td>${response[i].primerNombre} ${response[i].primerApellido}</td>
                <td>${response[i].precio}</td>
                <td>${response[i].moneda}</td>
                <td>${response[i].fechaPublicacion}</td>
                <td>${response[i].fechaVencimiento}</td>
                <td>${response[i].estado}</td>
                <td><button class="btn btn-outline-danger" onclick="darDeBaja(${response[i].idAnuncio})"><i class="far fa-trash-alt"></i></button></td>
                </tr>`
                );

            }

        },
        error: function (error) {

        }
    });
}

function cargarCategorias() {
    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=seleccionarCategorias`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);

            // $("#slc-categorias").html(" ");

            for (let i = 0; i < response.length; i++) {
                $("#slc-categorias").append(
                    `<option value=${response[i].idCategoria}>${response[i].categoria}</option>`
                )
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function cargarUsuarios() {
    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=seleccionarUsuarios`,
        success: function (respuesta) {
            let response = JSON.parse(respuesta);

            // console.log(response);
            // $("#slc-categorias").html(" ");

            for (let i = 0; i < response.length; i++) {
                $("#slc-usuarios").append(
                    `<option value=${response[i].idUsuario}>${response[i].primerNombre} ${response[i].primerApellido}</option>`
                )
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function Busqueda(terminoBusqueda) {

    $.ajax({
        url: "../backend/publicaciones_admin.php",
        data: `accion=getPublicaciones`,
        method: "POST",
        success: function (respuesta) {

            let response = JSON.parse(respuesta);
            console.log("Busqueda");
            console.log(response)

            var resultadoFiltrado = response.filter((elemento) => {
                return elemento.nombreProducto.trim().toLowerCase().includes(terminoBusqueda.trim().toLowerCase());
            });

            console.log(resultadoFiltrado);

            $("#tablaPublicaciones>tbody").html(" ");

            for (let i = 0; i < response.length; i++) {

                $("#tablaPublicaciones>tbody").append(
                    `<tr>  
                <td>${resultadoFiltrado[i].nombreProducto}</td>
                <td>${resultadoFiltrado[i].tipoProducto}</td>
                <td>${resultadoFiltrado[i].categoria}</td>
                <td>${resultadoFiltrado[i].descripcion}</td>
                <td>${resultadoFiltrado[i].primerNombre} ${resultadoFiltrado[i].primerApellido}</td>
                <td>${resultadoFiltrado[i].precio}</td>
                <td>${resultadoFiltrado[i].moneda}</td>
                <td>${resultadoFiltrado[i].fechaPublicacion}</td>
                <td>${resultadoFiltrado[i].fechaVencimiento}</td>
                <td>${resultadoFiltrado[i].estado}</td>
                <td><button class="btn btn-outline-danger" onclick="darDeBaja(${resultadoFiltrado[i].idAnuncio})"><i class="far fa-trash-alt"></i></button></td>
                </tr>`
                );

            }



        },
        error: function (error) {

        }
    });


}

$("#botonBuscar").on("click", () => {

    Busqueda($("#inputBusqueda").val());

    // console.log($("#inputBusqueda").val());


});


console.log("cama de barro".includes("Cama"))



function busquedaSegunSelect() {


    var selectEstados = document.getElementById("slc-estados");
    var estado = selectEstados.options[selectEstados.selectedIndex].value;

    var selectUsuarios = document.getElementById("slc-usuarios");
    var usuario = selectUsuarios.options[selectUsuarios.selectedIndex].value;

    var selectCategorias = document.getElementById("slc-categorias");
    var categoria = selectCategorias.options[selectCategorias.selectedIndex].value;

    console.log("categoria: " + categoria);

    console.log("usuario: " + usuario);

    console.log("estado: " + estado);

    //TODO: hacer consultas


    if (categoria != "null" && usuario != "null" && estado != "null") {

        console.log("Ninguna Null")

        $.ajax({
            url: "../backend/publicaciones_admin.php",
            data: `accion=getPublicacionesNingunaNull&categoria=${categoria}&usuario=${usuario}&estado=%${estado}`,
            method: "POST",
            success: function (respuesta) {

                console.log(respuesta)

                let response = JSON.parse(respuesta);
                console.log(response)


                generarTabla(response)
            },
            error: function (error) {

            }
        });

    } else if (categoria != "null" && usuario != "null" && estado == "null") {
        console.log("Estado null Null")

        $.ajax({
            url: "../backend/publicaciones_admin.php",
            data: `accion=getPublicacionesEstadoNull&categoria=${categoria}&usuario=${usuario}`,
            method: "POST",
            success: function (respuesta) {

                console.log(respuesta)

                let response = JSON.parse(respuesta);
                console.log(response)


                generarTabla(response)
            },
            error: function (error) {

            }
        });
    } else if (categoria != "null" && usuario == "null" && estado != "null") {
        console.log("Usuario null Null")

        $.ajax({
            url: "../backend/publicaciones_admin.php",
            data: `accion=getPublicacionesUsuarioNull&categoria=${categoria}&estado=%${estado}`,
            method: "POST",
            success: function (respuesta) {

                console.log(respuesta)

                let response = JSON.parse(respuesta);
                console.log(response)


                generarTabla(response)
            },
            error: function (error) {

            }
        });

    } else if (categoria == "null" && usuario != "null" && estado != "null") {

        console.log("categoria null Null")

        $.ajax({
            url: "../backend/publicaciones_admin.php",
            data: `accion=getCategoriasNull&usuario=${usuario}&estado=%${estado}`,
            method: "POST",
            success: function (respuesta) {

                console.log(respuesta)

                let response = JSON.parse(respuesta);
                console.log(response)


                generarTabla(response)
            },
            error: function (error) {

            }
        });

    } else if (categoria == "null" && usuario == "null" && estado == "null") {
        cargarTabla()
    } else if (categoria == "null" && usuario == "null" && estado != "null") {
        console.log("Solo estado");

        $.ajax({
            url: "../backend/publicaciones_admin.php",
            data: `accion=getPublicacionesSoloEstado&estado=%${estado}`,
            method: "POST",
            success: function (respuesta) {

                console.log(respuesta)

                let response = JSON.parse(respuesta);
                console.log(response)


                generarTabla(response)
            },
            error: function (error) {

            }
        });
    } else if (categoria == "null" && usuario != "null" && estado == "null") {
        console.log("Solo usuario");

        $.ajax({
            url: "../backend/publicaciones_admin.php",
            data: `accion=getPublicacionesSoloUsuario&usuario=${usuario}`,
            method: "POST",
            success: function (respuesta) {

                console.log(respuesta)

                let response = JSON.parse(respuesta);
                console.log(response)


                generarTabla(response)
            },
            error: function (error) {

            }
        });
    } else if (categoria != "null" && usuario == "null" && estado == "null") {
        console.log("Solo Categoria");

        $.ajax({
            url: "../backend/publicaciones_admin.php",
            data: `accion=getPublicacionesSoloCategoria&categoria=${categoria}`,
            method: "POST",
            success: function (respuesta) {

                console.log(respuesta)

                let response = JSON.parse(respuesta);
                console.log(response)


                generarTabla(response)
            },
            error: function (error) {

            }
        });
    }

}

function generarTabla(response) {
    $("#tablaPublicaciones>tbody").html(" ");

    for (let i = 0; i < response.length; i++) {

        $("#tablaPublicaciones>tbody").append(
            `<tr>  
        <td>${response[i].nombreProducto}</td>
        <td>${response[i].tipoProducto}</td>
        <td>${response[i].categoria}</td>
        <td>${response[i].descripcion}</td>
        <td>${response[i].primerNombre} ${response[i].primerApellido}</td>
        <td>${response[i].precio}</td>
        <td>${response[i].moneda}</td>
        <td>${response[i].fechaPublicacion}</td>
        <td>${response[i].fechaVencimiento}</td>
        <td>${response[i].estado}</td>
        <td><button class="btn btn-outline-danger" onclick="darDeBaja(${response[i].idAnuncio})"><i class="far fa-trash-alt"></i></button></td>
        </tr>`
        );

    }
}


$("#btn-tiempoNormal").on("click", () => {
    let tiempoNormal = parseInt($("#caducidadUsuarioNormal").val());

    console.log(tiempoNormal);

    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=cambiarTiempoUsuarioNormal&tiempoUsuarioNormal=${tiempoNormal}`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);


            if (response.codigo == 1) {
                $("#tiempoNormal").html(response.tiempoUsuarioNormal + " dias");
            }

            //selectTiempoUsuarioNormal();
        },

        error: function (error) {
            console.log(error);
        }

    });
});

function selectTiempoUsuarioNormal() {
    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=selectTiempoUsuarioNormal`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);

            console.log(response)

            $("#tiempoNormal").html(response.tiempoNormal + " dias");
        },

        error: function (error) {
            console.log(error);
        }

    });
}

$("#btn-tiempoEmpresa").on("click", () => {

    let tiempoEmpresa = parseInt($("#caducidadUsuarioEmpresa").val());

    console.log(tiempoEmpresa);

    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=cambiarTiempoUsuarioEmpresa&tiempoUsuarioEmpresa=${tiempoEmpresa}`,
        success: function (respuesta) {

            console.log(respuesta)

            let response = JSON.parse(respuesta);


            if (response.codigo == 1) {
                $("#tiempoEmpresa").html(response.tiempoUsuarioEmpresa + " dias");
            }

            //selectTiempoUsuarioNormal();
        },

        error: function (error) {
            console.log(error);
        }

    });
});

function selectTiempoUsuarioEmpresa() {
    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=selectTiempoUsuarioEmpresa`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);

            console.log(response)

            $("#tiempoEmpresa").html(response.tiempoEmpresa + " dias");


        },

        error: function (error) {
            console.log(error);
        }

    });
}

$("#btn-tiempoAdministrador").on("click", () => {
    let tiempoAdministrador = parseInt($("#caducidadUsuarioAdministrador").val());


    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=cambiarTiempoUsuarioAdministrador&tiempoUsuarioAdministrador=${tiempoAdministrador}`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);


            if (response.codigo == 1) {
                $("#tiempoAdministrador").html(response.tiempoUsuarioAdministrador + " dias");

            }


        },

        error: function (error) {
            console.log(error);
        }

    });
});

function selectTiempoUsuarioAministrador() {
    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=selectTiempoUsuarioAdministrador`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);

            console.log(response)

            $("#tiempoAdministrador").html(response.tiempoAdministrador + " dias");


        },

        error: function (error) {
            console.log(error);
        }

    });
}


function selectTiempoUsuarioEmpresa() {
    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=selectTiempoUsuarioEmpresa`,
        success: function (respuesta) {

            let response = JSON.parse(respuesta);

            console.log(response)

            $("#tiempoEmpresa").html(response.tiempoEmpresa + " dias");


        },

        error: function (error) {
            console.log(error);
        }

    });
}

$("#btn-tiempoEmpresa").on("click", () => {

    let tiempoEmpresa = parseInt($("#caducidadUsuarioEmpresa").val());

    console.log(tiempoEmpresa);

    $.ajax({
        url: "../backend/publicaciones_admin.php",
        method: "POST",
        data: `accion=cambiarTiempoUsuarioEmpresa&tiempoUsuarioEmpresa=${tiempoEmpresa}`,
        success: function (respuesta) {

            console.log(respuesta)

            let response = JSON.parse(respuesta);


            if (response.codigo == 1) {
                $("#tiempoEmpresa").html(response.tiempoUsuarioEmpresa + " dias");
            }

            //selectTiempoUsuarioNormal();
        },

        error: function (error) {
            console.log(error);
        }

    });
});