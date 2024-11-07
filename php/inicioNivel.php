<?php
session_start();
include_once 'conexion.php';
$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $id_nivel = $_POST['id_nivel'];
    $inicio = $_POST['inicio'];
    $completado = $_POST['completado'];
    $completado_bool = ($completado === "1") ? true : false;
    $stmt = $conexion->prepare("INSERT INTO niveles_usuarios (id_usuario, id_nivel, inicio, completado) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $id_usuario, $id_nivel, $inicio, $completado_bool);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Inicio de nivel registrado con éxito"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar el inicio del nivel"]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
