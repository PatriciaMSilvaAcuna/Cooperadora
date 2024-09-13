<?php

include_once('conexion.php'); // Incluye el archivo de conexión a la base de datos

// Establece el tipo de contenido a JSON
header('Content-Type: application/json');

// Obtiene los datos del formulario
$idcarrera = isset($_POST['idcarrera']) ? $_POST['idcarrera'] : null;
$carrera = isset($_POST['carrera']) ? $_POST['carrera'] : null;
$carreraactiva = isset($_POST['carreraactiva']) ? $_POST['carreraactiva'] : null;

// Inicializa la respuesta
$response = array('success' => false, 'message' => 'Error desconocido.');

if ($idcarrera && $carrera) {
    // Conecta a la base de datos
    $mysqli = conexion();

    // Prepara la consulta de actualización
    $query = "UPDATE carrera SET carrera = ?, estado = ? WHERE idcarrera = ?";
    if ($stmt = $mysqli->prepare($query)) {
        // Asocia los parámetros
        $estado = $carreraactiva ? 1 : 0; // Convierte el valor del checkbox a 1 o 0
        $stmt->bind_param("ssi", $carrera, $estado, $idcarrera);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['success'] = true;
                $response['message'] = 'Datos actualizados correctamente.';
            } else {
                $response['message'] = 'No se encontraron registros para actualizar.';
            }
        } else {
            $response['message'] = 'Error al ejecutar la consulta. Verifique los datos enviados.';
        }

        // Cierra la declaración
        $stmt->close();
    } else {
        $response['message'] = 'Error al preparar la consulta.';
    }

    // Cierra la conexión a la base de datos
    $mysqli->close();
} else {
    $response['message'] = 'Faltan datos para actualizar. Verifique los datos enviados.';
}

// Envía la respuesta JSON
echo json_encode($response);
?>
