<?php
session_start(); 

include_once('conexion.php'); 

$mysqli = conexion();

if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit();
}

$valorAbonado = $_POST['valorAbonado'];
$fecha = $_POST['fecha'];
$idmetodopago = $_POST['metodoPago'];
$idconcepto = $_POST['concepto'];
$idalumno = $_POST['idalumno']; // ID del alumno obtenido

$idusuario = $_SESSION['idusuario']; // Obtener el ID del usuario desde la sesión

$query = "INSERT INTO cargapago (valorabonado, fecha, idmetodopago, idconcepto, idalumno, idusuario) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param('ssiiii', $valorAbonado, $fecha, $idmetodopago, $idconcepto, $idalumno, $idusuario);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Pago registrado con éxito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar el pago']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta']);
}

$mysqli->close();
?>
