<?php 
session_start();
session_destroy();
$_SESSION["id_usuario"] = null;
echo json_encode(array("ok"=>true))

?>