<?php
include_once('conexion.php'); // Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso 

// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();

// Obtiene el 'idconcepto' de la solicitud POST; si no se recibe, se asigna el valor 0 por defecto
$idconcepto = isset($_POST['idconcepto']) ? intval($_POST['idconcepto']) : 0;

// Verifica si el 'idconcepto' recibido es mayor que 0 (un valor válido)
if ($idconcepto > 0) {
    // Prepara la consulta SQL para obtener el valor del concepto y el año de vigencia
    // Solo se obtiene el concepto correspondiente al 'idconcepto' y al 'idadministracion' más alto
    $query = "SELECT valorconcepto, aniovigente
              FROM administracion 
              WHERE idconcepto = ? 
              AND idadministracion = (SELECT MAX(idadministracion) FROM administracion WHERE idconcepto = ?)";

    // Prepara y ejecuta la consulta SQL
    if ($stmt = $mysqli->prepare($query)) {
        // Vincula los parámetros de la consulta, en este caso, el 'idconcepto' dos veces
        $stmt->bind_param("ii", $idconcepto, $idconcepto);
        // Ejecuta la consulta.
        $stmt->execute();
        // Obtiene los resultados de la consulta.
        $result = $stmt->get_result();

        // Preparar los datos para el JSON
        $data = array();
        if ($row = $result->fetch_assoc()) {
            // Si hay resultados, los agrega al array de datos
            $data['valorconcepto'] = $row['valorconcepto'];
            $data['aniovigente'] = $row['aniovigente'];
        } else {
            // Si no se encuentran registros, se asigna un mensaje indicando que no se encontró el valor
            $data['valorconcepto'] = 'No se encontró valor';
            $data['aniovigente'] = 'No se encontró año';
        }

         // Cierra la declaración preparada
        $stmt->close();
    } else {
        // Si hubo un error al preparar la consulta, se asignan mensajes de error en los datos
        $data['valorconcepto'] = 'Error en la preparación de la consulta';
        $data['aniovigente'] = 'Error en la preparación de la consulta';
    }
     // Cierra la conexión a la base de datos
    $mysqli->close();
} else {
     // Si el 'idconcepto' no es válido (es 0 o negativo), asigna un mensaje de error
    $data['valorconcepto'] = 'ID concepto inválido';
    $data['aniovigente'] = 'ID concepto inválido';
}

// Envia la respuesta en formato JSON
header('Content-Type: application/json');
// Envía la respuesta en formato JSON
echo json_encode($data);
?>
