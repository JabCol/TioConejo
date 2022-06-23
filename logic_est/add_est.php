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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

    <?php
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }
    include("../connection.php");

    $conexion = connection();

    $id_grado = $_SESSION['id_grado'];

    echo "<a href='page_est.php?id=$id_grado' class='btn btn-secondary enlace'>Volver a los estudiantes</a>
    <img src='../imgs/conejo.png' width='50px'>";

    if ($_POST) {
        // Info estudiante
        $nom_est = $_POST['nombre_est'];
        $ape_est = $_POST['apellido_est'];
        $gen = $_POST['genero_est'];
        $num_id = $_POST['tarjeta_est'];
        $fec_na = $_POST['fecha_est'];
        $id_acu = $_POST['cedula_acu'];

        $query = "SELECT COUNT(*) FROM estudiante WHERE tarjeta_id = '$num_id'";

        $consulta = pg_query($conexion, $query);

        $obj1 = pg_fetch_object($consulta);
        if ($obj1->count > 0) {
            echo "
            <br>
            <p class='error'>El numero de identificacion que esta ingresando, ya se encuentra registrado.</p>";
        } else {

            $query = "INSERT INTO estudiante (tarjeta_id, genero, nombre, apellido, fecha_nacimiento, id_grado2, id_acudi1) VALUES ('$num_id', '$gen', '$nom_est', '$ape_est', '$fec_na', '$id_grado', '$id_acu')";
            $consulta = pg_query($conexion, $query);

            if ($consulta) {
                header("location: page_est.php?id=$id_grado");
            } else {
                echo "Error";
            }
        }
    }

    ?>

    <form method='POST' class='formu'>
        <tr>
            <p class='bg-dark parrafo'>Informacion del estudiante</p>
            <label for='nombre_est'>Nombre del estudiante</label>
            <input type='text' required name='nombre_est' id='nombre_est' placeholder=''>
            <br>
            <label for='apellido_est'>Apellido del estudiante</label>
            <input type='text' required name='apellido_est' placeholder=''>
            <br>
            <label for='genero_est'>Genero</label>
            <select name='genero_est' required>
                <option value='MASCULINO'>MASCULINO</option>
                <option value='FEMENINO'>FEMENINO</option>
                <option value='OTRO'>OTRO</option>
            </select>
            <br>
            <label for='tarjeta_est'>Numero de identificacion</label>
            <input type='number' required name='tarjeta_est' placeholder=''>
            <br>
            <label for='fecha_est'>Fecha de nacimiento</label>
            <input name='fecha_est' type='date' required>
            <br>
            <label></label>
            <p class='bg-dark parrafo'>Informacion del acudiente</p>
            <label for="cedula_acu">Cedula del acudiente</label>


            <?php
            $query = "SELECT * FROM acudiente where id_grado4=$id_grado";
            $consulta = pg_query($conexion, $query);
            echo "<select name='cedula_acu' required>";
            while ($obj = pg_fetch_object($consulta)) {
                echo "<option value='$obj->id_acudi'>$obj->cedula / $obj->nombre_acudi $obj->apellido_acudi</option>";
            }
            ?>
            </select>

            <br>
            <!-- btn -->
            <button ttitle='Enviar' class='btnn' type='submit'>Enviar</button>
        </tr>
    </form>

    <?php
    
    ?>
    <script type="text/javascript">
        function preguntar(id_acudi, nombre_acudi, apellido_acudi) {

            swal({
                title: 'Eliminar acudiente',
                text: 'Si elimina el acudiente' + nombre_acudi + " " + apellido_acudi + ', se eliminara el estudiante al cual esta ligado; Desea continuar?',
                icon: 'warning',
                buttons: ["Cancelar", "Confirmar"],
            }).then((eleccion) => {
                if (eleccion) {
                    swal({
                        title: 'Se ha eliminado el acudiente',
                        text: ':(',
                        icon: 'success',
                        timer: "3000",
                    }).then((timer) => {
                        window.location = 'delete_acu.php?id=' + id_acudi
                    })
                }
            });
        }
    </script>
</body>

</html>