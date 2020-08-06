<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/FontAwesome.min.css">
    <link rel="stylesheet" href="css/busqueda.css">
    <!-- Compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->

    <!-- Compiled and minified JavaScript -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> -->
    <!-- <link rel="stylesheet" href="css/busqueda_material.css"> -->


</head>

<body style="background-color: white;">

    <nav class="navbar navbar-expand-lg navbar-light bg-light" style=" background-color: #FF5858 !important;">


        <a class="navbar-brand" href="/index.php" style="color: #000000;"><strong>PROVEDIM</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item" id="favoritos-item">
                    <a class="nav-link" id="favoritos-link"
                        href="http://www.publitodo.hn/usuarioCV/favoritos.php">Catálogo</a>
                </li>
                <li class="nav-item">
                    <a style="padding-left:0px; padding-right:0px;" class="nav-link"
                        href="http://www.publitodo.hn/usuarioCV/agregarPublicacion.php">Cotizaciones</a>
                </li>

                <li class="nav-item " id="categorias">

                    <select class="custom-select" id="categoriasElementos">
                        <!-- <option value="null" selected>Todas</option> -->
                    </select>


                    </select>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0" id="formBusqueda">
                <input class="form-control mr-sm-2" type="search" id="inputBusqueda"
                    placeholder="Buscar por palabra clave" aria-label="Search">
                <button class="btn  btn-light my-2 my-sm-0 btn-busqueda" type="button" id="btn-busqueda">Buscar</button>
            </form>

            <ul class="navbar-nav mr-auto">

                <?php
                    session_start(); 
                    

                    if(isset($_SESSION["es_administrador"])){
                        {
                            echo ('
                            <div class="btn-group" style="margin-right: 7em;">
                            <a href="usuarioCV/perfil.php" class=""><i class="fas fa-user-circle  fa-3x" style="color:#EAC67A;display:none" id="iconU"></i>
                                        <div id="imgNP" ></div></a>
                              <a href="usuarioCV/perfil.php" class="dropdown-toggle dropdown-toggle-split " data-toggle="dropdown" aria-haspopup="true"                  aria-expanded="false" style="padding-right: 0px;padding-left: 5px; padding-top: 10px;color:#EAC67A;font-size:20px;">
                                <span class="sr-only" style="color:#EAC67A;">Toggle Dropdown</span>
                              </a>
                              <div class="dropdown-menu" style="color: #EAC67A;margin-right:2em;">
                                <a class="dropdown-item" href="usuarioCV/perfil.php">Editar Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="administracion/index.php">Ir a Administración</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="cerrarSesion">Cerrar sesión</a>
                              </div>
                            </div>');
                        }
                    }

                    else if (isset($_SESSION["id_usuario"])){
                        echo ('
                        <div class="btn-group" style="margin-right: 7em;">
                            <a href="#" class=""><i class="fas fa-user-circle  fa-3x" style="color:#EAC67A;display:none" id="iconU"></i>
                                        <div id="imgNP" ></div></a>
                              <a href="#" class="dropdown-toggle dropdown-toggle-split " data-toggle="dropdown" aria-haspopup="true"                  aria-expanded="false" style="padding-right: 0px;padding-left: 5px; padding-top: 10px;color:#EAC67A;font-size:20px;">
                                <span class="sr-only" style="color:#EAC67A;">Toggle Dropdown</span>
                              </a>
                              <div class="dropdown-menu" style="color: #EAC67A;margin-right:2em;">
                                <a class="dropdown-item" href="usuarioCV/perfil.php">Editar Perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="cerrarSesion">Cerrar sesión</a>
                              </div>
                            </div>
                        ');
                    }
                    else{
                        echo ('<li class="nav-item"><button type="button" style="padding:.40em;" class="btn btn btn-outline-success" id="iniciarSesionBoton" data-toggle="modal" data-target="#modalFormularioLogin">Ingresa</button></li>');
                    }

                ?>
            </ul>
        </div>
    </nav>

    
    <div class="container" style="margin-top: 2em; padding: 0px;" id=main>
        <div class="row">
            <div class="col col-md-8">
                <div class="container">
                    <div class="row" id="anuncios">
                       
                    </div>
                </div>
            </div>
            <div class="col col-md-3">
                <div class="container filtros" style="margin-left: 4em;">
                    <div class="row rowFiltros">
                        <div class="col col-lg-12">
                            <h3>Detalla tu búsqueda</h3>
                        </div>
                    </div>
                    <div class="row rowFiltros">
                        <div class="col col-lg-12">
                            <Strong>Filtra por departamento:</Strong>
                            <select class="form-control selects_locacion" style="width: 70%;" id="departamentos"
                                onchange="traerMunicipios()">
                                <!-- <option value="null" class="form-control">Selecciona un departamento</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row rowFiltros">
                        <div class="col col-lg-12">
                            <Strong>Filtra por ciudad:</Strong>
                            <select name="" id="municipios" class="form-control selects_locacion" style="width: 70%;">
                                <option value="null" class="form-control">Selecciona una ciudad</option>
                            </select>
                        </div>
                    </div>
                    <div class="row rowFiltros">
                        <div class="col col-lg-12" style="text-align: center;">
                            <Strong>Detalla un rango de precios:</Strong>
                            <br>
                            <label class="" for="desde">Desde</label>
                            <input type="text" class="form-control" id="desde">
                            <div style="display: none; margin-left: auto;margin-right: auto; width: 40%;padding: .1em;"
                                class="alert alert-danger" role="alert" id="mensajeDesde">
                                No es un número.
                            </div>

                            <br>
                            <label class="" for="hasta">Hasta</label>
                            <input type="text" class="form-control" id="hasta">
                            <div style="display: none; margin-left: auto;margin-right: auto; width: 40%;padding: .1em;"
                                class="alert alert-danger" role="alert" id="mensajeHasta">
                                No es un número.
                            </div>
                        </div>
                    </div>
                    

                    <br>
                    <button id="btn-filtros" type="button" class="btn btn-outline-success" style="margin-left: auto;margin-right: auto;padding-inline: 4em; margin-top: 1em;">Filtrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="segundaFila" style="margin-top: 2em;">
            <div class="col col-lg-12" id="segundaFila"></div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalFormularioLogin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <div class="modal-body">
                    <form id="login-form">
                        <div style="text-align: center; margin-top: 1em; margin-bottom: 2em;">
                            <h4>Ingresa para poder comprar y vender.</h4>
                        </div>
                        <div class="form-group">
                            <!-- <label>Email</label> -->
                            <input type="email" class="form-control" id="correo" name="correo"
                                placeholder="Ingrese su correo electrónico">
                            <small style="display: none;" id="aviso" class="form-text text-muted">Debes haberte
                                registrado
                                para
                                poder
                                ingresar.</small>
                        </div>
                        <div class="form-group">
                            <!-- <label for="exampleInputPassword1">Contraseña</label> -->
                            <input type="password" class="form-control" id="contrasena" name="contrasena"
                                placeholder="Contraseña">
                            <small style="display: none;" id="avisoContrasena" class="form-text text-muted">Contraseña
                                Incorrecta</small>

                            <small><a href="#">
                                    ¿Olvidaste tu contraseña?
                                </a></small>

                        </div>

                        <div style="margin-left: auto;margin-right: auto;" class="text-center">
                            <button type="button" class="btn btn-primary" id="login-button"
                                style=" width: 15em !important;">Ingresar</button>

                        </div> <br>

                        <div class="alert alert-danger" id="mensajeDadodeBaja" style="display:none;text-align:center;">
                            Estás dado de baja actualmente </div>

                        <br>
                        <div class="text-center">
                            <small>¿No tienes una cuenta? </small>
                            <a href="/reg.php">
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#modalRegistro" id="crearCuenta">
                                    Crea una cuenta
                                </button>
                            </a>
                        </div>

                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
            <!-- </div> -->
        </div>



        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/fontsawesome.min.js"></script>
        <script src="js/busqueda.js"></script>
</body>

</html>