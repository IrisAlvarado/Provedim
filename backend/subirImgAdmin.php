<?php
	$nombre_temporal=$_FILES['archivo']['tmp_name'];
	$nombre=$_FILES['archivo']['name'];
	move_uploaded_file($nombre_temporal, '../archivos/'.$nombre);
    //$nombre='pic.png';
	///echo "Prueba ".$nombre." ".$nombre_temporal;
	//
	$codigo=$_GET['cod'];
    //$codigo=4;
	$mysqli = new mysqli("localhost:3306", "root", "", "mydb");

	$mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7=''; SET @p8='".$codigo."'; SET @p9=''; SET @p10='archivos/".$nombre."';SET @p11='editarFoto'; CALL `SP_PERFIL_ADMIN`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10, @p11,@p12); SELECT @p12 AS `mensaje`;");
           
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

	

?>