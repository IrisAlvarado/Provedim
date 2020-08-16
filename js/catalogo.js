$(window).on("load", function () {
   /* cargarTabla();
    cargarCategorias();
    cargarUsuarios();
    selectTiempoUsuarioNormal();
    selectTiempoUsuarioAministrador();
    selectTiempoUsuarioEmpresa()*/
    generarAnuncios();
    cargarDepartamento();
    cargarMunicipio();
    cargarCategoria();

})

var respuestaTbl;
var busqueda;
var munVal = "null";
/**==============================================================GENERAR ANUNCIOS======================================================= */
function generarAnuncios() {
    $.ajax({
        url: "backend/catalogo.php",
        data: `accion=getPublicaciones`,
        method: "POST",
        success: function (respuesta) {

            let response = JSON.parse(respuesta);


            publicaciones = response;


            console.log(response.length);

            $("#generarAnuncios").html(" ");

            for (let i = 0; i < response.length; i++) {

                $("#generarAnuncios").append(
                    `<div class="col-md-3 home-grid">
                            <div class="home-product-main">
                               <div class="home-product-top">
                                  <a href="single.html"><img src="${response[i].urlFoto}" alt="" class="img-responsive zoom-img"></a>
                               </div>
                                <div class="home-product-bottom">
                                        <h3><a href="single.html">${response[i].nombreProducto}</a></h3>
                                        <p>Ver Anuncio</p>
                                </div>
                                <div class="srch">
                                    <span>${response[i].precio}</span>
                                </div>
                            </div>
                         </div>`
                );

            }

        },
        error: function (error) {
            console.log("Error");
        }
    });
}


/**==============================================================SELECCIONAR CATEGORIA======================================================= */
$("#slc-categoria").on("change", function () {
    var data= verificarFiltro();
    data = data+'accion=filtrar';
    $.ajax({
        url: "backend/catalogo.php",
        data: data,
        method: "POST",
        success: function (respuesta) {

            respuestaTbl=respuesta;
            console.log(respuesta)
            cargarTablaTbl();
        },
        error: function (respuesta) {
            console.log(error);
        }
    });
});

