<?php
    //Conexion bd
    session_start();
    $nombre_usuario=$_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    } 
     
    include("../connection.php");
    $conexion = connection();

    //Obtener datos 
    if ($_GET) {
        $id = $_GET['id'];

        $query = "DELETE FROM solicitud where id_grado3 = $id";
        $consulta = pg_query($conexion,$query);

        $query = "DELETE FROM estudiante WHERE id_grado2 = $id";
        $consulta = pg_query($conexion,$query);

        $query = "DELETE FROM acudiente WHERE id_grado4 = $id";
        $consulta = pg_query($conexion,$query);

        $query = "DELETE FROM grado_materia WHERE id_grado = $id";
        $consulta = pg_query($conexion,$query);

        $query = "DELETE FROM grado WHERE id_grado = $id";
        $consulta = pg_query($conexion, $query);
        if ($consulta) {
            header('location: page_gra.php');
        } else {
            echo "No se ha podido eliminar el grado, intentalo de nuevo.";
        }
    }
?>
    