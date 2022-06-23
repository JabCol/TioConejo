<?php
    session_start();
    $id_admin1 = $_SESSION['id_admin'];

    if (!isset($id_admin1)) {
        header('location: ../../login.php');
    }

    include("../../connection.php");

    $conexion = connection();

    if($_GET){
        $id = $_GET['id'];

        $query = "DELETE FROM grado_materia WHERE id_materia=$id";
        $consulta = pg_query($conexion, $query);
        
        $query = "DELETE FROM materia WHERE id_materia = $id";
        $consulta = pg_query($conexion, $query);
        if($consulta){
            header('location: ../mat_gra.php');
        }else{
            echo"Error";
        }
    }
?>