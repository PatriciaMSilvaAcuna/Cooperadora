<?php
// Incluir archivo de conexión
include('conexion.php');
$mysqli = conexion();

// Verificar si la conexión se estableció correctamente
if (!isset($mysqli) || $mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Lista blanca de valores permitidos para "action"
$allowedActions = ['resetear_deuda'];

// Verificar si se recibió "action" y si está en la lista blanca
if (isset($_POST['action']) && in_array($_POST['action'], $allowedActions, true)) {
    // Validar que la acción es "resetear_deuda"
    if ($_POST['action'] === 'resetear_deuda') {
        // Llamar al procedimiento almacenado
        $sql = "CALL resetDeuda()";
        
        // Ejecutar el procedimiento
        if ($mysqli->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error al ejecutar el procedimiento: " . $mysqli->error;
        }
    }
} else {
    // Respuesta para solicitudes no válidas
    echo "invalid_request";
}

// Cerrar la conexión
$mysqli->close();
?>
