<link rel="stylesheet" href="../css/styles_table.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="shortcut icon" href="../imgs/conejo.png" type="image/x-icon" />

<?php
//Conexion bd
session_start();
$nombre_usuario = $_SESSION['nombre_usuario'];

if (!isset($nombre_usuario)) {
    header('location: ../login.php');
}

include("../connection.php");
$conexion = connection();

if ($_GET) {
    $id = $_GET['id'];

    $query = "SELECT * FROM solicitud WHERE id_solicitud = $id";

    $consulta = pg_query($conexion, $query);

    if ($obj = pg_fetch_object($consulta)) {
        $nom  = $obj->nombre_acudi;
        $ape = $obj->apellido_acudi;
        $tel = $obj->telefono_acudi;
        $dire = $obj->direccion_acudi;
        $ced = $obj->cedula_acudi;
        $id_gra = $obj->id_grado3;
        $num_id = $obj->tarjeta_id;

        // Acudiente verificacion
        $query  = "SELECT COUNT(*) FROM acudiente WHERE cedula = '$ced'";
        $consulta = pg_query($conexion, $query);
        $obj1 = pg_fetch_object($consulta);

        if ($obj1->count > 0) {
            echo "<p class='alert alert-danger incorrecto' role='alert'>El numero de cedula del acudiente que intenta registrar ya se encuentra en el registro, se recomienda ingresar manualmente la solicitud o comunicarse al numero de telefono de la solicitud, para evitar alterar los datos del acudiente ya registrado. <br><br>
            
            <a href='more_info.php?id=$id' class='btn btn-dark text-white'>Volver a la solicitud</a>
            <img src='../imgs/conejo.png' width='50px'>

            <a href='../logic_est/page_est.php?id=$id_gra' class='btn btn-dark text-white'>Ingresar la solicitud manualmente</a>
            <img src='../imgs/conejo.png' width='50px'>

            </p>
            <img src='../imgs/pngwing.com.png' class='imagen'>
            ";
        } else {
            // Estudiante verificacion
            $query = "SELECT COUNT(*) FROM estudiante WHERE tarjeta_id = '$num_id'";
            $consulta = pg_query($conexion, $query);
            $obj2 = pg_fetch_object($consulta);

            if ($obj2->count > 0) {
                echo "<p class='alert alert-danger incorrecto role='alert'>El numero de identificacion del estudiante que intenta registrar ya se encuentra en el registro, se recomienda ingresar manualmente la solicitud o comunicarse al numero de telefono de la solicitud, para evitar alterar los datos del estudiante ya registrado. <br><br>
                
                <a href='more_info.php?id=$id' class='btn btn-dark text-white'>Volver a la solicitud</a>
                <img src='../imgs/conejo.png' width='50px'>

                <a href='../logic_est/page_est.php?id=$id_gra' class='btn btn-dark text-white'>Ingresar la solicitud manualmente</a>
                <img src='../imgs/conejo.png' width='50px'>

                </p>
                <img src='../imgs/pngwing.com.png' class='imagen'>
                ";
            } else {
                $query = "INSERT INTO acudiente (nombre_acudi, apellido_acudi, telefono_acudi, direccion_acudi, cedula, id_grado4) values ('$nom', '$ape', '$tel', '$dire', '$ced', '$id_gra')";
                $consulta = pg_query($conexion, $query);

                if ($consulta) {
                    $query = "SELECT * FROM acudiente WHERE cedula = '$ced'";
                    $consulta = pg_query($conexion, $query);

                    if ($obj1 = pg_fetch_object($consulta)) {

                        $num_id = $obj->tarjeta_id;
                        $gen = $obj->genero_aspi;
                        $nom_est = $obj->nombre_aspi;
                        $ape_est = $obj->apellido_aspi;
                        $fec_na = $obj->fecha_nacimiento;
                        $id_grado = $obj->id_grado3;
                        $id_acu = $obj1->id_acudi;

                        $query = "INSERT INTO estudiante (tarjeta_id, genero, nombre, apellido, fecha_nacimiento, id_grado2, id_acudi1) VALUES ('$num_id', '$gen', '$nom_est', '$ape_est', '$fec_na', '$id_grado', '$id_acu')";

                        $consulta = pg_query($conexion, $query);

                        if ($consulta) {
                            $query = "DELETE FROM solicitud WHERE id_solicitud = $id";
                            $consulta = pg_query($conexion, $query);

                            if ($consulta) {
                                header('location: page_soli.php');
                            } else {
                                echo "error";
                            }
                        } else {
                            echo "Error";
                        }
                    } else {
                        echo "Error";
                    }
                } else {
                    echo "Error";
                }
            }
        }

        // }
    } else {
        echo "Error";
    }
}
