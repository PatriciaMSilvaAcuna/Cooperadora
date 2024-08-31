<?php
include_once('conexion.php'); 

$mysqli = conexion();

// Obtener el idconcepto de la solicitud POST
$idconcepto = isset($_POST['idconcepto']) ? intval($_POST['idconcepto']) : 0;

if ($idconcepto > 0) {
    // Consulta para obtener el valor del concepto y el año de vigencia para el idadministracion más alto
    $query = "SELECT valorconcepto, aniovigente
              FROM administracion 
              WHERE idconcepto = ? 
              AND idadministracion = (SELECT MAX(idadministracion) FROM administracion WHERE idconcepto = ?)";

    // Preparar y ejecutar la consulta
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("ii", $idconcepto, $idconcepto);
        $stmt->execute();
        $result = $stmt->get_result();

        // Preparar los datos para el JSON
        $data = array();
        if ($row = $result->fetch_assoc()) {
            $data['valorconcepto'] = $row['valorconcepto'];
            $data['aniovigente'] = $row['aniovigente'];
        } else {
            // Si no se encuentra el registro
            $data['valorconcepto'] = 'No se encontró valor';
            $data['aniovigente'] = 'No se encontró año';
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
    } else {
        $data['valorconcepto'] = 'Error en la preparación de la consulta';
        $data['aniovigente'] = 'Error en la preparación de la consulta';
    }

    $mysqli->close();
} else {
    $data['valorconcepto'] = 'ID concepto inválido';
    $data['aniovigente'] = 'ID concepto inválido';
}

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
