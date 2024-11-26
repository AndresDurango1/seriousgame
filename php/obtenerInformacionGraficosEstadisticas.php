<?php
include_once '../php/conexion.php';
$conexion = conectar();

//Consulta 1 a la base de datos para los Jugadores con los 10 mejores puntajes acumulados
$stmt1 = "SELECT u.usuario, CONCAT(u.nombre, ' ', u.apellido, ' (', u.identificacion, ')') AS Nombre_Completo, SUM(nu.puntaje) AS puntaje_total 
              FROM usuarios u
              JOIN niveles_usuarios nu ON u.id_usuario = nu.id_usuario
              GROUP BY u.id_usuario
              ORDER BY puntaje_total DESC 
              LIMIT 10;";
$result1 = $conexion->query($stmt1);
//Arreglos para almacenar la informacion en el JSON
$stmt1_usuarios = [];
$stmt1_puntajes = [];
$stmt1_leyendas = [];
while ($fila = $result1->fetch_assoc()) {
    $stmt1_usuarios[] = $fila['usuario'];
    $stmt1_puntajes[] = $fila['puntaje_total'];
    $stmt1_nombres_completos[] = $fila['Nombre_Completo'];
}
//Consulta 2 a la base de datos para los Jugadores con los 10 peores puntajes acumulados
$stmt2 = "SELECT u.usuario, CONCAT(u.nombre, ' ', u.apellido, ' (', u.identificacion, ')') AS Nombre_Completo, COALESCE(SUM(nu.puntaje)) AS puntaje_total 
    FROM usuarios u
    LEFT JOIN niveles_usuarios nu ON u.id_usuario = nu.id_usuario
    GROUP BY u.id_usuario
    ORDER BY puntaje_total ASC 
    LIMIT 10;";
$result2 = $conexion->query($stmt2);
//Arreglos para almacenar la informacion en el JSON
$stmt2_usuarios = [];
$stmt2_puntajes = [];
$stmt2_leyendas = [];
while ($fila = $result2->fetch_assoc()) {
    $stmt2_usuarios[] = $fila['usuario'];
    $stmt2_puntajes[] = $fila['puntaje_total'];
    $stmt2_nombres_completos[] = $fila['Nombre_Completo'];
}
//Consulta 3 a la base de datos para traer el puntaje promedio de los usuarios por nivel
$stmt3 = "SELECT u.usuario, n.nombre_nivel AS nivel, nu.id_nivel, AVG(nu.puntaje) AS puntaje_promedio FROM usuarios u
    JOIN niveles_usuarios nu ON u.id_usuario = nu.id_usuario
    JOIN niveles n ON nu.id_nivel = n.id_nivel
    GROUP BY u.id_usuario, nu.id_nivel
    ORDER BY puntaje_promedio DESC
    LIMIT 10;";
$result3 = $conexion->query($stmt3);
//Arreglos para almacenar la informacion en el JSON
$stmt3_usuarios = [];
$stmt3_niveles = [];
$stmt3_puntajes = [];
while ($fila = $result3->fetch_assoc()) {
    $stmt3_usuarios[] = $fila['usuario'];
    $stmt3_niveles[] = $fila['nivel'];
    $stmt3_puntajes[] = $fila['puntaje_promedio'];
}
//Consulta 4 a la base de datos para traer el tiempo transcurrido para completar un nivel
$stmt4 = "SELECT u.usuario, n.nombre_nivel AS nivel, nu.id_nivel, nu.tiempo_transcurrido FROM usuarios u
    JOIN niveles_usuarios nu ON u.id_usuario = nu.id_usuario
    JOIN niveles n ON nu.id_nivel = n.id_nivel
    GROUP BY u.id_usuario, nu.id_nivel
    ORDER BY tiempo_transcurrido ASC
    LIMIT 10;";
$result4 = $conexion->query($stmt4);
//Arreglos para almacenar la informacion en el JSON
$stmt4_usuarios = [];
$stmt4_niveles = [];
$stmt4_tiempo = [];
while ($fila = $result4->fetch_assoc()) {
    $stmt4_usuarios[] = $fila['usuario'];
    $stmt4_niveles[] = $fila['nivel'];
    $stmt4_tiempo[] = $fila['tiempo_transcurrido'];
}
//Consulta 5 a la base de datos para traer los generos de los usuarios
$stmt5 = "SELECT c.id_genero, COUNT(*) AS cantidad, g.genero FROM caracterizacion c
    JOIN generos g ON c.id_genero = g.id_genero 
    GROUP BY c.id_genero;";
$result5 = $conexion->query($stmt5);
$stmt5_generos = [];
$stmt5_cantidad = [];
while ($fila = $result5->fetch_assoc()) {
    $stmt5_generos[] = $fila['genero'];
    $stmt5_cantidad[] = $fila['cantidad'];
}
//Consulta 5 a la base de datos para traer las edades
$stmt6 = "SELECT c.fecha_nacimiento, TIMESTAMPDIFF(YEAR, c.fecha_nacimiento, CURDATE()) AS edad, c.id_usuario, u.usuario FROM caracterizacion c
    JOIN usuarios u ON c.id_usuario = u.id_usuario";
$result6 = $conexion->query($stmt6);
$stmt6_edades = [];
$stmt6_usuarios = [];
$stmt6_rangos = [
    '18-' => 0,
    '20-30' => 0,
    '31-40' => 0,
    '41-50' => 0,
    '51-60' => 0,
    '61+'   => 0
];
while ($fila = $result6->fetch_assoc()) {
    $edad = $fila['edad'];
    $usuario = $fila['usuario'];
    $stmt6_edades[] = $edad;
    $stmt6_usuarios[] = $usuario;
    if ($edad >= 0 && $edad <=19) {
        $stmt6_rangos['18-']++;
    }
    if ($edad >= 20 && $edad <= 30) {
        $stmt6_rangos['20-30']++;
    } elseif ($edad >= 31 && $edad <= 40) {
        $stmt6_rangos['31-40']++;
    } elseif ($edad >= 41 && $edad <= 50) {
        $stmt6_rangos['41-50']++;
    } elseif ($edad >= 51 && $edad <= 60) {
        $stmt6_rangos['51-60']++;
    } elseif ($edad >= 61) {
        $stmt6_rangos['61+']++;
    }
}
//Estrutura la informacion en formato JSON
$response = [
    'topScores' => [
        'usuarios' => $stmt1_usuarios,
        'puntajes' => $stmt1_puntajes,
        'nombres_completos' => $stmt1_nombres_completos
    ],
    'bottomScores' => [
        'usuarios' => $stmt2_usuarios,
        'puntajes' => $stmt2_puntajes,
        'nombres_completos' => $stmt2_nombres_completos
    ],
    'averageScores' => [
        'usuarios' => $stmt3_usuarios,
        'niveles' => $stmt3_niveles,
        'puntajes' => $stmt3_puntajes
    ],
    'bestTimes' => [
        'usuarios' => $stmt4_usuarios,
        'niveles' => $stmt4_niveles,
        'tiempo_transcurrido' => $stmt4_tiempo
    ],
    'generos' => [
        'generos' => $stmt5_generos,
        'cantidad' => $stmt5_cantidad
    ],
    'edades' => [
        'usuarios' => $stmt6_usuarios,
        'edades' => $stmt6_edades,
        'rangos' => $stmt6_rangos
    ]
];
//Generacion del JSON
echo json_encode($response);
