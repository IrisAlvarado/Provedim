<?php

$host = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "mydb";
$puerto = 3306;  //Cambiar puerto aca
$link;

$mysqli = new mysqli(	
        $host,
        $usuario,
        $password,
        $baseDatos,
        $puerto
);
//||||||||||||||||||||||||||Cambiar puerto aca
$dsn = "mysql:host=localhost:3306;dbname=mydb;charset=utf8";

        $options = [
          PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        try {
            $pdo = new PDO($dsn, "root", "", $options);
        } catch (Exception $e) {
            error_log($e->getMessage());
            exit('Something weird happened'); //something a user can understand
        }

session_start(); 



switch($_POST["accion"]){
    case "nuevo":

        $idAnuncio = $_POST["idAnuncio"];
        $idPersona = $_SESSION["id_usuario"];
        $accion = "nuevo";

        $call = $mysqli->prepare('CALL SP_FAVORITOS(? , ? , ?  , @codigo , @mensaje)');

        $call->bind_param('iis', 
            $idPersona,
            $idAnuncio,
            $accion
        );


        $call->execute();

        $select = $mysqli->query('SELECT  @codigo , @mensaje ');

        $result = $select->fetch_assoc();

        $mensaje = $result['@mensaje'];
        $codigo = $result['@codigo'];

        echo json_encode(
            array(
                "mensaje"=>$mensaje,
                "codigo"=>$codigo
            )
        );
        // echo json_encode(
        //     array(
        //         "idAnuncio"=>$idAnuncio,
        //         "idPersona"=>$idPersona,
        //         "accion"=>$accion
        //     )
        // );
    

    break;

    case "getfavoritos":

        $idPersona = $_SESSION["id_usuario"];

        $queryBase='SELECT p.idPersona, p.primerNombre, p.segundoNombre , p.primerApellido FROM persona p 
        WHERE p.idPersona IN 
            (
                SELECT f.favorito FROM favoritos f 
                WHERE f.idPersona = ?
            )';

        $parametros = array();

        array_push($parametros, $idPersona );
        

        $stmt = $pdo->prepare($queryBase);
        $stmt->execute($parametros);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$arr) echo json_encode(array("null"));
        
        echo json_encode($arr);

    break;

    case "verpublicaciones":

        $idPersona =  $_POST["idpersona"];

        $queryBase='SELECT a.idAnuncios, a.titulo , a.descripcion , a.precio,mu.nombre  municipio from anuncios a 
        inner join  persona  per on per.idPersona = a.idPersona 
        inner join municipio mu  on per.idMunicipio = mu.idMunicipio
        inner join deptos de on de.idDeptos = mu.idDeptos 
        inner join  tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario 
        inner join producto pro on pro.idProducto = a.idProducto 
        inner join categorias  ca on ca.idCategorias = pro.idCategorias 
        where a.estado like "%a" and  DATEDIFF(now(), a.fecha )<= tu.tiempoPublicacion 
        and per.idPersona = ?
        order by a.fecha desc';

        $parametros = array();

        array_push($parametros,  $idPersona);
        

        $stmt = $pdo->prepare($queryBase);
        $stmt->execute($parametros);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(!$arr) echo json_encode(array("null"));
        
        echo json_encode($arr);
    break;

    case "eliminar":

        $favorito = $_POST["favorito"];

        $idPersona =$_SESSION["id_usuario"];

        $queryBase='DELETE FROM favoritos fa
        WHERE fa.idPersona = ? 
        AND fa.favorito = ?';

        $parametros = array();

        array_push($parametros,  $idPersona);
        array_push($parametros,  $favorito);
        

        $stmt = $pdo->prepare($queryBase);
        
        
        if($stmt->execute($parametros)){
            echo json_encode(array(
                "codigo"=>1,
                "mensaje"=>"Eliminado correctamente"
            ));
        }
        else{
            echo json_encode(array(
                "codigo"=>-1,
                "mensaje"=>"Ocurrió un error."
            ));
        }
        
    
    break;

}


?>