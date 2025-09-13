<?php
include_once '../config.php';
include_once '../modelo/asistencia.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: ../vista/login/login.php');
    exit();
}

// Obtener parámetros de fechas
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : date('Y-m-01');
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : date('Y-m-d');

$asistenciaModel = new Asistencia();
$reporte = $asistenciaModel->obtenerReporte($fecha_inicio, $fecha_fin);

// Crear contenido HTML del reporte
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Asistencia</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>IE N° 207900000 "ANTONIO RAIMONDI"</h2>
        <h3>Reporte de Asistencia</h3>
        <p>Del ' . date('d/m/Y', strtotime($fecha_inicio)) . ' al ' . date('d/m/Y', strtotime($fecha_fin)) . '</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Empleado</th>
                <th>DNI</th>
                <th>Cargo</th>
                <th>Fecha</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Horas Trabajadas</th>
            </tr>
        </thead>
        <tbody>';

while ($fila = $reporte->fetch_assoc()) {
    $entrada = strtotime($fila['entrada']);
    $salida = $fila['salida'] ? strtotime($fila['salida']) : time();
    $horas_trabajadas = $fila['salida'] ? gmdate('H:i', $salida - $entrada) : '--:--';
    
    $html .= '
            <tr>
                <td>' . $fila['nombre'] . ' ' . $fila['apellido'] . '</td>
                <td>' . $fila['dni'] . '</td>
                <td>' . $fila['cargo'] . '</td>
                <td>' . date('d/m/Y', $entrada) . '</td>
                <td>' . date('H:i', $entrada) . '</td>
                <td>' . ($fila['salida'] ? date('H:i', strtotime($fila['salida'])) : '--:--') . '</td>
                <td>' . $horas_trabajadas . '</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Generar PDF
require_once '../lib/tcpdf/tcpdf.php';

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistema de Asistencia');
$pdf->SetTitle('Reporte de Asistencia');
$pdf->SetHeaderData('', 0, 'Reporte de Asistencia', 'IE N° 2079 "ANTONIO RAIMONDI"');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('reporte_asistencia.pdf', 'I');
?>