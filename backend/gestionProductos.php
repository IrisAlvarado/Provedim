<?php
	
	$mysqli = new mysqli("localhost:3306", "root", "", "mydb");

	
	switch($_GET["accion"]){

		case 'obtenerTodos':
			//$tipo=$_GET["tipo"];
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5='obtenerTodos'; SET @p6=''; CALL SP_PRODUCTOS_Y_SERVICIOS(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7);");
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
					

		case 'eliminar':
			$id=$_GET["codigo"];

			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4='".$id."'; SET @p5='eliminar'; SET @p6=''; CALL SP_PRODUCTOS_Y_SERVICIOS(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7); SELECT @p7 AS mensaje;");

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

		case 'editar':
			$codigo=$_GET["codigo"];
			$nombreP=$_GET["nombreP"];
			$descripcionP=$_GET["descripcionP"];
			$tipoE=$_GET["tipoE"];
			$categoria=$_GET["categoria"];

			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0='".$nombreP."'; SET @p1='".$descripcionP."'; SET @p2='".$tipoE."'; SET @p3='".$categoria."'; SET @p4='".$codigo."'; SET @p5='editar'; SET @p6=''; CALL SP_PRODUCTOS_Y_SERVICIOS(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7); SELECT @p7 AS mensaje;");

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

		case 'nuevo':

			$nombre=$_GET["nombre"];
			$descripcion=$_GET["descripcion"];
			$categoria=$_GET["categoria"];
			$tipo=$_GET["tipo"];

			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='".$nombre."'; SET @p1='".$descripcion."'; SET @p2='".$tipo."'; SET @p3='".$categoria."'; SET @p4=''; SET @p5='guardar'; SET @p6=''; CALL SP_PRODUCTOS_Y_SERVICIOS(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7); SELECT @p7 AS mensaje;");

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

		case 'buscarInactivo':
			$nombreCat=$_GET["nombreCat"];
			//$nombreCat="Camas";
			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='".$nombreCat."'; SET @p1=''; SET @p2='obtenerPorPalabra'; SET @p3=''; CALL SP_CATEGORIAS(@p0, @p1, @p2, @p3, @p4);");

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

		case 'obtenerCategoria':
			//$tipo="servicios";
			/*$tipo=$_GET["tipo"];*/
			//$nombreCat="Camas";
			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5='obtenercategorias'; SET @p6=''; CALL SP_PRODUCTOS_Y_SERVICIOS(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7);");

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