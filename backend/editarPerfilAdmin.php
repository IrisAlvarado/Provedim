<?php
	
	$mysqli = new mysqli("localhost:3306", "root", "", "mydb");

	
	switch($_GET["accion"]){

		case 'obtenerMunicipios':
			
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7=''; SET @p8=''; SET @p9=''; SET @p10='';SET @p11='obtenerMunicipios'; CALL SP_PERFIL_ADMIN(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12);");
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
					

		case 'obtenerDeptos':

			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7=''; SET @p8=''; SET @p9=''; SET @p10='';SET @p11='obtenerDeptos'; CALL `SP_PERFIL_ADMIN`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12);");

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


		case 'obtenerTelefono':

			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7=''; SET @p8='1'; SET @p9=''; SET @p10='';SET @p11='obtenerTelefono'; CALL `SP_PERFIL_ADMIN`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12);");

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
			$pNombre=$_GET["primerNombre"];
			$sNombre=$_GET["segundoNombre"];
			$pApellido=$_GET["primerApellido"];
			$sApellido=$_GET["segundoApellido"];
			$cel=$_GET["cel"];
			$correo=$_GET["correo"];
			$municipio=$_GET["mun"];
			$id=$_GET["codigo"];

			/*$pNombre="Karen";
			$sNombre="Melissa";
			$pApellido="Pastrana";
			$sApellido="Perez";
			$cel="12345678";
			$correo="asd@gmail.com";
			$municipio="1";
			$id=2;*/

			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0='".$pNombre."'; SET @p1='".$sNombre."'; SET @p2='".$pApellido."'; SET @p3='".$sApellido."'; SET @p4='".$correo."'; SET @p5=''; SET @p6='".$cel."'; SET @p7='".$municipio."'; SET @p8='".$id."'; SET @p9=''; SET @p10=''; SET @p11='editar'; CALL `SP_PERFIL_ADMIN`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12); SELECT @p12 AS `mensaje`;");

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

		case 'editarFoto':
			$urlImg=$_GET["urlImag"];
			$id=$_GET["codigo"];

			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7='".$id."'; SET @p8='".$urlImg."'; SET @p9='';SET @p10='';SET @p11='editarFoto'; CALL SP_PERFIL_ADMIN(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12); SELECT @p12 AS mensaje;");

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

		case 'obtenerFoto':
			
			$id=$_GET["codigo"];
			//$id=1;
			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7=''; SET @p8='".$id."'; SET @p9=''; SET @p10=''; SET @p11='obtenerFotos'; CALL `SP_PERFIL_ADMIN`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12); SELECT @p12 AS `mensaje`;");

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
	

	case 'obtenerMunDepto':
			
			$idDepto=$_GET["codDepto"];
			//$idDepto=1;
			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7=''; SET @p8=''; SET @p9='".$idDepto."'; SET @p10=''; SET @p11='obtenerPorDepto'; CALL `SP_PERFIL_ADMIN`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12);");

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
			
			$idUsuario=$_GET["idUsuario"];
			//$idUsuario=1;
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7=''; SET @p8='".$idUsuario."'; SET @p9=''; SET @p10=''; SET @p11='eliminar'; CALL `SP_PERFIL_ADMIN`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11, @p12); SELECT @p12 AS `mensaje`;");

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