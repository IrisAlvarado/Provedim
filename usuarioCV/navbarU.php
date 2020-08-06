<!DOCTYPE html>
<html>

<head>
	<title>PROVEDIM</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/all.css">
	<link rel="stylesheet" type="text/css" href="../css/custom.css">
</head>

<body>
	<!--barra de navegacion para el usuario-->
	<div class="fixed-top">
	<!-- 091f36  -->
	<!-- EA1D5D -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top navbarP" style="background-color: #FF5858;">
			<a class="navbar-brand font-weight-bold" href="../index.php" id="index">PROVEDIM</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
				aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item " id="publicaciones">
						<a class="nav-link  font-weight-bold navBarN" href="publicaciones.php">Catálogo</span></a>
					</li>
					<li class="nav-item " id="favoritos">
						<a class="nav-link  font-weight-bold" href="favoritos.php" tabindex="-1"
							aria-disabled="true">Cotizaciones</a>
					</li>
				</ul>
				<form class="form-inline my-2 my-lg-0 formN" style="background-color: transparent">
					<div class="btn-group">
						<a href="#" class=""><i class="fas fa-user-circle  fa-3x" style="color:#212529;display:none"
								id="iconU"></i>
							<div id="imgNP"></div>
						</a>
						<a href="#" class="dropdown-toggle dropdown-toggle-split " data-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false"
							style="padding-right: 80px;padding-top: 15px;color:#212529;font-size:20px;">
							<span class="sr-only">Perfil</span>
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item"
								href="/usuarioCV/perfil.php">Editar
								Perfil</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="" id="cerrarSesion">Cerrar sesión</a>
						</div>
					</div>
				</form>
			</div>
		</nav>
	</div>

	<script src="../js/jquery-3.4.1.min.js"></script>
	<script type="text/javascript" src="../js/all.js"></script>
	<script type="text/javascript" src="../js/bootstrap.bundle.min.js.descarga"></script>


</body>

</html>