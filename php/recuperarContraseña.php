<?php

    require '../vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    include_once 'conexion.php';
    $conexion = conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST['inputCorreo'];

        $stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows>0)
        {
            $token = bin2hex(random_bytes(50));
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $stmt = $conexion->prepare("UPDATE usuarios SET token = ?, token_expira = ? WHERE correo = ?");
            $stmt->bind_param("sss", $token, $expira, $correo);
            $stmt->execute();
            $enlace = "http://localhost/seriousgame/php/formularioRestablecerContraseña.php?token=".$token;
            $mail = new PHPMailer(true);
            try {
            // Configuración del servidor SMTP de Mailtrap
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '8770f64949b88e'; 
            $mail->Password = '76765441348773'; 
            $mail->SMTPSecure = 'tls'; 
            $mail->Port = 2525; 
            
            // Configuración del correo
            $mail->setFrom('durangoandres553@gmail.com', 'Andres Durango'); // Remitente
            $mail->addAddress($correo);
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = 'Haz clic en el siguiente enlace para restablecer tu contraseña: <a href="' . $enlace . '">Restablecer contraseña</a>';

            $mail->send();
            echo 'El enlace para restablecer la contraseña ha sido enviado a tu correo electrónico.';
            } catch (Exception $e) {
                echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
            }
        } 
        else {
            echo "El correo electrónico no está registrado.";
        }
    
    }
?>