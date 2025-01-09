<?php
    include_once '../php/conexion.php';
    $conexion = conectar();
    if (isset($_POST['id_departamento'])) {
        $id_departamento = $_POST['id_departamento'];
        $stmtCiudad = $conexion->prepare("SELECT id_ciudad, ciudad FROM ciudades WHERE id_departamento = ?");
        $stmtCiudad->bind_param("i", $id_departamento);
        $stmtCiudad->execute();
        $resultadoCiudad = $stmtCiudad->get_result();
    
        $ciudades = array();
        while ($row = $resultadoCiudad->fetch_assoc()) {
            $ciudades[] = $row;
        }
        // Devolver las ciudades en formato JSON
        echo json_encode($ciudades);
    }
?>
