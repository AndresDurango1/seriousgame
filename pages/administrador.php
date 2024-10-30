<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Las Aventuras de GO</title>
    <link rel="stylesheet" href="../css/styleadmi.css">
    </head>
<body>
    <!-- Modal para agregar usuario -->
    <div id="modalFormAdd" class="modal" style="display: none; ">
        <div class="modal-content">
            <span class="close" onclick="cerrarModalAdd()">&times;</span>
            <h2>Añadir Usuario</h2>
            <form action="../php/registroUsuarios.php" method="post">
                <label for="identificacion">Identificación</label>
                <input type="number" name="identificacion" id="identificacion" placeholder="Ingresa la Identificación" required>

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ingresa el Nombre" required>

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" placeholder="Ingresa el Apellido" required>

                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ingresa el Usuario" required>

                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" placeholder="Ingresa el Correo" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingresa la Contraseña" required>

                <label for="rol">Rol</label>
                <select name="rol" id="rol" required>
                    <option value="administrador">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>

                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Modal para actualizar datos -->
    <div id="modalFormUpdate" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="cerrarModalUpdate()">&times;</span>
            <h2>Actualizar Datos Personales</h2>
            <form action="../php/actualizarDatos.php" method="post">
                <label for="identificacion">Identificación</label>
                <input type="number" name="identificacion" id="identificacion" placeholder="Ingresa la Identificación" required>

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Ingresa el Nombre" required>

                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" placeholder="Ingresa el Apellido" required>

                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Ingresa el Usuario" required>

                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" placeholder="Ingresa el Correo" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingresa la Contraseña" required>

                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" required>

                <label for="departamento">Departamento</label>
                <input type="text" name="departamento" id="departamento" placeholder="Ingresa el Departamento" required>

                <label for="ciudad">Ciudad</label>
                <input type="text" name="ciudad" id="ciudad" placeholder="Ingresa la Ciudad" required>

                <label for="genero">Género</label>
                <select name="genero" id="genero" required>
                    <option value="femenino">Femenino</option>
                    <option value="masculino">Masculino</option>
                </select>

                <label for="grupo_etnico">Grupo Étnico</label>
                <select name="grupo_etnico" id="grupo_etnico" required>
                    <option value="indigena">Indígena</option>
                    <option value="afrodescendiente">Afrodescendiente</option>
                    <option value="mestizo">Mestizo</option>
                    <option value="otro">Otro</option>
                </select>

                <label for="celular">Celular</label>
                <input type="tel" name="celular" id="celular" placeholder="Ingresa el Número de Celular" required>

                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <div class="alerta" id="alerta">
        <p>Por favor actualizar datos personales</p>
        <div>
            <button class="boton-quizas" onclick="cerrarAlerta()">Quizás más tarde</button>
            <button class="boton-actualizar" onclick="actualizarDatos()">Actualizar</button>
        </div>
    </div>

    <!-- Encabezado -->
    <header>
        <div class="logo">
            <h1>Las Aventuras de GO</h1>
        </div>
        <div class="user-info">
            <img src="../recursos/img/avatar2.jpg" alt="Avatar de Usuario" class="avatar">
            <span>(#usuario)</span>
        </div>
        <nav class="nav-icons">
            <a href="javascript:void(0);" onclick="abrirModalAdd()">
                <img src="../recursos/img/añadirU.PNG" alt="Añadir Usuario">
            </a>
            <a href="../pages/index.php"><img src="../recursos/img/CERRARS.PNG" alt="Cerrar sesión"></a>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main>
        <!-- Barra lateral -->
        <aside class="sidebar">
            <h2>Mi perfil</h2>
            <form class="formularioRegistro" action="../php/registroUsuarios.php" method="post">
                <label for="lblIdentificacion">Identificación</label>
                <input type="number" name="inputIdentificacion" id="inputIdentificacion" placeholder="Ingresa tu Número de Identificación" required>
                <label for="lblNombre">Nombre</label>
                <input type="text" name="inputNombre" id="inputNombre" placeholder="Ingresa tu Nombre" required>
                <label for="lblApellido">Apellido</label>
                <input type="text" name="inputApellido" id="inputApellido" placeholder="Ingresa tu Apellido" required>
                <label for="lblUsuario">Usuario</label>
                <input type="text" name="inputUsuario" id="inputUsuario" placeholder="Ingresa tu Usuario" required>
            </form>
        </aside>
        
           <!-- Sección principal -->
           <section class="main-content">
                <!-- Banners de los mejores jugadores -->
                <section class="top-players">
                    <div class="player-card">
                        <img src="../recursos/img/avatar1.jpg" alt="Avatar" class="player-avatar">
                        <p>@SkyW</p>
                        
                    </div>
                    <div class="player-card first">
                        <img src="../recursos/img/avatar3.jpg" alt="Avatar" class="player-avatar">
                        <p>@Aethr</p>
                    </div>
                    <div class="player-card">
                        <img src="../recursos/img/avatar.jpg" alt="Avatar" class="player-avatar">
                        <p>@Elmnt</p>
                    </div>
                </section>
                <!-- Barra de búsqueda -->
                <section class="search-section">
                    <input type="text" placeholder="Buscar...">
                </section>
                <!-- Tabla de Ranking -->
                <section class="ranking">
                    <table>
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Id Mundo</th>
                                <th>Puntaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>@AethrKnight</td>
                                <td>1º</td>
                                <td>1234</td>
                            </tr>
                            <tr>
                                <td>@SkyWarr</td>
                                <td>2º</td>
                                <td>1233</td>
                            </tr>
                            <!-- Más filas -->
                        </tbody>
                    </table>
                </section>
            </section>
            </aside>
        </main>
    <script>
        function cerrarAlerta() {
            document.getElementById("alerta").style.display = "none";
        }
        
        function actualizarDatos() {
            document.getElementById("modalFormUpdate").style.display = "block";
        }

        function cerrarModalUpdate() {
            document.getElementById("modalFormUpdate").style.display = "none";
        }

        function abrirModalAdd() {
            document.getElementById("modalFormAdd").style.display = "flex"; // Usar flex para centrar
        }

        function cerrarModalAdd() {
            document.getElementById("modalFormAdd").style.display = "none";
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            var modalUpdate = document.getElementById("modalFormUpdate");
            var modalAdd = document.getElementById("modalFormAdd");
            if (event.target == modalUpdate) {
                modalUpdate.style.display = "none";
            } else if (event.target == modalAdd) {
                modalAdd.style.display = "none";
            }
        }
    </script>
</body>
</html>