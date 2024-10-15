<?php
    include 'conexion.php'; 
    $conexion = conectar();
    $id_departamento = $_GET['id'];

    $sql = "SELECT id, ciudad FROM ciudades WHERE id_departamento = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_departamento);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $ciudades = array(); 
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $ciudades[] = array(
                "id" => $row['id'],
                "ciudad" => $row['ciudad']
            );
        }
    }
    echo json_encode($ciudades);
    $stmt->close(); 
    $conexion->close();
?>
