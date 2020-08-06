<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//aqui tienen que buscar el archivo  autoload.php, en la carpeta que instalaron composer, en mi caso es esa. AL instalar phpMailer, ese archivo se crea automaticamente
//require 'C:\wamp64\composer\vendor\autoload.php';
require 'C:\xampp\composer\vendor\autoload.php';



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
$segundoNombre = $_POST["segundoNombre"];
$primerApellido = $_POST["primerApellido"];
$segundoApellido = $_POST["segundoApellido"];
$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$fechaNac = $_POST["fechaNac"];
$contrasenia = $_POST["contrasenia"];
$idMunicipio  = (int)$_POST["idMunicipio"];
$tipoUsuario=(int)$_POST["tipoUs"];



// ALTER TABLE mydb.persona ADD codigo VARCHAR(250) NOT NULL;

$call = $mysqli->prepare('CALL SP_REGISTRO_USUARIO(?, ? , ? , ? , ?, ? , ?, ? ,?,?,?, @mensaje, @codigo, @idUsuario)');

$codigo_usuario = md5(rand());

$call->bind_param('sssssssiiis', 
    $primerNombre,
    $segundoNombre,
    $primerApellido,
    $segundoApellido,
    $correo,
    //$telefono,
    $contrasenia,
    $fechaNac,
    $tipoUsuario,
    $idMunicipio,
    $telefono,
    $codigo_usuario
);


$call->execute();

$select = $mysqli->query('SELECT  @mensaje, @codigo, @idUsuario');

$result = $select->fetch_assoc();
$mensaje = $result['@mensaje'];
$codigo = $result['@codigo'];
$idUsuario = $result['@idUsuario'];

if((int)$codigo==1){

    
    $base_url = "http://localhost/Compra-y-venta-de-toda-papada-Back/backend/";
    $cuerpo_mail = "
    <p>Hola,  ".$primerNombre.".</p>
    <p>Gracias por registrarte.

    <p>Por favor abre este link para validar tu correo electronico- ".$base_url."verificacion_email.php?activation_code=".$codigo_usuario."
    <br>
    <p>Atentamente, Publitodo</p>
    ";


    //creo la instancia de la extension
    $mail = new PHPMailer(TRUE);

    try {
    
        //direccion de quien envia el correo, en este caso nuestra cuenta
        $mail->setFrom('publitodo.2020@gmail.com', 'Publitodo');

        //direccion de a quien se envia el correo, en este caso seria el correo que el usuario registro
        $mail->addAddress($correo, $primerNombre." ".$primerApellido);//TODO:Poner correo de usuario

        //La razon del correo
        $mail->Subject = 'Verifica tu correo en Publitodo';

        //aqui se pone el cuerpo del email, es en codigo html, una simple cadena html
        $mail->Body = $cuerpo_mail;
    
       /* Parametros SMTP. */
       /* Le dice a  PHPMailer que use SMTP. */
        $mail->isSMTP();
    
       /* Direccion del servidor de SMTP, en este caso uso el de google. */
        $mail->Host = 'smtp.gmail.com';

       /* Usar SMTP autenticacion. */
        $mail->SMTPAuth = TRUE;
    
       /* Configura el sistema de encriptacion. */
        $mail->SMTPSecure = 'ssl';//tls
    

       /* Aqui va el usuario de la cuenta de google del proyecto. */
        $mail->Username = 'publitodo.2020@gmail.com';
    
       /* La contrasena de la cuenta. */
        $mail->Password = 'Publitodo_2020.';
    
       /* El puerto en el que esta el servidor SMTP de Google. */
        $mail->Port = 465;

        //le dice la extension  que el cuerpo del mail es html
        $mail-> IsHTML(true);
    
       /* Envia el correo */
        $mail->send();
    }
    catch (Exception $e)
    {
        echo $e->errorMessage();
    }
    catch (\Exception $e)
    {
        echo $e->getMessage();
    }


    session_start(); 

    $_SESSION["id_usuario"] =   null; 
        
        echo json_encode(
            array(
                // 'pid'=>$pid,
                'codigo'=>$codigo,
                'mensaje'=>$mensaje,
                'idUsuario'=>$idUsuario
            ));
    } else
    {
        session_start(); 

        $_SESSION["id_usuario"] =   null; 
        echo json_encode(
            array(
                'codigo'=>$codigo,
                'mensaje'=>$mensaje,
            ));
    }


?>