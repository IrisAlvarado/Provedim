
jQuery(document).ready(function ($) {


	const queryString = window.location.search;

	const urlParams = new URLSearchParams(queryString);

	const idAnuncio = urlParams.get('idAnuncios');
	obtenerFoto(idAnuncio);
	detalleAnuncio(idAnuncio);
	obtenerIdUsuario();
	$("#enviarMsj").attr('href','contacto.php?idAnuncio='+idAnuncio+'');
	$("#btnVerDenuncias").attr('href','denuncias.php?idAnuncio='+idAnuncio+'');
});

$(function () {
	var menu_ul = $('.menu_drop > li > ul'),
		menu_a = $('.menu_drop > li > a');
	menu_ul.hide();
	menu_a.click(function (e) {
		e.preventDefault();
		if (!$(this).hasClass('active')) {
			menu_a.removeClass('active');
			menu_ul.filter(':visible').slideUp('normal');
			$(this).addClass('active').next().stop(true, true).slideDown('normal');
		} else {
			$(this).removeClass('active');
			$(this).next().stop(true, true).slideUp('normal');
		}
	});
});

function cargarIMG() {
	$('#etalage').etalage({
		thumb_image_width: 300,
		thumb_image_height: 400,
		source_image_width: 900,
		source_image_height: 1200,
		show_hint: true,
		click_callback: function (image_anchor, instance_id) {
			alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
		}
	});
}


$("#guardarCalificacion").on("click", () => {

	const queryString = window.location.search;

	const urlParams = new URLSearchParams(queryString);

	const idAnuncio = urlParams.get('idAnuncios');
	var parametros = "calificacion=" + $('input:radio[name=calificacion]:checked').val() + "&" +
		"razones=" + $('#razones').val() + "&" +
		"idAnuncios=" + idAnuncio + "&" +
		"idUsuariDaLike=" + $("#idUL").val();
	//alert(parametros);

	$.ajax({
		url: "../backend/gestionDetalleAnuncio.php?accion=guardarCalificacion",
		method: "GET",
		data: parametros,
		dataType: "json",
		success: function (respuesta) {
			console.log(respuesta);
			//alert(respuesta[0].mensaje);

			$("#msjG").addClass("alert-danger");
			$("#msjG").html(respuesta[0].mensaje);
			$("#msjG").fadeIn();
			$("#msjG").fadeOut(2000);
		}
	});
});


function detalleAnuncio(idAnuncio) {
	console.log(idAnuncio);

	var parametros = "idAnun=" + idAnuncio;
	$.ajax({
		url: "../backend/gestionDetalleAnuncio.php?accion=obtenerPublicacion",
		method: "GET",
		data: parametros,
		dataType: "json",
		success: function (respuesta) {
			console.log(respuesta);

			var contenido = "";
			//datos producto
			$("#productoServicio").html(respuesta[0].tipoProducto);
			$("#categoria").html(respuesta[0].categoria);
			$("#tituloAnuncio").html(respuesta[0].titulo);
			$("#titPub").html(respuesta[0].titulo);
			$("#descripcion").html(respuesta[0].descripcion);
			$("#precio").html(respuesta[0].precio + " " + respuesta[0].moneda);
			//Datos Contacto

			$("#nombre").html(respuesta[0].primerNombre + " " + respuesta[0].primerApellido);
			$("#correo").html(respuesta[0].correo);
			$("#telefono").html(respuesta[0].telefono);
			//Datos Ubicacion
			$("#depto").html(respuesta[0].depto);
			$("#municipio").html(respuesta[0].municipio);
			//console.log(respuesta[0].titulo);
			//$("#btn-Cal").addClass("onclick='"+respuesta[0].idAnuncios+","+respuesta[0].idPersona+"'");
		}

	});
}

function obtenerIdUsuario() {
	$.ajax({
		url: "../backend/perfilAdmin.php",
		// data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
		method: "GET",
		dataType: "json",
		success: function (respuesta) {
			console.log(respuesta);
			$("#idUL").val(respuesta.idUsuario);

		},
		error: function (error) {
			console.log(error)
		}
	});
}

