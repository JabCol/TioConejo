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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }
    ?>

    <?php
    include("../connection.php");

    $conexion = connection();

    if ($_GET) {
        $id = $_GET['id'];
        $_SESSION['id_grado'] = $id;
        $query = "SELECT * FROM grado where id_grado = '$id'";
        $consulta = pg_query($conexion, $query);
        $obj = pg_fetch_object($consulta);
    }

    //  Volver al grado / button 
    echo "
        <img src='../imgs/conejo.png' width='50px' style='margin-left:76px;'>
        <a href='../logic_gra/page_gra.php' class='btn btn-secondary '>Volver a los grados</a>
        <a href='add_est.php?id=$id' class='btn btn-secondary '>Añadir un estudiante</a>

        <a href='logic_acu/page_acu.php?id=$id' class='btn btn-secondary '>Ver acudientes</a>

        <a href='logic_mat_gra/page_mat.php?id=$id' class='btn btn-secondary  .text-center'>Ver materias del grado</a>

        <!-- Estudiante / table -->
        <p class='bg-dark parrafo'>Estudiantes del grado:$obj->nombre_grado</p>
        <div class='container'>
        <table id='example' class='table'>
            <thead>
                <th>Identificador</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Genero</th>
                <th>Nro Identificacion</th>
                <th>Fecha de nacimiento</th>
                <th>Opciones</th>
            </thead>
            <tbody>
        ";
    $query = "SELECT * FROM estudiante WHERE id_grado2 = $id order by id_estudiante";
    $consulta = pg_query($conexion, $query);
    while ($obj = pg_fetch_object($consulta)) {
        echo "
                <tr>
                    <td>$obj->id_estudiante</td>
                    <td>$obj->nombre</td>
                    <td>$obj->apellido</td>
                    <td>$obj->genero</td>
                    <td>$obj->tarjeta_id</td>
                    <td>$obj->fecha_nacimiento</td>

                    <td>
                    <a href='edit_est.php?id={$obj->id_estudiante}'><i class='material-icons' style='color:black;'>edit</i></a>

                    <a href='#' onclick='eliminar($obj->id_estudiante)'><i class='material-icons' style='color:black;'>delete</i></a>

                    <a href='seeAcu_est.php?id={$obj->id_estudiante}&id_gra={$id}'><i class='material-icons' style='color:black;'>escalator_warning</i></a>
                    </td>
                </tr>   
                ";
    }
    ?>
    </tbody>
    </table>
    </div>
    <script type="text/javascript">
        function eliminar(id_estudiante) {

            if (confirm('Segur@ que desea eliminar el estudiante?')) {
                window.location = 'delete_Est.php?id=' + id_estudiante;
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="../js/data_t.js"></script>

</body>

</html>