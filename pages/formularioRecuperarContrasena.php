<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/formularioRecuperarContrasenaStyles.css">
    <title>Document</title>
</head>
<body>
    <form class="form-container" action="../php/recuperarContrasena.php" method="post">
        <div class="contenedorIconoCerrarRC">
            <i class="far fa-window-close" id="iconoCerrarRC" style="color: #ffffff;" ></i>
        </div>
        <label for="inputCorreo">Ingresa tu correo</label>
        <input type="email" name="inputCorreo" id="inputCorreo" placeholder="example@email.com">
        <button type="submit">Recuperar</button>
    </form>
    <script src="../js/scriptAlertas.js"></script>
    <script src="../js/scriptModales.js"></script>
</body>
</html>