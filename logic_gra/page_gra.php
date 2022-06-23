<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../css/styles_table.css">
    <link rel="shortcut icon" href="../imgs/conejo.png" type="image/x-icon" />
    <title>Tio conejo</title>
</head>

<body>
    <?php
    //Iniciar la sesion
    session_start();
    $id_admin1 = $_SESSION['id_admin'];

    if (!isset($id_admin1)) {
        header('location: ../login.php');
    }
    ?>

    <!-- volver al inicio / button -->
    <a href="../main_page/main_page_login.php" class="btn btn-secondary enlace">Volver al inicio </a>
    <img src="../imgs/conejo.png" width="50px">
    <!-- Conexion bd -->
    <?php
    include("../connection.php");

    // Obtener datos del formulario para añadir un grado y añadirlo a la bd
    $conexion = connection();
    if ($_POST) {
        $nomb = $_POST['nombre_grado'];
        $jor = $_POST['jornada_grado'];

        $nomb_minis = (strtolower($nomb));

        $query =  "SELECT COUNT(*) FROM grado WHERE nombre_grado='$nomb_minis' AND jornada='$jor'";
        $consulta = pg_query($conexion, $query);
        $obj = pg_fetch_object($consulta);

        if ($obj->count > 0) {
            echo "<p class='error'>Ya existe un grado con el nombre que desea ingresar, se recomienda variar el nombre de estos para una mayor organizacion</p>";
        } else {
            $query =  "INSERT INTO grado (nombre_grado, jornada, id_admin1, ultimo_cambio) values ('$nomb_minis', '$jor', '$id_admin1', '$id_admin1')";
            $consulta = pg_query($conexion, $query);

            if ($consulta) {
                echo "<script>window.location='page_gra.php'</script>";
            } else {
                echo 'Error';
            }
        }
    }
    echo "
    <p class='bg-dark parrafo'>Añadir un nuevo grado</p>
    <form method='POST' class='formu'>
        <tr>
            <label for='nombre_mat'>Nombre del Grado</label>
            
            <td><input type='text' required name='nombre_grado' id='nombre_grado' placeholder='Nombre del Grado'></td>
        </tr>
        
        <td>
            <label for='jornada_grado'>Jornada del Grado</label>
            
            <td>
                <select name='jornada_grado'>
                    <option value='MAÑANA'>MAÑANA</option>
                    <option value='TARDE'>TARDE</option>
                </select>
            </td>
        </td>
        <tr>
        <button tittle='Enviar' type='submit'>Aceptar</button>
        </tr>
    </form>
    
    <!-- Grados / table -->
    <p class='bg-dark parrafo'>Lista De Grados</p>
    <div class='container'>
    <table id='example' class='table'>
        <thead>
            <th>Identificador</th>
            <th>Nombre del Grado</th>
            <th>Jornada</th>
            <th>Total de Estudiantes</th>
            <th>Total de Materias</th>
            <th>Creado por</th>
            <th>Ultimo Cambio</th>
            <th>Opciones</th>
        </thead>
        <tbody>
    ";
    ?>


    <?php
    // $query = "SELECT * FROM grado order by id_grado asc";
    $query = "SELECT * FROm grado AS g JOIN admin AS ad ON g.id_admin1 = ad.id_admin order by  g.id_grado ASC";

    $query1 = "SELECT * FROm grado AS g JOIN admin AS ad ON g.ultimo_cambio = ad.id_admin order by  g.id_grado ASC";

    $consulta = pg_query($conexion, $query);

    $consulta1 = pg_query($conexion, $query1);

    while ($obj = pg_fetch_object($consulta)) {

        $obj1 = pg_fetch_object($consulta1);

        echo "
                    <tr>
                    <td>$obj->id_grado</td>
                    <td>$obj->nombre_grado</td>
                    <td>$obj->jornada</td>
                    <td>$obj->total_estudiantes</td>
                    <td>$obj->total_materias</td>
                    <td>$obj->nombre_usuario</td>
                    <td>$obj1->nombre_usuario</td>

                    <td><a href='edit_gra.php?id={$obj->id_grado}'><i class='material-icons' style='color:black;'>edit</i></a>

                    <a href='#' onclick='preguntar($obj->id_grado)'><i class='material-icons' style='color:black;'>delete</i></a>

                    <a href='../logic_est/page_est.php?id={$obj->id_grado}'><i class='material-icons' style='color:black;'>more</i></a>
                    </td>
                    </tr>
                    ";
    }
    ?>
    </tbody>
    </table>
    </div>
    <?php
    echo "
    ";


    ?>
    <script type="text/javascript">
        function preguntar(id_grado) {

            if (confirm('Si elimina el grado; Se eliminaran todos los estudiantes, materias, solicitudes y acudientes que esten ligados a el; Desea continuar?')) {
                window.location = 'delete_gra.php?id=' + id_grado
            }
            // swal({
            //     title: 'Eliminar el grado: ' + nombre_grado,
            //     text: 'Si elimina el grado: ' + nombre_grado + '; Se eliminaran todos los estudiantes, materias y acudientes que esten ligados a el; Desea continuar?',
            //     icon: 'warning',
            //     buttons: ["Cancelar", "Confirmar"],
            // }).then((eleccion) => {
            //     if (eleccion) {
            //         swal({
            //             title: 'Se ha eliminado el grado: ' + nombre_grado,
            //             text: ':(',
            //             icon: 'success',
            //             timer: "3000",
            //         }).then((timer) => {
            //             window.location = 'delete_gra.php?id=' + id_grado
            //         })
            //     }
            // });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/data_t.js"></script>

</body>

</html>