<?php
// Define que la respuesta será JSON y establece el conjunto de caracteres en UTF-8
header('Content-Type: application/json; charset=utf-8');

// Incluye el archivo de conexión a la base de datos
include_once('conexion.php');

// Establece la conexión a la base de datos
$conn = conexion();

// Verifica que se hayan enviado los parámetros 'idconcepto', 'fechaInicio' y 'fechaFin' en la solicitud
if (isset($_GET['idconcepto']) && isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
     // Convierte 'idconcepto' en entero para evitar inyecciones SQL y obtener solo valores numéricos
    $idconcepto = intval($_GET['idconcepto']);
    // Obtiene los valores de fecha de inicio y fecha de fin desde la solicitud
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];
    
    // Consulta SQL para sumar el valor abonado para un concepto específico entre dos fechas dadas
    $sql = "SELECT idconcepto, SUM(valorabonado) AS total_recaudado 
            FROM cargapago 
            WHERE idconcepto = ? 
            AND fecha BETWEEN ? AND ? 
            GROUP BY idconcepto";

    // Prepara la consulta SQL
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Si hay un error al preparar la consulta, devuelve un mensaje de error en JSON y termina el script
        echo json_encode(['error' => 'Error en la preparación de la consulta.']);
        exit;
    }
    
    // Vincula los parámetros 'idconcepto' (entero), 'fechaInicio' y 'fechaFin' (cadenas) a la consulta
    $stmt->bind_param("iss", $idconcepto, $fechaInicio, $fechaFin);
    // Ejecuta la consulta SQL
    $stmt->execute();
    // Obtiene el resultado de la consulta
    $result = $stmt->get_result();

    // Inicializa un arreglo para almacenar los datos obtenidos
    $data = [];
    // Itera sobre los resultados obtenidos
    while ($row = $result->fetch_assoc()) {
         // Agrega cada fila al arreglo, formateando 'total_recaudado' con dos decimales
        $data[] = [
            'idconcepto' => $row['idconcepto'],
            'total_recaudado' => number_format(floatval($row['total_recaudado']), 2, '.', '')
        ];
    }
   
     // Envía los datos en formato JSON como respuesta
    echo json_encode(['data' => $data]);
    // Cierra la consulta preparada
    $stmt->close();
} else {
    // Si faltan parámetros en la solicitud, devuelve un mensaje de error en JSON
    echo json_encode(['error' => 'Faltan parámetros: idconcepto, fechaInicio o fechaFin.']);
}

// Cierra la conexión a la base de datos
$conn->close();
?>
