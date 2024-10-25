<?php
header('Content-Type: application/json'); 
include_once('conexion.php'); 

session_start(); 

function inscripCarrera() {
    $mysqli = conexion();
    
    // Imprimir datos recibidos para depuración
    error_log(json_encode($_POST)); // Para verificar los datos recibidos
    
    $idalumno = $_POST['idalumno'];
    $idcarrera = $_POST['idcarrera'];
    $idusuario = isset($_SESSION['idusuario']) ? $_SESSION['idusuario'] : null;

    // Validar si todos los campos están presentes
    if (empty($idalumno) || empty($idcarrera)) {
        echo json_encode(array("error" => "Faltan datos para la inscripción."));
        return;
    }

    // Verificar si el alumno ya está inscrito en la misma carrera
    $queryCheck = "SELECT * FROM inscripcion WHERE idalumno = ? AND idcarrera = ?";
    $stmtCheck = $mysqli->prepare($queryCheck);
    $stmtCheck->bind_param('ii', $idalumno, $idcarrera);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo json_encode(array("error" => "El alumno ya está inscrito en esta carrera."));
        $stmtCheck->close();
        $mysqli->close();
        return;
    }

    // Preparar la inserción si no está inscrito
    $query = "INSERT INTO inscripcion (fechaanual, idalumno, idcarrera, idusuario) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $año = date('Y');
        $stmt->bind_param('siii', $año, $idalumno, $idcarrera, $idusuario);

        if ($stmt->execute()) {
            echo json_encode(array("message" => "Inscripción registrada con éxito"));
        } else {
            echo json_encode(array("error" => "Error al registrar la inscripción: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("error" => "Error al preparar la consulta: " . $mysqli->error));
    }

    $stmtCheck->close();
    $mysqli->close();
}

// Llama a la función
inscripCarrera();
?>
