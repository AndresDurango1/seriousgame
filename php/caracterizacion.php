<?php
    session_start();
    if (!isset($_SESSION['id_usuario']) || ($_SESSION['rol'] != 0 && $_SESSION['rol'] != 1)) {
        header("Location: ../pages/index.php");
        exit();
    }
    include_once '../php/conexion.php';
    $conexion = conectar();
    $id_usuario = $_SESSION['id_usuario'];
    //Se debe validar que los campos del formulario no estén vacíos antes de procesarlo y enviarlo a la base de datos
    function validarCampos($data) {
        $errores = [];
        if (empty($data['inputFechaNacimiento'])) {
            $errores[] = "La fecha de nacimiento es obligatoria.";
        }
        if (empty($data['inputNumeroCelular'])) {
            $errores[] = "El número de celular es obligatorio.";
        }
        if (empty($data['inputGenero'])) {
            $errores[] = "El género es obligatorio.";
        }
        if (empty($data['inputGrupoEtnico'])) {
            $errores[] = "El grupo étnico es obligatorio.";
        }
        if (empty($data['inputCiudad'])) {
            $errores[] = "La ciudad es obligatoria.";
        }
        if (empty($data['inputEstadoCivil'])) {
            $errores[] = "El estado civil es obligatorio.";
        }
        if (empty($data['inputNivelEducativo'])) {
            $errores[] = "El nivel educativo es obligatorio.";
        }
        if (empty($data['inputOcupacion'])) {
            $errores[] = "La ocupación es obligatoria.";
        }
        if (empty($data['inputCargo'])) {
            $errores[] = "El cargo es obligatorio.";
        }
        if (empty($data['inputEstrato'])) {
            $errores[] = "El estrato es obligatorio.";
        }
        if (empty($data['inputTipoVivienda'])) {
            $errores[] = "El tipo de vivienda es obligatorio.";
        }
        return $errores;
    }
    //Por seguridad se debe sanitizar la informacion antes de enviarla a la base de datos, para evitar inyeccion sql, xss o algun tipo de actividad
    //maliciosa
    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $fecha_nacimiento = htmlspecialchars(strip_tags($_POST['inputFechaNacimiento']));
        $numero_celular = htmlspecialchars(strip_tags($_POST['inputNumeroCelular']));
        $id_usuario = filter_input(INPUT_POST, 'inputIdUsuario', FILTER_SANITIZE_NUMBER_INT);
        $id_genero = filter_input(INPUT_POST, 'inputGenero', FILTER_SANITIZE_NUMBER_INT);
        $id_grupo_etnico = filter_input(INPUT_POST, 'inputGrupoEtnico', FILTER_SANITIZE_NUMBER_INT);
        $id_ciudad = filter_input(INPUT_POST, 'inputCiudad', FILTER_SANITIZE_NUMBER_INT);
        $id_estado_civil = filter_input(INPUT_POST, 'inputEstadoCivil', FILTER_SANITIZE_NUMBER_INT);
        $id_nivel_educativo = filter_input(INPUT_POST, 'inputNivelEducativo', FILTER_SANITIZE_NUMBER_INT);
        $id_ocupacion = filter_input(INPUT_POST, 'inputOcupacion', FILTER_SANITIZE_NUMBER_INT);
        $id_cargo = filter_input(INPUT_POST, 'inputCargo', FILTER_SANITIZE_NUMBER_INT);
        $id_estrato = filter_input(INPUT_POST, 'inputEstrato', FILTER_SANITIZE_NUMBER_INT);
        $id_tipo_vivienda = filter_input(INPUT_POST, 'inputTipoVivienda', FILTER_SANITIZE_NUMBER_INT);
        // Validar campos obligatorios antes de enviarlos a la base de datos
        $errores = validarCampos($_POST);
        if (count($errores) > 0) {
            $errores_str = implode(",", $errores);
            header("Location: ../pages/formularioCaracterizacion.php?fc-error=true&errores=" . urlencode($errores_str));
            exit();
        }
        // Si no hay errores, proceder con la inserción o actualización
        $stmt = $conexion->prepare("SELECT id_caracterizacion FROM caracterizacion WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $id_caracterizacion = $resultado->fetch_assoc()['id_caracterizacion'];

            $stmtActualizacion = $conexion->prepare("UPDATE caracterizacion SET fecha_nacimiento = ?, celular = ?, id_usuario = ?, id_genero = ?, id_grupo_etnico = ?, id_ciudad = ?, id_estado_civil = ?, id_nivel_educativo = ?, id_ocupacion = ?, id_cargo = ?, id_estrato = ?, id_tipo_vivienda = ? WHERE id_caracterizacion = ?");
            $stmtActualizacion->bind_param("ssiiiiiiiiiii", $fecha_nacimiento, $numero_celular, $id_usuario, $id_genero, $id_grupo_etnico, $id_ciudad, $id_estado_civil, $id_nivel_educativo, $id_ocupacion, $id_cargo, $id_estrato, $id_tipo_vivienda, $id_caracterizacion);
            if($stmtActualizacion->execute()) {
                header("Location: ../pages/formularioCaracterizacion.php?fc-actualizado=true");
                exit();
            } else {
                header("Location: ../pages/formularioCaracterizacion.php?fc-no-actualizado=true");
                exit();
            }
        } else {
            $stmtInsercion = $conexion->prepare("INSERT INTO caracterizacion (fecha_nacimiento, celular, id_usuario, id_genero, id_grupo_etnico, id_ciudad, id_estado_civil, id_nivel_educativo, id_ocupacion, id_cargo, id_estrato, id_tipo_vivienda) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmtInsercion->bind_param("ssiiiiiiiiii", $fecha_nacimiento, $numero_celular, $id_usuario, $id_genero, $id_grupo_etnico, $id_ciudad, $id_estado_civil, $id_nivel_educativo, $id_ocupacion, $id_cargo, $id_estrato, $id_tipo_vivienda);
            if($stmtInsercion->execute()) {
                header("Location: ../pages/formularioCaracterizacion.php?fc-insertado=true");
                exit();
            } else {
                header("Location: ../pages/formularioCaracterizacion.php?fc-no-insertado=true");
                exit();
            }
        }
    } 
?>