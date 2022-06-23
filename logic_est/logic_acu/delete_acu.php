<?php
//Conexion bd
session_start();
$nombre_usuario = $_SESSION['nombre_usuario'];
$id_grado = $_SESSION['id_grado'];

if (!isset($nombre_usuario)) {
    header('location: ../../login.php');
}

include("../../connection.php");
$conexion = connection();

//Obtener datos
if ($_GET) {
    $id = $_GET['id'];

    $query = "DELETE FROM estudiante WHERE id_acudi1=$id";
    $consulta = pg_query($conexion, $query);
    if ($consulta) {
        $query = "DELETE FROM acudiente WHERE id_acudi = $id";
        $consulta = pg_query($conexion, $query);

        if ($consulta) {
            header("location: page_acu.php?id=$id_grado");
        } else {
            echo "Error";
        }
    } else {
        echo "No se ha podido eliminar el acudiente, intentelo mas tarde";
    }
}
