<?php 

include '../backend/seguridad.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Agregar Publicacion</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/icons.css">
	<link rel="stylesheet" type="text/css" href="../css/customAddANuncio.css">
</head>
<body>

	<?php
	include 'navbarU.php';
	?>

	<div class="container-fluid py-5 px-4"><!---Inicio contenedor--->
		<div class="row"><!---Inicio columna--->
			<div class="col-md-4 py-3" ><!---INicio primera columna--->
		<center><h3 class="py-2" id="agregar">Agregar Aviso</h3>
		<h3 class="py-2" id="editar" style="display: none">Editar Aviso</h3></center>
					
		<div class="rounded-lg" style="background-color:#F4F7F8">
				<form action="/">
					<div class="row py-3 px-3">
						<div class="col-md-6">
							<input type="text" name="idUsuario" id="idUsuario" style="display:none;">
							<input type="radio" value="Producto" id="radioProducto" name="tipo" checked class="">
						<label for="radioProducto" class="radio">Producto</label>
						</div>
						<div class="col-md-6">
							<input type="radio" value="Servicio" id="radioServicio" name="tipo" class="">
						<label for="radioServicio" class="radio">Servicio</label>
						</div>
						<span id="msjTipo" style="color:red;display: none">Debe seleccionar una opcion.</span>
					</div>
					<fieldset>
						<legend><span class="number">1</span>Información del Aviso</legend>
						<div class="col-md-12 py-2">
							<label for="slc-categorias">Categoria: </label>
						</div>
						<div class="col-md-12">
							<select name="slc-categorias" id="slc-categorias" class="form-control">
							<option value="null">Seleccionar Categoria:</option>
						</select>
						<span id="msjCate" style="color:red;display: none">Debe seleccionar una categoria.</span>
						</div>
						<div class="col-md-12 py-2">
							<label for="titulo">Título/Nombre:</label>
						</div><div class="col-md-12">
							<input type="text" id="titulo" name="titulo" class="form-control">
							<span id="msjTitulo" style="color:red;display: none">Debe ingresar un titulo</span>
						</div><div class="col-md-12 py-2">
							<label for="descripcion" >Descripción:</label>
						</div>
						<div class="col-md-12">
							<textarea id="descripcion" name="descripcion" class="form-control"></textarea>
							<span id="msjdescripcion" style="color:red;display: none">Debe hacer una descripcion del producto.</span>
						</div>
						<div class="col-md-12 py-2">
							<label for="precio">Precio:</label>
						</div>
						<div class="col-md-12">
							<input type="number" id="precio" name="precio" class="form-control">
							<span id="msjPrecio" style="color:red;display: none">Debe escribir el precio</span>
						</div>
						<div class="row py-3">
							<div class="col-md-6">
							<input type="radio" value="1" id="radioLps" name="moneda" checked><label for="radioLps" class="radio" chec>Lempiras</label>
						</div>
						<div class="col-md-6 ">
							<input type="radio" value="2" id="radioDolar" name="moneda">
						<label for="radioDolar" class="radio">Dólares</label>
						</div>
						<span id="msjMoneda" style="color:red;display: none">Debe seleccionar una moneda</span>
						</div>		
					</fieldset>
					<button type="button" id="btnGuardar" class="btn btn-primary btn-block" onclick="registrarDatos();">Publicar Anuncio</button>
					<br>
					<p class="alert alert-danger" style="display: none" id="msjAviso"></p>
				</form>
			</div>
			</div><!---Fin primer columna--->
			<div class="col-md-8 py-5"><br>
				<div class="alert alert-danger"> Nota: Debe subir como minimo tres imagenes y maximo 8 imagenes.</div>
				<div class="rounded-lg" style="background-color:#F4F7F8">
				<section id="Images" class="images-cards px-3 py-3">
						<form action="" method="post" enctype="multipart/form-data" id="formulario">
							<div class="row">
								<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-xl-3" id="add-photo-container">
									<div class="add-new-photo first"  id="add-photo">
										<span>
											<i class="fas fa-plus-square"></i></span>
									</div>
									<input type="file" multiple id="file" name="file[]">
								</div>
							</div>
							<div id="respuesta" class="alert alert-info" style="display:none;"></div><br><br>
							<button type="button" class="btn btn-success" id="btnSubirImg" disabled="true">Subir Imagenes</button>
							</form> 
						</section>
					</div>
			</div><!---Fin segunda columna--->
		</div><!---Fin row--->
	</div><!---Fin container--->
	
	
</body>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.bundle.min.js.descarga"></script>

<script src="../js/controlador_AgregarPublicacion.js"></script>

<!--Controladores para subir fotos--->
<script src="../js/subirImagenAnuncio.js"></script>
<!--script src="../js/functions.js"></script-->
<script src="../js/bootstrap.bundle.min.js.descarga"></script>
<!--- Foto usuario-->
<script type="text/javascript" src="../js/fotoAdmin.js"></script>
</html>