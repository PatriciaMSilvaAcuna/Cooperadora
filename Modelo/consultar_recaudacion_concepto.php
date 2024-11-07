<?php
header('Content-Type: application/json; charset=utf-8');
include_once('conexion.php');
$conn = conexion();

if (isset($_GET['idconcepto']) && isset($_GET['fechaInicio']) && isset($_GET['fechaFin'])) {
    $idconcepto = intval($_GET['idconcepto']);
    $fechaInicio = $_GET['fechaInicio'];
    $fechaFin = $_GET['fechaFin'];

    $sql = "SELECT idconcepto, SUM(valorabonado) AS total_recaudado 
            FROM cargapago 
            WHERE idconcepto = ? 
            AND fecha BETWEEN ? AND ? 
            GROUP BY idconcepto";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(['error' => 'Error en la preparación de la consulta.']);
        exit;
    }

    $stmt->bind_param("iss", $idconcepto, $fechaInicio, $fechaFin);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'idconcepto' => $row['idconcepto'],
            'total_recaudado' => number_format(floatval($row['total_recaudado']), 2, '.', '')
        ];
    }

    echo json_encode(['data' => $data]);
    $stmt->close();
} else {
    echo json_encode(['error' => 'Faltan parámetros: idconcepto, fechaInicio o fechaFin.']);
}

$conn->close();
?>
