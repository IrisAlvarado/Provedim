<?php 

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="css/bootstrap.min.css">
  <!--link href="css/font-awesome.css" rel="stylesheet"-->
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/all.css">
  <title>Reportes</title>
  <!--link  rel="stylesheet" type="text/css" href="../css/clasescss.css"-->
  <link rel="stylesheet" type="text/css" href="../css/navbarAdmin.css">
 <!-- tablas-->
  <link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap4.min.css">

  <!--link rel="stylesheet" href="css/vertical-menu.css"-->
  <!-- Custom styles for this template -->

</head>

<body>
  <?php
  include 'navbarAdmin.php';
  ?>
  <br><br><br>
  <!-- Envoltura Barra Izquierda & Contenido de la Pagina -->
  <div class="container-fluid py-5">
    <div class="row">
      <!--Lista navbar--->
      <div id="sidebar-wrapper" class="col-sm-5 col-md-2 col-lg-2  py-5">
          <div class="nav nav-sidebar colorNavI py-5 px-3">
            <br>
            <a class="lista btnNavI btn btn-primary btn-block py-1 active" href="#">Reportes Denuncias</a><br>
            <a class="lista btn btn-dark  btn-block btnNavI py-1" href="reportesUsuarios.php" onclick="">Reportes Usuarios</a><br>
            <a class="btn btn-dark  btn-block lista btnNavI py-1" href="Estadisticas.php" onclick="">Estadisticas</a>
            <a target="_blank" class="btn-primary btn btn-block lista btnNavI" href="reportes/empresas.php">Reporte Empresas</a>
        <a target="_blank" class="btn-primary btn btn-block lista btnNavI" href="reportes/usuarios.php">Reporte Compradores/ Vendedores</a>
        <a target="_blank" class="btn-primary btn btn-block lista btnNavI" href="reportes/anuncios.php">Reporte Anuncios</a>
          </div>
        </div><!--Fin lista Navbar-->
        <div class="col-lg">
          <br>
          <center>
            <h3>Lista Denuncias</h3>
          </center>
          <a target="_blank" class="btn-primary btn  lista btnNavI" href="reportes/denuncias.php">PDF</a>
          <input type="button"  class="btn btn-success" name="imprimir" value="Imprimir" onclick="window.print();">
          <br><br>
          <div id="div_ini"></div>
          <div id="div_table"></div>
          <br>
          <br>
          

        </div>
    </div>
  </div>
 
        <!-- Barra de Menu Izquierdo-->
        

        
      <div id="divUsuarios"></div>
      <div id="divEstadisticas" ></div>

    </div>

  </div>

</div> 


</div>  

<!--<input type="button" class="btn active color-principal bg-success" name="imprimir" value="Imprimir" onclick="window.print();">-->



</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap.bundle.min.js.descarga"></script>

<!--tablas--->
<script src="../js/jquery.dataTables.js" type="text/javascript"></script>
  <script src="../js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<script src="../js/controladorReportes.js"></script>

<script type="text/javascript" src="../js/fotoAdmin.js"></script>


</html>