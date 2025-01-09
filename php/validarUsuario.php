<?php
    session_start();
    include_once 'conexion.php';
    $conexion = conectar();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $identificacion = $_POST['inputIdentificacionR'];
    }
    // Consulta para verificar si el usuario existe
    $stmt = $conexion->prepare("SELECT id_usuario, identificacion, primer_nombre FROM usuarios WHERE identificacion = ?");
    $stmt->bind_param("s", $identificacion);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['registro_identificacion'] = $identificacion;
        header("Location: ../pages/formularioRegistroNuevaContrasena.php?usuario-registrado=true");
    } else {
        header("Location: ../pages/index.php?usuario-no-registrado=true");
    }
?>