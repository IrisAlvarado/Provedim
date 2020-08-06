
<!DOCTYPE html>
<html>
<head>
	<title>PUBLITODO</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/all.css">
	<link rel="stylesheet" type="text/css" href="../css/navbarAdmin.css">
</head>
<body>
	<!--barra de navegacion para el administrador-->
	<div class="fixed-top">
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark colorNavbar">
		  <a class="navbar-brand font-weight-bold" href="index.php" id="index">PUBLITODO</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item " id="publicaciones">
		        <a class="nav-link  font-weight-bold" href="publicaciones-admin.php">Publicaciones <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item " id="usuarios">
		        <a class="nav-link  font-weight-bold" href="verUsuariosDesdeAdminF.php" tabindex="-1" aria-disabled="true">Usuarios</a>
		      </li>
			  <li class="nav-item " id="solicitudes">
		        <a class="nav-link  font-weight-bold" href="solicitudes_administracion.php" tabindex="-1" aria-disabled="true">Solicitudes</a>
		      </li>
		      <li class="nav-item " id="categorias">
		        <a class="nav-link  font-weight-bold" href="categorias.php" tabindex="-1" aria-disabled="true">Categorias</a>
		      </li>

		   	  <!--li class="nav-item" id="productos">
		        <a class="nav-link  font-weight-bold" href="productos.php" tabindex="-1" aria-disabled="true">Productos</a>
		      </li--->

		      <li class="nav-item" id="denuncias">
		        <a class="nav-link  font-weight-bold" href="denuncias.php" tabindex="-1" aria-disabled="true">Denuncias</a>
		      </li>
		      <li class="nav-item" id="reportes">
		        <a class="nav-link  font-weight-bold" href="estadisticas.php" tabindex="-1" aria-disabled="true">Reportes</a>
		      </li>
		    </ul>
		    <form class="form-inline my-2 my-lg-0">
		    <div class="btn-group" style="">
  				<a href="#" class=""><i class="fas fa-user-circle  fa-3x" style="color:rgb(202, 211, 220);display:none" id="iconU"></i>
  			<!--id="iconU"-->
		    	<div id="imgNP" ></div></a>
		  		<a href="#" class="dropdown-toggle dropdown-toggle-split " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-right: 80px;padding-top: 10px;color:rgb(202, 211, 220);font-size:20px;">
		    <span class="sr-only">Toggle Dropdown</span>
		  </a>
		  <div class="dropdown-menu">
		    <a class="dropdown-item" href="perfilAdmin.php">Editar Perfil</a>
		    <div class="dropdown-divider"></div>
		    <a class="dropdown-item" href="#" id="cerrarSesion">Cerrar sesión</a>
		  </div>
		</div>
		    </form>
		  </div>
		</nav>
	</div>
	<script src="../js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="../js/all.js"></script>
	<script src="../js/bootstrap.bundle.min.js.descarga"></script>


</body>
</html>