$("#verCalifi").on("click", () => {
	obtenerPuntuacion();
});

function obtenerPuntuacion() {

	const queryString = window.location.search;

	const urlParams = new URLSearchParams(queryString);

	const idAnuncio = urlParams.get('idAnuncios');

	//console.log(idAnuncio);

	var parametros = "idAnun=" + idAnuncio;
	$.ajax({
		url: "../backend/gestionDetalleAnuncio.php?accion=obtenerPuntuacion",
		method: "GET",
		data: parametros,
		dataType: "json",
		success: function (respuesta) {
			console.log(respuesta);

			var contenido = "";
			//datos producto

			if (respuesta.length > 0) {
				$("#listaUsers").remove();
				$("#msjTotal").fadeOut();
				$("#estrellas").fadeIn();
				$("#calTotal").html('Puntuacion Total:' + respuesta[0].Total);
				for (var i = 0; i < respuesta.length; i++) {
					contenido += '<div id="listaUsers" class="row"><div class="col-md-2">' +
						'<i class="fas fa-user-circle  fa-2x" style="color:#212529;"></i>' +
						'</div><div class="col-md-10">' +
						'<label id="" class="">' + respuesta[i].primerNombre + " " + respuesta[i].primerApellido + '</label>' +
						'</div><div class="col-md-6">' +
						'<label  class="colorEstrellas">';
					for (var j = 0; j < respuesta[i].puntuacion; j++) {
						contenido += '★';
					}
					contenido += '</label>' +
						'</div><div class="col-md-6 py-2 px-4">' +
						'<a class="" data-toggle="collapse" data-target="#collapseExample' + respuesta[i].idCalificacion + '" aria-expanded="false" aria-controls="collapseExample">' +
						'Comentario <i class="fas fa-chevron-down  fa-1x" style="color:#212529;"></i>' +
						'</a></div><div class="col-md-12">' +
						'<div class="collapse" id="collapseExample' + respuesta[i].idCalificacion + '">' +
						'<div class="card card-body"> ' +
						respuesta[i].razones +
						'</div></div></div></div>';
				}
				$("#listaUsers").remove();
				$("#listaUsuarios").append(contenido);
			} else {
				$("#msjTotal").fadeIn();
			}
		}
	});
}

$("#btn-Cal").on("click", () => {
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const idAnuncio = urlParams.get('idAnuncios');

	parametros = "idAnuncios=" + idAnuncio + "&" +
		"idUsuariDaLike=" + $("#idUL").val();
	//console.log(idAnuncio);
	//alert(parametros);
	$.ajax({
		url: "../backend/gestionDetalleAnuncio.php?accion=editarCalificacion",
		method: "GET",
		data: parametros,
		dataType: "json",
		success: function (respuesta) {
			//console.log(respuesta);

			if (respuesta.length > 0) {
				$("input[name=calificacion][value=" + respuesta[0].puntuacion + "]").attr('checked', 'checked');
				$('#razones').val(respuesta[0].razones);
				$("#listaUsers").remove();
			}
		}
	});
});


$("#login-button").on("click", () => {
	let correo = $("#correo").val();
	let contrasena = $("#contrasena").val();

	console.log(correo + ", " + contrasena);

	/*|||||||||||||||||VALIDACIONES|||||||||||||||||||||| */

	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	//prueba si el correo es valido
	var esCorreoValido = re.test(String(correo).toLowerCase());

	var esContrasenaValida = contrasena.length > 6;

	if (correo != "" && contrasena != "") {
		login(correo, contrasena);

	} else {
		alert("No puede dejar Campos Vacios")
	}

});

