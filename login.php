<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylesFP.css">
    <link rel="stylesheet" href="./css/footerAnidado.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="./imgs/conejo.png" type="image/x-icon" />
    <title>Tío Conejo</title>
</head>

<body>
    <?php
    // Iniciar y destruir sesion, por si se regresa al login dentro del aplicativo
    session_start();
    session_destroy();
    ?>
    <!-- Barra de menú -->
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <a href="#" class="enlace">
            <img src="./imgs/conejo.png" alt="" class="logo">
            <p>Tío Conejo</p>
        </a>
        <ul>
            <li><a class="active" href="./index.html">Home</a></li>
            <li><a href="./logic_soli/for_inscripcion.php">Inscripción</a></li>
            <li><a href="./login.php">Login</a></li>
        </ul>
    </nav>

    <!-- Contenido -->

    <!-- Formulario para la informacion del usuario en el login -->
    <form action="logic_login/loguear.php" method="POST" class="formulario">
        <!-- Imagen login -->
        <img src="imgs/usuario.png" alt="Imagen usuario">
        <!-- Nombre del admin -->
        <label for="user_log">Nombre de usuario</label>
        <br>
        <input type="text" required name='user_log' placeholder='Nombre de usuario'>
        <br><br>
        <!-- Contraseña del admin -->
        <label for="password_log">Contraseña</label>
        <br>
        <input type="password" required name='password_log' placeholder="Contraseña">
        <br><br>

        <!-- Iniciar sesion / button -->
        <button type="submit">Entrar</button>
        <br><br>

    </form>

    <iframe src="footer.php" class="footer"></iframe>

</body>

</html>