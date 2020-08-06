<?php 

include '../backend/seguridad.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Publicaciones</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--  /Booststrap -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/publicaciones_perfil.css">

</head>
<body>
	<?php
	include 'navbarU.php';
	?>
<br><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-12 py-1">
   <br><br>
				<input type="text" name="idUsuario" id="idUsuario" style="display: none">
    <div class="btn-group-vertical">
				<a href="agregarPublicacion.php"  style="margin-left:2em;" class="btn btn-outline-success btn-lg btn-block" id="btnAdd"><i class="fas fa-plus-circle" ></i>Agregar Publicaciones</a>
		</div>
	</div><!--fin menu--->

	<div class="col-md-12 py-5 px-5">
		<center><h3>Mis Publicaciones</h3></center>
		<br>
		<div class="row" id="anuncios">
			<div class="row" id="anunciosM">
		</div>
		</div>
		
	</div>
</div>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.bundle.min.js.descarga"></script>

<script src="../js/controladorPublicaciones.js"></script>

<script type="text/javascript" src="../js/fotoAdmin.js"></script>

</body>

