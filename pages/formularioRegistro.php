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
            <form class="formularioRegistro" action="../php/registroUsuarios.php">
                <label for="lblIdentificacion">Identificacion</label>
                <input type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa tu Numero de Identificacion" require>
                <label for="lblNombre">Nombre</label>
                <input type="text" name="inputNombre" id="inputNombre" placeholder="Ingresa tu Nombre" require>
                <label for="lblApellido">Apellido</label>
                <input type="text" name="inputApellido" id="inputApellido" placeholder="Ingresa tu Apellido" require>
                <label for="lblUsuario">Usuario</label>
                <input type="text" name="inputUsuario" id="inputUsuario" placeholder="Ingresa tu Usuario" require>
                <label for="lblCorreo">Correo</label>
                <input type="email" name="inputCorreo" id="inputCorreo" placeholder="Ingresa tu Correo" require>
                <label for="lblContrasena">Contraseña</label>
                <input type="password" name="inputContrasena" id="inputContrasena" placeholder="Ingresa tu Contraseña" require>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>