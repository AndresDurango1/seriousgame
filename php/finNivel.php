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

    $stmt1 = $conexion->prepare("SELECT id_nivel_usuario FROM niveles_usuarios WHERE id_usuario = ? AND id_nivel = ? ORDER BY id_nivel_usuario DESC LIMIT 1");
    $stmt1->bind_param("ii", $id_usuario, $id_nivel);
    $stmt1->execute();
    $stmt1->bind_result($id_nivel_usuario);
    $stmt1->fetch();
    $stmt1->close();

    $stmt2 = $conexion->prepare("UPDATE niveles_usuarios SET fin = ?, tiempo_transcurrido = ?, puntaje = ?, completado = true WHERE id_nivel_usuario = ?");
    $stmt2->bind_param("ssii", $fin, $tiempo_transcurrido, $puntaje, $id_nivel_usuario);
    if ($stmt2->execute()) {
        echo json_encode(["status" => "success", "message" => "Nivel completado registrado con éxito"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar la finalización del nivel"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
