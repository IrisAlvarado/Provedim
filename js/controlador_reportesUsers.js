$(document).ready(function () {

    console.log("DOM cargado");
    obtenerUsuarios();
});

function obtenerUsuarios(){
	$.ajax({
		url:"../backend/gestionReportes.php?accion=obtenerUsuarios",
		method:"GET",
		dataType:"json",
		success:function(respuesta){
			//console.log(respuesta);
			var contenido = "";

			contenido='<div class="table-responsive" id="divUsuarios"><table  class="table table-striped table-hover table-bordered" id="tablaRU"><thead class="thead-dark"><tr>'+
                       	    '<th>Id</th>'+
	                        '<th>Nombre</th>'+
	                        '<th>Departamento</th>'+
	                        '<th>Municipio</th>'+
	                        '<th>N# Publicaciones</th>'+
	                        '<th>N# Denuncias</th>'+
	                        '<th>Estado</th></tr></thead>';


			for (var i = 0; i<respuesta.length; i++){

				contenido += '<tr><td>'+respuesta[i].idPersona+ '</td>'+
			                    '<td>'+respuesta[i].concatenacion+'</td>'+
			                    '<td>'+respuesta[i].nombreDepto+'</td>'+
			                    '<td>'+respuesta[i].nombre+'</td>'+
			                    '<td>'+respuesta[i].conteo+'</td>'+
			                    '<td>'+respuesta[i].cantidad+'</td>'+
			                    '<td>'+respuesta[i].estado+'</td>'+
			                  '</tr>';
			}	
			contenido+='</table></div>';
            console.log(contenido[i]);
			//$("#divEstadisticas").remove();
			//$("#con2").remove();
			//$("#c1").prop("disabled",false);
			//$("#divDenuncias").remove();
			$("#divUsuarios").append(contenido);
			cargarTabla();
		}
	});

}





function cargarTabla(){

	$('#tablaRU').DataTable({
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