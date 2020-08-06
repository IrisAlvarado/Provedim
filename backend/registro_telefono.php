<?php
    include ("class-conexion.php");
    $host = "localhost";
    $password = "";
    $usuario = "root";
    $baseDatos = "mydb";
    $puerto = 3306;
    $link = mysqli_connect($host, $usuario, $password, $baseDatos, $puerto);
    $conexion = new Conexion();
    $telefono = (int)$_POST["ptelefono"];
    $idUsuario = (int)$_POST["pidUsuario"];
    //$telefono = 95055710;
    //$idUsuario = 2;
    if(!$link)
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    else
    {
        $sql = "SELECT * FROM `telefono`";
        $resultado = $conexion->ejecutarConsulta($sql);
        $idTelefono = $resultado->num_rows + 1;
        echo $idTelefono;
        $sql = "INSERT INTO `telefono` (`idTelefono`, `telefono`, `idPersona`) VALUES ($idTelefono, $telefono, $idUsuario)";
        if(mysqli_query($link, $sql))
        {
            $codigo = 1;
            $mensaje = "Guardado con exito";
            echo json_encode(array('cod'=>$codigo, 'mensaje'=>$mensaje));
        }
        else
        {
            $codigo = 0;
            $mensaje = "Error: " . $sql . mysqli_error($link);
            echo json_encode(array('cod'=>$codigo, 'mensaje'=>$mensaje));
        }
    }
?>