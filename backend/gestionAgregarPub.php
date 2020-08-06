<?php 
//session_start(); 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require 'C:\wamp64\composer\vendor\autoload.php';
require 'C:\xampp\composer\vendor\autoload.php';

$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );

//$prueba = "registrarAnuncio";

switch ($_POST["accion"]) {  

    case "seleccionarCategorias":

    $idCategoria;
    $categoria;

    $stmt = $mysqli -> prepare(
        'SELECT idCategorias, descripcion FROM categorias'
    );

    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result( 
        $idCategoria,
        $categoria);


    $respuesta = array();

    $index = 0;

    while($stmt -> fetch()){

        $respuesta[$index] =  array(
            "idCategoria"=>$idCategoria,
            "categoria"=>$categoria,
        );

        $index++;
    }

    echo json_encode($respuesta);
    break;

    case 'guardar':
 
    $nombreProducto = $_POST["nombre"];
    $caracteristicas = $_POST["descripcion"];
    $idCategoria = $_POST["idCategoria"];
    $tipo = $_POST["tipo"];
    $precio = $_POST["precio"];
    $idPersona = $_POST["idPersona"];
    $idMoneda = $_POST["idMoneda"];
    //$url = $_POST["url"];
    //
    /*$nombreProducto='Puerta';
    $caracteristicas='COlor caoba';
    $idCategoria=1;
    $tipo='Producto';
    $precio=1234;
    $idPersona=4;
    $idMoneda=1;*/

    $mysqli->multi_query("SET @p0='".$nombreProducto."'; SET @p1='".$caracteristicas."'; SET @p2='".$idCategoria."'; SET @p3='".$tipo."'; SET @p4='".$precio."'; SET @p5='".$idPersona."'; SET @p6='".$idMoneda."'; SET @p7=''; SET @p8=''; SET @p9='guardar'; CALL `SP_AGREGAR_PUB`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10); SELECT @p10 AS `mensaje`;");
    $resultadoConsulta = array();
    do {
        if ($resultado = $mysqli->store_result()) {
          while ($fila = $resultado->fetch_assoc()) {

            $resultadoConsulta[] = $fila;

        }

        $resultado->free();
    } else {
        if ($mysqli->errno) {
            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    }
} while ($mysqli->more_results() && $mysqli->next_result());

echo json_encode($resultadoConsulta);

//enviar el correo a todos los favoritos del usuario

    //creo la instancia de la extension

   $mail = new PHPMailer(TRUE);


    $call = $mysqli->prepare(
    'SELECT per.correo correoFavorito, per.primerNombre  pnFavorito, per.primerApellido  paFavorito, 
    p.correo correoUsuario,p.primerNombre pnUsuario, p.primerApellido paUsuario FROM favoritos f 
    INNER JOIN persona per ON per.idPersona = f.favorito 
    INNER JOIN persona p on p.idPersona =  f.idPersona 
    WHERE f.favorito =  ?');

    $call->bind_param('i',$idPersona );
    $call->execute();
    $result = $call->get_result();
    //$result = $stmt->get_result(); 

    while ($row = $result->fetch_assoc()) {

        $cuerpo_mail = "
        <p>Hola,  ".$row['pnUsuario']." ". $row['paUsuario'] ."</p>
        <p>El usuario ".$row['pnFavorito']. " ". $row['paFavorito']." ha publicado un nuevo anuncio.</p> 
        
        <p>Revisa Publitodo para mantenerte al dia de tus publicaciones favoritas.</p>

        <br>
        <p>Atentamente, Publitodo</p>
        ";

        try {
    
            //direccion de quien envia el correo, en este caso nuestra cuenta
            $mail->setFrom('publitodo.2020@gmail.com', 'Publitodo');
    
            //direccion de a quien se envia el correo, en este caso seria el correo que el usuario registro
            $mail->addAddress($row['correoUsuario'], $row['pnUsuario']." ".$row['paUsuario']);//TODO:Poner correo de usuario
    
            //La razon del correo
            $mail->Subject = 'Notificacion de nueva publicacion.';
    
            //aqui se pone el cuerpo del email, es en codigo html, una simple cadena html
            $mail->Body = $cuerpo_mail;
        
           /* Parametros SMTP. */

            //Le dice a  PHPMailer que use SMTP. 
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


    //echo $row['name'];
    }

break;

case 'obtenerAnuncio':
    $idPersona = $_POST["idPersona"];
    //$idPersona=4;
    $mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5='".$idPersona."'; SET @p6=''; SET @p7=''; SET @p8=''; SET @p9='obtenerAnuncio'; CALL `SP_AGREGAR_PUB`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10);");
    $resultadoConsulta = array();
    do {
        if ($resultado = $mysqli->store_result()) {
          while ($fila = $resultado->fetch_assoc()) {

            $resultadoConsulta[] = $fila;

        }

        $resultado->free();
    } else {
        if ($mysqli->errno) {
            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    }
} while ($mysqli->more_results() && $mysqli->next_result());

echo json_encode($resultadoConsulta);

break;

case 'editar':

    $nombreProducto = $_POST["nombre"];
    $caracteristicas = $_POST["descripcion"];
    $idCategoria = $_POST["idCategoria"];
    $tipo = $_POST["tipo"];
    $precio = $_POST["precio"];
    $idPersona = $_POST["idPersona"];
    $idMoneda = $_POST["idMoneda"];
    $idAnuncio = $_POST["idAnuncio"];

    $mysqli->multi_query("SET @p0='".$nombreProducto."'; SET @p1='".$caracteristicas."'; SET @p2='".$idCategoria."'; SET @p3='".$tipo."'; SET @p4='".$precio."'; SET @p5='".$idPersona."'; SET @p6='".$idMoneda."'; SET @p7='".$idAnuncio."'; SET @p8=''; SET @p9='editar'; CALL `SP_AGREGAR_PUB`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10); SELECT @p10 AS `mensaje`;");
    $resultadoConsulta = array();
    do {
        if ($resultado = $mysqli->store_result()) {
          while ($fila = $resultado->fetch_assoc()) {

            $resultadoConsulta[] = $fila;

        }

        $resultado->free();
    } else {
        if ($mysqli->errno) {
            echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }
    }
} while ($mysqli->more_results() && $mysqli->next_result());

echo json_encode($resultadoConsulta);

break;

case 'obtenerFotos':

    $idAnuncio =$_POST["idAnuncio"];

    $mysqli->multi_query("SET @p0=''; SET @p1=''; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7='".$idAnuncio."'; SET @p8=''; SET @p9='obtenerFotos'; CALL `SP_AGREGAR_PUB`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10);");
    $resultadoConsulta = array();
    do {
        if ($resultado = $mysqli->store_result()) {
          while ($fila = $resultado->fetch_assoc()) {

            $resultadoConsulta[] = $fila;

        }

            $resultado->free();
        } else {
            if ($mysqli->errno) {
                echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
        }
    } while ($mysqli->more_results() && $mysqli->next_result());

    echo json_encode($resultadoConsulta);

break;

case 'eliminarAnuncio':

    $idAnuncio = $_POST["idAnuncio"];
    $razones =$_POST["razones"];
    //$idAnuncio =1;
    $mysqli->multi_query("SET @p0=''; SET @p1='".$razones."'; SET @p2=''; SET @p3=''; SET @p4=''; SET @p5=''; SET @p6=''; SET @p7='".$idAnuncio."'; SET @p8=''; SET @p9='eliminar'; CALL `SP_AGREGAR_PUB`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8, @p9, @p10); SELECT @p10 AS `mensaje`;");
    $resultadoConsulta = array();
    do {
        if ($resultado = $mysqli->store_result()) {
          while ($fila = $resultado->fetch_assoc()) {

            $resultadoConsulta[] = $fila;

        }

            $resultado->free();
        } else {
            if ($mysqli->errno) {
                echo "Store failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
        }
    } while ($mysqli->more_results() && $mysqli->next_result());

    echo json_encode($resultadoConsulta);

break;
}

$mysqli->close();



?>

