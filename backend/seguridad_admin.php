<?php
    session_start(); 
    if ($_SESSION["es_administrador"]!=1)
    header("Location: ../inicio.php");
    
?>