<link rel="stylesheet" href="../css/styles_table.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">

<?php
   include("../connection.php");
   $conexion = connection();
    session_start();

    $usuario = $_POST['user_log'];
    $clave = $_POST['password_log'];
  
    //Verificar login
    $query = "SELECT COUNT(*) as contar FROM admin WHERE nombre_usuario = '$usuario' AND password = '$clave'";

    $query2 = "SELECT * FROM admin WHERE nombre_usuario = '$usuario'";

    $consulta = pg_query($conexion, $query);
    $consulta2 = pg_query($conexion, $query2);

    $array = pg_fetch_array($consulta);
    $array2 = pg_fetch_array($consulta2);

    if($array['contar'] > 0){
        $_SESSION['nombre_usuario'] = $usuario;
        $_SESSION['id_admin'] = $array2['id_admin'];
        header('location: ../main_page/main_page_login.php');
    }else{
        echo "<p class='alert alert-danger incorrecto' role='alert'>Datos incorrectos. Si tienes algún problema con el ingreso a tu cuenta. Por favor comunicate con nosotros. 3226584502<br><br>
             <a href='../login.php' class='btn btn-dark text-white'>Volver</a>
             <img src='../imgs/conejo.png' width='30px'>   
             </p>
             <img src='../imgs/pngwing.com.png' class='imagen'>
        ";
    }

?>