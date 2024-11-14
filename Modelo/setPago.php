<?php
session_start(); 
include_once('conexion.php'); // Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

$mysqli = conexion();// Crea una conexión a la base de datos usando la función conexion()

if (!isset($_SESSION['idusuario'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit();
}

// Captura de datos
$valorAbonado = $_POST['valorAbonado'];
$fecha = $_POST['fecha'];
$idmetodopago = $_POST['metodoPago'];
$idconcepto = $_POST['concepto'];
$idalumno = $_POST['idalumno']; 
$idusuario = $_SESSION['idusuario']; 


// Define la consulta SQL que inserta el pago en la respectiva tabla.
$query = "INSERT INTO cargapago (valorabonado, fecha, idmetodopago, idconcepto, idalumno, idusuario) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($query);

if ($stmt) {
    $stmt->bind_param('ssiiii', $valorAbonado, $fecha, $idmetodopago, $idconcepto, $idalumno, $idusuario);
    if ($stmt->execute()) {
        $idcargapago = $stmt->insert_id; // Captura el ID del pago
        echo json_encode(['status' => 'success', 'message' => 'Pago registrado con éxito', 'idcargapago' => $idcargapago]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al registrar el pago']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta']);
}

// Cierra la conexion a la BBDD.
$mysqli->close();
?>
