$(document).ready(function () {
    console.log("DOM cargado");
    obtenerProductos('producto');
	$("#productos").addClass("active");
	//obtenerCategoria();

});
function obtenerProductos(idTipo){

	var parametros = "tipo="+idTipo;
	$.ajax({
		url:"../backend/gestionProductos.php?accion=obtenerTodos",
		method:"GET",
		data:parametros,
		dataType:"json",
		success:function(respuesta){
			//console.log(respuesta);
			var contenido = "";
			console.log(respuesta);
			contenido='<div class="table-responsive" id="div_ini">'+
						'<table class="table table-striped table-hover table-bordered" id="tablaCategoria">'+
						'<thead class="thead-dark"><tr>'+
                        '<th>Nombre</th>'+
                        '<th>Descripcion</th>'+
                        '<th>Categoria</th>'+
                        '<th>Tipo</th>'+
                        '<th>Dar de baja</th>'+
                        '<th>Editar</th></tr></thead>';

				/*  */

			for (var i = 0; i<respuesta.length; i++){

				contenido += '<tr><td>'+respuesta[i].nombre+ '</td>'+
			                    '<td>'+respuesta[i].caracteristicas+'</td>'+
			                    '<td>'+respuesta[i].categoria+'</td>'+
			                    '<td>'+respuesta[i].tipo+'</td>'+
			                    '<td>'+
			                    '<button class="btn btn-outline-danger" type="button" id="btnEliminar'+respuesta[i].idProducto+'" onclick="eliminarProducto('+respuesta[i].idProducto +')"><i class="fas fa-trash-alt fa-lg"></i></button>'+ 
			                    '</td>'+
			                    '<td>'+
			                    '<button class="btn btn-outline-primary" type="button" id="btnEdit'+respuesta[i].idProducto+'"   onclick="editarProductos('+respuesta[i].idProducto+','+"'"+respuesta[i].nombre+"'"+','+"'"+
			                    respuesta[i].caracteristicas+"'"+','+"'"+respuesta[i].tipo+"'"+","+"'"+respuesta[i].idCategorias+"'"+')"><i class="fas fa-edit fa-lg" ></i></button>'+ 
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


//funcion para obtener la categoria
function obtenerCategoria(tipo){
   // console.log("DOM cargado");
    document.getElementById("slcCat").innerHTML = " ";
    var parametros = "tipo="+tipo;
    //alert(tipo);
    $.ajax({
        url:"../backend/gestionProductos.php?accion=obtenerCategoria",
        method:"GET",
        data:parametros,
        dataType:"json",
        success:function(respuesta){
            var contenido = "";
            //console.log(respuesta);
   
                /*  */ 
            document.getElementById("slcCat").innerHTML += `<option selected="selected" value="null">
            Selecciona una categoria</option>`;
            for (var i = 0; i<respuesta.length; i++){
            	
    			contenido += '<option value="'+respuesta[i].idCategorias+'">'+
                               respuesta[i].descripcion+'</option>';
            }
            //document.getElementById("slcCat").innerHTML = " ";
            $("#slcCat").append(contenido);
        }
    });
}

function obtenerCategoriaE(tipo,idCategoria){
   // console.log("DOM cargado");
    document.getElementById("slcCatE").innerHTML = " ";
    var parametros = "tipo="+tipo;
    //alert(tipo);
    $.ajax({
        url:"../backend/gestionProductos.php?accion=obtenerCategoria",
        method:"GET",
        data:parametros,
        dataType:"json",
        success:function(respuesta){
            var contenido = "";
            //console.log(respuesta);
   
                /*  */ 
            document.getElementById("slcCatE").innerHTML += `<option selected="selected" value="null">
            Selecciona una categoria</option>`;
            for (var i = 0; i<respuesta.length; i++){
            	if (respuesta[i].idCategorias=idCategoria) {
            		contenido += '<option value="'+respuesta[i].idCategorias+'" selected="selected">'+
                                respuesta[i].descripcion+'</option>';
            	} else {
            		// statement
            		contenido += '<option value="'+respuesta[i].idCategorias+'">'+
                               respuesta[i].descripcion+'</option>';
            	}
    			
            }
            //document.getElementById("slcCat").innerHTML = " ";
            $("#slcCatE").append(contenido);
        }
    });
}

function guardarProductos(){
	validarRegistro();
	if (validarRegistro()) {
		var parametros= "nombre="+$("#nombrePro").val()+"&"+
						"descripcion="+$("#descripcionPro").val()+"&"+
						"categoria="+$("#slcCat").val()+"&"+
						"tipo="+$("#slcTipo").val();
					alert(parametros);
	
	$.ajax({
		url:"../backend/gestionProductos.php?accion=nuevo",
		method:"GET",
		data:parametros,
		dataType:"json",
		success:function(respuesta){  
			console.log(respuesta);
			//alert(respuesta[0].mensaje);
			
			$("#msjDelete").addClass("alert-danger");
			$("#msjDelete").html(respuesta[0].mensaje);
			$("#msjDelete").fadeIn();
			$("#msjDelete").fadeOut(2000);	

			$("#nombreCat").val('');
			obtenerProductos('producto');
		}
	});
		
		//window.location.replace("categorias.php");
		
	}else {
		alert("Campos requeridos");
	}
	
}

$('#slcTipo').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    console.log(valueSelected);

    //console.log('data=' + 'tipo = ' + valueSelected.trim());
    obtenerCategoria(valueSelected);
    if (valueSelected=='null') {
    	console.log('opcion: '+valueSelected);
    	$("#slcCat").attr('disabled',true);
    } else {
    	$("#slcCat").attr('disabled',false);
    	console.log(' se habilito '+valueSelected);
    }
    
});

$('#slcTipoE').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    console.log(valueSelected);

    //console.log('data=' + 'tipo = ' + valueSelected.trim());
    obtenerCategoriaE(valueSelected,"null");
    if (valueSelected=='null') {
    	console.log('opcion: '+valueSelected);
    	$("#slcCatE").attr('disabled',true);
    } else {
    	$("#slcCatE").attr('disabled',false);
    	console.log(' se habilito '+valueSelected);
    }
    
});


function eliminarProducto(idProducto){

	var parametros = "codigo="+idProducto;
	
	//alert(parametros);
	$.ajax({
		url:"../backend/gestionProductos.php?accion=eliminar",
		method:"GET",
		data:parametros,
		dataType:"json",
		success:function(respuesta){
			console.log(respuesta);

			if (respuesta[0].mensaje='Eliminado exitosamente') {

				$("#msjDelete").html(respuesta[0].mensaje);
				$("#msjDelete").fadeIn();
				$("#msjDelete").fadeOut(2000);
				
				obtenerProductos();
				//window.location.replace("denuncias.php");
			//
			}
			
		}
	});

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

function editarProductos(idProducto,nombre,descripcion,tipo,idCategoria){

	//ocultar formiulario agregar y mostrar form editar
	$("#agregarProducto").fadeOut();
	$("#editarProducto").fadeIn();

	//llenado de valores del producto o servicio a editar
	$("#nombreProE").val(nombre);
	$("#cod").val(idProducto);
	$("#descripcionProE").val(descripcion);
	$("#slcTipoE option[value="+tipo+"]").attr("selected",true);

	//$("#slcCat").attr('disabled',false);7
	obtenerCategoriaE(tipo,idCategoria);
}





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
//funcion para validar registro
function validarRegistro(){
	var tipo=$("#slcTipo option:selected").val();
	console.log(tipo);
	var cat=$("#slcCat option:selected").val();
	var nombre=validarCampoVacio("nombrePro");
	var descripcion=validarCampoVacio("descripcionPro");

	var tipoS=false;
	var catS=false;
	if (nombre) {
		// statement
		$("#avisoPro").fadeOut();
	} else {
		// statement
		$("#avisoPro").fadeIn();
	}

	if (descripcion) {
		$("#avisoD").fadeOut();
	} else {
		$("#avisoD").fadeIn();
	}

	if (cat=='null') {
		// statement
		$("#avisoCat").fadeIn();
		$("#slcCat").removeClass('is-valid');
		$("#slcCat").addClass('is-invalid');
		//catS=false;
	} else {
		// statement
		$("#avisoCat").fadeOut();
		$("#slcCat").removeClass('is-invalid');
		$("#slcCat").addClass('is-valid');
		catS=true;
	}

	if (tipo=='null') {
		// statement
		console.log('tipo '+tipo+" funciona")
		$("#avisoTipo").fadeIn();
		$("#slcTipo").removeClass('is-valid');
		$("#slcTipo").addClass('is-invalid');
		//catS=false;
	} else {
		// statement
		$("#avisoTipo").fadeOut();
		$("#slcTipo").removeClass('is-invalid');
		$("#slcTipo").addClass('is-valid');
		tipoS=true;
	}


	if (!(nombre || descripcion  || catS || tipoS)) {
		// statement
		return false;
	} else {
		// statement
		return true;
	}
}


function validarEditar(){
	var tipo=$("#slcTipoE option:selected").val();
	console.log(tipo);
	var cat=$("#slcCatE option:selected").val();
	var nombre=validarCampoVacio("nombreProE");
	var descripcion=validarCampoVacio("descripcionProE");

	var tipoS=false;
	var catS=false;
	if (nombre) {
		// statement
		$("#avisoProE").fadeOut();
	} else {
		// statement
		$("#avisoProE").fadeIn();
	}

	if (descripcion) {
		$("#avisoDProE").fadeOut();
	} else {
		$("#avisoDProE").fadeIn();
	}

	if (cat=='null') {
		// statement
		$("#avisoCatE").fadeIn();
		$("#slcCatE").removeClass('is-valid');
		$("#slcCatE").addClass('is-invalid');
		//catS=false;
	} else {
		// statement
		$("#avisoCatE").fadeOut();
		$("#slcCatE").removeClass('is-invalid');
		$("#slcCatE").addClass('is-valid');
		catS=true;
	}

	if (tipo=='null') {
		// statement
		console.log('tipo '+tipo+" funciona")
		$("#avisoTipoE").fadeIn();
		$("#slcTipoE").removeClass('is-valid');
		$("#slcTipoE").addClass('is-invalid');
		//catS=false;
	} else {
		// statement
		$("#avisoTipoE").fadeOut();
		$("#slcTipoE").removeClass('is-invalid');
		$("#slcTipoE").addClass('is-valid');
		tipoS=true;
	}


	if (!(nombre || descripcion  || catS || tipoS)) {
		// statement
		return false;
	} else {
		// statement
		return true;
	}
}

function editProductos(){

	validarEditar();
	if (validarEditar()) {
		var parametros="categoria="+$("#slcCatE").val()+"&"+
						"tipoE="+$("#slcTipoE").val()+"&"+
						"codigo="+$("#cod").val()+"&"+
						"nombreP="+$("#nombreProE").val()+"&"+
						"descripcionP="+$("#descripcionProE").val();
					//alert(parametros);
		$.ajax({
			url:"../backend/gestionProductos.php?accion=editar",
			method:"GET",
			data:parametros,
			dataType:"json",
			success:function(respuesta){
				console.log(respuesta);
				//alert(respuesta[0].mensaje);
				if (respuesta[0].mensaje='Edicion exitosa') {
					//alert(respuesta[0].mensaje);

					$("#msjDelete").html(respuesta[0].mensaje);
					$("#msjDelete").fadeIn();
					$("#msjDelete").fadeOut(2000);

					$("#editarProducto").fadeOut();
					$("#agregarProducto").fadeIn();
					
					obtenerProductos('producto');
				}
				
			}
		});
		//window.location.replace("categorias.php");
	}	
}