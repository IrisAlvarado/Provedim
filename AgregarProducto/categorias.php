<?php

//include '../backend/seguridad_admin.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Provedim</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<!--link href="css/font-awesome.css" rel="stylesheet"-->
	<link rel="stylesheet" type="text/css" href="../css/all.css">
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap4.min.css">
	<!-- tablas-->
		<link
			rel="stylesheet"
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
			integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
			crossorigin="anonymous"
		/>

	<link rel="stylesheet" type="text/css" href="../css/navbarAdmin.css">
	<link rel="stylesheet" href="css/estilos.css" />
	<link rel="stylesheet" href="fonts.css" />
</head>
<body>
	<?php
      //include 'navbarAdmin.php';
    ?>
		<div class="sidebar">
			<ul>
				<h2>MENÚ</h2>
				<li>
					<a href="index.html"><span class="icon-home"></span>INICIO</a>
				</li>
				<li>
					<a href=""><span class="icon-file-text"></span>CATÁLOGO</a>
				</li>
				<li>
					<a href=""><span class="icon-cart"></span>PRODUCTOS</a>
				</li>
				<li>
					<a href="categorias.php"><span class="icon-list"></span>CATEGORÍAS</a>
				</li>
				<li>
					<a href=""><span class="icon-stats-bars"></span>COTIZACIONES</a>
				</li>
				<li>
					<a href=""><span class="icon-question"></span>AYUDA</a>
				</li>
				<li>
					<a href=""><span class="icon-cog"></span>CONFIGURACIÓN</a>
				</li>
			</ul>
		</div>

		<div id="contenido" class="contenido">
			<h2>
				<a href="#"><span class="icon-menu"></span></a> PROVEDIM
			</h2>
			<h3>
				Proveedor<a href="#"><span class="icon-user-tie"></span></a>
			</h3>
			<div class="nom-prov">
				<div id="img">
					<img id="logo" src="img/logoprov.png" alt="" />
				</div></div>
	<div></div>
	<!--Prueba-->
	<section id="main">
      <div class="container-fluid px-3">
        <div class="row">
        <!--Columna agregar o editar -->
          <div class="col-md-4" >
				 <!--Columna agregar -->
				 <br><br><br><br><br><br>

				<div class="py-5 jumbotron" id="agregarCat" name="agregarCat">
					<div class="list-group">
		              <!--button class="list-group-item active  bg-success text-light bg-dark" id="Agregar">
		                Agregar Categoria&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-plus-circle fa-lg"></i>
		              </button-->
		              <h2 id="addCat">Agregar Nueva Categoria</h2>
		             <div class="list-group">
		             	<div class="py-1">
							<br><br><h4 class="font-weight-bold">Datos Categoria</h4>
							<form class="py-4">
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtCat">Nombre Categoria</label>
									</div>
									<div class="col-6 ">
										<input type="text" id="nombreCat" name="nombreCat" class="form-control"><br>
										<span id="avisoCat"  style=" display: none; color:red">Debe llenar la categoria</span>
										<span class="alert " id="msjG"  style=" display: none; color:blue"></span>
									</div>
								</div><br>
								<button type="button" id="btnGuardarC" name="btnGuardarC" class="btn  btn-block p-3 mb-2 bg-primary text-white font-weight-bold" onclick="guardarCategorias()">Guardar&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-save fa-lg"></i></button>
							</form>
						</div>
		             </div>
		            </div><br><br><br>
		        </div><!--Fin Columna agregar-->

		         <!--Columna editar -->

				<div class="" id="editarCat" name="editarCat" style="display: none">
					<br><br><br>
					<div class="list-group">
		              <button class="list-group-item active  bg-success text-light bg-dark" id="Agregar">
		                Editar Categoria
		              </button>
		             <div class="list-group">
		             	<div class="py-4">
		             		<br>
		             		<div class="row">
		             		<div class="col-md-8 " >
							<h3 class="font-weight-bold" id="dates" >Datos de Categoria</h3>
							</div>
						</div>
							<form class="py-4">
								<div class="form-row " style="display: none">
									<div class="col-5 ">
										<label id="txtCod">Codigo</label>
									</div>
									<div class="col-7 ">
										<input type="text" id="cod" name="cod" class="disabled form-control ">
									</div>
								</div><br>
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtCat">Nombre Categoria</label>
									</div>
									<div class="col-7 ">
										<input type="text" id="nombreCatEdit" name="nombreCatEdit" class="form-control">
										<span id="avisoCatE" style="display: none;color:red">Debe llenar la categoria</span>
										<span class="alert " id="msjE"  style=" display: none; color:red"></span>
									</div>
								</div><br>
								<button type="button" id="btnEditarC" name="btnEditarC" class="btn  btn-block p-3 mb-2 bg-primary text-white font-weight-bold" onclick="editCategorias()">Editar</button>
							</form>
						</div>
		             </div>
		            </div><br><br><br>
		        </div><!--Fin Columna editar-->

        </div> <!--Fin Columna agregar o editar-->
		<div class="col-1"></div>
        <div class="col-md-7 px-5">
            <!-- Vista rápida del sitio -->
              <!-- últimos usuarios -->
              <div class="panel panel-default">
              	<br><br><br>
                <div class="panel-heading main-color-bg contenedorTitle">
                  <h3 class="panel-title"><h1 class="panel-title" id="listcat">Lista de Categorias</h1>
                </div>

                <div><span class="alert alert-danger" id="msjDelete"  style=" display: none; color:red"></span><br><br></div>
                <div id="div_ini"></div>
                <div id="div_table"></div>
          </div>
        </div>
      </div>
      </div>
    </section>
	<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js.descarga"></script>

    <script src="../js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="../js/all.js"></script>
    <script type="text/javascript" src="../js/controladorCategoria.js"></script>

    <script type="text/javascript" src="../js/fotoAdmin.js"></script>
    		<!--Script para la integración de JavaScrpt-->


    <script src="abrir_menu.js"></script>
    <script src="validarProducto.js"></script>
</body>
</html>
