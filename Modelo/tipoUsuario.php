<?php
session_start();
require_once('conexion.php');

if (!isset($_SESSION['usuario'])) {
    // Usuario no está autenticado
    echo json_encode(array('error' => 'No autenticado'));
    exit();
}

$conexion = conexion();
$usuario = $_SESSION['usuario'];

// Obtener información del usuario
$query = "SELECT idtipousuario FROM usuario WHERE dniusuario = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode(array('tipoUsuario' => $data['idtipousuario']));
} else {
    echo json_encode(array('error' => 'Usuario no encontrado'));
}

$stmt->close();
$conexion->close();
?>
