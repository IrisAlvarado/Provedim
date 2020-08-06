<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//aqui tienen que buscar el archivo  autoload.php, en la carpeta que instalaron composer, en mi caso es esa. AL instalar phpMailer, ese archivo se crea automaticamente
require 'C:\wamp64\composer\vendor\autoload.php';

$connect = new PDO('mysql:host=localhost:3306;dbname=mydb', 'root', '', array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ));


switch($_POST["accion"]){
    case "enviarcorreo":

        $correo =  $_POST["correo"];

        $query = "
        select * from persona p where 
        p.correo = :correo";
        
        $statement = $connect->prepare($query);
        
        $statement->execute(
            array(
                ':correo'=>$correo
            )
        );
    
        $numero_filas = $statement->rowCount();
        
        if($numero_filas>0){
            //existe el correo
        

            $codigo_usuario = md5(rand());



            $query2 = "
            update persona p set codigo = :codigo where 
            p.correo  = :correo ";

            //WHERE p.codigo = :user_activation_code
            $statement2 = $connect->prepare($query2);


            if($statement2->execute(
                array(
                    ':codigo'   => $codigo_usuario,
                    ':correo'=>$correo
                )
            )){
            
                $cuerpo_mail = "
                <p>Hola,  saludos desde Publitodo.</p>
                <br>
                <p>Tu código para reestablecer tu contraseña:  <strong>".$codigo_usuario."</strong>
                <br>
                <p>Atentamente, Publitodo.</p>";
            
                //enviar correo con codigo
            
                 //creo la instancia de la extension
            $mail = new PHPMailer(TRUE);
            
            try {
            
                $mail -> charSet = "UTF-8"; 
            
                //direccion de quien envia el correo, en este caso nuestra cuenta
                $mail->setFrom('publitodo.2020@gmail.com', 'Publitodo');
            
                //direccion de a quien se envia el correo, en este caso seria el correo que el usuario registro
                $mail->addAddress($correo, $correo);//TODO:Poner correo de usuario
            
                //La razon del correo
                $mail->Subject = 'Codigo de Publitodo';
            
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
        
            }
        }
        else{
            echo json_encode(array(
                "ok"=>false,
                "mensaje"=>"No existe el correo."
            ));
        }
            
        
    break;

    case "verificarcodigo":

        $correo =  $_POST["correo"];
        $codigo_usuario = $_POST["codigo"];

        $query = "
        select * from persona p where 
        p.codigo = :codigo and p.correo = :correo";
        
        $statement = $connect->prepare($query);
        
        $statement->execute(
            array(
                ':codigo'   => $codigo_usuario,
                ':correo'=>$correo
            )
        );
    
        $numero_filas = $statement->rowCount();
    
        if($numero_filas > 0){

            echo json_encode(array(
                "ok"=>true,
                "mensaje"=>"El codigo es correcto."
            ));
        }
        else{
            echo json_encode(array(
                "ok"=>false,
                "mensaje"=>"El codigo es incorrecto."
            ));
        }
    break;

    case "cambiarcontrasena":

        $correo =  $_POST["correo"];
        $contrasena = $_POST["contrasena"];
       
        $query = "
        update persona p set contrasenia = :contrasena
        where p.correo  = :correo";
        
        $statement = $connect->prepare($query);
        
        $statement->execute(
            array(
                ':contrasena'   => $contrasena,
                ':correo'=>$correo
            )
        );

        echo  json_encode(array(
            "ok"=>true,
            "mensaje"=>"Contrasena guardada correctamente."
        ));

        $cuerpo_mail = "
        <p>Hola,  saludos desde Publitodo.</p>
        <br>
        <p>Se ha reestblecido tu contraseña correctamente.

        <p>Atentamente, Publitodo.</p>";
    
        //enviar correo con codigo
    
         //creo la instancia de la extension
    $mail = new PHPMailer(TRUE);
    
    try {
    
        $mail -> charSet = "UTF-8"; 
    
        //direccion de quien envia el correo, en este caso nuestra cuenta
        $mail->setFrom('publitodo.2020@gmail.com', 'Publitodo');
    
        //direccion de a quien se envia el correo, en este caso seria el correo que el usuario registro
        $mail->addAddress($correo, $correo);//TODO:Poner correo de usuario
    
        //La razon del correo
        $mail->Subject = 'Codigo de Publitodo';
    
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

        

    break;
}

?>