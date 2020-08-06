<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">



    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="css/fontsawesome.min.css">
    <script src="js/fontsawesome.min.js"></script>

    <link rel="stylesheet" href="css/inicio.styles.css">


    <link rel="stylesheet" href="css/inicio.css">


</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #FF5858!important;">
        <a class="navbar-brand font-weight-bold" href="#">PROVEDIM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="usuarioCV/favoritos.php"  >Catálogo <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active font-weight-bold">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#modalPublicar" id="btn-publicar"
                        style="margin-left:1em;padding-left: 0px;padding-right: 0px; width:10em;">Cotizaciones</a>
                </li>
                <li class="nav-item " id="categorias">

                    <select class="custom-select" id="categoriasElementos">
                        <option value="null" selected>Todas</option>
                    </select>


                    </select>
                </li>

            </ul>
            <form class="form-inline my-2 my-lg-0" id="formBusqueda" style="width: 50%;">
                <input class="form-control mr-sm-2" type="search" id="inputBusqueda"
                    placeholder="Buscar por palabra clave" aria-label="Search">
                <button class="btn btn-info my-2 my-sm-0 " type="button" id="btn-busqueda" style="">Buscar</button>
            </form>
            <!---color: #fff;background-color: #9C27B0;border-color: #9C27B0;-->

            <ul class="navbar-nav mr-auto">

                <?php
                    session_start(); 
                    if (isset($_SESSION["id_usuario"])){
                        echo ('<div class="btn-group" style="margin-right: 5em;">
        <a href="#" class=""><i class="fas fa-user-circle  fa-3x" style="color:#EAC67A;display:none" id="iconU"></i>
                    <div id="imgNP" ></div></a>
          <a href="#" class="dropdown-toggle dropdown-toggle-split " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-right: 0px;padding-left: 5px; padding-top: 10px;color:#EAC67A;font-size:20px;">
            <span class="sr-only" style="color:#EAC67A;">Toggle Dropdown</span>
          </a>
          <div class="dropdown-menu" style="color: #EAC67A;margin-right:2em;">
            <a class="dropdown-item" href="usuarioCV/perfil.php">Editar Perfil</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" id="cerrarSesion">Cerrar sesión</a>
          </div>
        </div>' );
                    }
                    else{
                        echo ('<li class="nav-item"><button type="button" class="btn" id="iniciarSesionBoton" data-toggle="modal" data-target="#modalFormularioLogin"> Ingresa</button></li>');
                    }
                ?>
            </ul>
        </div>
    </nav>


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
                            <h4>Sign In</h4>
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

                            <small><a href="reestablecer_contrasena.html?valid=1">
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
                            <a href="reg.php" class="btn btn-success" id="crearCuenta" onclick="">
                                Crea una cuenta
                            </a>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
        </div>
    </div>


    <br>




    <!-- //slide 0 -->
    <div class="container my-4">

        <h3 id="tituloCategoria0"></h3>
        <div style="display:inline" id="linkCategoria0">
            <!-- <a href="Google.com">Ver todos</a>
            <i style="margin-left:1em;" class="fas fa-arrow-right"></i> -->
        </div>

        <!--Carousel Wrapper-->
        <div id="slide0" class="carousel slide carousel-multi-item" data-ride="carousel">

            <!--Controls-->
            <div class="controls-top" style="text-align:center;">
                <a class="btn-floating" href="#slide0" data-slide="prev">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a class="btn-floating" href="#slide0" data-slide="next"><i class="fas fa-arrow-right"></i></a>
            </div>
            <!--/.Controls-->

            <br>
            <br>

            <!--Indicators-->
            <ol class="carousel-indicators" id="categoriaControl0">
                <!-- <li data-target="#multi-item-example" data-slide-to="0" style="background-color:black;" class="active">
        </li>
        <li data-target="#multi-item-example" data-slide-to="1" style="background-color:black;"></li>
        <li data-target="#multi-item-example" data-slide-to="2" style="background-color:black;"></li> -->
            </ol>
            <!--/.Indicators-->

            <!--Slides-->
            <div class="carousel-inner" role="listbox" style="margin-bottom:1em;" id="categoriaSlide0">

                <!--First slide-->
                <div class="carousel-item active">


                </div>
                <!--/.First slide-->

                <!--Second slide-->
                <div class="carousel-item">
                </div>
                <!--/.Second slide-->

                <!--Third slide-->
                <div class="carousel-item">
                </div>
                <!--/.Third slide-->

            </div>
            <!--/.Slides-->

        </div>
        <!--/.Carousel Wrapper-->


    </div>


    <br>

    

    

    <!-- //slide 1 -->
    <div class="container my-4">

        <h3 id="tituloCategoria1"></h3>

        <div style="display:inline" id="linkCategoria1">
            <!-- <a href="Google.com">Ver todos</a>
            <i style="margin-left:1em;" class="fas fa-arrow-right"></i> -->
        </div>


        <!--Carousel Wrapper-->
        <div id="slide1" class="carousel slide carousel-multi-item" data-ride="carousel">

            <!--Controls-->
            <div class="controls-top" style="text-align:center;">
                <a class="btn-floating" href="#slide1" data-slide="prev">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <a class="btn-floating" href="#slide1" data-slide="next"><i class="fas fa-arrow-right"></i></a>
            </div>
            <!--/.Controls-->

            <br>
            <br>

            <!--Indicators-->
            <ol class="carousel-indicators" id="categoriaControl1">
                <!-- <li data-target="#multi-item-example" data-slide-to="0" style="background-color:black;" class="active">
        </li>
        <li data-target="#multi-item-example" data-slide-to="1" style="background-color:black;"></li>
        <li data-target="#multi-item-example" data-slide-to="2" style="background-color:black;"></li> -->
            </ol>
            <!--/.Indicators-->

            <!--Slides-->
            <div class="carousel-inner" role="listbox" style="margin-bottom:1em;" id="categoriaSlide1">

                <!--First slide-->
                <div class="carousel-item active">


                </div>
                <!--/.First slide-->

                <!--Second slide-->
                <div class="carousel-item">
                </div>
                <!--/.Second slide-->

                <!--Third slide-->
                <div class="carousel-item">
                </div>
                <!--/.Third slide-->

            </div>
            <!--/.Slides-->

        </div>
        <!--/.Carousel Wrapper-->

    </div>

    <!--.....................................................................................................AGREGAR PUBLICACION.....................................................................................................-->
    <!-------------------------------------------------------BOTON AGREGAR PUBLICACION----------------------------------------->

    <!--------------------------------------------------VENTANA MODAL DE AVISO----------------------------------------------------->
    <div id="btn-ventana">
        <div class="modal fade" id="modalPublicar" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-color:black ; border-style:double; border-width: 2px;">
                    <!--Cabecera del Modal-->
                    <div class="modal-header">
                        <h4 style="color:black " class="modal-title">Atención</h4>
                        <button style="color: red;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!--Cuerpo del Modal-->
                    <div class="modal-body">
                        <p>Debes <strong>registrarte</strong> o haber <strong>iniciado sesion</strong> para poder
                            agregar publicaciones.<p>
                    </div>
                    <!--Pie del Modal-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modalFormularioLogin">Iniciar Sesion</button>
                        <a href="reg.php" class="btn btn-primary" id="crearCuenta" onclick="">
                            Crea una cuenta
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
</body>

<script src="js/inicio.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js.descarga"></script>
<!--Mostrar foto de perfil-->
<script src="js/fotoInicio.js"></script>
<!--.....................................................................................................AGREGAR PUBLICACION.....................................................................................................-->
<script src="js/publicar.js"></script>
<!--.........................................................................................FIN AGREGAR PUBLICACION........................................................................................................-->

</html>