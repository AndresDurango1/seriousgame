<?php
    function conectar()
    {
        $host = "localhost";
        $user = "root";
        $password = "";
        $db = "u275682645_seriousgame";
        $conn = mysqli_connect($host, $user, $password, $db);

        // Verificar la conexión
        if (mysqli_connect_error()) {
            die("Error en la conexión a la base de datos.");
        }
        return $conn;
    }
?>
