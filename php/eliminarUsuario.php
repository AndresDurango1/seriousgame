<?php
    session_start();
    require_once '../php/conexion.php';
    $conexion = conectar();
    if (!$conexion) {
        header("Location:../pages/administrarUsuarios.php?connection-failed-error=true");
        exit();
    }
    if (isset($_GET['id_user']) && !empty($_GET['id_user'])) {
        $idUsuario = filter_var($_GET['id_user'], FILTER_VALIDATE_INT);
        if ($idUsuario === false) {
            header("Location:../pages/administrarUsuarios.php?delete-user-error=true&reason=invalid-id");
            exit();
        }
        $stmtDelete = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmtDelete->bind_param("i", $idUsuario);

        if ($stmtDelete->execute()) {
            header("Location:../pages/administrarUsuarios.php?delete-user-success=true");
        } else {
            header("Location:../pages/administrarUsuarios.php?delete-user-error=true&reason=query-failed");
        }
        $stmtDelete->close();
    } else {
        header("Location:../pages/administrarUsuarios.php?delete-user-error=true&reason=missing-id");
    }
?>
