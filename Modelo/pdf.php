<?php
require_once 'conexion.php';
require('fpdf.php');

$mysqli = conexion();

// Obtener el último idcargapago
$query = "SELECT idcargapago FROM cargapago ORDER BY idcargapago DESC LIMIT 1";
$result = $mysqli->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $idcargapago = $row['idcargapago'];
} else {
    echo json_encode(['error' => 'No se pudo obtener el último ID de carga de pago.']);
    exit();
}

// Obtener datos del pago
$sql = "SELECT usuario.dniusuario, alumno.nombre, alumno.apellido, cargapago.valorabonado, cargapago.fecha, metodopago.metodopago 
        FROM cargapago 
        INNER JOIN alumno ON cargapago.idalumno = alumno.idalumno 
        INNER JOIN usuario ON usuario.idusuario = cargapago.idusuario 
        INNER JOIN metodopago ON cargapago.idmetodopago = metodopago.idmetodopago 
        WHERE cargapago.idcargapago = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $idcargapago);
$stmt->execute();
$result = $stmt->get_result();

$pdf = new FPDF();
$pdf->AddPage();

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Comprobante de Pago', 0, 1, 'C');
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nombre', 1);
$pdf->Cell(40, 10, 'Apellido', 1);
$pdf->Cell(40, 10, 'DNI', 1);
$pdf->Cell(40, 10, 'Valor Abonado', 1);
$pdf->Cell(40, 10, 'Fecha', 1);
$pdf->Cell(40, 10, 'Método de Pago', 1);
$pdf->Ln();

// Datos de los pagos
$pdf->SetFont('Arial', '', 12);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['nombre'], 1);
        $pdf->Cell(40, 10, $row['apellido'], 1);
        $pdf->Cell(40, 10, $row['dniusuario'], 1);
        $pdf->Cell(40, 10, '$' . number_format($row['valorabonado'], 2), 1);
        $pdf->Cell(40, 10, date("d/m/Y", strtotime($row['fecha'])), 1);
        $pdf->Cell(40, 10, $row['metodopago'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No se encontraron datos para el último ID de carga de pago.', 0, 1);
}

// Pie de página
$pdf->SetY(-30);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Gracias por su pago!', 0, 0, 'C');

$pdf->Output('D', 'comprobante_pago.pdf');

$stmt->close();
$mysqli->close();
?>
