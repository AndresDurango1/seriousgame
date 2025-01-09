<?php
include_once 'conexion.php';
$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $identificacion = htmlspecialchars($_POST['inputIdentificacion']);
    $primerNombre = htmlspecialchars($_POST['inputPrimerNombre']);
    $segundoNombre = isset($_POST['inputSegundoNombre']) ? htmlspecialchars($_POST['inputSegundoNombre']) : '';
    $primerApellido = htmlspecialchars($_POST['inputPrimerApellido']);
    $segundoApellido = isset($_POST['inputSegundoApellido']) ? htmlspecialchars($_POST['inputSegundoApellido']) : '';
    $rol = isset($_POST['inputRol']) ? intval($_POST['inputRol']) : 0;
    $celular = htmlspecialchars($_POST['inputCelular']);
    $correo = filter_var($_POST['inputCorreo'], FILTER_SANITIZE_EMAIL);
    $empresa = intval($_POST['inputEmpresa']);
    $canal = intval($_POST['inputCanal']);
    $cargo = intval($_POST['inputCargo']);
    $regional = intval($_POST['inputRegional']);
    $ciudad = intval($_POST['inputCiudad']);
    $fechaContratacion = $_POST['inputFechaContratacion'];
    $segmento = intval($_POST['inputSegmento']);

    $stmtValidacion = $conexion->prepare("SELECT id_usuario, identificacion FROM usuarios WHERE identificacion = ?");
    $stmtValidacion->bind_param("s", $identificacion);
    $stmtValidacion->execute();
    $resultadoValidacion = $stmtValidacion->get_result();

    if ($resultadoValidacion->num_rows > 0) {
        header("Location:../pages/formularioRegistroUsuario.php?usuario-existente=true");
        exit();
    } else {
        $stmtRegistro = $conexion->prepare("INSERT INTO usuarios (identificacion, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, rol, celular, correo, id_empresa, id_canal, id_cargo, id_regional, id_ciudad, fecha_contratacion, id_segmento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtRegistro->bind_param("sssssissiiiiisi", $identificacion, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $rol, $celular, $correo, $empresa, $canal, $cargo, $regional, $ciudad, $fechaContratacion, $segmento);

        if ($stmtRegistro->execute()) {
            header("Location:../pages/formularioRegistroUsuario.php?usuario-guardado=true");
            exit();
        } else {
            //error_log("Error en el registro: " . $stmtRegistro->error);
            header("Location:../pages/formularioRegistroUsuario.php?usuario-no-guardado=true");
            exit();
        }
    }
    $stmtValidacion->close();
    $stmtRegistro->close();
    $conexion->close();
} else {
    echo "Método no permitido";
}
?>
