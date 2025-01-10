<?php
    require '../vendor/autoload.php'; // Cargar PhpSpreadsheet
    include_once '../php/conexion.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;

    session_start();
    if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 0) {
        header("Location: ../pages/index.php");
        exit();
    }
    $conexion = conectar();
    // Crear un nuevo archivo de Excel
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    // Encabezados de la tabla
    $encabezados = ['Nombre Completo', 'Número Identificación', 'Usuario', 'Nivel', 'Estado Nivel', 'Inicio', 'Fin', 'Tiempo Transcurrido', 'Puntaje'];
    $sheet->fromArray($encabezados, null, 'A1');

    // Aplicar formato a los encabezados
    $styleEncabezados = [
        'font' => [
            'bold' => true,
            'color' => ['argb' => 'FFFFFF'],
            'size' => 12,
            'name' => 'Arial'
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['argb' => '4CAF50'],
        ],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];
    $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
    $sheet->getStyle('A1:I1')->applyFromArray($styleEncabezados);
    // Obtener los datos de la base de datos
    $query = "SELECT CONCAT(u.nombre, ' ', u.apellido) AS nombre_completo, u.identificacion, u.usuario AS usuario, n.nombre_nivel AS nivel, nu.completado, nu.inicio, nu.fin, nu.tiempo_transcurrido, nu.puntaje 
              FROM niveles_usuarios nu
              JOIN usuarios u ON nu.id_usuario = u.id_usuario
              JOIN niveles n ON nu.id_nivel = n.id_nivel
              WHERE nu.id_usuario = "  . $_SESSION['id_usuario'];
    $result = $conexion->query($query);
    // Agregar los datos al Excel
    $row = 2; // Comenzar en la segunda fila
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue("A$row", $data['nombre_completo']);
        $sheet->setCellValue("B$row", $data['identificacion']);
        $sheet->setCellValue("C$row", $data['usuario']);
        $sheet->setCellValue("D$row", $data['nivel']);
        $sheet->setCellValue("E$row", $data['completado'] ? 'Completado' : 'No Completado');
        $sheet->setCellValue("F$row", $data['inicio']);
        $sheet->setCellValue("G$row", $data['fin']);
        $sheet->setCellValue("H$row", $data['tiempo_transcurrido']);
        $sheet->setCellValue("I$row", $data['puntaje']);
        $row++;
    }
    // Aplicar formato a los datos
    $styleDatos = [
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_LEFT,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];
    $sheet->getStyle("A2:I" . ($row - 1))->applyFromArray($styleDatos);
    foreach (range('A', 'I') as $columna) {
        $sheet->getColumnDimension($columna)->setAutoSize(true);
    }
    // Obtener el nombre completo del usuario antes de procesar los datos
    $queryNombre = "SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo 
    FROM usuarios 
    WHERE id_usuario = " . $_SESSION['id_usuario'];
    $resultNombre = $conexion->query($queryNombre);
    $dataNombre = $resultNombre->fetch_assoc();
    $nombreCompleto = $dataNombre['nombre_completo'];
    $nombreArchivo = "reporte_individual_Las-aventuras-de-Go_" . str_replace(' ', '-', $nombreCompleto) . ".xlsx";
    
    // Encabezados para la descarga
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $nombreArchivo . '"');
    header('Cache-Control: max-age=0');    // Guardar el archivo en formato Excel y enviarlo al navegador
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
?>