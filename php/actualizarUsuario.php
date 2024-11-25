<?php
include_once 'conexion.php';
$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['inputId'];
    $nombre = $_POST['inputNombre'];
    $apellido = $_POST['inputApellido'];
    $correo = $_POST['inputCorreo'];
    $contrasena = $_POST['inputContrasena'];
    $confirmarContrasena = $_POST['inputConfirmarContrasena'];

    //Consulta SQL para traer el rol del usuario
    $role_query = "SELECT rol FROM usuarios WHERE id_usuario = ?";
    $stmt_role = $conexion->prepare($role_query);
    $stmt_role->bind_param("i", $id_usuario);
    $stmt_role->execute();
    $stmt_role->bind_result($role);
    $stmt_role->fetch();
    $stmt_role->close();
    if ($contrasena !== $confirmarContrasena) {
        if ($role == 1) {
            header("Location: ../pages/administrador.php?contrasenaIsDifferent=true");
        } else {
            header("Location: ../pages/usuario.php?contrasenaIsDifferent=true");
        }
        exit();
    }
    $query = "UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?";
    if (!empty($contrasena)) {
        $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);
        $query .= ", contrasena = ?";
    }
    $query .= " WHERE id_usuario = ?"; 
    $stmt = $conexion->prepare($query);   
    if (!empty($contrasena)) {
        $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $contrasena_encriptada, $id_usuario);
    } else {
        $stmt->bind_param("sssi", $nombre, $apellido, $correo, $id_usuario);
    }
    if ($stmt->execute()) {
        if ($role == 1) {
            header("Location: ../pages/administrador.php?actualizado=true");
        } else {
            header("Location: ../pages/usuario.php?actualizado=true");
        }
        exit();
    } else {
        echo "¡Error al actualizar la información del usuario! " . $stmt->error;
    }
    $stmt->close();
    $conexion->close();
}
?>
