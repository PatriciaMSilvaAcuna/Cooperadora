<?php
session_start(); 
include_once('conexion.php'); 

$mysqli = conexion();

if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit();
}

$dni = $_POST['dni'];

$query = "SELECT idalumno FROM alumno WHERE dni = ?";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param('s', $dni);
    $stmt->execute();
    $stmt->bind_result($id_alumno);
    $stmt->fetch();
    // Verifica que $id_alumno no esté vacío
    if ($id_alumno) {
        echo json_encode(['idalumno' => $id_alumno]);
    } else {
        echo json_encode(['idalumno' => null]);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'Error al preparar la consulta']);
}

$mysqli->close();
?>
