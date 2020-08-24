<?php
	include ("../config/conexion.php");
	include ("../class/class-productos.php");

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
			$sql = 	"SELECT nombre, marca, descripcion, categoria, precio, cantidad, codigo, urlImagen ".
					"FROM productos";

			$resultado = $conexion->ejecutarConsulta($sql);
			$resultadoProductos = array();
			while ($fila = $conexion->obtenerFila($resultado)) {
				$resultadoProductos[] = $fila;
			}
			echo json_encode($resultadoProductos);
        break;
        
		case 'guardarRegistro':
			$sql = sprintf("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES	WHERE TABLE_SCHEMA = 'mydb'	AND   TABLE_NAME   = 'productos'");
			$ultimo = $conexion->ejecutarConsulta($sql);
			$ultimos = $ultimo->fetch_array()[0]+1;
			
			$ruta_carpeta = "images/producto/". ($ultimos-1) ."/";
			if (!file_exists($ruta_carpeta)) {
				mkdir('../'.$ruta_carpeta, 0777, true);
			}

			$nombre_archivo = "imagen_".date("dHis").".".pathinfo( $_FILES["images"]["name"],PATHINFO_EXTENSION );
			$ruta_guardar_archivo = $ruta_carpeta .  $nombre_archivo;
			
			if ( move_uploaded_file(  $_FILES["images"]["tmp_name"], '../'.$ruta_guardar_archivo ) ) {
					
				$productos = new Productos(
					$_POST["txt-producto"],
					$_POST["txt-marca"],
					$_POST["txt-descripcion"],
					$_POST["s-categoria"],
					$_POST["txt-precio"],
					$_POST["txt-cantidad"],
					$_POST["txt-codigo"],
					$ruta_guardar_archivo
				);
				$productos->guardarRegistroBase($conexion);

				//header("Status: 301 Moved Permanently");
				header("Location: http://localhost/Provedim/catalogo.php");
			}else{
				$sql = sprintf("DELETE FROM productos WHERE id='".$ultimos."'");
				$resultado = $conexion->ejecutarConsulta($sql);
				echo "No se puede Cargar";
			}			
		break;
		
		default:
			# code...
			break;
	}
	$conexion->cerrarConexion();
?>