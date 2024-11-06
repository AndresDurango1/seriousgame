<?php
    session_start();
    if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 0) {
        header("Location: ../pages/index.php");
        exit();
    }
    include_once '../php/conexion.php';
    $conexion = conectar();
    $id_usuario = $_SESSION['id_usuario'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $fecha_nacimiento = $_POST['inputFechaNacimiento'];
        $numero_celular = $_POST['inputNumeroCelular'];
        $id_usuario = $_POST['inputIdUsuario'];
        $id_genero = $_POST['inputGenero'];
        $id_grupo_etnico = $_POST['inputGrupoEtnico'];
        $id_ciudad = $_POST['inputCiudad'];
        $id_estado_civil = $_POST['inputEstadoCivil'];
        $id_nivel_educativo = $_POST['inputNivelEducativo'];
        $id_ocupacion = $_POST['inputOcupacion'];
        $id_cargo = $_POST['inputCargo'];
        $id_estrato = $_POST['inputEstrato'];
        $id_tipo_vivienda = $_POST['inputTipoVivienda'];

        $stmt = $conexion->prepare("SELECT id_caracterizacion FROM caracterizacion WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $id_caracterizacion = $resultado->fetch_assoc()['id_caracterizacion'];
            $stmtActualizacion = $conexion->prepare("UPDATE caracterizacion SET fecha_nacimiento = ?, celular = ?, id_usuario = ?, id_genero = ?, id_grupo_etnico = ?, id_ciudad = ?, id_estado_civil = ?, id_nivel_educativo = ?, id_ocupacion = ?, id_cargo = ?, id_estrato = ?, id_tipo_vivienda = ? WHERE id_caracterizacion = ?");
            $stmtActualizacion->bind_param("ssiiiiiiiiiii", $fecha_nacimiento, $numero_celular, $id_usuario, $id_genero, $id_grupo_etnico, $id_ciudad, $id_estado_civil, $id_nivel_educativo, $id_ocupacion, $id_cargo, $id_estrato, $id_tipo_vivienda, $id_caracterizacion);
            $stmtActualizacion->execute();
            if($stmtActualizacion->execute()) {
                header("Location: ../pages/formularioCaracterizacion.php");
                exit();
            } else {
                echo "Error: ". $stmtActualizacion->error;
            }
        } else {
            $stmtInsercion = $conexion->prepare("INSERT INTO caracterizacion (fecha_nacimiento, celular, id_usuario, id_genero, id_grupo_etnico, id_ciudad, id_estado_civil, id_nivel_educativo, id_ocupacion, id_cargo, id_estrato, id_tipo_vivienda) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtInsercion->bind_param("ssiiiiiiiiii", $fecha_nacimiento, $numero_celular, $id_usuario, $id_genero, $id_grupo_etnico, $id_ciudad, $id_estado_civil, $id_nivel_educativo, $id_ocupacion, $id_cargo, $id_estrato, $id_tipo_vivienda);
            $stmtInsercion->execute();
            if($stmtInsercion->execute()) {
                header("Location: ../pages/formularioCaracterizacion.php");
                exit();
            } else {
                echo "Error: ". $stmtInsercion->error;
            }
        }
    } 
?>