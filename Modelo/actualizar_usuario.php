<?php

include_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos
header('Content-Type: application/json');
try {
    updateUsuario();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Excepción capturada: ' . $e->getMessage()]);
}

function updateUsuario() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mysqli = conexion(); // Conexión a la base de datos desde el archivo conexion.php
        
        if ($mysqli->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $mysqli->connect_error]);
            return;
        }

        // Obtener y verificar los datos recibidos por POST
        $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
        $contrasenia = isset($_POST['contrasenia']) ? $_POST['contrasenia'] : '';
        $usuario_activo = isset($_POST['usuario_activo']) ? 1 : 0;
        $Dni_usuario = isset($_POST['Dni_usuario']) ? $_POST['Dni_usuario'] : '';
        
        // Validar que el DNI del usuario esté presente
        if (empty($Dni_usuario)) {
            echo json_encode(['success' => false, 'message' => 'DNI del usuario no proporcionado.']);
            return;
        }

        // Preparar la consulta SQL para actualizar los datos del usuario
        $query = "UPDATE usuario SET usuario = ?, contrasenia = ?, usuario_activo = ? WHERE Dni_usuario = ?";
        $stmt = $mysqli->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssis", $usuario, $contrasenia, $usuario_activo, $Dni_usuario);
            
            // Ejecutar la consulta y verificar el resultado
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo actualizar los datos.']);
            }
            
            $stmt->close();
        } else {
            error_log('Error al preparar la consulta: ' . $mysqli->error);
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta.']);
        }

        $mysqli->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
    }
}
