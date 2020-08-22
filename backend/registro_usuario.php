<?php

$conexion=mysqli_connect('localhost:3306','root','','mydb');

$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$direccion = $_POST["direccion"];
$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];
#$tipoUsuario=$_POST["tipoUsuario"];
 
$sql="INSERT into persona (idPersona, nombres,apellidos,direccion, correo, contrasenia, tipoUsuario, idMunicipio)
            values (6,'$nombres','$apellidos','$direccion', '$correo', '$contrasena', 1, NULL)";
    echo mysqli_query($conexion,$sql);


?>