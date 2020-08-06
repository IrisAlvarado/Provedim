<?php 

include '../backend/seguridad.php';

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/all.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes</title>
  <!--link href="../css/clasescss.css" rel="stylesheet" type="text/css"--->

  
  <link rel="stylesheet" href="../css/inicio.styles.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <!--link rel="stylesheet" href="css/vertical-menu.css"-->
  <!-- Custom styles for this template -->

</head>

<body>
  <?php
  include 'navbarAdmin.php';
  ?>
  <br><br><br>
  <div class="container-fluid py-5">
    <div class="row">
      <!--Lista navbar--->
      <div id="sidebar-wrapper" class="col-sm-5 col-md-2 col-lg-2  py-5">
          <div class="nav nav-sidebar colorNavI py-5 px-3">
            <br>
            <a class="lista btnNavI btn btn-dark btn-block py-1" href="reportes/denuncias.php">Reportes Denuncias</a><br>
            <!--a class="lista btn btn-dark  btn-block btnNavI py-1" href="reportesUsuarios.php" onclick="">Reportes Usuarios</a--><br>
            <a class="lista btnNavI btn btn-primary btn-block py-1 active" href="#" >Estadisticas</a>
            <a target="_blank" class="btn-primary btn btn-block lista btnNavI" href="reportes/empresas.php">Reporte Empresas</a>
            <a target="_blank" class="btn-primary btn btn-block lista btnNavI" href="reportes/usuarios.php">Reporte Compradores/ Vendedores</a>
            <a target="_blank" class="btn-primary btn btn-block btnNavI" href="reportes/anuncios.php">Reporte Anuncios</a>
          </div>
        </div><!--Fin lista Navbar-->

         <!-- Barra Izquierda & Contenido de la Pagina -->
        <div class="col-lg ">
          <br><br><br><br>
          <div id="divEstadisticas"></div>
          <h4>Estadisticas</h4> 
          <div class="container">
            <div class="row">
              <div class="col-lg">
                <div class="panel panel-primary">
                  <div class="panel panel-heading"></div>
                  <div class="panel panel-body">
                    <div class="row">
                        <!--div class="col-sm">
                          <div id="cargaPastel"></div>
                        </div-->
                        <div class="col-sm">
                          <div id="cargaLineal"></div>
                        </div>
                        <div class="col-sm">
                          <div id="cargaBarra"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            
            <br></br>
            <input type="button" class="btn btn-success" name="imprimir" value="Imprimir" onclick="window.print();">
      </div> 
    </div>
  </div>


</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script src="../Graficas/Librerias/jquery-3.4.1.min.js"></script>
<script src="../Graficas/Librerias/plotly-latest.min.js"></script>

<script src="../js/bootstrap.bundle.min.js.descarga"></script>
<!--script src="js/controlador_estadisticas.js"></script-->
<script type="text/javascript" src="../js/fotoAdmin.js"></script>

</html>

<script type="text/javascript">
  $(document).ready(function () {

    $('#cargaBarra').load('../Graficas/graficoBarra.php');
    $('#cargaPastel').load('../Graficas/graficoPastel.php');
    $('#cargaLineal').load('../Graficas/graficoLineal.php');
    console.log("DOM cargado");

  });
</script>


