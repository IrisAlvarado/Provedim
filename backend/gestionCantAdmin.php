<?php
	
	$mysqli = new mysqli("localhost:3306", "root", "", "mydb");

	
	switch($_GET["accion"]){

		case 'obtenerUsuarios':
			
			$mysqli->multi_query("SET @p0='obtenerUsuarios'; CALL `SP_CANTIDAD_ADMIN`(@p0, @p1);");
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
					

		case 'obtenerPublicaciones':
		
			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='obtenerPublicaciones'; CALL `SP_CANTIDAD_ADMIN`(@p0, @p1);");

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

		case 'obtenerProducto':
		
			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0='obtenerProductos'; CALL `SP_CANTIDAD_ADMIN`(@p0, @p1);");

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

		case 'obtenerServicios':
			
			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='obtenerServicios'; CALL `SP_CANTIDAD_ADMIN`(@p0, @p1);");

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
			$nombreCat=$_GET["nombreCat"];
			//$nombreCat="Camas";
			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='".$nombreCat."'; SET @p1=''; SET @p2='obtenerPorPalabra'; SET @p3=''; CALL `SP_CATEGORIAS`(@p0, @p1, @p2, @p3, @p4);");

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