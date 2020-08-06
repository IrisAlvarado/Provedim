<?php 

session_start(); 


$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );


    $correo;
    $primerNombre;
    $segundoNombre;
    $primerApellido;
    $segundoApellido;
    $fechaNac;
    $idMunicipio;

    $stmt = $mysqli -> prepare('SELECT primerNombre, segundoNombre, primerApellido,segundoApellido,correo,
        fechaNac,idMunicipio
        FROM persona WHERE idPersona = ?');

    $userId = $_SESSION["id_usuario"]; // or $_GET['userId'];

    $stmt -> bind_param('i', $userId);
    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result( 
    $primerNombre,
    $segundoNombre,
    $primerApellido,
    $segundoApellido,
    $correo,
    $fechaNac,
    $idMunicipio);

    $stmt -> fetch();
    
    echo (json_encode(
        array(
            "nombre"=> $primerNombre." ".$segundoNombre,
            "apellidos"=>$primerApellido." ".$segundoApellido,
            "correo"=>$correo,
            "fechaNa"=>$fechaNac,
            "idmunicipio"=>$idMunicipio,
            "idUsuario"=>$userId
        )
    ));

?>