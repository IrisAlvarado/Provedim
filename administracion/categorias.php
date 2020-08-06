<?php 

include '../backend/seguridad_admin.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>PUBLITODO</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<!--link href="css/font-awesome.css" rel="stylesheet"-->
	<link rel="stylesheet" type="text/css" href="../css/all.css">

	<!-- tablas-->
	<link rel="stylesheet" type="text/css" href="../css/dataTables.bootstrap4.min.css">
</head>
<body>
	<?php
      include 'navbarAdmin.php';
    ?>
	
	<div><br><br><br><br></div>	
	<!--Prueba-->
	<section id="main">
      <div class="container-fluid px-3">
        <div class="row">
        <!--Columna agregar o editar -->
          <div class="col-md-4" >
				 <!--Columna agregar -->
				 <br><br>
				<div class="py-5" id="agregarCat" name="agregarCat">
					<div class="list-group">
		              <button class="list-group-item active  bg-success text-light bg-dark" id="Agregar">
		                Agregar Categoria&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-plus-circle fa-lg"></i>
		              </button>
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
										<span class="alert " id="msjG"  style=" display: none; color:red"></span>
									</div>
								</div><br>
								<button type="button" id="btnGuardarC" name="btnGuardarC" class="btn  btn-block p-3 mb-2 bg-primary text-white font-weight-bold" onclick="guardarCategorias()">Guardar&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-save fa-lg"></i></button>
							</form>
						</div>
		             </div>
		            </div><br><br><br>
		        </div><!--Fin Columna agregar-->

		         <!--Columna editar -->

				<div id="editarCat" name="editarCat" style="display: none">
					<br>
					<div class="list-group">
		              <button class="list-group-item active  bg-success text-light bg-dark" id="Agregar">
		                Editar Categoria
		              </button>
		             <div class="list-group">
		             	<div class="py-3">
							<br><br><h3 class="font-weight-bold">Datos Categoria</h3>
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
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title"><h3 class="panel-title">Lista Categorias</h3>
                </div>
                <br><br>    
                <div><span class="alert alert-danger" id="msjDelete"  style=" display: none; color:red"></span><br><br></div>   
                <div id="div_ini"></div>
                <div id="div_table"></div>
          </div>
        </div>
      </div>
    </section>
	<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js.descarga"></script>

    <script src="../js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

    <script type="text/javascript" src="../js/controladorCategoria.js"></script>

    <script type="text/javascript" src="../js/fotoAdmin.js"></script>
</body>
</html>