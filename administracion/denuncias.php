<?php 

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>PUBLITODO</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/all.css">

	<!-- tablas-->
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap4.min.css">
</head>
<body>
	<!--Encabezado -->
	<?php
      include 'navbarAdmin.php';
    ?>
	<!--Fin Encabezado -->
	<!--Contenido div tabla denuncias -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 py-5">
				<!--Mostrar mensaje-->
				<br><br><br>
				<h3 class="text-center">Lista de denuncias</h3>
				<br>
				<div class="text-center">
					<span class="alert " id="msjE"  style=" display: none; color:red"></span>
				</div>
			</div>
		</div>
		<div class="row py-2">
			<div class="col-1"></div>
			<div class="col-10">
				<div id="div_ini"></div>
            	<div id="div_table"></div>
			</div>
			
		</div>
	</div>

	<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>

    <script src="../js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

	<script src="../js/bootstrap.bundle.min.js.descarga"></script>
    <!--script type="text/javascript" src="js/controladorCategoria.js"></script-->
    <script type="text/javascript" src="../js/controladorDenuncias.js"></script>

    <script type="text/javascript" src="../js/fotoAdmin.js"></script>
</body>
</html>