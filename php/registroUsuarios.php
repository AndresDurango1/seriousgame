<?php
    include_once 'conexion.php';
    $conexion = conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $identificacion = $_POST['inputIdentificacion'];
        $nombre = $_POST['inputNombre'];
        $apellido = $_POST['inputApellido'];
        $usuario = $_POST['inputUsuario'];
        $rol = isset($_POST['inputRol']) ? $_POST['inputRol'] : 0;
        $correo = $_POST['inputCorreo'];
        $contrasena = $_POST['inputContrasena'];
        $id_imagen = $_POST['inputIdImagenPerfil'];
        $stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo "El usuario ya existe.";
        } else {
            $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

            $stmt = $conexion->prepare("INSERT INTO usuarios (identificacion, nombre, apellido, usuario, rol, correo, contrasena, id_imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssissi", $identificacion, $nombre, $apellido, $usuario, $rol, $correo, $contrasena_encriptada, $id_imagen);
            if ($stmt->execute()) {
                //echo "¡Registro exitoso!";
                header("Location:../pages/formularioRegistroUsuario.php?registrado=true");
                exit();
            } else {
                //echo "¡Error en el registro!";
                header("Location:../pages/formularioRegistroUsuario.php?registrado=false");
                exit();
            }
        }
        $stmt->close();
        $conexion->close();    
    }
    else {
        echo "Método no permitido";
    }
?>
