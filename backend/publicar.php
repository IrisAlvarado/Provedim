<?php
session_start();
		if (!isset($_SESSION["id_usuario"]))
		echo json_encode(array("acceder"=>false));
		else
		echo json_encode(array("acceder"=>true));
?>