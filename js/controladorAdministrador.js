
//Funcion para cambiar el nombre a la categoria
function editPerfil(codigoUA){

	//validarEditar();
	//if (validarEditar()) {
		var parametros="idUA="+codigoUA+"&"+
					   "imgUrl="+$("#imagen").val();
					alert(parametros);
		$.ajax({
			url:"../backend/gestionAdmin.php?accion=editar",
			method:"GET",
			data:parametros,
			dataType:"json",
			success:function(respuesta){
				//console.log(respuesta);
				//alert(respuesta[0].mensaje);
			}
		});
		
		window.location.replace("perfilAdmin.php");
	//}
	
	
}
