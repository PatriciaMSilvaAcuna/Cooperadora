<?php

include_once('conexion.php'); 
header('Content-Type: application/json');// Establece el tipo de contenido como JSON para la respuesta

try {
    updateAlumno(); // Llama a la función que actualiza los datos del usuario
} catch (Exception $e) {
    // Captura cualquier excepción y devuelve un mensaje de error en formato JSON
    echo json_encode(['success' => false, 'message' => 'Excepción capturada: ' . $e->getMessage()]);
}
// Función que actualiza Alumno
function updateAlumno() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mysqli = conexion();

        $idalumno  = $_POST['idalumno'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $dniActualizar  = $_POST['dniActualizar'] ?? '';
        $deuda = $_POST['deuda'] ?? '';
        $mail = $_POST['mail'] ?? '';
        $alumnoactivo = isset($_POST['alumnoactivo']) ? 1 : 0;

        if (empty($idalumno)) {
            echo json_encode(['success' => false, 'message' => 'ID de alumno no proporcionado.']);
            return;
        }

 // Actualiza sin modificar la fecha de alta
        $query = "UPDATE alumno SET nombre = ?, apellido = ?, dni = ?, deuda = ?, mail = ?, alumnoactivo = ? WHERE idalumno = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sssisii", $nombre, $apellido, $dniActualizar, $deuda, $mail, $alumnoactivo, $idalumno);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo actualizar los datos.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta.']);
        }

        $mysqli->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
    }
}
?>