async function login(correo, contrasena) {


	data = {
		correo: correo.toLowerCase(), //$("#correo").val().toLowerCase(),
		password: contrasena //$("#contrasena").val()
	};

	var respuestaGlobal;


	$.ajax({
		url: "../backend/login.php",
		data: "correo=" + correo.toLowerCase() + "&contrasena=" + contrasena, //data, //"correo=" + $("#txt-correo").val().toLowerCase() + "&password=" + $("#txt-contrasena").val(),
		method: "POST",
		dataType: "json",
		success: async function (respuesta) {
			respuestaGlobal = respuesta;

			// alert(respuesta.mensaje);

			console.log(respuesta);


			if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 1 && respuesta.estadoRegistro == 1) {

				console.log("Logueado Exitosamente");

				document.getElementById("correo").classList.remove("is-invalid");
				document.getElementById("correo").classList.add("is-valid");

				document.getElementById("contrasena").classList.remove("is-invalid");
				document.getElementById("contrasena").classList.add("is-valid");
				$("#aviso").fadeOut();
				$("#avisoContrasena").fadeOut();


				await sleep(500);
				location.reload();
				//console.log('Entro a :'+respuesta.usuario);
				//console.log(respuesta);
				/* if (respuesta.usuario==1) {
				     var url = "http://localhost/Compra-y-venta-de-toda-papada-Back/administracion/index.php";
				     window.location = url;  
				 }else{
				   var url = "http://localhost/Compra-y-venta-de-toda-papada-Back/usuarioCV/perfil.php";
				   window.location = url;
				   console.log('Entro como comprador');  
				 }*/


			} else if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 0) {

				console.log("contrasena incorrecta");

				document.getElementById("contrasena").classList.remove("is-valid");
				document.getElementById("contrasena").classList.add("is-invalid");
				$("#avisoContrasena").fadeIn();
				$("#aviso").fadeOut();

			} else if (respuesta.existe == 0 && respuesta.contrasenaCorrecta ==
				0) {
				console.log(" No existe el usuario");


				document.getElementById("correo").classList.remove("is-valid");
				document.getElementById("correo").classList.add("is-invalid");

				document.getElementById("contrasena").classList.remove("is-valid");
				document.getElementById("contrasena").classList.add("is-invalid");


				$("#aviso").fadeIn();
			} else if (respuesta.existe == 1 && respuesta.contrasenaCorrecta == 1 && respuesta.estadoRegistro == 0) {
				console.log(respuesta.mensaje)

				$("#mensajeDadodeBaja").fadeIn();
			}
		},
		error: function (error) {
			console.log(error);
			alert("Ocurrió un error.");
		}
	});
};

function sleep(time) {
	return new Promise((resolve) => setTimeout(resolve, time));
}


