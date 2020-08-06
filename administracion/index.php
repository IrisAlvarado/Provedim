<?php 

include_once('../backend/seguridad_admin.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ADMINISTRACION</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
	<?php 

    //llamado a nabvar
    include_once('navbarAdmin.php');

    ?>
	<br><br><br>
   <div class="container-fluid"  style="background-color: green">
   	<br>
   	<h3 class="text-warning"><i class="fas fa-cog fa-lg" id="iconU"></i> Panel de administracion</h3>
   	<br>
   </div><br><br>

   <div class="container-fluid">
   	<div class="row">
   		<div class="col-12 col-md-2 bg-dark colorNavI">
   			<br><br>
   			<div class="btn-group-vertical">
				<a href="publicaciones-admin.php" class="btn btn-dark btn-lg btn-block btnNavI">Publicaciones</a>
				<a href="verUsuariosDesdeAdminF.php" class="btn btn-dark btn-lg btn-block btnNavI">Usuarios</a>
				<a href="solicitudes_administracion.php" class="btn btn-dark btn-lg btn-block btnNavI">Solicitudes</a>

				<a href="categorias.php" class="btn btn-dark btn-lg btn-block btnNavI">Categorias</a>
				<!--a href="productos.php" class="btn btn-dark btn-lg btn-block btnNavI">Productos</a-->
				<a href="denuncias.php" class="btn btn-dark btn-lg btn-block btnNavI">Denuncias</a>
				<a href="reportesDenuncias.php" class="btn btn-dark btn-lg btn-block btnNavI">Reportes</a>
				<!--a href="#" class="btn btn-dark btn-lg btn-block" type="button" data-toggle="modal" data-target="#exampleModal">Agregar usuario administrador</a-->
				<button type="button" class="btn btn-dark btn-lg btn-block btnNavI" data-toggle="modal" data-target="#exampleModal">
				  Registrar usuario administrador
				</button>
				<?php 

			    //llamado a modal de registro
			    include 'modalRegAdmin.php';

			    ?>
	</div>
   			<br><br><br><br>
   		</div>
   		<div class="col-10 alert alert-secondary py-5">
   			 <div class="alert alert-dark">
   			 	<h3 class="text-center text-success font-weight-bold">Vista rapida</h3>
   			 </div>
   			 <div class="row">
   			 	<div class="col-sm-3">
   			 		<div class="card" style="width: 18rem;">
   			 			<img src="../imgUsers/usuarios.jpeg" class="card-img-top" style="
						    height: 188px;">
   			 			<div class="card-body" id="cantUs">
   			 			</div>
   			 		</div>
   			 	</div>
   				<div class="col-sm-3">
   			 		<div class="card" style="width: 18rem;">
   			 			<img src="../imgUsers/publi.jpeg" class="card-img-top" >
   			 			<div class="card-body" id="cantPubli">
   			 		
   			 			</div>
   			 		</div>
   			 	</div>
   			 	<div class="col-sm-3">
   			 		<div class="card" style="width: 18rem;">
   			 			<img src="../imgUsers/prod.jpeg" class="card-img-top">
   			 			<div class="card-body" id="cantPro">
   			 			</div>
   			 		</div>
   			 	</div>
   			 	<div class="col-sm-3">
   			 		<div class="card" style="width: 18rem; ">
   			 			<img src="../imgUsers/servicios.jpeg" class="card-img-top" style="
						    height: 196px;
						    width: 280px;
						">
   			 			<div class="card-body" id="serviciosReg">
   			 			</div>
   			 		</div>
   			 	</div>
   			 </div>
   		</div>	 
   	</div>
   </div>

</body>

<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script type="text/javascript" src="../js/fotoAdmin.js"></script>
<script src="../js/bootstrap.bundle.min.js.descarga"></script>

<script src="../js/cantidadAdmin.js"></script>
</html>