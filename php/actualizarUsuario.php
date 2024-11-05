<?php
    include_once 'conexion.php';
    $conexion = conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $id_usuario = $_POST['inputId'];
    $nombre = $_POST['inputNombre'];
    $apellido = $_POST['inputApellido'];
    $correo = $_POST['inputCorreo'];
    $contrasena = $_POST['inputContrasena'];
    $confirmarContrasena = $_POST['inputConfirmarContrasena'];

    if ($contrasena !== $confirmarContrasena) {
        header("Location: ../pages/usuario.php?contrasena=true");
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
    $stmt->execute();
    if ($stmt->execute()) {
        header("Location: ../pages/usuario.php?actualizado=true");
        exit();
    } else {
        echo "¡Error al actualizar la información del usuario! " . $stmt->error;
    }        
    $stmt->close();
    $conexion->close();    
}
?>
