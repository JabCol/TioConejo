<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imgs/conejo.png" type="image/x-icon" />
    <link rel="stylesheet" href="../css/stylesFP.css">
    <link rel="stylesheet" href="../css/footerAnidado.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/styles_table.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" 
    rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <title>Tío Conejo</title>
</head>

<body>
    <!-- Barra de menú -->
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <a href="#" class="enlace">
            <img src="../imgs/conejo.png" alt="" class="logo">
            <p>Tío Conejo</p>
        </a>
        <ul>
            <li><a class="active" href="../index.html">Home</a></li>
            <li><a href="#">Inscripción</a></li>
            <li><a href="../login.php">Login</a></li>
        </ul>
    </nav>

    <!-- Contenido -->
    <?php
    include("../connection.php");
    $conexion = connection();

    if ($_POST) {
        // Info estudiante
        $nombre_aspi = $_POST['nombreAspi'];
        $apellido_aspi = $_POST['apellidoAspi'];
        $tarjeta_id = $_POST['tarjetaAspi'];
        $genero_aspi = $_POST['genero'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $id_grado3 = $_POST['id_grado3'];

        // Info acudiente
        $nombre_acudi = $_POST['nombre_acudi'];
        $apellido_acudi = $_POST['apellido_acudi'];
        $telefono_acudi = $_POST['telefono_acudi'];
        $direccion_acudi = $_POST['direccion_acudi'];
        $cedula_acudi = $_POST['cedula_acudi'];

        $query = "SELECT COUNT(*) FROM solicitud WHERE tarjeta_id = '$tarjeta_id' AND cedula_acudi = '$cedula_acudi'";
        $consulta = pg_query($conexion, $query);
        $obj = pg_fetch_object($consulta);

        if ($obj->count > 0) {
            echo "
            <p style='text-align: center; background-color: #FFC107;
            color: #000;'>Ya se hizo una solicitud con el numero de tarjeta de identidad del aspirante y de cedula del acudiente, que ingreso; Si ya hizo una solicitud anteriormente, nos pondremos en contacto con usted lo mas rapido posible.</p>";
        } else {
            $query = "INSERT INTO solicitud (nombre_aspi, apellido_aspi,tarjeta_id,genero_aspi, fecha_nacimiento, id_grado3, nombre_acudi, apellido_acudi, telefono_acudi, direccion_acudi, cedula_acudi)
            VALUES ('$nombre_aspi', '$apellido_aspi', '$tarjeta_id', '$genero_aspi', '$fecha_nacimiento', '$id_grado3', '$nombre_acudi', '$apellido_acudi', '$telefono_acudi', '$direccion_acudi', '$cedula_acudi')";
            $consulta = pg_query($conexion, $query);

            if ($consulta) {
                echo "<p style='background-color: green;
                color: #fff;
                text-align: center;'>Se hizo la solicitud de registro a nuestra escuela correctamente nos pondremos en contacto al número dado lo mas pronto posible.</p>";
            } else {
                echo "Error";
            }
        }
    }

    echo "
        <form class='formulario' method='POST'>
        <div>
            <h3>Información del aspirante</h3>
        </div>
        <div>
            <label htmlFor='nombreAspi'>Nombres </label>
            <input type='text' required name='nombreAspi' placeholder='Ingresa el nombre del aspirante'>
        </div>
        <div>
            <label htmlFor='apellidoAspi'>Apellidos </label>
            <input type='text' required name='apellidoAspi' placeholder='Ingresa el apellido del aspirante'>
        </div>
        <div>
            <label htmlFor='tarjetaAspi'>Documento </label>
            <input type='number' required name='tarjetaAspi' placeholder='Ingresa el número de documento del aspirante'>
        </div>
        <div>
            <label htmlFor='genero'>Genero </label>
            <select name='genero'>
                <option value='MASCULINO'>MASCULINO</option>
                <option value='FEMENINO'>FEMENINO</option>
                <option value='OTRO'>OTRO</option>
            </select>
        </div>
        <div>
            <label htmlFor='fecha_nacimiento'>Fecha de nacimiento</label>
            <input type='date' required name='fecha_nacimiento' placeholder='Ingresa la fecha de nacimiento del aspirante'>
        </div>
        <div>
            <label htmlFor='id_grado3'>Grado </label>
            <select name='id_grado3'>
        ";

    $query = "SELECT * FROM grado";
    $consulta = pg_query($conexion, $query);
    while ($obj = pg_fetch_object($consulta)) {
        echo "<option value='$obj->id_grado'>$obj->nombre_grado / $obj->jornada</option>";
    }
    echo "     
            </select>
        </div>
        <div>
            <h3>Información del acudiente</h3>
        </div>
        <div>
            <label htmlFor='nombre_acudi'>Nombre </label>
            <input type='text' required name='nombre_acudi' placeholder='Ingresa el nombre del acudiente'>
        </div>
        <div>
            <label htmlFor='apellido_acudi'>Apellido </label>
            <input type='text' required name='apellido_acudi' placeholder='Ingresa el apellido del acudiente'>
        </div>
        <div>
            <label htmlFor='telefono_acudi'>Teléfono </label>
            <input type='number' required name='telefono_acudi' placeholder='Ingresa el telefono del acudiente'>
        </div>
        <div>
            <label htmlFor='direccion_acudi'>Dirección </label>
            <input type='text' required name='direccion_acudi' placeholder='Ingresa el direccion del acudiente'>
        </div>
        <div>
            <label htmlFor='cedula_acudi'>Cédula </label>
            <input type='number' required name='cedula_acudi' placeholder='Ingresa el cedula del acudiente'>
        </div>
        <button type='submit'>Enviar</button>
    </form>
        ";

    
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/data_t.js"></script>

    <iframe src="../footer.php" class="footer"></iframe>
</body>

</html>