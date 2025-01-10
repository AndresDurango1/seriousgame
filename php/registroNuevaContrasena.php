<?php
    include_once 'conexion.php';
    $conexion = conectar();
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $identificacion = $_POST['inputIdentificacion'];
        $contrasena = $_POST['inputContrasena'];
        $confirmarContrasena = $_POST['inputConfirmarContrasena'];
        $id_imagen = $_POST['inputIdImagenPerfil'];
        $stmt = $conexion->prepare("SELECT id_usuario, identificacion FROM usuarios WHERE identificacion = ?");
        $stmt->bind_param("s", $identificacion);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $id_usuario = $resultado->fetch_assoc()['id_usuario'];

        if ($resultado->num_rows > 0) {
            if($contrasena == $confirmarContrasena) {
                $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);
                $stmtUpdate = $conexion->prepare("UPDATE usuarios SET contrasena = ?, id_imagen = ? WHERE id_usuario =  ?");
                $stmtUpdate->bind_param("sii", $contrasena_encriptada, $id_imagen, $id_usuario);
                $stmtUpdate->execute();
                $stmtUpdate->close();
                header("Location:../pages/index.php?perfil-completado=true");
                exit();    
            } else {
                echo "Las contraseñas no coinciden.";
            }
        }
        $stmt->close();
        $conexion->close();    
    }
    else {
        echo "Método no permitido";
    }
?>
