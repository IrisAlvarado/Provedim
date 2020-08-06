<?php
	
	$mysqli = new mysqli("localhost:3306", "root", "", "mydb");

    
    switch($_GET["accion"]){

        case 'editar':
            
            $mysqli->multi_query("");
           
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
            $idDenuncia=$_GET["idDenuncia"];

            $resultadoConsulta = array();
            $mysqli->multi_query("SET @p0='eliminar'; SET @p1='".$idDenuncia."'; SET @p2=''; SET @p3=''; CALL `SP_DENUNCIAS`(@p0, @p1, @p2, @p3, @p4); SELECT @p4 AS `mensaje`;");

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
        	/*$nombreImg=$_FILES['imagen']['name'];
        	$archivo=$_FILES_GET['imagen']['tmp_name'];

        	$ruta="imgUsers";

        	$ruta=$ruta."/".$nombreImg;
        	move_uploaded_file($archivo, $ruta);

        	echo "nombre img ".$nombreImg;
        	echo "ruta vieja ".$archivo;
        	echo "ruta nueva ".$ruta;
			//$imgUrl=$_GET["imgUrl"];
			//$idC=$_GET["codigo"];*/
			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0='".$nombreCat."'; SET @p1='".$idC."'; SET @p2='editar'; SET @p3='a'; CALL `SP_CATEGORIAS`(@p0, @p1, @p2, @p3, @p4); SELECT @p4 AS `mensaje`;");

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

		case 'obtenerUsuario':
        	//$nombreImg=$_FILES['imagen']['name'];
			$idC=$_GET["codigo"];
			
			$resultadoConsulta = array();

			$mysqli->multi_query("SET @p0='".$nombreCat."'; SET @p1='".$idC."'; SET @p2='editar'; SET @p3='a'; CALL `SP_CATEGORIAS`(@p0, @p1, @p2, @p3, @p4); SELECT @p4 AS `mensaje`;");

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