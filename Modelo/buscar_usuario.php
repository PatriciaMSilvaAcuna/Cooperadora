<?php
// buscar_usuario.php

include_once('conexion.php');

header('Content-Type: application/json');

echo buscarUsuario();

function buscarUsuario(){
    $mysqli = conexion(); // Conexión a la base de datos desde el archivo conexion.php
    
    $response = [];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        error_log("Datos POST recibidos: " . print_r($_POST, true));
    // Aseguramos que el Dni_usuario está establecido y se escapa para prevenir inyección SQL
        if(isset($_POST['Dni_usuario'])) {
            $Dni_usuario = $mysqli->real_escape_string($_POST['Dni_usuario']);
            error_log("DNI recibido: " . $Dni_usuario);
            
        $query = "SELECT idusuario, mailusuario, contrasenia, dniusuario FROM usuario WHERE dniusuario = ?";
        $stmt = $mysqli->prepare($query);
        if (!$stmt) {
            $response = ['estado' => 'ER', 'msg' => 'Error al preparar la consulta: ' . $mysqli->error];
            echo json_encode($response);
            return;
        }

        $stmt->bind_param("s", $Dni_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $row['estado'] = 'OK';
            $response = $row;
        } else {
            $response = ['estado' => 'ER', 'msg' => 'DNI no encontrado'];
        }

        $stmt->close();
    } else {
        $response = ['estado' => 'ER', 'msg' => 'DNI no proporcionado'];
    }
} else {
    $response = ['success' => false, 'message' => 'Solicitud inválida.'];
}

$mysqli->close();
echo json_encode($response);
}
?>
