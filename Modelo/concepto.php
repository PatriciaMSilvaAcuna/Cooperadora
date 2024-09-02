<?php
include_once('conexion.php'); 

$mysqli = conexion();

// Obtener el idconcepto de la solicitud POST
$idconcepto = isset($_POST['idconcepto']) ? intval($_POST['idconcepto']) : 0;

if ($idconcepto > 0) {
    // Consulta para obtener el valor del concepto para el idadministracion más alto
    $query = "SELECT valorconcepto 
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
        } else {
            $data['valorconcepto'] = null;
        }

        // Cerrar la declaración y la conexión
        $stmt->close();
    } else {
        $data['valorconcepto'] = null;
    }

    $mysqli->close();
} else {
    $data['valorconcepto'] = null;
}

// Enviar la respuesta en formato JSON
echo json_encode($data);
?>