function cargarCategoria() {
    $.ajax({
        url: "backend/catalogo.php",
        data: `accion=seleccionarCategoria`,
        method: "POST",
        success: function (respuesta) {
        let response = JSON.parse(respuesta);
            for (let i = 0; i < response.length; i++) {
                $("#slc-categoria").append(
                    `<option value=${response[i].idCategoria}>${response[i].nombre}</option>`
                )
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

/**==============================================================FIN SELECCIONAR CATEGORIA======================================================= */


/**==============================================================SELECCIONAR DEPARTAMENTO======================================================= */
$("#slc-departamento").on("change", function () {
    var data= verificarFiltro();
    data = data+'accion=filtrar';
    $.ajax({
        url: "backend/catalogo.php",
        data: data,
        method: "POST",
        success: function (respuesta) {

            respuestaTbl=respuesta;
            console.log(respuesta)
            cargarTablaTbl();
            cargarMunicipio();/*----------ADDED*/


        },
        error: function (respuesta) {
            console.log(error);
        }
    });
});

function cargarDepartamento() {
    $.ajax({
        url: "backend/catalogo.php",
        data: `accion=seleccionarDepartamento`,
        method: "POST",
        success: function (respuesta) {
        let response = JSON.parse(respuesta);
            for (let i = 0; i < response.length; i++) {
                $("#slc-departamento").append(
                    `<option value=${response[i].idDeptos}>${response[i].nombre}</option>`
                )
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

/**==============================================================FIN SELECCIONAR DEPARTAMENTO======================================================= */

/**==============================================================SELECCIONAR MUNICIPIO======================================================= */

$("#slc-municipio").on("change", function () {
    munVal  = document.getElementById("slc-municipio").value;
    var data= verificarFiltro();
    munVal ="null";
    data = data+'accion=filtrar';
    $.ajax({
        url: "backend/catalogo.php",
        data: data,
        method: "POST",
        success: function (respuesta) {

            respuestaTbl=respuesta;
            console.log(respuesta)
            cargarTablaTbl();
        },
        error: function (respuesta) {
            console.log(error);
        }
    });
});

function cargarMunicipio() {
    let idDepartamento = $("#slc-departamento option:selected").val();/*----------------------ADDED---------------------------*/
    /* $("#slc-municipio").html("Seleccionar");*/
    $("#slc-municipio").html("");
    $("#slc-municipio").append(`<option value="null" selected>Seleccionar</option>`);
    munVal = "null";
    /*document.getElementById("slc-municipio").value = null;*/
    /*verificarFiltro();/*----------------------------------ADDED----------------------------------*/
    if (idDepartamento != "null") {/*------------------------ADDED--------------------*/
    let datas = `accion=seleccionarMunicipio&`;
    datas = datas+`idDepartamentoSelected=${idDepartamento}`;
    /*console.log("ID DE DEPARTAMENTO ");
    console.log(datas);*/
    $.ajax({
        url: "backend/catalogo.php",
        data: datas,/*`accion=seleccionarMunicipio`,*/
        method: "POST",
        success: function (respuesta) {
            /*let response = null;*/
            let response = JSON.parse(respuesta);
           /* console.log("RESPUESTA DEL AYAX");
            console.log(response);*/
           /* $("#slc-municipio").html("");*/
            /*$("#slc-municipio").append("Seleccionar");*/
            for (let i = 0; i < response.length; i++) {
                $("#slc-municipio").append(
                    `<option value=${response[i].idMunicipio}>${response[i].nombre}</option>`
                )
            }
           /* let idDepartamento = null;*/
            /*verificarFiltro();
            cargarTablaTbl();*/
        },
        error: function (error) {
            console.log(error);
        }
    });
}
}
/**==============================================================FIN SELECCIONAR MUNICIPIO======================================================= */

/**==============================================================CARGAR TBL ======================================================= */

function cargarTablaTbl() {

    $("#generarAnuncios").html(" ");
    console.log("cargar tabla tbl");
    let response = JSON.parse(respuestaTbl);
    for (let i = 0; i < response.length; i++) {

                $("#generarAnuncios").append(
                    `<div class="col-md-3 home-grid">
                            <div class="home-product-main">
                               <div class="home-product-top">
                                  <a href="single.html"><img src="${response[i].urlFoto}" alt="" class="img-responsive zoom-img"></a>
                               </div>
                                <div class="home-product-bottom">
                                        <h3><a href="single.html">${response[i].nombreProducto}</a></h3>
                                        <p>Ver Anuncio</p>
                                </div>
                                <div class="srch">
                                    <span>${response[i].precio}</span>
                                </div>
                            </div>
                         </div>`
                );

    }

}
/**==============================================================FIN CARGAR TBL ======================================================= */

/**==============================================================BUSQUEDA======================================================= */
$("#inputBusquedaBtn").click(function () {
    var valueSelected = $("#inputBusqueda").val();
    busqueda=valueSelected;
    console.log(valueSelected);
    hacerBusqueda();
});

function hacerBusqueda(){
    $.ajax({
        url: `backend/catalogo.php`,
        data: `palabraClave=${busqueda}&accion=busquedaNombreProducto`,
        method: "POST",
        success: function (respuesta) {
            respuestaTbl=respuesta;
            console.log(respuesta)
            cargarTablaTbl();
        },
        error: function (respuesta) {
            console.log(error);
        }
    });
}
/**==============================================================FIN BUSQUEDA======================================================= */

/**============================================================ FILTRO DE PRECIOS======================================================= */
var desde;
var hasta;
$("#btn-filtros").click(function () {
    desde = $("#desde").val();
    hasta = $("#hasta").val();
   /* if (desde == is_integer()) {console.log("NO SE INGRESARON NUMEROS");}*/
    /*if (is_integer(desde) && is_integer(hasta) ) {*/
        console.log(desde);
        console.log(hasta);
        hacerBusquedaPorPrecio();
   /* }else{*/

        /*generarAnuncios();*/
    /*}*/

    /*hacerBusquedaPorPrecio();*/
});

function hacerBusquedaPorPrecio(){
    $.ajax({
        url: `backend/catalogo.php`,
        data: `desde=${desde}&hasta=${hasta}&accion=busquedaPorPrecio`,
        method: "POST",
        success: function (respuesta) {
            //if (respuesta !="false") {
                respuestaTbl=respuesta;
                console.log(respuesta)
                cargarTablaTbl();
           // }else{
                //$("#mensajeDesde").css.;
           /*     document.getElementById('mensajeDesde').style.display = "block";
            }*/
            /*respuestaTbl=respuesta;
            console.log(respuesta)
            cargarTablaTbl();*/
        },
        error: function (respuesta) {
            console.log(error);
        }
    });
}
/**==========================================================FIN FILTRO DE PRECIOS======================================================= */


/**================================================ =========FUNCION VERIFICAR FILTRO======================================================= */

function verificarFiltro(){
    var optionCategory;
    var valueCategory;
    var optionDepto;
    var valueDepto;
    var optionMunicipio;
    var valueMunicipio;

    var data= "";

    valueCategory = document.getElementById("slc-categoria").value;
    valueDepto = document.getElementById("slc-departamento").value;
    /*valueMunicipio  = document.getElementById("slc-municipio").value;*/
    valueMunicipio  = munVal;

    if (valueCategory != 'null') {
        data = data+`idCategoria=${valueCategory}&`;
    } if (valueDepto != 'null') {
        data = data+`idDepto=${valueDepto}&`;
    } if (valueMunicipio != 'null') {
        data = data+`idMunicipio=${valueMunicipio}&`;
    }
    return data;
}

/**================================================ =========FIN FUNCION VERIFICAR FILTRO======================================================= */