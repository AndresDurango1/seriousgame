<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <?php
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        echo '
        <form action="restablecerContrasena.php" method="POST">
            <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
            <label for="inputNuevaContrasena">Nueva Contraseña</label>
            <input type="password" name="inputNuevaContrasena" required>
            <button type="submit">Restablecer Contraseña</button>
        </form>';
    } else {
        echo "Token no válido.";
    }
    ?>
</body>
</html>
