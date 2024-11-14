<?php
// Inicializa la sesión
session_start();

// Establece un array para almacenar el estado de la sesión
$response = array();

// Verifica si hay una sesión activa
if (isset($_SESSION['usuario'])) { // Cambia 'usuario_id' por la variable de sesión que estés usando
    $response['sesionActiva'] = true; // La sesión está activa
} else {
    $response['sesionActiva'] = false; // La sesión no está activa
}

// Configura los encabezados para que se pueda acceder desde JavaScript
header('Content-Type: application/json'); // Establece el tipo de contenido a JSON
echo json_encode($response); // Devuelve la respuesta en formato JSON
exit; // Aseguro de que no se ejecute más código después de esto
?>
