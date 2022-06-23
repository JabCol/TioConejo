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
</head>

<body>
    <!-- volver al inicio / button -->
    <a href="../main_page/main_page_login.php" class="btn btn-secondary enlace">Volver al inicio </a>
    <img src='../imgs/conejo.png' width='50px'>

    <?php
    session_start();
    $id_admin1 = $_SESSION['id_admin'];

    if (!isset($id_admin1)) {
        header('location: ../login.php');
    }

    include("../connection.php");

    $conexion = connection();

    echo "
    <p class='bg-dark parrafo'>Añadir nueva materia</p>
    <form method='POST' class='formu'>
        <label for='nom_mat'>Nombre de la materia</label>
        <input type='text' required name='nom_mat'>
        <button type='submit' tittle='Enviar'>Aceptar</button>
    </form>
    ";
    if ($_POST) {
        $nom_mat = $_POST['nom_mat'];
        $nomb_mat_minis = (strtolower($nom_mat));

        $query = "SELECT COUNT(*) FROM materia WHERE nombre_materia='$nomb_mat_minis'";
        $consulta = pg_query($conexion, $query);
        $obj = pg_fetch_object($consulta);

        if ($obj->count > 0) {
            echo "
            <br>
            <p class='error'>La materia que desea ingresar ya esta registrada.</p>
            ";
        } else {
            $query = "INSERT INTO materia (nombre_materia) VALUES ('$nomb_mat_minis')";
            $consulta = pg_query($conexion, $query);

            if ($consulta) {
                echo "<script>window.location='mat_gra.php'</script>";
            } else {
                echo "Error";
            }
        }
    }
    echo "
    <p class='bg-dark parrafo'>Lista De Materias en el colegio</p>
    <div class='container'>
    <table id='example' class='table'>
        <thead>
            <th>Identificador</th>
            <th>Nombre de la Materia</th>
            <th>Opciones</th>
        </thead>
        <tbody>
    ";
    $query = "SELECT * FROM materia order by id_materia ASC";
    $consulta = pg_query($conexion, $query);
    while ($obj = pg_fetch_object($consulta)) {
        echo "
            <tr>
            <td>$obj->id_materia</td>
            <td>$obj->nombre_materia</td>

            <td>
            <a href='logic_mat/edit_mat.php?id=$obj->id_materia'><i class='material-icons' style='color:black;'>edit</i></a>
            <a href='#' onclick='preguntar($obj->id_materia)'><i class='material-icons' style='color:black;'>delete</i></a>
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
    function preguntar(id_materia) {
        if(confirm('Si elimina la materia; Se eliminara de todos los cursos en la que este vigente; Desea continuar?')){
            window.location = 'logic_mat/delete_mat.php?id='+id_materia
        }
        // swal({
        //     title: 'Eliminar la materia: '+nombre_materia,
        //     text: 'Si elimina la materia: '+nombre_materia+'; Se eliminara de todos los cursos en la que este vigente; Desea continuar?',
        //     icon: 'warning',
        //     buttons: ["Cancelar", "Confirmar"],
        // }).then((eleccion) => {
        //     if (eleccion) {
        //         swal({
        //             title: 'Se ha eliminado la materia de la escuela: ',
        //             text: ':(',
        //             icon: 'success',
        //             timer: "3000",
        //         }).then((timer) => {
        //              window.location = 'logic_mat/delete_mat.php?id='+id_materia  
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