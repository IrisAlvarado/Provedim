<?php 

$mysqli = new mysqli( 'localhost:3306', 'root', '', 'mydb' );

switch ($_POST["accion"]) {

    case "getPublicaciones":

        $nombreProducto;
        $tipoProducto;
        $categoria;
        $descripcion;
        $primerNombre;
        $primerApellido;
        $precio;
        $moneda;
        $fechaPublicacion;
        $fechaVencimiento;
        $estado;
        $idAnuncio;
    
    
        $stmt = $mysqli -> prepare(
            'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
            per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
            DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
            from anuncios an
            inner join producto pro on an.idProducto=pro.idProducto
            inner join categorias ca on pro.idCategorias=ca.idCategorias
            inner join persona per on an.idPersona=per.idPersona
            inner join moneda mo on an.idMoneda=mo.idMoneda
            inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario');

        getAnuncios($stmt);
        
        break;

        case "darDeBaja":


            $idAnuncio = $_POST["idAnuncio"];

            $stmt = $mysqli -> prepare('UPDATE anuncios  SET estado = "I"  WHERE idAnuncios = ?');
            $stmt->bind_param('i', $idAnuncio);

            $stmt -> execute();
            // $stmt -> store_result();
            // $stmt -> bind_result( );
            // $stmt -> fetch();


            echo (json_encode(array("idAnuncio"=>$_POST["idAnuncio"])));

        break;

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

        case "seleccionarUsuarios":

            $idUsuario;
            $primerNombre;
            $primerApellido;

            $stmt = $mysqli -> prepare(
                'SELECT idPersona, primerNombre, primerApellido FROM persona'
                );
            
            $stmt -> execute();
            $stmt -> store_result();
            $stmt -> bind_result( 
                $idUsuario,
                $primerNombre,
                $primerApellido);
            
            
            $respuesta = array();
            
            $index = 0;
            
            while($stmt -> fetch()){
            
                $respuesta[$index] =  array(
                    "idUsuario"=>$idUsuario,
                    "primerNombre"=>$primerNombre,
                    "primerApellido"=>$primerApellido
                );
            
                $index++;
            }

            echo json_encode($respuesta);
        break;   
        
        
        case "getPublicacionesNingunaNull":

            
            $idPersona= $_POST["usuario"];
            $nombreProducto;
            $tipoProducto;
            $categoria =  $_POST["categoria"];
            $descripcion;
            $primerNombre;
            $primerApellido;
            $precio;
            $moneda;
            $fechaPublicacion;
            $fechaVencimiento;
            $estado = $_POST["estado"];
            $idAnuncio; 
        
        
            $stmt = $mysqli -> prepare(
                'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
                per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
                DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
                from anuncios an
                inner join producto pro on an.idProducto=pro.idProducto
                inner join categorias ca on pro.idCategorias=ca.idCategorias
                inner join persona per on an.idPersona=per.idPersona
                inner join moneda mo on an.idMoneda=mo.idMoneda
                inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
                WHERE per.idPersona = ? AND an.estado LIKE  ?  AND ca.idCategorias = ?');

            $stmt->bind_param('isi', $idPersona, $estado, $categoria);

            getAnuncios($stmt);

        break;

        case "getPublicacionesEstadoNull":
            $idPersona= $_POST["usuario"];
            $nombreProducto;
            $tipoProducto;
            $categoria =  $_POST["categoria"];
            $descripcion;
            $primerNombre;
            $primerApellido;
            $precio;
            $moneda;
            $fechaPublicacion;
            $fechaVencimiento;
            $idAnuncio; 
        
        
            $stmt = $mysqli -> prepare(
                'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
                per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
                DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
                from anuncios an
                inner join producto pro on an.idProducto=pro.idProducto
                inner join categorias ca on pro.idCategorias=ca.idCategorias
                inner join persona per on an.idPersona=per.idPersona
                inner join moneda mo on an.idMoneda=mo.idMoneda
                inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
                WHERE per.idPersona = ? AND ca.idCategorias = ?');

            $stmt->bind_param('ii', $idPersona, $categoria);

            getAnuncios($stmt);

        break;

        case "getPublicacionesUsuarioNull":
            $idPersona;
            $nombreProducto;
            $tipoProducto;
            $categoria =  $_POST["categoria"];
            $descripcion;
            $primerNombre;
            $primerApellido;
            $precio;
            $moneda;
            $fechaPublicacion;
            $fechaVencimiento;
            $idAnuncio; 
            $estado = $_POST["estado"];
        
        
            $stmt = $mysqli -> prepare(
                'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
                per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
                DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
                from anuncios an
                inner join producto pro on an.idProducto=pro.idProducto
                inner join categorias ca on pro.idCategorias=ca.idCategorias
                inner join persona per on an.idPersona=per.idPersona
                inner join moneda mo on an.idMoneda=mo.idMoneda
                inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
                WHERE an.estado LIKE ? AND ca.idCategorias = ?');

            $stmt->bind_param('si', $estado, $categoria);

            getAnuncios($stmt);
    
        break;

        case "getCategoriasNull":
            $idPersona = $_POST["usuario"];
            $nombreProducto;
            $tipoProducto;
            $categoria;
            $descripcion;
            $primerNombre;
            $primerApellido;
            $precio;
            $moneda;
            $fechaPublicacion;
            $fechaVencimiento;
            $idAnuncio; 
            $estado = $_POST["estado"];
        
        
            $stmt = $mysqli -> prepare(
                'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
                per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
                DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
                from anuncios an
                inner join producto pro on an.idProducto=pro.idProducto
                inner join categorias ca on pro.idCategorias=ca.idCategorias
                inner join persona per on an.idPersona=per.idPersona
                inner join moneda mo on an.idMoneda=mo.idMoneda
                inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
                WHERE an.estado LIKE ? AND per.idPersona = ?');

            $stmt->bind_param('si', $estado, $idPersona);

            getAnuncios($stmt);
        break;

        case "getPublicacionesSoloEstado":

            $estado = $_POST["estado"];
        
        
            $stmt = $mysqli -> prepare(
                'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
                per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
                DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
                from anuncios an
                inner join producto pro on an.idProducto=pro.idProducto
                inner join categorias ca on pro.idCategorias=ca.idCategorias
                inner join persona per on an.idPersona=per.idPersona
                inner join moneda mo on an.idMoneda=mo.idMoneda
                inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
                WHERE an.estado LIKE ?');

            $stmt->bind_param('s', $estado);

            getAnuncios($stmt);

        break;

        case "getPublicacionesSoloUsuario":

            $idPersona = $_POST["usuario"];
        
        
            $stmt = $mysqli -> prepare(
                'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
                per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
                DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
                from anuncios an
                inner join producto pro on an.idProducto=pro.idProducto
                inner join categorias ca on pro.idCategorias=ca.idCategorias
                inner join persona per on an.idPersona=per.idPersona
                inner join moneda mo on an.idMoneda=mo.idMoneda
                inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
                WHERE per.idPersona = ?');

            $stmt->bind_param('i', $idPersona);

            getAnuncios($stmt);
        break;

        case "getPublicacionesSoloCategoria":
            $categoria = $_POST["categoria"];
        
        
            $stmt = $mysqli -> prepare(
                'select  pro.nombre,pro.tipo ,ca.descripcion categoria,an.descripcion,per.primerNombre,
                per.primerApellido ,an.precio,mo.descripcion ,an.fecha fechaPublicacion,
                DATE_ADD(an.fecha , INTERVAL tu.tiempoPublicacion DAY) fechaVencimiento, an.estado, an.idAnuncios 
                from anuncios an
                inner join producto pro on an.idProducto=pro.idProducto
                inner join categorias ca on pro.idCategorias=ca.idCategorias
                inner join persona per on an.idPersona=per.idPersona
                inner join moneda mo on an.idMoneda=mo.idMoneda
                inner join tipousuario tu on tu.idTipoUsuario = per.idTipoUsuario
                WHERE pro.idCategorias = ?');

            $stmt->bind_param('i', $categoria);

            getAnuncios($stmt);
        break;

        case "cambiarTiempoUsuarioAdministrador":

            $tiempoUsuarioAdministrador = $_POST["tiempoUsuarioAdministrador"];
            $mensaje;
            $codigo;

            
            $call = $mysqli->prepare('CALL SP_CAMBIAR_TIEMPO_USUARIO_ADMINISTRADOR(?, @mensaje, @codigo, @cantidadDiasOut)');
            
            $call->bind_param('i', 
                $tiempoUsuarioAdministrador);
            
            
            $call->execute();
            
            $select = $mysqli->query('SELECT  @mensaje, @codigo, @cantidadDiasOut');
            
            $result = $select->fetch_assoc();

            $mensaje = $result['@mensaje'];
            $codigo = $result['@codigo'];
            $tiempoUsuarioAdministrador = $result['@cantidadDiasOut'];


            
            echo json_encode(array(
                "mensaje"=>$mensaje,
                "codigo"=>$codigo,
                "tiempoUsuarioAdministrador"=>$tiempoUsuarioAdministrador
            ));


        break;

        case "selectTiempoUsuarioNormal":

            
            $tiempoNormal;

            $stmt = $mysqli->prepare(
                'select tiempoPublicacion from tipoUsuario  tu 
                where tu.descripcion  like "%normal%"'
            );

            $stmt -> execute();
            $stmt -> store_result();

            $stmt -> bind_result( 
                $tiempoNormal
                );

            $stmt -> fetch();
            
            echo json_encode(array("tiempoNormal"=> $tiempoNormal));

        break;

        case "cambiarTiempoUsuarioNormal":

            $tiempoUsuarioNormal = $_POST["tiempoUsuarioNormal"];
            $mensaje;
            $codigo;

            
            $call = $mysqli->prepare('CALL SP_CAMBIAR_TIEMPO_USUARIO_NORMAL(?, @mensaje, @codigo, @cantidadDiasOut)');
            
            $call->bind_param('i', 
                $tiempoUsuarioNormal
            );
            
            
            $call->execute();
            
            $select = $mysqli->query('SELECT  @mensaje, @codigo, @cantidadDiasOut');
            
            $result = $select->fetch_assoc();

            $mensaje = $result['@mensaje'];
            $codigo = $result['@codigo'];
            $tiempoUsuarioNormal = $result['@cantidadDiasOut'];


            
            echo json_encode(array(
                "mensaje"=>$mensaje,
                "codigo"=>$codigo,
                "tiempoUsuarioNormal"=>$tiempoUsuarioNormal
            ));
        break;

        case "cambiarTiempoUsuarioEmpresa":

            $tiempoUsuarioEmpresa = $_POST["tiempoUsuarioEmpresa"];
            $mensaje;
            $codigo;

            
            $call = $mysqli->prepare('CALL SP_CAMBIAR_TIEMPO_USUARIO_EMPRESA(?, @mensaje, @codigo, @cantidadDiasOut)');
            
            $call->bind_param('i', 
                $tiempoUsuarioEmpresa
            );
            
            
            $call->execute();
            
            $select = $mysqli->query('SELECT  @mensaje, @codigo, @cantidadDiasOut');
            
            $result = $select->fetch_assoc();

            $mensaje = $result['@mensaje'];
            $codigo = $result['@codigo'];
            $tiempoUsuarioEmpresa = $result['@cantidadDiasOut'];


            
            echo json_encode(array(
                "mensaje"=>$mensaje,
                "codigo"=>$codigo,
                "tiempoUsuarioEmpresa"=>$tiempoUsuarioEmpresa
            ));
        break;

        case "selectTiempoUsuarioEmpresa":

            
            $tiempoEmpresa;

            $stmt = $mysqli->prepare(
                'select tiempoPublicacion from tipoUsuario  tu
                where tu.descripcion  like "%empresa%"
                '
            );

            $stmt -> execute();
            $stmt -> store_result();

            $stmt -> bind_result( 
                $tiempoEmpresa
                );

            $stmt -> fetch();
            
            echo json_encode(array("tiempoEmpresa"=> $tiempoEmpresa));

        break;

        case "selectTiempoUsuarioAdministrador":
            $tiempoAdministrador;

            $stmt = $mysqli->prepare(
                'select tiempoPublicacion from tipoUsuario tu
                where tu.descripcion  like "%administrador%"'
            );

            $stmt -> execute();
            $stmt -> store_result();

            $stmt -> bind_result( 
                $tiempoAdministrador
                );

            $stmt -> fetch();
            
            echo json_encode(array("tiempoAdministrador"=> $tiempoAdministrador));

        break;
        case "cambiarTiempoUsuarioEmpresa":

            $tiempoUsuarioEmpresa = $_POST["tiempoUsuarioEmpresa"];
            $mensaje;
            $codigo;

            
            $call = $mysqli->prepare('CALL SP_CAMBIAR_TIEMPO_USUARIO_EMPRESA(?, @mensaje, @codigo, @cantidadDiasOut)');
            
            $call->bind_param('i', 
                $tiempoUsuarioEmpresa
            );
            
            
            $call->execute();
            
            $select = $mysqli->query('SELECT  @mensaje, @codigo, @cantidadDiasOut');
            
            $result = $select->fetch_assoc();

            $mensaje = $result['@mensaje'];
            $codigo = $result['@codigo'];
            $tiempoUsuarioEmpresa = $result['@cantidadDiasOut'];


            
            echo json_encode(array(
                "mensaje"=>$mensaje,
                "codigo"=>$codigo,
                "tiempoUsuarioEmpresa"=>$tiempoUsuarioEmpresa
            ));
        break;

        case "selectTiempoUsuarioEmpresa":

            
            $tiempoEmpresa;

            $stmt = $mysqli->prepare(
                'select tiempoPublicacion from tipoUsuario  tu
                where tu.descripcion  like "%empresa%"
                '
            );

            $stmt -> execute();
            $stmt -> store_result();

            $stmt -> bind_result( 
                $tiempoEmpresa
                );

            $stmt -> fetch();
            
            echo json_encode(array("tiempoEmpresa"=> $tiempoEmpresa));

        break;



}

$mysqli->close();



function getAnuncios($stmt){

    $nombreProducto;
    $tipoProducto;
    $categoria;
    $descripcion;
    $primerNombre;
    $primerApellido;
    $precio;
    $moneda;
    $fechaPublicacion;
    $fechaVencimiento;
    $estado;
    $idAnuncio;

    $stmt -> execute();
    $stmt -> store_result();
    $stmt -> bind_result( 
        $nombreProducto,
        $tipoProducto,
        $categoria,
        $descripcion,
        $primerNombre,
        $primerApellido,
        $precio,
        $moneda,
        $fechaPublicacion,
        $fechaVencimiento,
        $estado,
        $idAnuncio
        );
    
    
    $respuesta = array();
    
    $index = 0;
    
    while($stmt -> fetch()){
    
        $respuesta[$index] =  array(
            "nombreProducto"=>$nombreProducto,
            "tipoProducto"=>$tipoProducto,
            "categoria"=>$categoria,
            "descripcion"=>$descripcion,
            "primerNombre"=>$primerNombre,
            "primerApellido"=>$primerApellido,
            "precio"=>$precio,
            "moneda"=>$moneda,
            "fechaPublicacion"=>$fechaPublicacion,
            "fechaVencimiento"=>$fechaVencimiento,
            "estado"=>$estado,
            "idAnuncio"=>$idAnuncio
        );
    
        $index++;
    }
    
    echo json_encode($respuesta);
}

//works
?>