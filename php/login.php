<?php
session_start();
include_once 'conexion.php';
$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['inputUsuario'];
    $contrasena = $_POST['inputContrasena'];
    $stmt = $conexion->prepare("SELECT id_usuario, usuario, rol, contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $contrasena_encriptada = $fila['contrasena'];
        $id_usuario = $fila['id_usuario'];
        $rol = $fila['rol'];

        if (password_verify($contrasena, $contrasena_encriptada)) {
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['usuario'] = $usuario; 
            $_SESSION['rol'] = $rol;
            // Preparar la respuesta como JSON
            $respuesta = [
                "status" => "success",
                "id_usuario" => $id_usuario,
                "usuario" => $usuario,
                "rol" => $rol
            ];
            echo json_encode($respuesta);
        } else {
            echo json_encode(["status" => "error", "message" => "Contraseña incorrecta"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "El usuario no existe o es incorrecto"]);
    }
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
