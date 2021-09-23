<?php session_start();
    if(isset($_SESSION['usuario'])){
        require 'frontend/historial.php';
    }else{
        header ('location: login.php');
    }
        
?>