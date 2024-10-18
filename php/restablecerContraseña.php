<?php
    include_once 'conexion.php';
    $conexion = conectar();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $token = $_POST['token'];
        $nuevaContrasena = $_POST['inputNuevaContrasena'];
    
        $stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE token = ? AND token_expira > NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            $contrasena_encriptada = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
            $stmt = $conexion->prepare("UPDATE usuarios SET contrasena = ?, token = NULL, token_expira = NULL WHERE token = ?");
            $stmt->bind_param("ss", $contrasena_encriptada, $token);
            $stmt->execute();
            echo "Tu contraseña ha sido restablecida con éxito.";
        } else {
            echo "Token no válido o ha expirado.";
        }
    }
?>