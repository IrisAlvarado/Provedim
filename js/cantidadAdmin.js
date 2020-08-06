$(document).ready(function () {
	console.log("DOM cargado");
	obtenerUsuarios();
	obtenerPublicaciones();
	obtenerServicios();
	obtenerProductos();
	$("#index").addClass("active");

});
//total usuarios
function obtenerUsuarios() {
	$.ajax({
		url: "../backend/gestionCantAdmin.php?accion=obtenerUsuarios",
		method: "GET",
		dataType: "json",
		success: function (respuesta) {
			var contenido = '';
			console.log(respuesta);
			contenido = '<h5 class="card-text">Usuarios: ' + respuesta[0].total + '</h5>';
			$("#cantUs").append(contenido);
			console.log(respuesta);

		}
	});

}
//total publicaciones
function obtenerPublicaciones() {
	$.ajax({
		url: "../backend/gestionCantAdmin.php?accion=obtenerPublicaciones",
		method: "GET",
		dataType: "json",
		success: function (respuesta) {
			var contenido = '';
			console.log(respuesta);
			contenido = '<h5 class="card-text">Publicaciones: ' + respuesta[0].total + '</h5>';
			$("#cantPubli").append(contenido);
			console.log(respuesta);

		}
	});

}

//obtener productos
function obtenerProductos() {
	$.ajax({
		url: "../backend/gestionCantAdmin.php?accion=obtenerProducto",
		method: "GET",
		dataType: "json",
		success: function (respuesta) {
			var contenido = '';
			console.log(respuesta);

			contenido = '<h5 class="card-text">Productos Registrados: ' + respuesta[0].total + '</h5>';
			$("#cantPro").append(contenido);
			console.log(respuesta);

		}
	});

}

//obtener servicios
function obtenerServicios() {
	$.ajax({
		url: "../backend/gestionCantAdmin.php?accion=obtenerServicios",
		method: "GET",
		dataType: "json",
		success: function (respuesta) {
			var contenido = '';
			console.log(respuesta);

			contenido = '<h5 class="card-text">Servicios Registrados:  ' + respuesta[0].total + '</h5>';
			$("#serviciosReg").append(contenido);
			console.log(respuesta);

		}
	});
}