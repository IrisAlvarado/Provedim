<?php 


$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );
$dsn = "mysql:host=localhost:3306;dbname=mydb;charset=utf8mb4";

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

switch ($_POST["accion"]){


    case "traerElectronicos":

        $idAnuncio;    
        $titulo;
        $descripcion;
        $precio;
    
        //TODO: hacer subconsulta para traer id tipo usuario
        $stmt = $mysqli -> prepare('
        select a.idAnuncios, a.titulo , a.descripcion , a.precio from anuncios a 
        inner join producto pro on pro.idProducto = a.idProducto 
        inner join categorias ca on ca.idCategorias = pro.idCategorias 
        where ca.descripcion  like "%electronico%"
                ');
        
        // $stmt -> bind_param('i', $userId);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result( 
            $idAnuncio,    
            $titulo,
            $descripcion,
            $precio
        );
    
    
        $respuesta = array();
    
        $index = 0;
        
        while($stmt -> fetch()){
    
            $respuesta[$index] =  array(
            "idAnuncio"=>$idAnuncio,    
            "titulo"=>$titulo,
            "descripcion"=>$descripcion,
            "precio"=>$precio
            );
    
            $index++;
        }
        
        echo json_encode($respuesta);
    break;

    case "Traercategorias":

        $idCategorias;    
        $descripcion;
    
        //TODO: hacer subconsulta para traer id tipo usuario
        $stmt = $mysqli -> prepare('
        select idCategorias , descripcion from categorias c
        where estado like "%a"
                ');
        
        // $stmt -> bind_param('i', $userId);
        $stmt -> execute();
        $stmt -> store_result();
        $stmt -> bind_result( 
            $idCategorias,    
            $descripcion
        );
    
    
        $respuesta = array();
    
        $index = 0;
        
        while($stmt -> fetch()){
    
            $respuesta[$index] =  array(
                "idCategorias"=>$idCategorias,
                "descripcion"=>$descripcion
            );
    
            $index++;
        }
        
        echo json_encode($respuesta);
    break;

    case "probandoFetchGroup":

        $queryBase = ' select a.idAnuncios, a.titulo , a.descripcion , a.precio, ca.descripcion categoria, ca.idCategorias from anuncios a 
        inner join producto pro on pro.idProducto = a.idProducto 
        inner join categorias ca on ca.idCategorias = pro.idCategorias
        inner join persona per on per.idPersona  = a.idPersona 
        inner join tipousuario tu on tu.idTipoUsuario  = per.idTipoUsuario 
        where a.estado like "%a" and  DATEDIFF(now(), a.fecha )<= tu.tiempoPublicacion';

        $stmt = $pdo->prepare($queryBase);
        $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC );
        
        if(!$arr) json_encode(array("null"));

        echo json_encode($arr);

        
    break;

}

$mysqli->close();
$pdo = null;
?>