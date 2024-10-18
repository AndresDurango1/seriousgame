<?php
    session_start();
    include_once 'conexion.php';
    $conexion = conectar();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['inputUsuario'];
        $contrasena = $_POST['inputContrasena'];
        $stmt = $conexion->prepare("SELECT usuario, rol, contrasena FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $contrasena_encriptada = $fila['contrasena'];
            $rol = $fila['rol'];
            echo "Usuario: " . $usuario . "<br>";
            echo "Rol: " . $rol . "<br>";
            if (password_verify($contrasena, $contrasena_encriptada)) {
                $_SESSION['usuario'] = $usuario;
                $_SESSION['rol'] = $rol;
                echo "Inicio de sesión exitoso";
            } else {
                echo "Contraseña incorrecta";
            }
        } else {
            echo "Usuario no encontrado";
        }
        $stmt->close();
        $conexion->close();
    } else {
        echo "Método no permitido";
    }
?>
