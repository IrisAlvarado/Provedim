<?php 
	
	include_once 'class-conexion.php';
	$conexion = new Conexion();


	switch ($_GET["accion"]) {

        case 'obtener_Deptos':
        //$codigo=2;
       // obtenerRegistro($codigo);
            $sql ="SELECT *FROM vistadeptos";
            
            $resultado = $conexion->ejecutarConsulta($sql);

            $resultadoDeptos = array();
            while($fila = $conexion->obtenerFila($resultado)){
                $resultadoDeptos[] = $fila;
                 
            }

            echo json_encode($resultadoDeptos);
            break;

            case 'Guardar':
	        //guardar

	 
	        break;
    }        
?>