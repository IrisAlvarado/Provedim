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
			$productos = new Productos(
				$_POST["nombre"],
				$_POST["marca"],
				$_POST["descripcion"],
                $_POST["categoria"],
                $_POST["precio"],
                $_POST["cantidad"],
				$_POST["codigo"],
				null
			);
			$productos->guardarRegistroBase($conexion);
		break;

		case 'guardarImagen':
			$sql = sprintf("SELECT id FROM productos ORDER BY id DESC LIMIT 1");
			$ultimo = $conexion->ejecutarConsulta($sql);
			$ultimos = $ultimo->fetch_array()[0];

			echo $ultimos;
			$ruta_carpeta = "images/producto/". $ultimos ."/";
			mkdir('../'.$ruta_carpeta, 0777, true);

			$nombre_archivo = "imagen_".date("dHis").".".pathinfo( $_FILES["imagen"]["name"],PATHINFO_EXTENSION );
			$ruta_guardar_archivo = $ruta_carpeta .  $nombre_archivo;

			echo $ruta_guardar_archivo;

			$sql = sprintf("UPDATE productos SET urlImagen='".$ruta_guardar_archivo."' WHERE Id ='". $ultimos."'");
			$resultado = $conexion->ejecutarConsulta($sql);

			if ( move_uploaded_file(  $_FILES["imagen"]["tmp_name"], '../'.$ruta_guardar_archivo ) ) {
				header("Status: 301 Moved Permanently");
				header("Location: http://localhost/Provedim/catalogo.php");
				exit;		
				echo "Imagen Cargada";
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