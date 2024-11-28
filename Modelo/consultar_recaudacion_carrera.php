<?php
// Mostrar todos los errores en la pantalla (solo en desarrollo, desactivar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Definir la respuesta como JSON
header('Content-Type: application/json; charset=utf-8');

// Incluir el archivo de conexión a la base de datos
include_once('conexion.php');

// Obtener la conexión
$conn = conexion();

// Verificar si la conexión es exitosa
if ($conn->connect_error) {
    die(json_encode(['error' => 'Error de conexión: ' . $conn->connect_error]));
}

// Verificar si se recibió el parámetro 'idcarrera'
if (isset($_GET['idcarrera'])) {
    $idcarrera = intval($_GET['idcarrera']); // Convertir a entero para evitar inyecciones SQL

    // Llamar al procedimiento almacenado
    $sql = "CALL obtener_recaudacion_carrera(?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Vincular el parámetro 'idcarrera' y ejecutar
        $stmt->bind_param("i", $idcarrera);
        $stmt->execute();

        // Obtener el primer conjunto de resultados (detalles)
        $result_detalles = $stmt->get_result();
        $detalles = [];
        while ($row = $result_detalles->fetch_assoc()) {
            $detalles[] = [
                'carrera' => $row['carrera'],
                'alumno' => $row['alumno'],
                'concepto' => $row['concepto'],
                'valorabonado' => number_format(floatval($row['valorabonado']), 2, '.', ''),
                'fecha' => $row['fecha']
            ];
        }

        // Mover al siguiente conjunto de resultados (total)
        $stmt->next_result();
        $result_total = $stmt->get_result();
        $total = 0;
        if ($row_total = $result_total->fetch_assoc()) {
            $total = number_format(floatval($row_total['total_recaudado']), 2, '.', '');
        }

        // Cerrar el statement
        $stmt->close();

        // Enviar la respuesta JSON
        echo json_encode([
            'total' => $total,
            'detalles' => $detalles
        ]);
    } else {
        // Error al preparar la consulta
        echo json_encode(['error' => 'No se pudo preparar la consulta.']);
    }
} else {
    // Si falta el parámetro 'idcarrera'
    echo json_encode(['error' => 'Falta el parámetro idcarrera.']);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
