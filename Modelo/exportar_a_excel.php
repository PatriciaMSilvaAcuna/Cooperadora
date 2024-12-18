
<?php
// Define que la respuesta será JSON y establece el conjunto de caracteres en UTF-8
header('Content-Type: application/json; charset=utf-8');

// Incluye el archivo de conexión a la base de datos
include_once('conexion.php');

// Establece la conexión a la base de datos
$conn = conexion();

if (isset($_GET['idconcepto'], $_GET['fechaInicio'], $_GET['fechaFin'])) {
    $idConcepto = intval($_GET['idconcepto']);
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];

    // Consulta optimizada con filtros de idconcepto y rango de fechas
    $sql = "
        SELECT cp.idcargapago, cp.fecha, cp.valorabonado, u.dniusuario AS usuario, mp.metodopago AS metodopago, a.apellido AS alumno, c.concepto AS concepto
        FROM cargapago cp
        JOIN usuario u ON cp.idusuario = u.idusuario
        JOIN metodopago mp ON cp.idmetodopago = mp.idmetodopago
        JOIN alumno a ON cp.idalumno = a.idalumno
        JOIN concepto c ON cp.idconcepto = c.idconcepto
        WHERE cp.idconcepto = ? AND cp.fecha BETWEEN ? AND ?
    ";
    // Prepara la consulta SQL
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Si hay un error al preparar la consulta, devuelve un mensaje de error en JSON y termina el script
        echo json_encode(['error' => 'Error en la preparación de la consulta.']);
        exit;
    }
     // Vincula los parametros
    $stmt->bind_param("iss", $idConcepto, $fechaInicio, $fechaFin);
    // Ejecuta la consulta SQL
    $stmt->execute();

    // Obtiene el resultado de la consulta.
    $result = $stmt->get_result();

    // Nombre del archivo CSV
    $fileName = 'recaudacion_export_' . date('Y-m-d') . '.csv';

    // Cabeceras para forzar la descarga del archivo CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');

    // Abrir la salida en modo escritura para el archivo CSV
    $output = fopen('php://output', 'w');

    // Escribir los encabezados de columna
    fputcsv($output, ['ID Pago', 'Fecha', 'Valor Abonado', 'Usuario', 'Metodo Pago', 'Alumno', 'Concepto']);

    // Escribir los datos de la consulta en el archivo CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['idcargapago'],
            $row['fecha'],
            $row['valorabonado'],
            $row['usuario'],
            $row['metodopago'],
            $row['alumno'],
            $row['concepto']
        ]);
    }

    // Cerrar el archivo CSV
    fclose($output);
    // Cierra la consulta
    $stmt->close();
} else {
    echo json_encode(['error' => 'Faltan parámetros de consulta.']);
}

// Cierra la conexión a la BBDD
$conn->close();
?>
