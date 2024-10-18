<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="contenedorPrincipal">
        <div class="contenedorFormulario">
            <form class="formularioRegistro" action="../php/registroUsuarios.php" method="post">
                <label for="lblIdentificacion">Identificacion</label>
                <input type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa tu Numero de Identificacion" required>
                <label for="lblNombre">Nombre</label>
                <input type="text" name="inputNombre" id="inputNombre" placeholder="Ingresa tu Nombre" required>
                <label for="lblApellido">Apellido</label>
                <input type="text" name="inputApellido" id="inputApellido" placeholder="Ingresa tu Apellido" required>
                <label for="lblUsuario">Usuario</label>
                <input type="text" name="inputUsuario" id="inputUsuario" placeholder="Ingresa tu Usuario" required>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
                <label for="lblRol">Rol</label>
                <select name="inputRol" id="inputRol">
                    <option >Selecciona un Rol</option>
                    <option value="0">Usuario</option>
                    <option value="1">Administrador</option>                
                </select>
                <?php endif; ?>
                <label for="lblCorreo">Correo</label>
                <input type="email" name="inputCorreo" id="inputCorreo" placeholder="Ingresa tu Correo" required>
                <label for="lblContrasena">Contraseña</label>
                <input type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Contraseña" required>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>