<?php
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $id_grado = $_SESSION['id_grado'];
    
    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }

    include("../connection.php");
    $conexion = connection();

    if($_GET){
        $id=$_GET['id'];
        $query = "DELETE FROM estudiante WHERE id_estudiante = $id";
        $consulta=pg_query($conexion, $query);
        if($consulta){
            header("location: page_est.php?id=$id_grado");
        }else{
            echo"Error";
        }
    }
?>