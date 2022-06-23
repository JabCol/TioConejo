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

    if (!isset($nombre_usuario)) {
        header('location: ../../login.php');
    }
    //Conexion bd
    include("../../connection.php");

    $conexion = connection();

    if ($_GET) {
        $id = $_GET['id'];
        $query = "SELECT * FROM materia WHERE id_materia = $id";
        $consulta = pg_query($conexion, $query);

        while ($obj = pg_fetch_object($consulta)) {
            $nombre_materia = $obj->nombre_materia;
        }

        echo "
        
        <a href='../mat_gra.php' class='btn btn-secondary enlace'>Volver a las materias</a>
        <img src='../../imgs/conejo.png' width='50px'>

        <p class='bg-dark parrafo'>Edita la informacion de la materia: $nombre_materia</p>

        <form method='POST' class='formu'>
        <label for='nom_mat'>Nombre de la materia</label>
        <input type='text' required  name='nom_mat' value='$nombre_materia'>
        <br>

        <button tittle='Enviar' type='submit' class='btnn'>Aceptar</button>
        </form>
        ";

        if ($_POST) {
            $id = $_GET['id'];
            $nom_mat = $_POST['nom_mat'];

            $query = "SELECT COUNT(*) FROM materia WHERE nombre_materia = '$nom_mat'";
            $consulta = pg_query($conexion, $query);
            $obj = pg_fetch_object($consulta);

            if ($obj->count > 0) {
                $query = "SELECT * FROM materia WHERE nombre_materia = '$nom_mat'";
                $consulta = pg_query($conexion, $query);
                $obj = pg_fetch_object($consulta);

                if ($obj->id_materia == $id) {
                    $query = "UPDATE materia SET nombre_materia = '$nom_mat' WHERE id_materia = $id";
                    $consulta = pg_query($conexion, $query);

                    if ($consulta) {
                        header('location: ../mat_gra.php');
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "
                    <br>
                    <p class='error'>Ya hay una materia con el nombre que desea usar para el cambio.</p>
                    ";
                }
            } else {
                $query = "UPDATE materia SET nombre_materia = '$nom_mat' WHERE id_materia = $id";
                $consulta = pg_query($conexion, $query);

                if ($consulta) {
                    header('location: ../mat_gra.php');
                } else {
                    echo "Error";
                }
            }
        }
    }
    ?>
</body>

</html>