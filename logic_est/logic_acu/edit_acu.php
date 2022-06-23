<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/styles_table.css">
    <link rel="shortcut icon" href="../../imgs/conejo.png" type="image/x-icon" />
    <title>Tio conejo</title>
</head>

<body>
    <?php
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];
    $id = $_SESSION['id_grado'];

    if (!isset($nombre_usuario)) {
        header('location: ../../login.php');
    }
    //conexion bd
    include("../../connection.php");

    $conexion = connection();

    if ($_GET) {
        $id_acu = $_GET['id'];
        $query = "SELECT * FROM acudiente WHERE id_acudi = $id_acu";
        $consulta = pg_query($conexion, $query);
        while ($obj = pg_fetch_object($consulta)) {
            $nombre_acu = $obj->nombre_acudi;
            $apellido_acu = $obj->apellido_acudi;
            $telefono_acu = $obj->telefono_acudi;
            $direccion_acu = $obj->direccion_acudi;
            $numero_cedula = $obj->cedula;
        }

        echo "
        <a href='page_acu.php?id=$id' class='btn btn-secondary enlace'>Acudientes</a>
        <img src='../../imgs/conejo.png' width='50px'>

        <p class='bg-dark parrafo'>Edita la informacion del acudiente: $nombre_acu $apellido_acu / Numero de cedula: $numero_cedula</p>

        <form method='POST' class='formu'>
            <label for='nom_acu'>Nombre del acudiente</label>
            <input name='nom_acu' type='text' required value='$nombre_acu'>
            <br>

            <label for='ape_acu'>Nombre del acudiente</label>
            <input name='ape_acu' type='text' required value='$apellido_acu'>
            <br>

            <label for='tel_acu'>Telefono</label>
            <input name='tel_acu' type='number' required value='$telefono_acu'>
            <br>

            <label for='ced_acu'>Cedula</label>
            <input name='ced_acu' type='number' required value='$numero_cedula'>
            <br>
            
            <label for='dir_acu'>Direccion</label>
            <textarea name='dir_acu' cols='50' rows='3'>$direccion_acu</textarea>
            <br>

            <button tittle='Enviar' type='submit' class='btnn'>Aceptar</button>
        </form>
        ";

        if ($_POST) {
            $nombre = $_POST['nom_acu'];
            $apellido = $_POST['ape_acu'];
            $telefono = $_POST['tel_acu'];
            $direccion = $_POST['dir_acu'];
            $cedula = $_POST['ced_acu'];

            $query = "SELECT COUNT(*) FROM acudiente WHERE cedula = '$cedula'";
            $consulta = pg_query($conexion, $query);
            $obj = pg_fetch_object($consulta);

            if ($obj->count > 0) {

                $query = "SELECT * FROM acudiente WHERE cedula = '$cedula'";
                $consulta = pg_query($conexion, $query);
                $obj = pg_fetch_object($consulta);

                if ($obj->id_acudi == $id_acu) {
                    $query = "UPDATE acudiente SET
                nombre_acudi = '$nombre',
                apellido_acudi = '$apellido',
                telefono_acudi = '$telefono',
                direccion_acudi = '$direccion',
                cedula = '$cedula'
                WHERE id_acudi = $id_acu
                ";
                    $consulta = pg_query($conexion, $query);

                    if ($consulta) {
                        header("location: page_acu.php?id=$id");
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "
                <br>
                <p class='error'>Ya hay un acudiente registrado, con el numero de cedula que esta ingresando para el cambio</p>";
                }
            } else {
                $query = "UPDATE acudiente SET
                nombre_acudi = '$nombre',
                apellido_acudi = '$apellido',
                telefono_acudi = '$telefono',
                direccion_acudi = '$direccion',
                cedula = '$cedula'
                WHERE id_acudi = $id_acu
                ";
                $consulta = pg_query($conexion, $query);

                if ($consulta) {
                    header("location: page_acu.php?id=$id");
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