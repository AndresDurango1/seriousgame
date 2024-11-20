<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../css/estilosformularioContrasena.css">
    <title>Document</title>

</head>
<body>
    
<div class="form-container">
    <div class="contenedorIconoCerrarIS">
        <i class="far fa-window-close" id="iconoCerrarIS"></i>
    </div>
    <form id="recuperarForm" action="../php/recuperarContrasena.php">
        <label for="inputCorreo">Ingresa tu correo</label>
        <input type="email" name="inputCorreo" id="inputCorreo" placeholder="ejemplo@correo.com" required>
        <button type="submit">Recuperar</button>
    </form>
    <div id="respuesta" style="margin-top: 10px; color: red;"></div> <!-- Para mostrar mensajes -->
</div>


<script src="./js/scriptAlertas.js"></script>

</body>
</html>
