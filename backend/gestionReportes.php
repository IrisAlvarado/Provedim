<?php
	
	$mysqli = new mysqli("localhost:3306", "root", "", "mydb");

	
	switch($_GET["accion"]){

		case 'obtenerDenuncias':
			
			$mysqli->multi_query("SET @p0='obtenerDenuncias'; SET @p1=''; CALL SP_REPORTES(@p0, @p1);");
			$resultadoConsulta = array();
			do {
			    if ($resultado = $mysqli->store_result()) {
					  while ($fila = $resultado->fetch_assoc()) {

        				$resultadoConsulta[] = $fila;

			            }
			        
			        $resultado->free();
			    } else {
			        if ($mysqli->errno) {
			            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
			        }
			    }
			} while ($mysqli->more_results() && $mysqli->next_result());

			echo json_encode($resultadoConsulta);
	
		break;
					

		case 'obtenerUsuarios':
			$mysqli->multi_query("SET @p0='obtenerUsuarios'; SET @p1=''; CALL SP_REPORTES(@p0, @p1);");
			$resultadoConsulta = array();
			do {
			    if ($resultado = $mysqli->store_result()) {
					  while ($fila = $resultado->fetch_assoc()) {

        				$resultadoConsulta[] = $fila;

			            }
			        
			        $resultado->free();
			    } else {
			        if ($mysqli->errno) {
			            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
			        }
			    }
			} while ($mysqli->more_results() && $mysqli->next_result());

			echo json_encode($resultadoConsulta);
	
		break;

		
		
		case 'buscarNombre':
			$nombreRepo=$_GET["nombreRepo"];
			//$nombreCat="Camas";
			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='".$nombreRepo."'; SET @p1=''; SET @p2='obtenerPorPalabra'; SET @p3=''; CALL `SP_REPORTES`(@p0, @p1, @p2, @p3, @p4); SELECT @p4 AS `mensaje`;");

			$resultadoConsulta = array();
			do {
			    if ($resultado = $mysqli->store_result()) {
					  while ($fila = $resultado->fetch_assoc()) {

        				$resultadoConsulta[] = $fila;

			            }
			        
			        $resultado->free();
			    } else {
			        if ($mysqli->errno) {
			            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
			        }
			    }
			} while ($mysqli->more_results() && $mysqli->next_result());

			echo json_encode($resultadoConsulta);
					
		break;

	}
?>