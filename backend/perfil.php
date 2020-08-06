<?php 

session_start(); 

$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );


    $correo;
    $primerNombre;
    $segundoNombre;
    $primerApellido;



    $stmt = $mysqli -> prepare('SELECT primerNombre, segundoNombre, primerApellido, correo FROM persona WHERE idPersona = ?');

    $userId = $_SESSION["id_usuario"]; // or $_GET['userId'];
    
    $stmt -> bind_param('i', $userId);
    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result( 
    $primerNombre,
    $segundoNombre,
    $primerApellido,
    $correo );


    $stmt -> fetch();
    
    echo (json_encode(
        array(
            "nombre"=> $primerNombre." ".$segundoNombre." ".$primerApellido,
            "correo"=>$correo
        )
    ));

?>