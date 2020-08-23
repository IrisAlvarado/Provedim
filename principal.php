<?php
    session_start();
    
    if(empty($_SESSION['active'])){
        header('location: ingresar.php');

    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Provedim</title>
        <link href="css/disenio.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed" background="img/fondu2.jpg">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">PROVEDIM</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <!--<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>-->
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo "Usuario"; ?> <i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Configuración</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Salir</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="principal.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Inicio</a>
                            
                            <a class="nav-link" href="AgregarProducto/categorias.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                categorías
                            </a>
                            
                            
                            <a class="nav-link" href="catalogo.php"
                                ><div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Catálogo</a
                            >
                            <a class="nav-link" href="AgregarProducto/index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Agregar producto
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Ingreso a:</div>
                        Provedim
                    </div>
                </nav>
            </div>


            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Bienvenido</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"></li>
                        </ol>
                        <h2>Somos una plataforma que le ayuda a promocionar sus productos médicos y de bioseguridad.</h2>
                        <h5>Nuestras Opciones</h5>
                        <div class="row">
                          <div class="card border-success mb-3" style="max-width: 18rem;">
                            <h5 class="card-title"></h5>
                            <div class="card-header">Catálogo</div>
                            <div class="card-body text-success">
                            
                            <p class="card-text">Le permite visualizar el catálogo de productos que se muestran al usuario, donde se puede filtrar para obtener mejores resutados en la búsqueda de productos que están publicados dentro de la plataforma.</p>
                            <a href="../catalogo.php">Ir a catálogo</a>
                        </div>
                    </div>
                    <br>........</br>

                    <div class="card border-warning mb-3" style="max-width: 18rem;">
                        <div class="card-header">Categorías</div>
                        <div class="card-body text-warning">
                            <h5 class="card-title"></h5>
                            <p class="card-text">Si ud al publicar un producto necesita una categoría y esta no se encuentra en las opciones, en esta página ud puede crear esa nueva categoría, de igual manera puede visualzar las categorías creadas por ud.</p>
                            <a href="categorias.php">Ir a catálogo</a>
                        </div>
                    </div>
                    <br>........ </br>
                    <div class="card border-info mb-3" style="max-width: 18rem;">
                        <div class="card-header">Agregar Producto</div>
                        <div class="card-body text-info">
                            <h5 class="card-title"></h5>
                            <p class="card-text">En esta sección ud podrá agregar nuevos productos, a través de un formulario donde colocará datos especifícos del producto que desea publicar.</p>
                            <br></br>
                            <a href="index.html">Ir a catálogo</a>
                        </div>
                    </div>


                            
                    </div>  
                        
                        
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Provedim</div>
                            <div>
                                <a href="#">Política de privacidad</a>
                                &middot;
                                <a href="#">Terminos &amp; Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/login.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
</html>
