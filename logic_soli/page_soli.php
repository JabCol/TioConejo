<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../css/styles_table.css">
    <link rel="shortcut icon" href="../imgs/conejo.png" type="image/x-icon" />
    <title>Tio conejo</title>
</head>

<body>
    <a href="../main_page/main_page_login.php" class="btn btn-secondary enlace">Volver al inicio </a>
    <img src='../imgs/conejo.png' width='50px'>
    
    <?php
    session_start();
    $nombre_usuario =  $_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }

    include("../connection.php");
    $conexion = connection();


    echo "
    <p class='bg-dark parrafo'>Solicitudes Pendientes</p>
        <div class='container'>
        <table id='example' class='table'>
            <thead>
                <th>Identificador</th>
                <th>Nombre aspirante</th>
                <th>Apellido aspirante</th>
                <th>Nombre del acudiente</th>
                <th>Apellido del acudiente</th>
                <th>Telefono</th>
                <th>Grado deseado</th>
                <th>Opciones</th>
            </thead>
            <tbody>
        ";
    $query = "SELECT * FROM solicitud";
    $consulta = pg_query($conexion, $query);
    while ($obj = pg_fetch_object($consulta)) {
        $query2  = "SELECT * FROM grado WHERE id_grado = $obj->id_grado3";
        $consulta2 = pg_query($conexion, $query2);
        $obj2 = pg_fetch_object($consulta2);
        echo "
            <tr>
            <td>$obj->id_solicitud</td>
            <td>$obj->nombre_aspi</td>
            <td>$obj->apellido_aspi</td>
            <td>$obj->nombre_acudi</td>
            <td>$obj->apellido_acudi</td>
            <td>$obj->telefono_acudi</td>
            <td>$obj2->nombre_grado / $obj2->jornada</td>

            <td>
            <a href='more_info.php?id=$obj->id_solicitud'><i class='material-icons' style='color:black;'>more</i></a>
            </td>
            </tr>
            ";
    }
    ?>
    </tbody>
    </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/data_t.js"></script>

</body>

</html>