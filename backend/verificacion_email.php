<?php


$connect = new PDO('mysql:host=localhost:3306;dbname=mydb', 'root', '');
//session_start();

$message = '';

if(isset($_GET['activation_code']))
{
    $query = "
    SELECT * FROM persona p  
    WHERE p.codigo = :user_activation_code";
    
    $statement = $connect->prepare($query);
    
    $statement->execute(
        array(
            ':user_activation_code'   => $_GET['activation_code']
        )
    );

    $no_of_row = $statement->rowCount();

    if($no_of_row > 0){
    $result = $statement->fetchAll();

    foreach($result as $row){
        if($row['estado'] == 'I')
    {
    $update_query = "
    UPDATE persona 
    SET estado = 'A' 
    WHERE idPersona = '".$row['idPersona']."'
    ";

    $statement = $connect->prepare($update_query);
    $statement->execute();
    $sub_result = $statement->fetchAll();

    if(isset($sub_result)){
        $message = '<label class="text-success">Tu email ha sido validado exitosamente,  <br />Ya puedes loguearte: - <a href="../inicio.php">Inicio</a></label>';

        echo $message;
    }
    }else{
        $message = '<label class="text-info">Tu email ya ha sido verificado.</label> 
        <br />Ir a inicio: - <a href="../inicio.php">Inicio</a></label>';

        echo $message;
    }
    }
    }
    else
    {
    $message = '<label class="text-danger">Link Inválido</label>
    <br />Ir a inicio: - <a href="../inicio.php">Inicio</a></label>';
    echo $message;
    }
}

?>