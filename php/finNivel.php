<?php
session_start();
include_once 'conexion.php';
$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $id_nivel = $_POST['id_nivel'];
    $fin = $_POST['fin'];
    $tiempo_transcurrido = $_POST['tiempo_transcurrido'];
    $puntaje = $_POST['puntaje'];

    $stmt = $conexion->prepare("UPDATE niveles_usuarios SET fin = ?, tiempo_transcurrido = ?, puntaje = ?, completado = true WHERE id_usuario = ? AND id_nivel = ?");
    $stmt->bind_param("ssiii", $fin, $tiempo_transcurrido, $puntaje, $id_usuario, $id_nivel);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Nivel completado registrado con éxito"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar la finalización del nivel"]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
