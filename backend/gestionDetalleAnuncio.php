<?php
	
	$mysqli = new mysqli("localhost:3306", "root", "", "mydb");

	
	switch($_GET["accion"]){

		case 'obtenerPublicacion':
			
			$idAnuncio=$_GET["idAnun"];
			//$idAnuncio=1;
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2='".$idAnuncio."'; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6='obtenerPublicacion'; SET @p7=''; CALL `SP_DETALLE_PUBLICACION`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8);");
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
					

		case 'guardarCalificacion':
			$calificacion=$_GET["calificacion"];
			$razones=$_GET["razones"];
			$idUsuarioDalike=$_GET["idUsuariDaLike"];
			//$idUsuarioDalike=1;
			$idPublicacion=$_GET["idAnuncios"];
			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='".$idUsuarioDalike."'; SET @p1=''; SET @p2='".$idPublicacion."'; SET @p3=''; SET @p4='".$calificacion."'; SET @p5='".$razones."'; SET @p6='guardarCalificacion'; SET @p7=''; CALL `SP_DETALLE_PUBLICACION`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8); SELECT @p8 AS `mensaje`;");

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

		case 'obtenerPuntuacion':
			$idAnuncio=$_GET["idAnun"];

			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2='".$idAnuncio."'; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6='obtenerPuntuacion'; SET @p7=''; CALL `SP_DETALLE_PUBLICACION`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8);");

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

		case 'obtenerFotos':
			$idAnuncios=$_GET["idAnuncios"];

			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2='".$idAnuncios."'; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6='obtenerFotos'; SET @p7=''; CALL `SP_DETALLE_PUBLICACION`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8);");

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

		case 'editarCalificacion':
			$idAnuncios=$_GET["idAnuncios"];
			$idUsuariDaLike=$_GET["idUsuariDaLike"];

			$resultadoConsulta = array();
			$mysqli->multi_query("SET @p0='".$idUsuariDaLike."'; SET @p1=''; SET @p2='".$idAnuncios."'; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6='editarCalificacion'; SET @p7=''; CALL `SP_DETALLE_PUBLICACION`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8); SELECT @p8 AS `mensaje`;");

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