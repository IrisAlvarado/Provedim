<?php 

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/FontAwesome.min.css">
    <link rel="stylesheet" type="text/css" href="../css/all.css">
    <script src="../js/FontAwesome.min.js"></script>

    <link rel="stylesheet" href="../css/inicio.styles.css">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

</head>

<body>
    <?php 

    //llamado a nabvar
    include ('navbarAdmin.php');

    ?>
    <br><br><br><br><br>

    <!-- style="background-color: #2b3f81 !important; color: white !important;" -->

    <!--nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="../ico/image-alt.svg" style="width:45px"></a-->
        <!--LOGO DE LA EMPRESA-->
        <!--button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" style="padding-left:45em;">
                <li class="nav-item active ">
                    <a class="nav-link" href="#">Publicaciones<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Denuncias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reportes</a>
                </li>
            </ul>
            <a class="navbar-brand" href="ico/person-fill.svg"><img src="ico/person-fill.svg" style="width:45px"></a>


        </div>
    </nav-->


    <div class="container" style="margin-right: 2em;">

        <div class="row">
            <div class="col col-lg-6" style="margin-top: auto !important; margin-bottom: 0em; !important">
                <form id="form-tiempo-vencimiento">
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="caducidadUsuarioNormal">Tiempo de caducidad Usuario Normal:</label>
                            <Span id="tiempoNormal"> dias</Span>
                            <input type="text" class="form-control" id="caducidadUsuarioNormal"
                                placeholder="Ingresa una cantidad en días" style="width:50%;">
                            <button type="button" class="btn btn-primary" style="margin-top: .5em;"
                                id="btn-tiempoNormal">Actualizar</button>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="caducidadUsuarioAdministrador">Tiempo de caducidad Usuario
                                Administrador:</label>
                            <Span id="tiempoAdministrador"> dias</Span>

                            <input type="text" class="form-control" id="caducidadUsuarioAdministrador"
                                placeholder="Ingresa una cantidad en días" style="width:50%;">

                            <button type="button" class="btn btn-primary" style="margin-top: .5em;"
                                id="btn-tiempoAdministrador">Actualizar</button>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-lg-12">
                            <label for="caducidadUsuarioEmpresa">Tiempo de caducidad Usuario
                                    Empresa:</label>
                            <Span id="tiempoEmpresa"> dias</Span>


                            <input type="text" class="form-control" id="caducidadUsuarioEmpresa"
                                placeholder="Ingresa una cantidad en días" style="width:50%;">

                            <button type="button" class="btn btn-primary" style="margin-top: .5em;"
                                id="btn-tiempoEmpresa">Actualizar</button>


                            <input type="text" class="form-control" id="caducidadUsuarioEmpresa"
                                placeholder="Ingresa una cantidad en días" style="width:50%;">

                            <button type="button" class="btn btn-primary" style="margin-top: .5em;"
                                id="btn-tiempoEmpresa">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col col-lg-6"
                style="margin-top: auto; margin-bottom: 0em; margin-left: auto; margin-right: 0em;">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-12">
                            <div class="container">
                                <div class="row">
                                    <div class="col col-lg-12">
                                        <div>Filtrar por: </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col col-lg-4">
                                        <div>
                                            <label for=" slc-categorias">Categoria: </label><br>
                                            <select name="slc-categorias" id="slc-categorias"
                                                onChange="busquedaSegunSelect()">
                                                <option value="null">Seleccionar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col col-lg-4">
                                        <div>
                                            <label for="slc-usuarios">Usuario: </label><br>
                                            <select name="slc-usuarios" id="slc-usuarios"
                                                onChange="busquedaSegunSelect()">
                                                <option value="null">Seleccionar</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col col-lg-4">
                                        <div>
                                            <label>Estado: </label><br>
                                            <select name="slc-estados" id="slc-estados"
                                                onChange="busquedaSegunSelect()">
                                                <option selected value="null">Seleccionar</option>
                                                <option value="A">Activo</option>
                                                <option value="I">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row" style="padding-top:2em;">
                        <div class="col col-lg-12">
                            <form class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" id="inputBusqueda" placeholder="Buscar">
                                <button type="button" class="btn btn-outline-success" id="botonBuscar">Buscar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col col-lg-12">
                <div class="table-responsive">
                    <center>
                        <h2>Lista de publicaciones</h2>
                    </center>
                    <br>

                    <table  class="table table-striped table-hover table-bordered"
                        id="tablaPublicaciones" style="width: 100%; margin-left:auto; margin-right:auto">
                        <thead class="thead-dark">
                            <tr>
                                <td><strong> Nombre </strong></td>
                                <td><strong>Tipo (Produto o Servicio) </strong></td>
                                <td><strong>Categoria </strong></td>
                                <td><strong>Descripcion </strong></td>
                                <td><strong>Nombre Usuario </strong></td>
                                <td><strong>Precio </strong></td>
                                <td><strong>Moneda </strong></td>
                                <td><strong>Dia Publicación </strong></td>
                                <td><strong>Dia Vencimiento </strong></td>
                                <td><strong>Estado </strong></td>
                                <td><strong>Dar de Baja </strong></td>
                                <!--<td><strong>Modificar </strong></td>  -->
                            </tr>
                        </thead>
                        <tr>
                            <td>Cama </td>
                            <td>Producto </td>
                            <td>camas</td>
                            <td>Queen Size</td>
                            <td>Pedro Perez</td>
                            <td>5,500.00</td>
                            <td>12/02/2020</td>
                            <td>25/02/2020 </td>
                            <td>disponible</td>
                            <td>
                                <center><a href="#"><img src="../ico/x-circle-fill.svg" style="width:25px "></a></center>
                            </td>
                            <!--<td><center><a href="index.html"><img src="ico/pencil.svg" style="width:25px "></a></center></td>   -->
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <br>
    <br>




    <script src="../js/publicaciones-admin.js"></script>
    <script type="text/javascript" src="../js/all.js"></script>
    <script src="../js/bootstrap.bundle.min.js.descarga"></script>
    <script type="text/javascript" src="../js/fotoAdmin.js"></script>
</body>

</html>