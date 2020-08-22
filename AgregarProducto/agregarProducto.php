<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registrar Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/estilos.css" />
    <link rel="stylesheet" href="fonts.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="sidebar">
        <ul>
            <h2>MENÚ</h2>
            <li>
                <a href="#"><span class="icon-home"></span>INICIO</a>
            </li>
            <li>
                <a href="#"><span class="icon-file-text"></span>CATÁLOGO</a>
            </li>
            <li>
                <a href="#"><span class="icon-cart"></span>PRODUCTOS</a>
            </li>
            <li>
                <a href="categorias.php"><span class="icon-list"></span>CATEGORÍAS</a>
            </li>
            <li>
                <a href="#"><span class="icon-stats-bars"></span>COTIZACIONES</a>
            </li>
            <li>
                <a href="#"><span class="icon-question"></span>AYUDA</a>
            </li>
            <li>
                <a href="#"><span class="icon-cog"></span>CONFIGURACIÓN</a>
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
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <label id="label" for=""><span class="icon-clipboard"></span>INFORMACIÓN DEL PRODUCTO</label><br>
                    <label for="">Nombre Producto</label></br>
                    <input id="txt-producto" class="form-control" type="text" placeholder="Nombre del producto" value="" /><br />
                    <label for="">Marca</label><br />
                    <input id="txt-marca" class="form-control" type="text" placeholder="Marca del producto" value="" /><br />
                    <label for="">Descripción</label><br />
                    <textarea id="txt-descripcion" class="form-control" placeholder="Descripción" rows="4" cols="20" value=""></textarea><br />
                    <select id="s-categoria" class="form-control" name="categoria">
									<option value="1">Mascartillas</option>
									<option value="2">Alcohol</option>
									<option value="3">Gel antibacterial</option>
									<option value="4">Guantes</option>
								</select>
                </div>
                <div class="col-sm-6">
                    <label for="">Precio de venta</label><br />
                    <input id="txt-precio" class="form-control" type="text" placeholder="L." value="" /><br />
                    <label for="">Cantidad disponible</label><br />
                    <input id="txt-cantidad" class="form-control" type="text" placeholder="Cantidad disponible" value="" /><br />
                    <label for="">Código de barras</label><br />
                    <input id="txt-codigo" class="form-control" type="text" placeholder="Código de barras" value="" /><br />
                    
                    <button id="idGuardarRegistro" onclick="validarProducto()" type="button" class="btn btn-success btn-lg btn-block">
						<span class="icon-floppy-disk"></span>Subir Imagen
					</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalSubirImagen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <b><h5 class="modal-title" id="exampleModalLabel">Cargar Imágen</h5></b>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
                </div>
                <div class="modal-body">
                    <form action="../backend/apiProductos.php?accion=guardarImagen" method="POST" enctype="multipart/form-data" role="form">
                        <div class="card" style="width: auto;">
                            <div class="card-body">
                                <div class="form-group">
                                    <input class="btn btn-success btn-lg btn-block" type="file" id="idImagen" name="imagen" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Guardar Registro</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Script para la integración de JavaScrpt-->
    <script src="../js/jquery.min.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="abrir_menu.js"></script>
    <script src="validarProducto.js"></script>
</body>

</html>