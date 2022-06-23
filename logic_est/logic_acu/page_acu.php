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

    <link rel="stylesheet" href="../../plugins/SweetAlert/dist/sweetalert2.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php
    session_start();
    $nombre_usuario = $_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../../login.php');
    }

    include("../../connection.php");

    $conexion = connection();

    if ($_GET) {
        $id = $_GET['id'];
        $_SESSION['id_grado'] = $id;
        $query = "SELECT * FROM grado where id_grado = '$id'";
        $consulta = pg_query($conexion, $query);
        $obj = pg_fetch_object($consulta);
    }

    echo "
    <a href='../page_est.php?id=$id' class='btn btn-secondary enlace'>Volver a los estudiantes</a>
    <img src='../../imgs/conejo.png' width='50px'>

        <p class='bg-dark parrafo'>Añadir acudientes al grado:$obj->nombre_grado</p>
        
        <form method='POST' id='formulario_acudiente' class='formu'>
    
        <label for='nombre_acudi'>Nombre del acudiente</label>
        <input type='text' required name='nombre_acudi'>
        <br>
        <label for='apellido_acudi'>Apellido del acudiente</label>
        <input type='text' required name='apellido_acudi'>
        <br>
        <label for='telefono_acudi'>Telefono del acudiente</label>
        <input type='number' required name='telefono_acudi'>
        <br>
        <label for='cedula_acudi'>Cedula del acudiente</label>
        <input type='number'required name='cedula_acudi' id='cedula_acudiente'>
        <br>
        <label for='direccion_acudi' required>Direccion del acudiente</label>
        <textarea name='direccion_acudi' cols='50' rows='3' required></textarea>
        <br>
        <button tittle='Enviar' type='submit' class='btnn'>Aceptar</button>
         
        </form>
        ";

    if ($_POST) {
        $nom = $_POST['nombre_acudi'];
        $ape = $_POST['apellido_acudi'];
        $tel = $_POST['telefono_acudi'];
        $dire = $_POST['direccion_acudi'];
        $ced = $_POST['cedula_acudi'];

        $query  = "SELECT COUNT(*) FROM acudiente WHERE cedula = '$ced'";
        $consulta = pg_query($conexion, $query);
        $obj1 = pg_fetch_object($consulta);

        if ($obj1->count > 0) {
            echo "
            <br>
            <p class='error'>El numero de cedula que esta tratando de ingresar, ya se encuentra registrada.</p>";
        } else {
            $query =  "INSERT INTO acudiente (nombre_acudi, apellido_acudi, telefono_acudi, direccion_acudi, cedula, id_grado4) values ('$nom', '$ape', '$tel', '$dire', '$ced', '$id')";
            $consulta = pg_query($conexion, $query);


            if ($consulta) {
                header("location: page_acu.php?id=$id");
            } else {
                echo "Error";
            }
        }
    }

    echo "
      <!-- Acudientes / table -->
      
        <p class='bg-dark parrafo'>Acudientes del grado:$obj->nombre_grado</p>
        <div class='container'>
        <table id='example' class='table'>
            <thead>
                <th>Identificador</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Cedula</th>
                <th>Opciones</th>
            </thead>
            <tbody>
    ";
    $query = "SELECT * FROM acudiente WHERE id_grado4 = $id order by id_acudi";
    $consulta = pg_query($conexion, $query);
    while ($obj = pg_fetch_object($consulta)) {
        echo "
                <tr>
                    <td>$obj->id_acudi</td>
                    <td>$obj->nombre_acudi</td>
                    <td>$obj->apellido_acudi</td>
                    <td>$obj->telefono_acudi</td>
                    <td>$obj->direccion_acudi</td>
                    <td>$obj->cedula</td>

                    <td>
                    <a href='edit_acu.php?id=$obj->id_acudi'><i class='material-icons' style='color:black;'>edit</i></a>
                    <a href='#' onclick='preguntar($obj->id_acudi)'><i class='material-icons' style='color:black;'>delete</i></a>
                    </td>
                </tr>   
                ";
    }
    ?>
</body>
</table>
</div>

<script type="text/javascript">
    function preguntar(id_acudi) {

        if(confirm("Si elimina el acudiente; Se eliminara el ó los estudiante a los cuales esta ligado; Desea continuar?")){
            window.location = 'delete_acu.php?id=' + id_acudi 
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="../../js/data_t.js"></script>

</body>

</html>