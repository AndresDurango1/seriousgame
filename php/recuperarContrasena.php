<?php
    set_time_limit(300); // Aumenta el tiempo de ejecución máximo a 300 segundos

    include_once 'conexion.php';
    $conexion = conectar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = $_POST['inputCorreo'];

        $stmt = $conexion->prepare("SELECT usuario FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $token = bin2hex(random_bytes(50)); // Genera el token
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour')); // Tiempo de expiración del token

            $stmt = $conexion->prepare("UPDATE usuarios SET token = ?, token_expira = ? WHERE correo = ?");
            $stmt->bind_param("sss", $token, $expira, $correo);
            $stmt->execute();

            $enlace = "http://localhost/seriousgame/pages/formularioRestablecerContrasena.php?token=" . $token;

            // Datos para enviar en el cuerpo de la solicitud a Mailtrap
            $data = array(
                'from' => array(
                    //Remitente
                    'email' => 'soportejuego@email.com', 
                    'name' => 'Soporte'
                ),
                'to' => array(
                    array(
                        // Destinatario
                        'email' => $correo 
                    )
                ),
                'subject' => 'Recuperación de contraseña',
                'html' => 'Haz clic en el siguiente enlace para restablecer tu contraseña: <a href="' . $enlace . '">Restablecer contraseña</a>',
                'category' => 'Recuperación de contraseña'
            );

            // Inicializa cURL
            $ch = curl_init('https://sandbox.api.mailtrap.io/api/send/3219068');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para obtener la respuesta de la API
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer 905eec600f7b873a8446923ab168dc57', // Tu API token
                'Content-Type: application/json' // El contenido será JSON
            ));
            curl_setopt($ch, CURLOPT_POST, true); // Es una solicitud POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Convierte los datos a formato JSON

            // Ejecuta la solicitud
            $response = curl_exec($ch);

            // Manejo de errores de cURL
            if (curl_errno($ch)) {
                echo 'Error en la conexión cURL: ' . curl_error($ch);
            } else {
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($http_code == 200) {
                    echo 'El enlace para restablecer la contraseña ha sido enviado a tu correo electrónico.';
                } else {
                    echo 'Error al enviar el correo. Código HTTP: ' . $http_code;
                }
            }

            curl_close($ch); // Cierra cURL

        } else {
            echo "El correo electrónico no está registrado.";
        }
    }
?>
