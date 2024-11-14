<?php
// /Modelo/consultar_recaudacion_carrera.php

header('Content-Type: application/json; charset=utf-8'); // Definir que la respuesta será JSON

include_once('conexion.php');// Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

$conn = conexion(); // Obtener conexión

// Verifica si se ha enviado el parámetro 'idcarrera' a través de una solicitud GET
if (isset($_GET['idcarrera'])) {
    $idcarrera = intval($_GET['idcarrera']); // Convierte 'idcarrera' a entero para evitar inyecciones SQL

    
    // Consulta SQL para calcular la recaudación total de una carrera específica
    // La consulta suma todos los pagos, pero solo cuenta la cuota social (concepto = 2) una vez para la primera carrera del alumno
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
    // Prepara la consulta SQL
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Si ocurre un error al preparar la consulta, devuelve un mensaje de error en formato JSON y termina el script
        echo json_encode([
            'error' => 'Error en la preparación de la consulta.'
        ]);
        exit;
    }
    // Vincula el parámetro 'idcarrera' a la consulta
    $stmt->bind_param("i", $idcarrera); 
    $stmt->execute();// Ejecuta la consulta
    $result = $stmt->get_result();// Obtiene el resultado de la consulta

    if ($result) {
        $data = [];// Inicializa un arreglo para almacenar los datos obtenidos
        while ($row = $result->fetch_assoc()) {
               // Agrega cada resultado al arreglo, formateando el total recaudado con dos decimales
            $data[] = [
                'idcarrera' => $row['idcarrera'],
                'total_pagado' => number_format(floatval($row['total_recaudado']), 2, '.', '')
            ];
        }
         // Envía los datos en formato JSON como respuesta
        echo json_encode([
            'data' => $data
        ]);
    } else {
        // Si ocurre un error al ejecutar la consulta, devuelve un mensaje de error en formato JSON
        echo json_encode([
            'error' => 'Error en la ejecución de la consulta.'
        ]);
    }
     // Cierra la consulta preparada
    $stmt->close();
} else {
    // Si no se envió el parámetro 'idcarrera', devuelve un mensaje de error en formato JSON
    echo json_encode([
        'error' => 'Falta el parámetro idcarrera.'
    ]);
}
// Cierra la conexion a la BBDD.
$conn->close();
?>
