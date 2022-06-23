<?php
    //Funcion para conectarse a la BD
    function connection(){
        $conexion = pg_connect("host=localhost dbname='Escuela' user=postgres password=jac08");
        return $conexion;
    }
?>