<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 <link rel="stylesheet" href="css/estilos.css">
 <link rel="stylesheet" type="text/css" href="css/all.css">
 
 
 <title>Principal</title>
</head>
<body background="img/portada4.jpeg">
  <!----background-color:rgba(198, 228, 232, 0.49); rgb(233, 233, 233);-->
<div class="fondopantalla">
 <div class="container">

      
     	<div class="row">

     <div class="col-md-4 col-1 py-5"></div>
     <div class="col-md-5" style="background-color:#fff;box-shadow: 12px 12px 20px -7px rgba(0, 0, 0, 0.75);margin-top: 30px;margin-bottom: 30px;">
      <br><!---#1012133b;--->
      <center>
        <h4 style="color:#2C9C29">PROVEDIM</h4>
        <h4 class="" style="color: #000000">Bienvenido(a) a nuestra plataforma </h4>
        <h4></h4>
       
      </center>
      
      <center class="py-1 text-primary"><h5>iYa puedes registrarte!</h5> 
      </center>
      <form role="form">
        <div class="form-row">
          <div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">
            <!--label>Nombre:</label-->
            <i class="fas fa-user fa-2x" style="color: #000"></i>
          </div>
          <div class="col-10">
            <input type="text" name="nombres" id="nombres" placeholder="Nombre de la Empresa" class="form-control" >
            <span style="color: red;display: none" id="avisoNombres" >Escriba el nombre de su empresa</span>
          </div>    
        </div>
        <div class="form-row py-2">
          <div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">
            <!--label>Apellidos:</label-->
            <i class="fas fa-user fa-2x" style="color: #000"></i>
          </div>
          <div class="col-10">
            <input type="text" name="apellidos" id="apellidos" placeholder="Nombre del Administrador" class="form-control"> 
            <span style="color: red;display: none" id="avisoapellidos" >Escriba el nombre del admin</span>
          </div>
                            
        </div>
        <div class="form-row py-2">
        <div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">
          <i class="fas fa-map-marker-alt fa-2x" style="color: #000"></i>
        </div>
        <div class="col-10">
            <input type="text" name="direccion" id="direccion" placeholder="Dirección" class="form-control"> 
            <span style="color: red;display: none" id="avisoapellidos" >Escriba la dirección de su empresa</span>
          </div>
        </div>
       <div class="form-row ">
         <div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">           
           <i class="fas fa-envelope fa-2x" style="color: #000"></i> 
         </div>  
	       <div class="col-10">
	         <input type="text" name="correo" id="correo" placeholder="Correo Electrónico" class="form-control">
	         <span style="color: red;display: none" id="avisoCorreo" >Ingresa un correo valido</span> 
	         <span style="color: red;display: none" id="avisoCorreoExistente" >El correo ya existe.</span> 
	       </div>
      </div>
   			<!--div class="form-row py-2">
        <div class="col-1" style="
    padding-left: 0px;padding-right: 0px; bord">
          <i class="fas fa-phone-alt fa-2x " style="color: #000"></i>
        </div>
        <div class="col-10">
        	<input type="number" name="telefono" id="telefono" placeholder="Ingrese su telefono" class="form-control">
        	<span style="color: red;display: none" id="avisoTelefono" >Telefono no valido.</span> 
        </div>
      </div-->
      <!--div class="form-row ">
      	<div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">
      		<i class="fas fa-calendar-alt fa-2x" style="color: #000"></i>
      	</div>
      	<div class="col-10">
      		<input type="date" name="fechaNacimiento" id="fechaNacimiento"step="1" min="1940-01-01" max="2020-04-03" class="form-control">
      		<span style="color: red;display: none" id="avisoFechaNacimiento" >Debes ser mayor de 21 años para registrate.</span> 
      		<span style="color: red;display: none" id="avisoFechaNacimiento2" >Ingresa una fecha de nacimiento.</span> 
      	</div>
      </div-->
      	<!--div class="col-10">
      		<select id="departamentos" class="form-control">
          <option selected="selected" value="null">No hay nada que cargar</option>
        </select>
        <span style="color: red;display: none" id="avisoDepto">Debe seleccionar un departamento</span>
      	</div>
      </div-->
      <!--div class="form-row">
      	<div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">
      		<i class="fa fa-map-marker fa-2x" style="color: #000"></i>
      	</div>
      	<div class="col-10">
      		<select id="municipios" class="form-control">
          <option selected="selected" value="null">Seleccione un departamento arriba</option>
        </select>
        <span style="color: red;display: none" id="avisoMunicipio">Debe seleccionar un municipio</span>
      	</div>
      </div-->
      <div class="form-row py-2">
      	<div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">
      		<i class="fas fa-lock fa-2x" style="color: #000"></i>
      	</div>
      	<div class="col-10">
      		<input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña">
      		<span style="color: red;display: none" id="avisoContrasena" >La contrasena debe contener    más de 8 caracteres.</span>
      	</div>
      </div>
      <!--div class="form-row ">
      	<div class="col-1" style="
    padding-left: 0px;padding-right: 0px;">
      		<i class="fas fa-lock fa-2x" style="color: #000"></i>
      	</div>
      	<div class="col-10" >
      		<input type="password" name="confContrasenia" id="confContrasenia" placeholder="Vuelva a escribir la contraseña" class="form-control">
      		<span style="color: red;display: none" id="avisoContrasena2" >La contrasena debe ser igual a la anterior.</span>
      	</div>
      </div-->

      <div class="form-group py-3">
        <fieldset>
          <legend>Plan de Suscripción:</legend>
          <label for="radio">
            <input type="radio" name="tipo" id="tiposEmpresa" value="1">Básico 
          </label>
           <label for="radio">
            <input type="radio" name="tipo" id="tipoPlan" value="2">Estándar 
          </label>
          <label for="radio">
            <input type="radio" name="tipo" id="tipoComun" value="3" checked="checked">
            Premium
          </label>
        </fieldset>
        <input type="checkbox" name="contrato" id="contrato" >Acepta <a href="" data-toggle="modal" data-target="#exampleModalLong">términos y condiciones</a>
        <br>
      <span style="color: red;display: none" id="avisoContrato" >Debe aceptar los términos y condiciones para registrarse.</span>
      </div>
      <button type="button" id="btnGuardar" class="btn btn-info btn-block">Guardar</button>
      <a href="inicio.php" id="" class="btn btn-dark btn-block">Cancelar</a>
      <br><br>
      </form>
     </div>
   	 </div>
  		</div>
  	</div>
 	</div>    
 </div>


 <!-- Modal contrato-->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Contrato</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div align="right"><a href="docs/Contrato.pdf" download> Descargar </a></div>
          <!--<h2>CONTRATO</h2>-->
          <center><h3>Condiciones para la publicación de un artículo o servicio</h3></center>
          <br>
          <p>
            Cuando pones en venta un artículo o decides ofrecer un servicio, debes estar de acuerdo con las siguientes condiciones que se te presentan a continuación:
          </p>
  
          <ul>
            <li>Es necesario que seas mayor de edad para poder registrarte y publicar anuncios en esta plataforma.</li>
            <li>El contenido que publiques a través de los anuncios debe contener información verídica de los mismos, ya sea un servicio o producto que se ofrezca, de lo contrario puede ser modificado, o eliminado a nuestra discreción.</li>
            <li>Si publicas un anuncio que contenga imágenes pornográficas, o contenido relacionado con el mismo, esto para ofrecer un servicio relacionado con ello, dicho anuncio será eliminado.</li>
            <li>No está permitido que dupliques un anuncio (esto no significa que no puedes publicar anuncios que tengan cosas similares).</li>
            <li>El administrador podrá editar y eliminar cualquier anuncio considerando que no cumple con las reglas establecidas en este contrato.</li>
            <li>La empresa no tiene ninguna responsabilidad con respecto al envió de productos comprados o vendidos en su plataforma.</li>
            <li>Los anuncios se publicarán inicialmente por orden de fecha y hora, por lo cual tu anuncio no siempre estará entre los primeros inicialmente.</li>
            <li>Para generar una experiencia positiva para el usuario, es posible que un anuncio no aparezca en algunos resultados de búsqueda independientemente del orden de clasificación elegido por el comprador.</li>
            <li>Los anuncios tendrán un límite de 14 días para estar publicados en la plataforma, al finalizar el tiempo, éstos serán eliminados automáticamente.(No aplica para los usuario con tipo de cuenta: Empresa)</li>
            <li>No nos hacemos responsables si el comprador recibe un artículo que no sea de su voluntad, es decir que no sea el que vio inicialmente en la o las imágenes del anuncio que le interesó.</li>
            <li>No es responsabilidad nuestra si en un anuncio se postean imágenes de un artículo nuevo y al final se entrega un artículo usado.</li>
          </ul>
          <br>
          <hr>
          <p>Crear una plataforma de comercio electrónico donde los compradores  encuentren lo que buscan, es uno de los objetivos primordiales de la empresa por lo cual te especificamos lo que debes tener en cuenta:</p>
          <h4>Cuando compras un artículo:</h4>
          Debes estar de acuerdo con lo siguiente:
          <ul>
            <li>Eres responsable de leer todo el anuncio del artículo antes de hacer una oferta de compra o confirmar una compra.</li>
            <li>Al elegir un anuncio que sea de tu conveniencia debes contactarte con el vendedor de dicho anuncio, solo si realmente estas interesado en dicha compra.</li>
            <li>La empresa no se hace responsable de cualquier daño que pueda tener el artículo que desees comprar, ya que solo ofrecemos la oportunidad de que puedas encontrar lo que buscas con mayor facilidad.</li>
          </ul>
          <br>
          <hr>
  
          <p>Así mismo es de nuestro interés que los vendedores logren sus objetivos de venta de una forma eficiente, por lo cual:</p>
          <h4>Cuando vendes un artículo:</h4>
          Te debes comprometer a cumplir lo siguiente:
          <ul>
            <li>Ofrecer un artículo en buen estado, esto quiere decir, que si ofreces un artículo usado, tú debes garantizar que dicho artículo se puede utilizar en lo que se amerita.</li>
            <li>Eres responsable de dar una descripción bien detallada del contenido de lo que es el artículo ofrecido para la venta.</li>
            <li>Debes indicar obligatoriamente el precio del producto que deseas vender, el cual debe ser: en lempiras o dólares solamente.</li>
            <li>Es necesario que al publicar tu artículo para la venta pongas al menos una  imagen del mismo, ya que de esta manera haces tú anuncio más amigable a las personas que visitan la página.</li>
          </ul>
          <br>
          <hr>
  
          <p>De igual forma, cuando tu objetivo radica en publicar un anuncio para dar un servicio, nos interesa que tomes en cuenta lo siguiente:</p>
          <h4>Cuando ofreces un servicio:</h4>
          <ul>
            <li>El servicio que se brindará debe ser legal.</li>
            <li>Es importante colocar el costo del servicio que quieres brindar, ya que éste es muy importante para que los usuarios que vean el anuncio estén consientes al momento de contactarse contigo.</li>
            <li>Siempre debes colocar al menos una imagen para ilustrar el tipo de servicio que ofreces.</li>
          </ul>
          <br>     
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
 </div>
</body>

<script  src="js/all.js"></script>
<script src="js/registroUsuarioNormal.js"></script>

</html>