function obtenerFoto(idAnuncio) {
	parametros = "idAnuncios=" + idAnuncio;
	//console.log(idAnuncio);
	//alert(parametros);
	$.ajax({
		url: "../backend/gestionDetalleAnuncio.php?accion=obtenerFotos",
		method: "GET",
		data: parametros,
		dataType: "json",
		success: function (respuesta) {
			console.log(respuesta);
			var contenido = '';
			var contenidoU = '';
			if (respuesta.length > 0) {
				contenido += '<div class="single_top">' +
					'<div class="container">' +
					'<div class="single_grid">' +
					'<h2 id="tituloAnuncio">Producto X</h2>' +
					'<div class="grid imgCate_3_of_2" > <!--Inicio div Imagenes-->' +
					'<ul id="etalage">';
				for (var i = 0; i < respuesta.length; i++) {
					if (i == 0) {
						// statement
						contenido += '<li><a href="#">' +
							'<img class="etalage_thumb_image" src="../' + respuesta[i].urlFoto + '" class="img-responsive" />' +
							'<img class="etalage_source_image" src="../' + respuesta[i].urlFoto + '" class="img-responsive" title="" />' +
							'</a></li>';
					} else {
						// statement
						contenido += '<li>' +
							'<img class="etalage_thumb_image" src="../' + respuesta[i].urlFoto + '" class="img-responsive"  />' +
							'<img class="etalage_source_image" src="../' + respuesta[i].urlFoto + '"class="img-responsive"  />' +
							'</li>';
					}
				}
				contenido += '</ul>' +
					'<div class="clearfix"></div>' +
					'</div> <!--Fin div Imagenes-->' +
					'</div></div></div>';
				//$("#imgAnuncios").remove();							  
				$("#imagenesAnuncio").append(contenido);
				cargarIMG();
			} else {
				contenidoU += '<div class="single_top">' +
					'<div class="container">' +
					'<div class="single_grid">' +
					'<h2 id="tituloAnuncio">Producto X</h2>' +
					'<div class="grid imgCate_3_of_2" id="fotosAnuncio"></div>' +
					'<div class="grid imgCate_3_of_2" > <!--Inicio div Imagenes-->' +
					'<ul id="etalage"><li><a href="#">' +
					'<img class="etalage_thumb_image" src="../imgCate/microondas.jpg" class="img-responsive" />' +
					'<img class="etalage_source_image" src="../imgCate/microondas.jpg" class="img-responsive" title="" />' +
					'</a></li><li>' +
					'<img class="etalage_thumb_image" src="../imgCate/micro2.jpg" class="img-responsive" />' +
					'<img class="etalage_source_image" src="../imgCate/micro2.jpg" class="img-responsive" title="" />' +
					'</li><li>' +
					'<img class="etalage_thumb_image" src="../imgCate/micro3.jpg" class="img-responsive"  />' +
					'<img class="etalage_source_image" src="../imgCate/micro3.jpg"class="img-responsive"  />' +
					'</li><li>' +
					'<img class="etalage_thumb_image" src="../imgCate/micro4.jpg" class="img-responsive"  />' +
					'<img class="etalage_source_image" src="../imgCate/micro4.jpg"class="img-responsive"  />' +
					'</li></ul>' +
					'<div class="clearfix"></div>' +
					'</div> <!--Fin div Imagenes-->' +
					'</div></div></div>';

				console.log("Entre a 0");
				$("#imagenesAnuncio").append(contenidoU);
				cargarIMG();
				//	$("#imagenesAnuncio").fadeIn();
			}
		}
	});
}

// agregar favorito
$("#btn-favorito").on("click", () => {
	console.log("click favorito");

	const queryString = window.location.search;

	const urlParams = new URLSearchParams(queryString);

	const idAnuncio = urlParams.get('idAnuncios');

	//console.log(idAnuncio);

	$.ajax({
		url: "../backend/gestion_favoritos.php",
		method: "POST",
		data: `accion=nuevo&idAnuncio=${idAnuncio}`,
		success: async (respuesta) => {
			console.log(respuesta);

			let response = JSON.parse(respuesta);

			if (response.codigo == 1) {
				//$("#mensaje-agregado-favorito").fadeIn();
				$("#mensaje-agregado-favorito").css("display", "inline");

				await sleep(4000);

				//$("#mensaje-agregado-favorito").fadeOut();
				$("#mensaje-agregado-favorito").css("display", "none");

			} else if (response.codigo == 2) {
				$("#mensaje-existe-favorito").css("display", "inline");
				//$("#mensaje-existe-favorito").fadeIn();

				await sleep(4000);

				//$("#mensaje-existe-favorito").fadeOut();
				$("#mensaje-existe-favorito").css("display", "none");

			}
		},
		error: (error) => {
			console.error(error);
		}
	});

});


$("#guardarDenuncia").on("click", () => {

	const queryString = window.location.search;

	const urlParams = new URLSearchParams(queryString);

	const idAnuncio = urlParams.get('idAnuncios');
	var parametros = "razon=" + $('#razonesDenuncia').val() + "&" +
		"idAnuncio=" + idAnuncio + "&" +
		"idDenunciante=" + $("#idUL").val();
	
	//alert(parametros);

	$.ajax({
		url: "../backend/gestionDenuncias.php?accion=solicitudDenuncia",
		method: "GET",
		data: parametros,
		dataType: "json",
		success: function (respuesta) {
			//console.log(respuesta);
			//alert(respuesta[0].mensaje);

			$("#msjG").addClass("alert-danger");
			$("#msjG").html(respuesta[0].mensaje);
			$("#msjG").fadeIn();
			$("#msjG").fadeOut(2000);
		}
	});
});

