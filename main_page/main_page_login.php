<?php require_once "../vistas/parteSuperior.php" ?>

<div class="main">
    <div class="topbar">
        <div class="toggle">
            <ion-icon name="menu-outline"></ion-icon>
        </div>
    </div>

    <?php
    //Conectarse a la bd
    include("../connection.php");
    $conexion = connection();

    //Iniciar sesion
    session_start();
    $nombre_usuario =  $_SESSION['nombre_usuario'];

    if (!isset($nombre_usuario)) {
        header('location: ../login.php');
    }
        // Obtener datos de la BD para mostrar informacion en la pagina principal
        $query1 = "SELECT COUNT(*) FROM solicitud";
        $consulta1 = pg_query($conexion, $query1);
        $obj1 = pg_fetch_object($consulta1);

        $query2 = "SELECT COUNT(*) FROM grado";
        $consulta2 = pg_query($conexion, $query2);
        $obj2 = pg_fetch_object($consulta2);

        $query3 = "SELECT COUNT(*) FROM estudiante";
        $consulta3 = pg_query($conexion, $query3);
        $obj3 = pg_fetch_object($consulta3);

        $query4 = "SELECT COUNT(*) FROM materia";
        $consulta4 = pg_query($conexion, $query4);
        $obj4 = pg_fetch_object($consulta4);

        // Mostrar informacion obtenida de la BD
        echo "
    <!-- página inicio -->
    
    <p class='p'> Bienvenido (a) $nombre_usuario</p>
    
    <div class='cardBox'>
        <div class='card'>
            <div>
                <div class='numeros'>$obj1->count</div>
                <div class='cardName'>Solicitudes</div>
            </div>
            <div class='iconBx'>
                <ion-icon name='mail-outline'></ion-icon>
            </div>
        </div>
        <div class='card'>
            <div>
                <div class='numeros'>$obj2->count</div>
                <div class='cardName'>Grados</div>
            </div>
            <div class='iconBx'>
                <ion-icon name='school-outline'></ion-icon>
            </div>
        </div>
        <div class='card'>
            <div>
                <div class='numeros'>$obj3->count</div>
                <div class='cardName'>Estudiantes</div>
            </div>
            <div class='iconBx'>
                <ion-icon name='people-outline'></ion-icon>
            </div>
        </div>
        <div class='card'>
            <div>
                <div class='numeros'>$obj4->count</div>
                <div class='cardNme'>Materias</div>
            </div>
            <div class='iconBx'>
                <ion-icon name='library-outline'></ion-icon>
            </div>
        </div>
    </div>
    <div class='imgC'>
        <img src='../imgs/conejo.png' alt=''>
        <h2>Tío Conejo</h2>
    </div>

    ";
    ?>

    <div>
    </div>
</div>


<?php require_once "../vistas/parteInferior.php" ?>