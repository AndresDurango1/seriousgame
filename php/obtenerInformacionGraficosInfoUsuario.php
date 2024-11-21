<?php
session_start();
include_once '../php/conexion.php';
$conexion = conectar();
//Consulta a la base de datos para traer los niveles completados por el usuario
$stmt1 = $conexion->prepare("SELECT n.nombre_nivel, 
                                SUM(CASE WHEN nu.completado = 1 THEN 1 ELSE 0 END) AS completados, 
                                SUM(CASE WHEN nu.completado = 0 THEN 1 ELSE 0 END) AS no_completados 
                                FROM niveles_usuarios nu
                                JOIN niveles n ON nu.id_nivel = n.id_nivel
                                WHERE nu.id_usuario = ?
                                GROUP BY n.nombre_nivel
                                ORDER BY nu.id_usuario ASC, nu.id_nivel ASC");
$stmt1 ->bind_param("s", $_SESSION['id_user']);
$stmt1 -> execute();
$result1 = $stmt1->get_result();
//Arreglos para almacenar la información en el JSON
$stmt1_nombre_niveles = [];
$stmt1_completados = [];
$stmt1_no_completados = [];
while ($fila = $result1->fetch_assoc()) {
    $stmt1_nombre_niveles[] = $fila['nombre_nivel'];
    $stmt1_completados[] = $fila['completados'];
    $stmt1_no_completados[] = $fila['no_completados'];
}
//Consulta a la base de datos para traer el puntaje promedio del usuario en cada nivel
$stmt2 = $conexion ->prepare("SELECT n.nombre_nivel, AVG(nu.puntaje) AS puntaje_promedio 
                                FROM niveles_usuarios nu
                                JOIN niveles n ON nu.id_nivel = n.id_nivel
                                WHERE nu.id_usuario = ?
                                GROUP BY n.nombre_nivel
                                ORDER BY nu.id_usuario ASC, nu.id_nivel ASC");
$stmt2 ->bind_param("s", $_SESSION['id_user']);
$stmt2->execute();
$result2 = $stmt2->get_result();
//Arreglos para almacenar la información en el JSON
$stmt2_nombres_niveles = [];
$stmt2_puntajes_promedios = [];
while ($fila = $result2->fetch_assoc()) {
    $stmt2_nombres_niveles[] = $fila['nombre_nivel'];
    $stmt2_puntajes_promedios[] = $fila['puntaje_promedio'];
}
//Consulta a la base de datos para traer la informacion del tiempo transcurrido en cada nivel
$stmt3 = $conexion->prepare("SELECT n.nombre_nivel, SEC_TO_TIME(AVG(TIME_TO_SEC(nu.tiempo_transcurrido))) AS tiempo_promedio
                                FROM niveles_usuarios nu
                                JOIN niveles n ON nu.id_nivel = n.id_nivel
                                WHERE nu.id_usuario = ?
                                GROUP BY nu.id_nivel
                                ORDER BY nu.id_nivel ASC");
$stmt3->bind_param("s", $_SESSION['id_user']);
$stmt3->execute();
$result3 = $stmt3->get_result();

// Arreglos para almacenar la información en el JSON
$stmt3_nombres_niveles = [];
$stmt3_tiempos_transcurridos = [];
while ($fila = $result3->fetch_assoc()) {
    $stmt3_nombres_niveles[] = $fila['nombre_nivel'];
    $stmt3_tiempos_transcurridos[] = $fila['tiempo_promedio'];
}
//Estructura la información en formato JSON
$response = [
    'partidas' => [
        'nombre_nivel' => $stmt1_nombre_niveles,
        'completados' => $stmt1_completados,
        "no_completados" => $stmt1_no_completados
    ],
    'averageScores' => [
        'niveles' => $stmt2_nombres_niveles,
        'puntajes' => $stmt2_puntajes_promedios,
    ],
    'tiemposTranscurridos' => [
        'niveles' => $stmt3_nombres_niveles,
        'tiempo' => $stmt3_tiempos_transcurridos
    ]
];
//Generación del JSON
echo json_encode($response);
?>
