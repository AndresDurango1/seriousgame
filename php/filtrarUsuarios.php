<?php
include_once '../php/conexion.php';
$conexion = conectar();

$termino = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';
// Consulta para buscar usuarios según el término
$stmt = $conexion->prepare("
    SELECT u.id_usuario, u.identificacion, CONCAT(u.primer_nombre, ' ', u.segundo_nombre) AS nombre_completo,
           CONCAT(u.primer_apellido, ' ', u.segundo_apellido) AS apellido_completo, 
           CASE u.rol WHEN 0 THEN 'Colaborador' ELSE u.rol END AS rol,
           u.celular, LOWER(u.correo) AS correo
    FROM usuarios u
    WHERE rol != 1 AND (
        u.identificacion LIKE ? OR
        CONCAT(u.primer_nombre, ' ', u.segundo_nombre) LIKE ? OR
        CONCAT(u.primer_apellido, ' ', u.segundo_apellido) LIKE ? OR
        u.correo LIKE ?
    )
    ORDER BY apellido_completo ASC
");
$stmt->bind_param("ssss", $termino, $termino, $termino, $termino);
$stmt->execute();
$resultado = $stmt->get_result();

$usuarios = [];
while ($fila = $resultado->fetch_assoc()) {
    $usuarios[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($usuarios);
?>
