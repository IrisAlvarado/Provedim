
<?php
session_start(); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'C:\xampp\composer\vendor\autoload.php';



include_once 'class-conexion.php';
$conexion = new Conexion();


$idAnuncio = $_GET["idAnuncio"];
$idUser = $_SESSION["id_usuario"];
$nombre = $_POST["name"];
$correo =  $_POST["email"];
$telefono = $_POST["phone"];
$mensaje = $_POST["message"];
$correoBase;
$nombreBase;

$correoVendedor = "
select p.correo from persona p 
INNER JOIN anuncios anu on anu.idPersona = p.idPersona 
where anu.idAnuncios = $idAnuncio";

$resultado = $conexion->ejecutarConsulta($correoVendedor);

$resultadoCorreo = $conexion->obtenerFila($resultado);

$cadena = implode(";", $resultadoCorreo);
            
//echo json_encode($cadena);




	$nombreVendedor = "select CONCAT(p.primerNombre, '', p.primerApellido) as nombre from persona p 
	INNER JOIN anuncios anu on anu.idPersona = p.idPersona 
	where anu.idAnuncios = $idAnuncio";

   $resultado = $conexion->ejecutarConsulta($nombreVendedor);

            $resultadoNombre = $conexion->obtenerFila($resultado);


            $cadena2 = implode(";", $resultadoNombre);

            //echo json_encode($cadena2);
	

	$tituloAnuncio = "
	select titulo from anuncios  
	where idAnuncios = $idAnuncio";

	$resultado = $conexion->ejecutarConsulta($tituloAnuncio);

    $resultadoTitulo = $conexion->obtenerFila($resultado);
                 
    $cadena3 = implode(";", $resultadoTitulo);
     

     //echo json_encode($cadena3);



//Instancia
	$mail = new PHPMailer(TRUE);

	try {

		$mail -> charSet = "UTF-8"; 

    //direccion de quien envia el correo
		$mail->setFrom($correo, $correo);

    //direccion de a quien se envia el correo
		$mail->addAddress($cadena, $cadena2);

    //La razon del correo
		$mail->Subject = 'Correo de contacto';

    //aqui se pone el cuerpo del email
		$mail->Body = $mensaje;

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

    if($mail->send() == false){
    	echo '<script type="text/javascript">
    alert("Su mensaje no fue enviado");
    window.location.href="../usuarioCV/contacto.php";
    </script>';
    }else{
    	echo '<script type="text/javascript">
    alert("Correo enviado con exito");
    window.history.go(-2);
    </script>';

    }

    echo json_encode(array(
    	"ok"=>true
    ));
}
catch (Exception $e)
{
	echo $e->errorMessage();
}
catch (\Exception $e)
{
	echo $e->getMessage();
}


?>