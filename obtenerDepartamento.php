<?php
    include_once 'conexion.php'
    $conexion = conectar();

    $stmt = "SELECT id, departamento FROM departamentos";
    $resultado = $conexion->query($stmt);
    $departamentos = array();
    if ($resultado->num_rows > 0) {
        while($row = $resultado->fetch_assoc()) {
            $departamentos[] = array(
                "id" => $row['id'],
                "departamento" => $row['departamento']
            );
        }
    }
    echo json_encode($departamentos);
    $conexion->close();
?>