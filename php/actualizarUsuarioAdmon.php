<?php
include_once 'conexion.php';
$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = intval($_POST['inputId']);
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
    $segmento = intval($_POST['inputSegmento']);

    $stmtUpdate = $conexion->prepare("UPDATE usuarios SET identificacion =?, primer_nombre =?, segundo_nombre =?, primer_apellido =?, segundo_apellido =?, rol =?, celular =?, correo =?, id_empresa =?, id_canal =?, id_cargo =?, id_regional =?, id_ciudad =?, id_segmento =? WHERE id_usuario =?");
    $stmtUpdate->bind_param("sssssissiiiiiii", $identificacion, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $rol, $celular, $correo, $empresa, $canal, $cargo, $regional, $ciudad, $segmento, $id_usuario);

    if ($stmtUpdate->execute()) {
        header("Location:../pages/administrarUsuarios.php?usuario-actualizado=true");
        exit();
    } else {
        header("Location:../pages/administrarUsuarios.php?usuario-no-actualizado=true");
        exit();
    }
    $stmt->close();
    $conexion->close();
}
?>
