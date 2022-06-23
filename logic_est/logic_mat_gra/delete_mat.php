<?php
    session_start();
    $id_admin1 = $_SESSION['id_admin'];

    if (!isset($id_admin1)) {
        header('location: ../../login.php');
    }

    include("../../connection.php");

    $conexion = connection();

    if($_GET){
        $id_mat = $_GET['id'];
        $id_gra = $_GET['id2'];
        $query = "DELETE FROM grado_materia WHERE id_materia = $id_mat AND id_grado = $id_gra";
        $consulta = pg_query($conexion, $query);
        if($consulta){
            header("location: page_mat.php?id=$id_gra");
        }else{
            echo"Error";
        }
    }
?>