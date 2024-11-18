<?php
    session_start();
    if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 0) {
        header("Location: ../pages/index.php");
        exit();
    }
    include_once '../php/conexion.php';
    $conexion = conectar();
    $id_usuario = $_SESSION['id_usuario'];

    $limit = 2; // Número de registros por página
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $stmt = $conexion->prepare("SELECT nu.id_usuario, u.usuario AS usuario, nu.id_nivel, n.nombre_nivel AS nivel, nu.completado, nu.inicio, nu.fin, nu.tiempo_transcurrido, 
                                nu.puntaje FROM niveles_usuarios nu
                                JOIN 
                                    usuarios u ON nu.id_usuario = u.id_usuario
                                JOIN 
                                    niveles n ON nu.id_nivel = n.id_nivel 
                                WHERE nu.id_usuario = ?
                                LIMIT ? OFFSET ?");
    
    $stmt ->bind_param("iii", $id_usuario, $limit, $offset);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $totalQuery = "SELECT COUNT(*) as total FROM niveles_usuarios WHERE id_usuario = ?";
    $totalStmt = $conexion->prepare($totalQuery);
    $totalStmt->bind_param("i", $id_usuario);
    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    $totalRow = $totalResult->fetch_assoc();
    $totalUsers = $totalRow['total'];
    $totalPages = ceil($totalUsers / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="barraNavegacion">
        <h1>Bienvenid@ <?php echo $_SESSION['usuario']; ?></h1>
    </nav>
    <div class="contenedorPrincipal">
        <aside class="barraLateral">
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
        <div class="">
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nivel</th>
                        <th>Estado Nivel</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Tiempo transcurrido</th>
                        <th>Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($fila = $resultado->fetch_assoc()) 
                        {
                            echo "<tr>";
                            echo "<td>" ."@". $fila['usuario'] . "</td>";
                            echo "<td>" . $fila['nivel'] . "</td>";
                            echo "<td>" . ($fila['completado'] ? 'Completado' : 'No Completado') . "</td>";
                            echo "<td>" . $fila['inicio']."</td>";
                            echo "<td>" . $fila['fin']."</td>";
                            echo "<td>" . $fila['tiempo_transcurrido'] . "</td>";
                            echo "<td>" . $fila['puntaje'] . "</td>";
                            echo "</tr>";
                        }
                ?>
                </tbody>
            </table>
            <div class="paginacion">
                <?php
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=$i'>$i</a> ";
                }
                ?>
            </div>
 
        </div>
    </div>
    <script src="../js/scriptPaginacion.js"></script>
</body>
</html>