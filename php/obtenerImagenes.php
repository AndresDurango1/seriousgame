<?php
include_once 'conexion.php';
$conexion = conectar();
if (isset($_GET['categoria_id'])) {
    $categoriaId = $_GET['categoria_id'];
    $stmt = $conexion->prepare("SELECT id_imagen, ruta_imagen, id_categoria FROM imagenes WHERE id_categoria = ?");
    $stmt->bind_param("i", $categoriaId);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $imagenes = [];
    while ($imagen = $resultado->fetch_assoc()) {
        $imagenes[] = $imagen;
    }
    echo json_encode($imagenes);
}
?>
