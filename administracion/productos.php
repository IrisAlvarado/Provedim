<?php 

include '../backend/seguridad_admin.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Anuncios</title>
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
				 <br>
				<div class="py-3" id="agregarProducto" name="agregarProducto">
					<div class="list-group">
		              <button class="list-group-item active  bg-success text-light bg-dark" id="Agregar">
		                Agregar &nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-plus-circle fa-lg"></i>
		              </button>
		             <div class="list-group">
		             	<div class="py-1">
							<br><h4 class="font-weight-bold">Datos: </h4>
							<form class="py-4">
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtPro">Nombre Producto:</label>
									</div>
									<div class="col-7 ">
										<input type="text" id="nombrePro" name="nombrePro" class="form-control">
										<span id="avisoPro"  style=" display: none; color:red">Debe llenar el nombre</span><br>
									</div>
								</div>
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtTipo">Tipo:</label>	
									</div>
									<div class="col-7 ">
										<select id="slcTipo" name="slcTipo" class="form-control">
											<option value="null">Seleccione una opcion</option>
											<option value="producto">Producto</option>
											<option value="servicios">Servicio</option>

										</select>
										<span id="avisoTipo"  style=" display: none; color:red">Debe seleccionar un tipo</span><br>
									</div>
								</div>
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtCat">Nombre Categoria:</label>
										
									</div>
									<div class="col-7 ">
										<select id="slcCat" name="slcCat" class="form-control" disabled="">
											<option value="null">Seleccione una categoria</option>
										
										</select>
										<span id="avisoCat"  style=" display: none; color:red">Debe seleccionar la categoria</span><br>
									</div>
								</div>
								<div class="form-row ">
									<div class="col-3 ">
										<label id="txtDes">Descripcion:</label>
									</div>
									<div class="col-9 ">
										<textarea class="form-control" id="descripcionPro" rows="4"></textarea><br>
										<span id="avisoD"  style=" display: none; color:red">Debe llenar la descripcion</span>
									</div>
								</div>
								<button type="button" id="btnGuardarP" name="btnGuardarC" class="btn  btn-block p-3 mb-2 bg-primary text-white font-weight-bold" onclick="guardarProductos()">Guardar&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-save fa-lg"></i></button>
							</form>
						</div>
		             </div>
		            </div><br><br><br>
		        </div><!--Fin Columna agregar-->

		         <!--Columna editar -->
				<div class="py-3" id="editarProducto" name="editarProducto" style="display: none">
					<div class="list-group">
		              <button class="list-group-item active  bg-success text-light bg-dark" id="editar">
		                Editar &nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-plus-circle fa-lg"></i>
		              </button>
		             <div class="list-group">
		             	<div class="py-1">
							<br><h4 class="font-weight-bold">Datos </h4>
							<form class="py-4">
								<div class="form-row " style="display: none">
									<div class="col-5 ">
										<label id="txtCod">Codigo</label>
									</div>
									<div class="col-7 ">
										<input type="text" id="cod" name="cod" class="disabled form-control ">
									</div>
								</div>
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtProE">Nombre :</label>
									</div>
									<div class="col-7 ">
										<input type="text" id="nombreProE" name="nombreProE" class="form-control">
										<span id="avisoProE"  style=" display: none; color:red">Debe llenar el nombre</span><br>
									</div>
								</div>
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtTipo">Tipo:</label>	
									</div>
									<div class="col-7 ">
										<select id="slcTipoE" name="slcTipoE" class="form-control">
											<option value="null">Seleccione una opcion</option>
											<option value="producto">Producto</option>
											<option value="servicios">Servicio</option>

										</select>
										<span id="avisoTipoE"  style=" display: none; color:red">Debe seleccionar un tipo</span><br>
									</div>
								</div>
								<div class="form-row ">
									<div class="col-5 ">
										<label id="txtCat">Nombre Categoria:</label>
										
									</div>
									<div class="col-7 ">
										<select id="slcCatE" name="slcCatE" class="form-control" >
											<option value="null">Seleccione una categoria</option>
										
										</select>
										<span id="avisoCatE"  style=" display: none; color:red">Debe seleccionar la categoria</span><br>
									</div>
								</div>
								<div class="form-row ">
									<div class="col-3 ">
										<label id="txtDesE">Descripcion:</label>
									</div>
									<div class="col-9 ">
										<textarea class="form-control" id="descripcionProE" rows="4"></textarea>
										<span id="avisoDProE"  style=" display: none; color:red">Debe llenar la descripcion</span><br>
									</div>
								</div>
								<button type="button" id="btnGuardarPE" name="btnGuardarC" class="btn  btn-block p-3 mb-2 bg-primary text-white font-weight-bold" onclick="editProductos()">Guardar&nbsp;&nbsp;&nbsp;&nbsp; <i class="fas fa-save fa-lg"></i></button>
							</form>
						</div>
		             </div>
		            </div><br><br><br>
		        </div>
				<!--Fin Columna editar-->

        </div> <!--Fin Columna agregar o editar-->
		<!--div class="col-1"></div-->
        <div class="col-md-8 px-4">
            <!-- Vista rápida del sitio -->
              <!-- últimos usuarios -->
              <div class="panel panel-default">
                <div class="panel-heading main-color-bg">
                  <h3 class="panel-title text-center">Lista Productos Y Servicios</h3>
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

    <script src="../js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

	<script src="../js/bootstrap.bundle.min.js.descarga"></script>

    <script type="text/javascript" src="../js/controladorProductos.js"></script>

    <script type="text/javascript" src="../js/fotoAdmin.js"></script>
</body>
</html>