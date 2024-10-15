<?php
    include_once 'conexion.php';
    $conexion = conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $identificacion = $_POST['inputIdentificacion'];
        $nombre = $_POST['inputNombre'];
        $apellido = $_POST['inputApellido'];
        $usuario = $_POST['inputUsuario'];
        $contrasena = $_POST['inputContrasena'];
        $correo = $_POST['inputCorreo'];
        $departamento = $_POST['inputDepartamento'];
        $ciudad = $_POST['inputCiudad'];
        $edad = $_POST['inputEdad'];

        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            echo "El usuario ya existe.";
        } else {
            $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

            $stmt = $conexion->prepare("INSERT INTO usuarios (identificacion, nombre, apellido, usuario, contrasena, correo, departamento, ciudad, edad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssi", $identificacion, $nombre, $apellido, $usuario, $contrasena_encriptada, $correo, $departamento, $ciudad, $edad);
            if ($stmt->execute()) {
                echo "Registro exitoso";
            } else {
                echo "Error en el registro";
            }
        }
        $stmt->close();
        $conexion->close();    
    }
    else {
        echo "Método no permitido";
    }
?>