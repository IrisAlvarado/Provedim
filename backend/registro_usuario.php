<?php

$host = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "mydb";
$puerto = 3306;
$link;

$mysqli = new mysqli(   
        $host,
        $usuario,
        $password,
        $baseDatos,
        $puerto
);

$primerNombre = $_POST["primerNombre"];
$primerApellido = $_POST["primerApellido"];
$segundoApellido = $_POST["segundoApellido"];
$correo = $_POST["correo"];
$direccion = $_POST["direccion"];
$contrasenia = $_POST["contrasenia"];
$tipoUsuario=(int)$_POST["tipoUs"];



// ALTER TABLE mydb.persona ADD codigo VARCHAR(250) NOT NULL;

$call = $mysqli->prepare('CALL SP_REGISTRO_USUARIO(?, ? , ? , ? , ?, ? , ?, ? , @mensaje, @codigo, @idUsuario)');

$codigo_usuario = md5(rand());

$call->bind_param('ssssssii', 
    $primerNombre,
    $primerApellido,
    $segundoApellido,
    $direccion,
    $correo,
    $contrasenia,
    $tipoUsuario,
    $codigo_usuario
);


$call->execute();

$select = $mysqli->query('SELECT  @mensaje, @codigo, @idUsuario');

$result = $select->fetch_assoc();
$mensaje = $result['@mensaje'];
$codigo = $result['@codigo'];
$idUsuario = $result['@idUsuario'];



?>