<?php
require_once 'conexion.php';
require('fpdf.php');

$mysqli = conexion();

// Obtener el último idcargapago
$query = "SELECT idcargapago FROM cargapago ORDER BY idcargapago DESC LIMIT 1";
$result = $mysqli->query($query);

if ($result) {
    $row = $result->fetch_assoc();
   // Completa el idcargapago con ceros a la izquierda hasta 6 dígitos
    $idcargapago = str_pad($row['idcargapago'], 6, '0', STR_PAD_LEFT);
} else {
    echo json_encode(['error' => 'No se pudo obtener el último ID de carga de pago.']);
    exit();
}

// Obtener datos del pago
$sql = "SELECT alumno.dni, alumno.nombre, alumno.apellido, cargapago.valorabonado, cargapago.fecha, metodopago.metodopago 
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

// Agregar imagen en la cabecera
if (file_exists('../oldlogo.png')) {
    $pdf->Image('../oldlogo.png', 10, 8, 33); // Cambia la ruta de la imagen
}
$pdf->Ln(15); // Espacio después de la imagen

// Título en negrita y color negro
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(0, 0, 255); // Color azul
$pdf->Cell(0, 10, 'Comprobante de Pago', 0, 1, 'C');
$pdf->Ln(5); // Reducir espaciado

// Número de comprobante en cursiva y color negro
$pdf->SetFont('Arial', 'I', 12);
$pdf->SetTextColor(0, 0, 0);// Negro


$pdf->Cell(0, 10, 'Numero de Comprobante: 0001-' . $idcargapago, 0, 1, 'C');
$pdf->Ln(5); // Reducir espaciado

// Todo el texto en color negro
$pdf->SetTextColor(0, 0, 0);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Datos con nombre del campo en negrita y valor en texto normal
        $pdf->SetFont('Arial', 'B', 12); // Negrita para el nombre del campo
        $pdf->Cell(40, 10, "Nombre:", 0, 0);
        $pdf->SetFont('Arial', '', 12); // Texto normal para el valor
        $pdf->Cell(0, 10, $row['nombre'] . " " . $row['apellido'], 0, 1);

        $pdf->SetFont('Arial', 'B', 12); // Negrita para el nombre del campo
        $pdf->Cell(40, 10, "DNI:", 0, 0);
        $pdf->SetFont('Arial', '', 12); // Texto normal para el valor
        $pdf->Cell(0, 10, $row['dni'], 0, 1);

        $pdf->SetFont('Arial', 'B', 12); // Negrita para el nombre del campo
        $pdf->Cell(40, 10, "Valor Abonado:", 0, 0);
        $pdf->SetFont('Arial', '', 12); // Texto normal para el valor
        $pdf->Cell(0, 10, "$" . number_format($row['valorabonado'], 2), 0, 1);

        $pdf->SetFont('Arial', 'B', 12); // Negrita para el nombre del campo
        $pdf->Cell(40, 10, "Fecha:", 0, 0);
        $pdf->SetFont('Arial', '', 12); // Texto normal para el valor
        $pdf->Cell(0, 10, date("d/m/Y", strtotime($row['fecha'])), 0, 1);

        $pdf->SetFont('Arial', 'B', 12); // Negrita para el nombre del campo
        $pdf->Cell(40, 10, utf8_decode("Método de Pago:"), 0, 0);
        $pdf->SetFont('Arial', '', 12); // Texto normal para el valor
        $pdf->Cell(0, 10, $row['metodopago'], 0, 1);

        $pdf->Ln(5); // Espacio entre registros

        // Texto de agradecimiento centrado y en cursiva
        $pdf->SetFont('Arial', 'I', 12);
        
        $pdf->Cell(0, 10, utf8_decode('¡Gracias por su pago!'), 0, 0, 'C');
    }
} else {
    $pdf->SetFont('Arial', 'B', 12); // Negrita en caso de error
    $pdf->Cell(0, 10, 'No se encontraron datos para el último ID de carga de pago.', 0, 1);
}

// Pie de página
$pdf->SetY(-30); // Ajusta el pie de página más cerca del borde
$pdf->SetFont('Arial', 'I', 10);
//$pdf->Cell(0, 10, 'Este es un comprobante generado automáticamente.', 0, 0, 'C');

// Salida del archivo
$pdf->Output('D', 'comprobante_pago.pdf');

$stmt->close();
$mysqli->close();
?>
