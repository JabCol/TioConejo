<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles_table.css">
    <link rel="shortcut icon" href="../imgs/conejo.png" type="image/x-icon" />
    <title>Tio Conejo</title>
</head>

<body>
    <?php
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }
    //Conexion bd
    include("../connection.php");

    $conexion = connection();

    $id_admin = $_SESSION['id_admin'];

    //Obtener datos del form
    if ($_GET) {
        $id = $_GET['id'];
        $query = "SELECT * FROM grado WHERE id_grado = $id ";
        $consulta = pg_query($conexion, $query);
        while ($obj = pg_fetch_object($consulta)) {
            $nombre_grado = $obj->nombre_grado;
            $jornada_grado = $obj->jornada;
            $id_tabla = $obj->id_admin1;
        }

        //Editar grado / form

        echo "
        
        <a href='page_gra.php' class='btn btn-secondary enlace'>Volver a los grados</a>
        <img src='../imgs/conejo.png' width='50px'>
        
        <p class='bg-dark parrafo'>Edita la informacion del grado: $nombre_grado</p>  
    <form method='POST' class='formu'>

        <tr>
            <td><label for='nombre_mat'>Nombre del grado</label></td>
            <td><input type='text' required name='nombre_grado' id='nombre_grado' placeholder='$nombre_grado'></td>
        </tr>
        <br>
        
        <td>
            <td><label for='jornada_grado'>Jornada del grado</label></td>
            <td>
                <select name='jornada_grado'>
                    <option value='MAÑANA'>MAÑANA</option>
                    <option value='TARDE'>TARDE</option>
                </select>
            </td>
        </td>

        <br>
        <tr>
        <button tittle='Enviar' type='submit' class='btnn'>Aceptar</button>
        </tr>
    </form>
    ";
        //Actualizar datos        
        if ($_POST) {
            $id_grado = $_GET['id'];
            $nomb = $_POST['nombre_grado'];
            $nomb_minis = (strtolower($nomb));
            $jorn = $_POST['jornada_grado'];

            $query =  "SELECT COUNT(*) FROM grado WHERE nombre_grado='$nomb_minis' AND jornada='$jorn'";
            $consulta = pg_query($conexion, $query);
            $obj = pg_fetch_object($consulta);

            if ($obj->count > 0) {

                $query =  "SELECT * FROM grado WHERE nombre_grado='$nomb_minis' AND jornada='$jorn'";
                $consulta = pg_query($conexion, $query);
                $obj = pg_fetch_object($consulta);

                if ($obj->id_grado == $id) {

                    $query = "UPDATE grado SET nombre_grado = '$nomb_minis', jornada = '$jorn', ultimo_cambio='$id_admin' WHERE id_grado = $id";
                    $consulta = pg_query($conexion, $query);

                    if ($consulta) {
                        echo "<script>window.location='page_gra.php'</script>";
                    } else {
                        echo 'Error.';
                    }
                    
                } else {
                    echo "
                    <br>
                    <p class='error'>Ya existe un grado con el nombre ingresado, se recomienda variar el nombre de estos para una mayor organizacion</p>";
                }
            } else {
                $query = "UPDATE grado SET nombre_grado = '$nomb_minis', jornada = '$jorn', ultimo_cambio='$id_admin' WHERE id_grado = $id";
                $consulta = pg_query($conexion, $query);

                if ($consulta) {
                    echo "<script>window.location='page_gra.php'</script>";
                } else {
                    echo 'Error.';
                }
            }
        }
    } else {
        echo 'Ha ocurrido un error inesperado, porfavor regrese al inicio e intentelo de nuevo.';
    }

    ?>
</body>

</html>