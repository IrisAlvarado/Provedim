$(document).ready(function () {
    console.log("DOM cargado");
    obtenerCategorias();
	$("#categorias").addClass("active");

});
function obtenerCategorias(){
	$.ajax({
		url:"../backend/gestionCategorias.php?accion=obtenerTodos",
		method:"GET",
		dataType:"json",
		success:function(respuesta){
			//console.log(respuesta);
			var contenido = "";
			console.log(respuesta);
			contenido='<div class="table-responsive" id="div_ini"><table class="table table-striped table-hover table-bordered" id="tablaCategoria"><thead class="thead-dark"><tr>'+
                        '<th>Nombre Categoria</th>'+
                        //'<th>Tipo Categoria</th>'+
                        '<th>Dar de baja</th>'+
                        '<th>Editar</th></tr></thead>';

				/*  */

			for (var i = 0; i<respuesta.length; i++){

				contenido += '<tr><!--td>'+respuesta[i].idCategorias+ '</td-->'+
			                    '<td>'+respuesta[i].descripcion+'</td>'+
			                    //'<td>'+respuesta[i].estado+'</td>'+
			                    '<td>'+
			                    '<button class="btn btn-outline-danger" type="button" id="btnEliminar'+respuesta[i].idCategorias+'" onclick="eliminarCategorias('+respuesta[i].idCategorias +')"><i class="fas fa-trash-alt fa-lg" style=""></i></button>'+ 
			                    '</td>'+
			                    '<td>'+
			                    '<button class="btn btn-outline-primary" type="button" id="btnEdit'+respuesta[i].idCategorias+'"   onclick="editarCategorias('+respuesta[i].idCategorias+','+"'"+respuesta[i].descripcion+"'"+')"><i class="fas fa-edit fa-lg" style=""></i></button>'+ 
			                    '</td>'+
			                  '</tr>';
			}
			contenido+='</table></div>';

			$("#div_ini").remove();
			//$("#con2").remove();
			//$("#c1").prop("disabled",false);
			$("#div_table").append(contenido);
			cargarTabla();
		}
	});

}

function guardarCategorias(){
	validarRegistro();
	if (validarRegistro()) {
		var parametros= "nombreCate="+$("#nombreCat").val();
					//alert(parametros);
	
		$.ajax({
			url:"../backend/gestionCategorias.php?accion=nuevo",
			method:"GET",
			data:parametros,
			dataType:"json",
			success:function(respuesta){
				console.log(respuesta);
				//alert(respuesta[0].mensaje);
				
				$("#msjG").addClass("alert-danger");
				$("#msjG").html(respuesta[0].mensaje);
				$("#msjG").fadeIn();
				$("#msjG").fadeOut(2000);	

				$("#nombreCat").val('');
				obtenerCategorias();
			}
		});
		
		//window.location.replace("categorias.php");
		
	}else {
		//alert("Campos requeridos");
	}
	
}


function eliminarCategorias(idCategoria){

	var parametros = "idCategoria="+idCategoria;
	
	//alert(parametros);
	$.ajax({
		url:"../backend/gestionCategorias.php?accion=eliminar",
		method:"GET",
		data:parametros,
		dataType:"json",
		success:function(respuesta){
			console.log(respuesta);

			if (respuesta[0].mensaje=='Eliminado exitosamente') {

				$("#msjDelete").html(respuesta[0].mensaje);
				$("#msjDelete").fadeIn();
				$("#msjDelete").fadeOut(2000);
				
				obtenerCategorias();
				//window.location.replace("denuncias.php");
			//
			}
			
		}
	});

}

function editarCategorias(idCategoria,nombreCat){

	///$("#Agregar").css("display","none");
	//$("#Editar").css("display","block");
	$("#agregarCat").fadeOut();
	$("#editarCat").fadeIn();
	//llenado de codigo categoria a editar
	$("#cod").val(idCategoria);
	$("#nombreCatEdit").val(nombreCat);
	
	//alert(idCategoria,nombreCat);
	//$("#nombreCatEdit").value('Hola', nombreCat); 

}
//Funcion para cambiar el nombre a la categoria
function editCategorias(){

	validarEditar();
	if (validarEditar()) {
		var parametros= "codigo="+$("#cod").val()+"&"+
						"nombreCate="+$("#nombreCatEdit").val();
					//alert(parametros);
		$.ajax({
			url:"../backend/gestionCategorias.php?accion=editar",
			method:"GET",
			data:parametros,
			dataType:"json",
			success:function(respuesta){
				console.log(respuesta);
				//alert(respuesta[0].mensaje);
				if (respuesta[0].mensaje=='Edicion exitosa') {
					//alert(respuesta[0].mensaje);

					$("#msjDelete").html(respuesta[0].mensaje);
					$("#msjDelete").fadeIn();
					$("#msjDelete").fadeOut(2000);

					$("#editarCat").fadeOut();
					$("#agregarCat").fadeIn();
					
					obtenerCategorias();
				}
				
			}
		});
		
		
		//window.location.replace("categorias.php");
	}
	
	
}

