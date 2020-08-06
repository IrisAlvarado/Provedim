<?php
	
    $mysqli = new mysqli("localhost:3306", "root", "", "mydb");

    
    switch($_GET["accion"]){

        case 'obtenerTodos':
            
            $mysqli->multi_query("SET @p0='obtenerTodos'; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; CALL `SP_DENUNCIAS`(@p0, @p1, @p2, @p3, @p4, @p5, @p6);");
           
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
            $mysqli->multi_query("SET @p0='eliminar'; SET @p1=''; SET @p2='".$idDenuncia."'; SET @p3=''; SET @p4=''; SET @p5=''; CALL `SP_DENUNCIAS`(@p0, @p1, @p2, @p3, @p4, @p5, @p6); SELECT @p6 AS `mensaje`;");

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


        case 'solicitudDenuncia':
            $idAnuncio=$_GET["idAnuncio"];
            $idDenunciante=$_GET["idDenunciante"];
            $razon=$_GET["razon"];

            $resultadoConsulta = array();
            $mysqli->multi_query("SET @p0='solicitudDenuncia'; SET @p1='".$idAnuncio."'; SET @p2=''; SET @p3='".$idDenunciante."'; SET @p4='".$razon."'; SET @p5=''; CALL `SP_DENUNCIAS`(@p0, @p1, @p2, @p3, @p4, @p5, @p6); SELECT @p6 AS `mensaje`;");

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