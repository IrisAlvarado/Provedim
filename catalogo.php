<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Provedim</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--script src="js/jquery-1.11.0.min.js"></script-->
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" href="css/catalogo.css">
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
						 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Shoplist Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--Google Fonts-->
<link href='//fonts.googleapis.com/css?family=Hind:400,500,300,600,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
	</script>
<!-- //end-smoth-scrolling -->
<!-- the jScrollPane script -->
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
		<script type="text/javascript" id="sourcecode">
			$(function()
			{
				$('.scroll-pane').jScrollPane();
			});
		</script>
<!-- //the jScrollPane script -->
<script src="js/simpleCart.min.js"> </script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<!--header strat here-->
<?php
    //llamado a nabvar
    include_once('navbarMain.php');
 ?>



<!--header end here-->
<!--product start here-->
<div class="product">
	<div class="container">
		<div class="product-main">
			  <div class=" product-menu-bar">
			  	<div class="col-md-12 jumbotron">
			  			<div class="row">
					    <div class="col-md-7" style="/*padding-left:65em; padding-right:0px; margin-top:70px">
					    		<h2>Busqueda con filtros</h2>
    						<br>
					        <form class="form-inline my-2 my-lg-0">
					            <input class="form-control mr-sm-2 " type="search" id="inputBusqueda" name="inputBusqueda" placeholder="Buscar por nombre del producto"
					                aria-label="Search" ><!--onkeypress="myFunction(event)"-->
					            <!--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>-->
					            <button type="button" id="inputBusquedaBtn" name="inputBusquedaBtn" class="btn btn-link"><img id="lupa" src="ico/lupa.png"></button>
					        </form>
					    </div>


                    <div class="col-md-5 contenedorFilter">
                        <div class="col col-lg-12" style="text-align: center;">
                        	<br>
                            <Strong id="subtitulo" >Detalla un rango de precios:</Strong>
                            <br>
                            <div class="col-md-6">
                            <label class="" for="desde">Desde</label>
                            <input type="text" class="form-control" id="desde">
                            <div style="display: none; margin-left: auto;margin-right: auto; width: 40%;padding: .1em;"
                                class="alert alert-danger" role="alert" id="mensajeDesde">
                                No es un número.
                            </div>
                            </div>


                            <div class="col-md-6">
                            <label class="" for="hasta">Hasta</label>
                            <input type="text" class="form-control" id="hasta">
                            <div style="display: none; margin-left: auto;margin-right: auto; width: 40%;padding: .1em;"
                                class="alert alert-danger" role="alert" id="mensajeHasta">
                                No es un número.
                            </div>
						</div>

                        </div>

                        <div class="row">
                        	<div class="col-md-12">
                    			<button id="btn-filtros" type="button" class="btn btn-outline-success" style=""><b>Filtrar</b></button>
                			</div>
            			</div>
                    </div>
                    </div>



					    <br>
					    <br>
					    <div class="row " style="">
					        <div style="/*padding-top:2.5%;" id="filter" >Filtrar por: </div>

					        <div class="col-md-4" style="/*margin-left:5%;">
					            <label for="slc-categoria">Categorias: </label><br>
					            <select class="select-btn" name="slc-categoria" id="slc-categoria">
					                <option value="null">Seleccionar</option>
					            </select>
					        </div>

					        <div  class="col-md-4" style="/*margin-left:5%;">
					            <label for="slc-departamento">Departamento: </label><br>
					            <select class="select-btn" name="slc-departamento" id="slc-departamento">
					                <option value="null">Seleccionar</option>

					            </select>
					        </div>

					        <div class="col-md-4" style="/*margin-left:5%;">
					            <label for="slc-municipio">Municipio: </label><br>
					            <select class="select-btn" name="slc-municipio" id="slc-municipio">
					                <option value="null">Seleccionar</option>

					            </select>
					        </div>

					    </div>

					    <br>
			  	</div>

				<hr id="line">

			  </div>
			  <div class="col-md-12">
			  	<div class="col-md-6">
			  		<h1>Catalogo de Productos</h1>
			  	</div>
			  	<div class="col-md-6">
			  		<button type="button" class="btn btn-link" style="margin-left:49%;"><a href="product.php" id="show">Mostrar todos los Anuncios</a></button>
			  	</div>
			  </div>

			  <div class="col-md-12 product-block">
			  		<div id="generarAnuncios">

			  		</div>
			      <div class="clearfix"> </div>
			  </div>
		</div>
	</div>
</div>
<!--product end here-->
<!--footer strat here-->
<div class="footer">
	<div class="container">
		<div class="footer-main">
			<div class="ftr-grids-block">
				<div class="col-md-3 footer-grid">
					<ul>
						<li><a href="product.html">Accessories</a></li>
						<li><a href="product.html">Hand bags</a></li>
						<li><a href="product.html">Clothing</a></li>
						<li><a href="product.html">Brands</a></li>
						<li><a href="product.html">Watches</a></li>
					</ul>
				</div>
				<div class="col-md-3 footer-grid">
					<ul>
						<li><a href="login.html">Tu cuenta</a></li>
						<li><a href="contact.html">Contáctanos</a></li>
						<li><a href="product.html">Store Locator</a></li>
						<li><a href="pressroom.html">Press Room</a></li>
					</ul>
				</div>
				<div class="col-md-3 footer-grid">
					<ul>
						<li><a href="terms.html">Website Terms</a></li>
						<li><select class="country">
										<option value="select your location">Select Country</option>
										<option value="saab">Australia</option>
										<option value="fiat">Singapore</option>
										<option value="audi">London</option>
									</select>

						</li>
						<li><a href="shortcodes.html">Short Codes</a></li>
					</ul>
				</div>
				<div class="col-md-3 footer-grid-icon">
					<ul>
						<li><a href="#"><span class="u-tub"> </span></a></li>
						<li><a href="#"><span class="instro"> </span></a></li>
						<li><a href="#"><span class="twitter"> </span></a></li>
						<li><a href="#"><span class="fb"> </span></a></li>
						<li><a href="#"><span class="print"> </span></a></li>
					</ul>
					<form>
					<input class="email-ftr" type="text" value="Newsletter" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Newsletter';}">
					<input type="submit" value="Submit">
					</form>
				</div>
		    <div class="clearfix"> </div>
		  </div>
		  <div class="copy-rights">
		     <p>© 2020 UNAH. Industria del Software | Grupo 4  <a href="http://w3layouts.com/" target="_blank">Provedim</a> </p>
		   </div>
		</div>
	</div>
</div>
<!--footer end here-->
    <!--script src="js/jquery-2.2.4.js"></script-->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fontsawesome.min.js"></script>
    <script src="js/catalogo.js"></script>
</body>
</html>