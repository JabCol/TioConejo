<?php
    //Conexion bd
    session_start();
    $nombre_usuario=$_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    } 
     
    include("../connection.php");
    $conexion = connection();

    if($_GET){
        $id = $_GET['id'];
        $query = "DELETE FROM solicitud WHERE id_solicitud = $id";
        $consulta = pg_query($conexion, $query);
        if($consulta){
            header('location: page_soli.php');
        }else{
            echo "Error";
        }
    }
?>