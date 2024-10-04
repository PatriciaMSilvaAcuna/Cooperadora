<?php

include_once('conexion.php'); 
header('Content-Type: application/json');// Establece el tipo de contenido como JSON para la respuesta


try {
    updateUsuario();// Llama a la función que actualiza los datos del usuario
} catch (Exception $e) {
    // Captura cualquier excepción y devuelve un mensaje de error en formato JSON
    echo json_encode(['success' => false, 'message' => 'Excepción capturada: ' . $e->getMessage()]);
}

function updateUsuario() {
     // Verifica que la solicitud sea del tipo POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mysqli = conexion(); // Obtiene la conexión a la base de datos
         // Verifica si hubo un error de conexión a la base de datos
        if ($mysqli->connect_error) {
            echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $mysqli->connect_error]);
            return;
        }

        // Obtiene los datos enviados por POST y asigna valores por defecto si no están presentes
        $idusuario  = $_POST['idusuario']?? null;
        $Dni_usuario = $_POST['Dni_usuario'] ?? '';
        $contrasenia = $_POST['contrasenia'] ?? '';
        $mailusuario = $_POST['mailusuario'] ?? '';
        $usuario_activo = isset($_POST['usuario_activo']) ? 1 : 0;
        $idtipousuario = $_POST['idtipousuario'] ?? '';
         // Verifica que los campos obligatorios no estén vacíos
        if (empty($idusuario) || empty($Dni_usuario)) {
            echo json_encode(['success' => false, 'message' => 'DNI del usuario o ID de usuario no proporcionados.']);
            return;
        }

    

        // Preparar la consulta SQL para actualizar los datos del usuario
        $query = "UPDATE usuario SET dniusuario = ?, contrasenia = ?, mailusuario = ?, usuarioactivo = ?, idtipousuario = ? WHERE idusuario = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
             // Vincula los parámetros con los valores recibidos
            $stmt->bind_param("issiii", $Dni_usuario, $contrasenia, $mailusuario, $usuario_activo, $idtipousuario, $idusuario);
            // Ejecuta la consulta y verifica si la operación fue exitosa
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Datos actualizados correctamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo actualizar los datos.']);
            }
            
            $stmt->close();// Cierra la sentencia preparada
        } else {
            // Registra el error en el log y devuelve un mensaje de error en formato JSON
            error_log('Error al preparar la consulta: ' . $mysqli->error);
            echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta.']);
        }

        $mysqli->close();// Cierra la conexión a la base de datos
    } else {
        // Si la solicitud no es POST, devuelve un mensaje de error en formato JSON
        echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
    }
}
