<?php
session_start();
include_once 'conexion.php';
$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['inputUsuario'];
    $contrasena = $_POST['inputContrasena'];
    $origen = isset($_POST['origen']) ? $_POST['origen'] : '';

    // Consulta para obtener los datos del usuario
    $stmt = $conexion->prepare("SELECT id_usuario, usuario, rol, contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $contrasena_encriptada = $fila['contrasena'];
        $id_usuario = $fila['id_usuario'];
        $rol = $fila['rol'];

        // Verificación de la contraseña
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
            // Gestión para diligenciamiento del formulario de caracterización
            $stmtCaracterizacion = $conexion->prepare("SELECT * FROM caracterizacion WHERE id_usuario = ?");
            $stmtCaracterizacion->bind_param("i", $id_usuario);
            $stmtCaracterizacion->execute();
            $resultadoCaracterizacion = $stmtCaracterizacion->get_result();

            if ($origen != "unity") {
                if ($rol == 1) { // Administrador
                    if ($resultadoCaracterizacion->num_rows === 0) {
                        // El administrador debe diligenciar el formulario de caracterización
                        header("Location: ../pages/administrador.php?caracterizacion=true");
                    } else {
                        // El administrador ya diligenció el formulario de caracterización
                        header("Location: ../pages/administrador.php");
                    }               
                } else { // Usuario regular
                    if ($resultadoCaracterizacion->num_rows === 0) {
                        // El usuario debe diligenciar el formulario de caracterización
                        header("Location: ../pages/usuario.php?caracterizacion=true");
                    } else {
                        // El usuario ya diligenció el formulario de caracterización
                        header("Location: ../pages/usuario.php");
                    }
                }
                exit(); 
            }
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
