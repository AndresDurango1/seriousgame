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
            header("Location:../pages/administrarUsuarios.php?id-user-error=true");
            //Mostrar alerta debido a que el id_user no es valido
            exit();
        }
        $stmtDelete = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmtDelete->bind_param("i", $idUsuario);
        if ($stmtDelete->execute()) {
            header("Location:../pages/administrarUsuarios.php?delete-user-success=true");
            //Mostrar alerta debido a que el usuario se elimino correctamente
        } else {
            header("Location:../pages/administrarUsuarios.php?delete-user-error=true");
            //Mostrar alerta debido a que ocurrio un error al eliminar el usuario
        }
        $stmtDelete->close();
    } else {
        header("Location:../pages/administrarUsuarios.php?missing-id-user=true");
        //Mostrar alerta debido a que falta el id_user en la consulta
    }
?>
