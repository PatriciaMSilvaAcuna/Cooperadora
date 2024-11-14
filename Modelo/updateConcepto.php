<?php
include_once('conexion.php');// Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();

// Obtener los datos de la solicitud POST
$idconcepto = isset($_POST['idconcepto']) ? intval($_POST['idconcepto']) : 0;
$valorconcepto = isset($_POST['valorconcepto']) ? $_POST['valorconcepto'] : '';
$aniovigencia = isset($_POST['aniovigencia']) ? intval($_POST['aniovigencia']) : 0;

// Inicializa un arreglo vacío para almacenar la respuesta que se enviará en formato JSON.
$response = array();

// Validar que todos los datos necesarios estén presentes
if ($idconcepto > 0 && $valorconcepto !== '' && $aniovigencia > 0) {
    // Consulta para insertar un nuevo registro
    $query = "INSERT INTO administracion (idconcepto, valorconcepto, aniovigente)
              VALUES (?, ?, ?)";

    // Preparar y ejecutar la consulta
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("isi", $idconcepto, $valorconcepto, $aniovigencia);
        if ($stmt->execute()) {
            $response['message'] = 'Inserción exitosa';
        } else {
            $response['message'] = 'Error en la ejecución de la consulta';
        }
        $stmt->close();
    } else {
        $response['message'] = 'Error en la preparación de la consulta';
    }
} else {
    $response['message'] = 'Datos inválidos o incompletos';
}

// Cerrar la conexión con la base de datos
$mysqli->close();

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
