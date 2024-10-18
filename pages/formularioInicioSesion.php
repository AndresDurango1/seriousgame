<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../php/login.php" method="POST">
        <label for="inputUsuario">Usuario</label>
        <input type="text" name="inputUsuario" id="inputUsuario" required>

        <label for="inputContrasena">Contraseña</label>
        <input type="password" name="inputContrasena" id="inputContrasena" required>

        <button type="submit">Iniciar sesión</button>
    </form>

</body>
</html>