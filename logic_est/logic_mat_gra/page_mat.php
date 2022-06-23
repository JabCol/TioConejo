<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../../css/styles_table.css">
    <link rel="shortcut icon" href="../../imgs/conejo.png" type="image/x-icon" />
    <title>Tio conejo</title>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php
    session_start();
    $id_admin1 = $_SESSION['id_admin'];

    if (!isset($id_admin1)) {
        header('location: ../../login.php');
    }

    include("../../connection.php");

    $conexion = connection();

    if ($_GET) {
        $id = $_GET['id'];
    }
    if ($_POST) {
        $id_mat = $_POST['nom_mat'];


        $query = "SELECT COUNT(*) FROM grado_materia WHERE id_materia = $id_mat AND id_grado=$id";
        $consulta = pg_query($conexion, $query);
        $obj = pg_fetch_object($consulta);

        if ($obj->count > 0) {
            echo "
            <br>
            <p class='error'>La materia que trata de registrar, ya esta en el registro de materias de este grado con el identificador: $id_mat</p>
            ";
        } else {
            $query = "INSERT INTO grado_materia (id_materia, id_grado) VALUES ($id_mat, $id)";
            $consulta = pg_query($conexion, $query);

            if ($consulta) {
                header("location: page_mat.php?id=$id");
            } else {
                echo "Error";
            }
        }
    }
    echo "
    <a href='../page_est.php?id=$id' class='btn btn-secondary enlace'>Volver al grado</a>
    <img src='../../imgs/conejo.png' width='50px'>

    <p class='bg-dark parrafo'>Añadir una materia:</p>
    <form method='POST' class='formu'>
        <label for='nom_mat'>Nombre de la materia</label>
        <select name='nom_mat'>
    ";

    

    $query = "SELECT * FROM materia";
    $consulta = pg_query($conexion, $query);
    while ($obj = pg_fetch_object($consulta)) {
        echo "<option value='$obj->id_materia'>$obj->nombre_materia</option>";
    }
    echo "
    </select>

    <button type='submit' tittle='Enviar'>Aceptar</button>
    </form>
    <p class='bg-dark parrafo'>Materias del grado: </p>
    <div class='container'>
    <table id='example' class='table'>
        <thead>
            <th>Identificador</th>
            <th>Nombre de la Materia</th>
            <th>Opciones</th>
        </thead>
        <tbody>
    ";
    $query = "SELECT * FROM grado_materia gm JOIN materia m 
        ON gm.id_materia = m.id_materia
        WHERE gm.id_grado = $id order by gm.id_materia ASC";
    $consulta = pg_query($conexion, $query);
    while ($obj = pg_fetch_object($consulta)) {
        echo "
            <tr>
            <td>$obj->id_materia</td>
            <td>$obj->nombre_materia</td>

            <td>
            <a href='#' onclick='preguntar($obj->id_materia,$id)'><i class='material-icons' style='color:black;'>delete</i></a>
            </td>
            </tr>
            ";
    }
    ?>
    </tbody>
    </table>
    </div>

    <?php
    
    ?>
    <script type="text/javascript">
        function preguntar(id_materia,id) {

            if(confirm('Se eliminara la materia seleccionada del grado; Desea continuar?')){
                window.location = 'delete_mat.php?id='+id_materia+'&id2='+id;
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../js/data_t.js"></script>

</body>

</html>