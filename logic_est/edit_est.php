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
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $id = $_SESSION['id_grado'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }
    //conexion bd
    include("../connection.php");

    $conexion = connection();

    if ($_GET) {
        $id_es = $_GET['id'];
        $query = "SELECT * FROM estudiante e JOIN grado g ON e.id_grado2 = g.id_grado WHERE id_estudiante = $id_es";
        $consulta = pg_query($conexion, $query);
        while ($obj = pg_fetch_object($consulta)) {
            // Info del estudiante
            $tarjeta = $obj->tarjeta_id;
            $genero = $obj->genero;
            $nombre = $obj->nombre;
            $apellido = $obj->apellido;
            $fecha_na = $obj->fecha_nacimiento;
            $id_acudi = $obj->id_acudi1;

            //Info grado del grado
            $nom_gra = $obj->nombre_grado;
            $jor_gra = $obj->jornada;

            //Info del acudiente
            $query1 = "SELECT * FROM estudiante e JOIN acudiente a ON e.id_acudi1 = a.id_acudi WHERE id_estudiante = $id_es";
            $consulta1 = pg_query($conexion, $query1);
            $obj1 = pg_fetch_object($consulta1);

            $nombre_acu = $obj1->nombre_acudi;
            $apellido_acu = $obj1->apellido_acudi;
            $cedula_acu = $obj1->cedula;
        }


        echo "
        <a href='page_est.php?id=$id' class='btn btn-secondary enlace'>Volver a los Estudiantes</a>
        <img src='../imgs/conejo.png' width='50px'>

        <p class='bg-dark parrafo'>Edita la informacion del Estudiante: $nombre $apellido / $nom_gra - $jor_gra</p>

        <form method='POST' class='formu'>
        <label for='nom_est'>Nombre del Estudiante</label>
        <input name='nom_est' required type='text' value=$nombre>
        <br>

        <label for='ape_est'>Apellido del Estudiante</label>
        <input name='ape_est' required type='text' value=$apellido>
        <br>

        <label for='gen_est'>Genero</label>
            <select name='gen_est'>
                <option value='MASCULINO'>MASCULINO</option>
                <option value='FEMENINO'>FEMENINO</option>
                <option value='OTRO'>OTRO</option>
            </select>
        <br>

        <label for='ide_est'>Numero de Identificacion</label>
        <input name='ide_est' required type='number' value=$tarjeta>
        <br>

        <label for='fna_est'>Fecha de Nacimiento</label>
        <input name='fna_est' required type='date' value=$fecha_na>
        <br>

        <label for='acu_est'>Acudiente del estudiante</label>
        <select name='acu_est'>
        ";
        $query = "SELECT * FROM acudiente WHERE id_grado4 = $id";
        $consulta = pg_query($conexion, $query);
        echo "<option value='$id_acudi'>$cedula_acu / $nombre_acu $apellido_acu</option>";
        while ($obj = pg_fetch_object($consulta)) {
            if ($id_acudi != $obj->id_acudi) {
                echo "<option value='$obj->id_acudi'>$obj->cedula / $obj->nombre_acudi $obj->apellido_acudi</option>";
            }
        }
        echo "
        </select>
        <br>

        <button tittle='Enviar' type='submit' class='btnn'>Aceptar</button>
        </form>";

        if ($_POST) {
            $tarjeta_id = $_POST['ide_est'];
            $genero = $_POST['gen_est'];
            $nombre = $_POST['nom_est'];
            $apellido = $_POST['ape_est'];
            $fecha_nacimiento = $_POST['fna_est'];
            $id_acudi1 = $_POST['acu_est'];

            $query = "SELECT COUNT(*) FROM estudiante WHERE tarjeta_id = '$tarjeta_id'";
            $consulta = pg_query($conexion, $query);
            $obj = pg_fetch_object($consulta);

            if ($obj->count > 0) {

                $query = "SELECT * FROM estudiante WHERE tarjeta_id = '$tarjeta_id'";
                $consulta = pg_query($conexion, $query);
                $obj = pg_fetch_object($consulta);

                if ($obj->id_estudiante == $id_es) {
                    $query = "UPDATE estudiante SET 
                    
                    genero = '$genero',
                    nombre = '$nombre',
                    apellido = '$apellido',
                    fecha_nacimiento = '$fecha_nacimiento',
                    id_acudi1 = '$id_acudi1'
                    WHERE id_estudiante = $id_es
                    ";
                    $consulta = pg_query($conexion, $query);
                    if ($consulta) {
                        header("location: page_est.php?id=$id");
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "
                <br>
                <p class='error'>Ya hay un estudiante registrado, con el numero de tarjeta de identidad, que esta ingresando para el cambio</p>
                ";
                }
            } else {
                $query = "UPDATE estudiante SET 
                tarjeta_id = '$tarjeta_id',
                genero = '$genero',
                nombre = '$nombre',
                apellido = '$apellido',
                fecha_nacimiento = '$fecha_nacimiento',
                id_acudi1 = '$id_acudi1'
                WHERE id_estudiante = $id_es
                ";
                $consulta = pg_query($conexion, $query);
                if ($consulta) {
                    header("location: page_est.php?id=$id");
                } else {
                    echo "Error";
                }
            }
        }
    } else {
        echo 'Ha ocurrido un error inesperado, porfavor regrese al inicio e intentelo de nuevo.';
    }


    ?>
</body>

</html>