
<!DOCTYPE HTML>
<html>
<head>
<title>Anuncio</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../css/bootstrap.min.css" rel='stylesheet' type='text/css' />

<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="../css/all.css">
<link rel="stylesheet" href="../css/etalage.css">

<link rel="stylesheet" type="text/css" href="../css/customDetalles.css">
<!--initiate accordion-->
<script type="text/javascript">

</script>
</head>
<body>
	<a href="../index.php" class="btn btn-danger px-5 btnAtras"><i class="fas fa-long-arrow-alt-left fa-2x " id="iconU"></i> </a>
	<br>
<div class="container">
	<div class="row">
		<div class="col-md-4" id="imagenesAnuncio">
		</div>

<div class="col-md-8 col-12">
	<input type="text" name="idUL" id="idUL" style="display: none">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<br>
				<h3>Detalles Anuncio</h3>
			<hr style="background-color:#984B43;">
			<div class=""><!--INICIO FORMULARIO DETALLE PROD -->
				<form>
			  <div class="row">
			    <div class="col-md-7">
			      <h4 id="titPub"></h4>
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Categoria:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="categoria" class="">Categoria ...</label>
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Descripcion:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="descripcion" class="">Descripcion ...</label>
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Precio:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="precio" class="">Precio ...</label>
			    </div>
			  </div>
			</form>
			</div><!--FIN FORMULARIO DETALLE PROD -->
			<br>
		<?php
    session_start(); 
    if (isset($_SESSION["id_usuario"])){
		echo ('<h3 style="display:inline; margin-right:1em;">Datos Vendedor</h3>
			<button class="btn btn-outline-danger" id="btn-favorito" style="display:inline;margin-right:.5em;">Añadir a favoritos <i class="far fa-star"></i></button>
			<div class="alert alert-danger" role="alert" style="display:inline; padding-left:0px;padding-right:0px; display:none;" id="mensaje-existe-favorito">
  				Ya  lo tienes registrado como favorito.
			</div>
			<div class="alert alert-success" role="alert" style="display:inline; padding-left:0px;padding-right:0px;display:none;" id="mensaje-agregado-favorito" >
  				Agregado exitosamente.
			</div>
			<hr style="background-color:#984B43;">
			<div><!--inicio FORMULARIO datos vendedor -->
				<form>
				 <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Nombre:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="nombre" class="">Nombre ...</label>
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Correo:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="correo" class="">Correo ...</label>
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Telefono:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="telefono" class="">Telefono ...</label>
			    </div>
			  </div>
        <div class="row">
            <div class="col-md-5">
              <label class="font-weight-bold">Contactar</label>
            </div>
            <div class="col-md-7">
              <a class="btn btn-outline-danger"  id="enviarMsj">
                        Cotizar
              </a>
             </div>
          </div>
			 </form>
			</div><!--fin FORMULARIO datos vendedor -->
			<br>
			<h3>Ubicacion</h3>
			<hr style="background-color:#984B43;">
			<div><!--inicio FORMULARIO datos ubicacion -->
				<form>
				 <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Departamento Recidencia:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="depto" class="">Depto ...</label>
			    </div>
			  </div>
			  <div class="row">
			    <div class="col-md-5">
			      <label class="font-weight-bold">Municipio:</label>
			    </div>
			    <div class="col-md-7">
			      <label id="municipio" class="">Municipio ...</label>
			    </div>
			  </div>
			 </form>
			</div><!--fin FORMULARIO ubicacion -->
			<br><hr style="background-color:#984B43;">
			</div>
			</div>
		</div>
		<div class="row">
		<div class="col-md-12 px-5">
		<p>
  	
		</p>
		<span class="alert alert-warning" id="msjG" style="display: none"></span>
		<div class="row">       
  	<div class="col">
    		<div class="collapse multi-collapse" id="calificar">
        <div class="card card-body">
       			<ul>
       				<input class="form-check-input" type="radio" name="calificacion" id="cal1" value="1" checked>
  								 <label class="form-check-label colorEstrellas" for="calificacion">
    								★
  								 </label><br>
  								 <input class="form-check-input" type="radio" name="calificacion" id="cal2" value="2" >
  								 <label class="form-check-label colorEstrellas" for="calificacion">
    								★★
  								 </label><br>
  								 <input class="form-check-input" type="radio" name="calificacion" id="cal3" value="3" >
  								 <label class="form-check-label colorEstrellas" for="calificacion">
    								★★★
  								 </label><br>
  								 <input class="form-check-input" type="radio" name="calificacion" id="cal4" value="4" >
  								 <label class="form-check-label colorEstrellas" for="calificacion">
    								★★★★
  								 </label><br>
  								 <input class="form-check-input" type="radio" name="calificacion" id="cal5" value="5" >
  								 <label class="form-check-label colorEstrellas" for="calificacion">
    								★★★★★
  								 </label><br>
  								 <label>Razones de su calificacion:</label>
  								 (Opcional)
  								 <textarea name="razones" id="razones" class="form-control " rows="4"></textarea><br>
  								 <button type="button" id="guardarCalificacion" class="btn btn-success" data-toggle="collapse" href="#calificar" role="button" aria-expanded="false" aria-controls="calificar">Guardar</button>
       			</ul>
      		</div>
    			</div><br><br>
  				</div>
					<!--/div-->
				</div><!--fin primer columna-->
        <div class="col-md-12"><!--Denuncias-->
          <div class="col">
            <div class="collapse multi-collapse" id="denunciar">
              <div class="card card-body">
                <ul>
                  </label><br>
                   <label>Razones de su Denuncia:</label>
                   
                   <textarea name="razonesDenuncia" id="razonesDenuncia" class="form-control " rows="4"></textarea><br>
                   <button type="button" id="guardarDenuncia" class="btn btn-success" data-toggle="collapse" href="#denunciar" role="button" aria-expanded="false" aria-controls="denunciar">Guardar</button>

                </ul>
              </div>
            </div>
          </div> 
        </div><!--Fin Denuncias-->
				<div class="col-md-12">
		<!--div class="row"-->
  	<div class="col">
    		<div class="collapse multi-collapse" id="verCalificacion">
        <div class="card card-body">
       			<form>
       				<div class="row">
       					<div class="col-md-12">
       						<h3 id="estrellas" class="colorEstrellas" style="display: none">★★★★★</h3>
       					</div>
       					<div class="col-md-12">
       						<h5 id="calTotal" class="colorEstrellas"></h5>
       					</div>
       				</div>
       				
       				<div class="col-md-12">
					   <p id="msjTotal" class="alert alert-danger" style="display: none;">Esta publicacion no tiene calificacion.</p>
					</div>
					<div id="listaUsers" class="row">
       				</div>
       				<div id="listaUsuarios" class="row">
       				</div>
       			</form>
      		</div>
    			</div><br><br>
  				</div>
					</div>
				</div><!--fin segunda columna-->');
    }
    else{
        echo ('<div><!--Comienzo columna-->
<a class="btn btn-danger" data-toggle="collapse" href="#verContacto" role="button" aria-expanded="false" aria-controls="verContacto" id="">Datos Contacto</a>
		<div class="row">
  	<div class="col-md-8">
    		<div class="collapse multi-collapse" id="verContacto">
        <div class="card card-body">
       			<form>
       				<div class="row">

       					<div class="col-md-12">
       						<p>Para acceder a los datos del vendedor necesita Iniciar secion.<br>
       						</p>
       					</div>
       					<!--div class="col-md-6"></div-->
       					<div class="col-md-6">
       						<a href="../reg.php" class="btn btn-primary btn-block" id="registrar">Registrarse</a>
       					</div>
       					<div class="col-md-6">
       						<button type="button" class="btn btn-success btn-block" id="iniciarSesionBoton" data-toggle="modal" data-target="#modalFormularioLogin"> Iniciar Secion</button>
       					</div>
       				</div>
       			</form>
      		</div>
    			</div><br><br>
  				</div>
					</div>
				</div><!--fin columna Datos contacto-->

    <!-- Modal -->
    <div class="modal fade" id="modalFormularioLogin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body px-5">
                    <form id="login-form">
                        <div style="text-align: center; margin-top: 1em; margin-bottom: 2em;">
                            <h4>Ingresa para poder comprar y vender.</h4>
                        </div>
                        <div class="form-group">
                      
                            <input type="email" class="form-control" id="correo" name="correo"
                                placeholder="Ingrese su correo electrónico">
                            <small style="display: none;" id="aviso" class="form-text text-muted">Debes haberte
                                registrado
                                para
                                poder
                                ingresar.</small>
                        </div>
                        <div class="form-group">
                           
                            <input type="password" class="form-control" id="contrasena" name="contrasena"
                                placeholder="Contraseña">
                            <small style="display: none;" id="avisoContrasena" class="form-text text-muted">Contraseña
                                Incorrecta</small>

                            <small><a href="#">
                                    ¿Olvidaste tu contraseña?
                                </a></small>

                        </div>

                        <div style="margin-left: auto;margin-right: auto;" class="text-center">
                            <button type="button" class="btn btn-primary" id="login-button"
                                style=" width: 15em !important;">Ingresar</button>

                        </div> <br>

                        <div class="alert alert-danger" id="mensajeDadodeBaja" style="display:none;text-align:center;">
                            Estás dado de baja actualmente </div>

                        <br>
                        <div class="text-center">
                            <small>¿No tienes una cuenta? </small>
                            <a href="reg.php" class="btn btn-success"  id="crearCuenta" onclick="">
                                Crea una cuenta
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--Fin modal---><hr style="background-color:#984B43;"><div class="col-md-6"><p>
  	<a class="btn btn-danger" data-toggle="collapse" href="#verCalificacion" role="button" aria-expanded="false" aria-controls="verCalificacion" id="verCalifi">Ver calificaciones</a>
		</p>
		<div class="row">
  	<div class="col">
    		<div class="collapse multi-collapse" id="verCalificacion">
        <div class="card card-body">
       			<form>
       				<div class="row">
       					<div class="col-md-12">
       						<h3 id="estrellas" class="colorEstrellas" style="display: none">★★★★★</h3>
       					</div>
       					<div class="col-md-12">
       						<h5 id="calTotal" class="colorEstrellas"></h5>
       					</div>
       				</div>
					   <div class="col-md-12">
					   <p id="msjTotal" class="alert alert-danger" style="display: none;">Esta publicacion no tiene calificacion.</p>
					   </div>
       				
					<div id="listaUsers" class="row">
       				</div>
       				<div id="listaUsuarios" class="row">
       				</div>
       				</div>
       			</form>
      		</div>
    			</div><br><br>
  				</div>
					</div>
				</div><!--fin segunda columna-->');
    }
  ?>
			
		</div>
	</div>
</div>
</div>
       
			 



</body>
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/all.js"></script>

<script src="../js/bootstrap.bundle.min.js.descarga"></script>
<script src="../js/jquery.etalage.min.js"></script>
<script src="../js/controladorDetalles.js"></script>
</html>		


