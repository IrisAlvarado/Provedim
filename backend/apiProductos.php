<?php
	include ("../config/conexion.php");
    $conexion = new Conexion();
    
    /*$sql = 	"SELECT nombre, marca, descripcion, categoria, precio, cantidad, codigo ".
					"FROM productos";

			$resultado = $conexion->ejecutarConsulta($sql);
			$resultadoUsuarios = array();
			while ($fila = $conexion->obtenerFila($resultado)) {
				$resultadoUsuarios[] = $fila;
			}
			echo json_encode($resultadoUsuarios);*/

	switch ($_GET["accion"]) {
		case 'obtenerProductos':
			$sql = 	"SELECT nombre, marca, descripcion, categoria, precio, cantidad, codigo ".
					"FROM productos";

			$resultado = $conexion->ejecutarConsulta($sql);
			$resultadoProductos = array();
			while ($fila = $conexion->obtenerFila($resultado)) {
				$resultadoProductos[] = $fila;
			}
			echo json_encode($resultadoProductos);
        break;
        
        case 'guardarRegistro':
			include("../class/class-productos.php");

			$productos = new Productos(
				$_POST["nombre"],
				$_POST["marca"],
				$_POST["descripcion"],
                $_POST["categoria"],
                $_POST["precio"],
                $_POST["cantidad"],
                $_POST["codigo"]
			);
			$productos->guardarRegistroBase($conexion);
		break;
		
		default:
			# code...
			break;
	}
	$conexion->cerrarConexion();
?>