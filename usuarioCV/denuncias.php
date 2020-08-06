<?php 

include '../backend/seguridad.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Denuncias</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/all.css">
	<!-- tablas-->
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap4.min.css">
</head>
<body>
	<?php
	include 'navbarU.php';
	?>

	<!--Contenido div tabla denuncias -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 py-5">
				<!--Mostrar mensaje-->

				<br><br><br>
				<input type="text" name="idUL" id="idUL" style="display: none">
				<h3 class="text-center">Lista de denuncias</h3>
				<br>
				<div class="text-center">
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
	
</body>

<script  src="../js/jquery-3.4.1.min.js"></script>
<script  src="../js/bootstrap.min.js"></script>
<script  src="../js/bootstrap.bundle.min.js.descarga"></script>
<!--tablas--->
<script src="../js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<!--controlador--->
<script  src="../js/denuncias.js"></script>
<!--foto perfil usuario--->
<script type="text/javascript" src="../js/fotoAdmin.js"></script>
</html>