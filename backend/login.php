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

$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];
$call = $mysqli->prepare('CALL SP_LOGIN(?, ?, @pid, @mensaje, @existe, @contrasenaCorrecta, @estadoRegistro, @esUsuarioAdmin)');
$call->bind_param('ss', $correo, $contrasena);
$call->execute();

$select = $mysqli->query('SELECT @pid, @mensaje, @existe, @contrasenaCorrecta, @estadoRegistro, @esUsuarioAdmin');

$result = $select->fetch_assoc();
$pid     = $result['@pid'];
$mensaje = $result['@mensaje'];
$existe = $result['@existe'];
$contrasenaCorrecta = $result['@contrasenaCorrecta'];
$estadoRegistro = $result['@estadoRegistro'];
$esUsuarioAdmin = $result['@esUsuarioAdmin'];


if($existe==1 && $contrasenaCorrecta==1 && $estadoRegistro==1 && $esUsuarioAdmin==1 ){
    session_start(); 

    $_SESSION["id_usuario"] =   $pid;
    $_SESSION["es_administrador"] =  1;

    echo json_encode(
        array(
            'pid'=>$pid,
            'mensaje'=>$mensaje,
            'existe'=> $existe,
            'contrasenaCorrecta'=>$contrasenaCorrecta,
            'estadoRegistro'=>$estadoRegistro,
            'usuario'=>$esUsuarioAdmin
        ));
}
else if($existe==1 && $contrasenaCorrecta==1 && $estadoRegistro==1 && $esUsuarioAdmin == 0 ){

    session_start(); 

    $_SESSION["id_usuario"] =   $pid;
    $_SESSION["es_administrador"] =  null;

    echo json_encode(
        array(
            'pid'=>$pid,
            'mensaje'=>$mensaje,
            'existe'=> $existe,
            'contrasenaCorrecta'=>$contrasenaCorrecta,
            'estadoRegistro'=>$estadoRegistro,
            'usuario'=>$esUsuarioAdmin
        ));
}
else{
    session_start(); 

    $_SESSION["id_usuario"] =   null;
    $_SESSION["es_administrador"] =  null;

    echo json_encode(
        array(
            'pid'=>$pid,
            'mensaje'=>$mensaje,
            'existe'=> $existe,
            'contrasenaCorrecta'=>$contrasenaCorrecta,
            'estadoRegistro' => $estadoRegistro
        ));
}





// session_start(); 

// //TODO:Anadir logica de login con db

// $loginCorrecto = true;

// if($loginCorrecto){

//     $_SESSION["id_usuario"] =   "1"; //$_POST["correo"];

//     $mensaje = "Usuario logueado con exito: " . $_POST["correo"];

//     $respuesta = array("codigo" => 1, "mensaje" => $mensaje);

//     echo json_encode($respuesta);
// }
// else{

//     $_SESSION["id_usuario"] = null;
//     $mensaje = "Creedenciales invalidas";
//     $respuesta = array("codigo" => 0, "mensaje" => $mensaje);

//     echo json_encode($respuesta);}


// $archivo = fopen("../data/registro-usuarios.json", "r");
// while (($linea = fgets($archivo))) {
//     $registro = json_decode($linea, true);
//     if ($registro["correo"] == $_POST["correo"]
//         && $registro["password"] == $_POST["password"]) {
//                 //Usuario con credenciales correctas
//                // $_SESSION["nombre"] = $_POST["nombre"];
//         $_SESSION["correo"] = $_POST["correo"];
//         echo '{"codigo":0,"mensaje":"Usuario logueado con exito"}';
//         fclose($archivo);
//         exit();
//     }

// }

// echo '{"codigo":1,"mensaje":"Credenciales invalidas"}';
?>