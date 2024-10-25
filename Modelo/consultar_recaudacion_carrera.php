<?php
// /Modelo/consultar_recaudacion_carrera.php

header('Content-Type: application/json; charset=utf-8'); // Definir que la respuesta será JSON

include_once('conexion.php');

$conn = conexion(); // Obtener conexión

// Verificar si el idcarrera ha sido enviado
if (isset($_GET['idcarrera'])) {
    $idcarrera = intval($_GET['idcarrera']); // Asegurarse de que sea entero

    // Consulta para sumar todos los pagos, pero solo sumar la cuota social (concepto = 2) una vez para la primera carrera del alumno
    $sql = "
        SELECT i.idcarrera, SUM(cp.valorabonado) AS total_recaudado
        FROM inscripcion i
        INNER JOIN cargapago cp ON i.idalumno = cp.idalumno
        WHERE i.idcarrera = ?
        AND (cp.idconcepto != 2 -- Sumar todos los conceptos excepto la cuota social
        OR (cp.idconcepto = 2 
            AND i.idinscripcion IN (
                -- Solo sumar la cuota social para la primera inscripción del alumno
                SELECT MIN(i2.idinscripcion)
                FROM inscripcion i2
                WHERE i2.idalumno = i.idalumno
            )
        ))
        GROUP BY i.idcarrera";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode([
            'error' => 'Error en la preparación de la consulta.'
        ]);
        exit;
    }

    $stmt->bind_param("i", $idcarrera); // Vincular parámetros
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = [
                'idcarrera' => $row['idcarrera'],
                'total_pagado' => number_format(floatval($row['total_recaudado']), 2, '.', '')
            ];
        }

        echo json_encode([
            'data' => $data
        ]);
    } else {
        echo json_encode([
            'error' => 'Error en la ejecución de la consulta.'
        ]);
    }

    $stmt->close();
} else {
    // Si no se envió el idcarrera, devolver un error
    echo json_encode([
        'error' => 'Falta el parámetro idcarrera.'
    ]);
}

$conn->close();
?>
