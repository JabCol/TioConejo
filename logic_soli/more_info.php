<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles_table.css">
    <link rel="shortcut icon" href="../imgs/conejo.png" type="image/x-icon" />
    <title>Tio conejo</title>
</head>

<body>
    <?php
    session_start();
    $nombre_usuario =  $_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }

    include("../connection.php");
    $conexion = connection();

    if ($_GET) {
        $id = $_GET['id'];
        $query = "SELECT * FROM solicitud WHERE id_solicitud = $id";
        $consulta = pg_query($conexion, $query);
        $obj = pg_fetch_object($consulta);

        $nombre_asp = $obj->nombre_aspi;
        $apellido_asp = $obj->apellido_aspi;
        $idNum_asp = $obj->tarjeta_id;
    }

    echo "
        <a href='page_soli.php' class='btn btn-secondary enlace'>Volver a las solicitudes</a>
        <img src='../imgs/conejo.png' width='50px'>
        
        <p class='bg-dark parrafo text-white'>Solicitudes del aspirante: $nombre_asp $apellido_asp / Numero de identificacion : $idNum_asp</p>

        <p class='bg-dark parrafo text-white'>Informacion del aspirante</p>
        <div class='container'>
        <table class='table'>
            <thead>
                <th>Identificador</th>
                <th>Nombre del aspirante</th>
                <th>Apellido del aspirante</th>
                <th>Numero de identificacion</th>
                <th>Genero</th>
                <th>Fecha de nacimiento</th>
                <th>Grado aspirado</th>
            </thead>
                <tbody>
                <tr>
                <td>$obj->id_solicitud</td>
                <td>$obj->nombre_aspi</td>
                <td>$obj->apellido_aspi</td>
                <td>$obj->tarjeta_id</td>
                <td>$obj->genero_aspi</td>
                <td>$obj->fecha_nacimiento</td>
            ";
    $query = "SELECT * FROM grado WHERE id_grado = $obj->id_grado3";
    $consulta = pg_query($conexion, $query);
    $obj1 = pg_fetch_object($consulta);

    echo "
            
            <td>$obj1->nombre_grado</td>
            </tr>

            </tbody>
            </table>
            </div>
            
            <p class='bg-dark parrafo text-white'>Informacion del acudiente:</p>
            <div class='container'>
            <table class='table'>
            <thead>
                <th>Nombre del acudiente</th>
                <th>Apellido del acudiente</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Cedula</th>
            </thead>
                <tbody>
                <tr>
                <td>$obj->nombre_acudi</td>
                <td>$obj->apellido_acudi</td>
                <td>$obj->telefono_acudi</td>
                <td>$obj->direccion_acudi</td>
                <td>$obj->cedula_acudi</td>           
            ";
    ?>
    </tbody>
    </table>
    </div>

    <?php
    echo "
    <div class='boton'>
    <a href='#' onclick='preguntar1($id)' class='btn btn-info'>Aceptar</a>
    <a href='#' onclick='preguntar2($id)' class='btn btn-secondary'>Rechazar-Eliminar</a>
    </div>";

    ?>
    <script type="text/javascript">
        function preguntar1(id) {
            if (confirm('Esta segur@ que desea aceptar la solicitud seleccionada?')) {
                window.location = 'accept_soli.php?id=' + id
            }
        }
    </script>

    <script type="text/javascript">
        function preguntar2(id) {
            if (confirm('Esta segur@ que desea eliminar la solicitud seleccionada?')) {
                window.location = 'delete_soli.php?id=' + id
            }
        }
    </script>
</body>

</html>