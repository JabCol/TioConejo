<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles_table.css">
    <link rel="shortcut icon" href="../imgs/conejo.png" type="image/x-icon" />
    <title>Tio conejo</title>
</head>

<body>
    <?php
    session_start();
    $id_admin1 = $_SESSION['id_admin'];

    if (!isset($id_admin1)) {
        header('location: ../login.php');
    }

    include("../connection.php");

    $conexion = connection();

    if ($_GET) {
        $id = $_GET['id_gra'];
        $id_est = $_GET['id'];

        $query = "SELECT * FROM estudiante e JOIN acudiente a ON e.id_acudi1 = a.id_acudi WHERE id_estudiante = $id_est";

        $consulta = pg_query($conexion, $query);

        if ($obj = pg_fetch_object($consulta)) {

            echo "
            <a href='page_est.php?id=$id' class='btn btn-secondary enlace'>Volver al grado</a>
            <img src='../imgs/conejo.png' width='50px'>
            
                <p class='bg-dark parrafo'>Acudiente del estudiante:$obj->nombre $obj->apellido / Numero de identificacion: $obj->tarjeta_id</p>
                <div class='container'>
                <table class='table'>  
                        <thead>
                        <th>Identificador</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Direccion</th>
                        <th>Cedula</th>
                    </thead>
                    <tbody>
                        <tr>
                          <td>$obj->id_acudi</td>
                        <td>$obj->nombre_acudi</td>
                        <td>$obj->apellido_acudi</td>
                        <td>$obj->telefono_acudi</td>
                        <td>$obj->direccion_acudi</td>
                        <td>$obj->cedula</td>
                        </tr>   
                    </tbody>
                </table>
                </div>
                ";
        } else {
            echo "Error";
        }
    }
    ?>
</body>

</html>