var validarCampoVacio = function(id){
	
	if ($("#"+id).val() == ""){
		$("#"+id).removeClass('is-valid');
		$("#"+id).addClass('is-invalid');
		return false;
	}
	else{
		$("#"+id).removeClass('is-invalid');
		$("#"+id).addClass('is-valid');
		return true;
	}
};

function validarRegistro(){
	
	var nombre=validarCampoVacio("nombrePro");
	if (nombre) {
		$("#avisoPro").fadeOut();
		console.log("Nombre correcto");
		return true;
	}else{
		console.log("Nombre incorrecto");
		$("#avisoPro").fadeIn();
		return false;
	}
}

function validarEditar(){
	
	var nombre=validarCampoVacio("nombreCatEdit");
	if (nombre) {
		$("#avisoCatE").fadeOut();
		console.log("Categoria correcta");
		return true;
	}else{
		console.log("Categoria incorrecta");
		$("#avisoCatE").fadeIn();
		return false;
	}
}

function validarBuscar(){
	
	var nombre=validarCampoVacio("buscarCat");
	if (nombre) {
		$("#avisoCatB").fadeOut();
		console.log("Categoria correcta");
		return true;
	}else{
		console.log("Categoria incorrecta");
		$("#avisoCatB").fadeIn();
		return false;
	}
}

function buscar(){
	validarBuscar();
	if (validarBuscar()) {
		var parametros= "nombreCat="+$("#buscarCat").val();
		//alert(parametros);
		$.ajax({
			url:"../backend/gestionCategorias.php?accion=buscarNombre",
			data:parametros,
			method:"GET",
			dataType:"json",
			success:function(respuesta){
				//console.log(respuesta);
				var contenido = "";

				contenido='<div class="table-responsive" id="div_ini"><table class="table table-striped table-hover"><thead class="thead-dark"><tr>'+
	                        '<th>Nombre Categoria</th>'+
	                        //'<th>Tipo Categoria</th>'+
	                        '<th>Dar de baja</th>'+
	                        '<th>Editar</th></tr></thead>';

					/*  */

				for (var i = 0; i<1; i++){

					contenido += '<tr><!--td>'+respuesta[i].idCategorias+ '</td-->'+

				                    '<td>'+respuesta[i].descripcion+'</td>'+
				                    //'<td>'+respuesta[i].estado+'</td>'+
				                    '<td>'+
				                    '<button class="btn btn-primary" type="button" id="btnEliminar'+respuesta[i].idCategorias+'" onclick="eliminarCategorias('+respuesta[i].idCategorias +')">Eliminar</button>'+ 
				                    '</td>'+
				                    '<td>'+
				                    '<button class="btn btn-primary" type="button" id="btnEdit'+respuesta[i].idCategorias+'"   onclick="editarCategorias('+respuesta[i].idCategorias+','+"'"+respuesta[i].descripcion+"'"+')">Editar</button>'+ 
				                    '</td>'+
				                  '</tr>';
				}
				contenido+='</table></div>';

				$("#div_ini").remove();
				//$("#con2").remove();
				//$("#c1").prop("disabled",false);
				$("#div_table").append(contenido);
				$("#buscarT").fadeIn();
			}
		});
	}
}

$("#buscarT").click(function(){
	$("#buscarT").fadeOut();
	$("#buscarCat").val("");
});


function cargarTabla(){

	$('#tablaCategoria').DataTable({
		language: {
			"lengthMenu":"Mostrar _MENU_ registros",
			"zeroRecords":"No se encontraron Resultados",
			"info":"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"infoEmpty":"Mostrando registros del 0 al 0 de un total de 0 registros",
			"infoFiltered":"(Filtrado de un total de _MAX_ registros)",
			"sSearch":"Buscar",
			"oPaginate":{
				"sFirst":"Primero",
				"sLast":"Ultimo",
				"sNext":"Siguiente",
				"sPrevious":"Anterior"
			},
			"sProcessing":"Procesando...",
		}
		/*,
		initComplete: function(){
                    this.api().columns().every(function(){
                        var column=this;
                        var select=
                        $('<select class="form-control btn-dark" style=""><option value=""></option></select>')
                            .appendTo($(column.header()).empty())
                            .on('change',function(){
                                var val=$.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column.search(val ? '^'+val+'$': '',true,false)
                                  .draw();

                        });

                        column.data().unique().sort().each(function (d,j){
                            select.append('<option value"'+d+'">'+d+'</option>')
                        });
                    });
                }*/
		
	});
}