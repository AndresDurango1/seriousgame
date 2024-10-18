<?php
    include_once 'conexion.php';
    $conexion = conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $identificacion = $_POST['inputIdentificacion'];
        $nombre = $_POST['inputNombre'];
        $apellido = $_POST['inputApellido'];
        $usuario = $_POST['inputUsuario'];
        $correo = $_POST['inputCorreo'];
        $contrasena = $_POST['inputContrasena'];

        $stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            echo "El usuario ya existe.";
        } else {
            $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

            $stmt = $conexion->prepare("INSERT INTO usuarios (identificacion, nombre, apellido, usuario, correo, contrasena) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $identificacion, $nombre, $apellido, $usuario, $correo, $contrasena_encriptada);
            if ($stmt->execute()) {
                echo "¡Registro Exitoso!";
            } else {
                echo "¡Error en el registro!";
            }
        }
        $stmt->close();
        $conexion->close();    
    }
    else {
        echo "Método no permitido";
    }
?>
