<?php
include_once('conexion.php'); // 

function bajaUsuario($userId)
{
    $mysqli = conexion(); // Establece la conexión a la base de datos
    $userId = $mysqli->real_escape_string($userId); // Evita la inyección SQL

    $query = "UPDATE usuario SET usuarioactivo = 0 WHERE idusuario = '$userId'";
    $resultado = $mysqli->query($query); // Ejecuta la consulta

    if ($resultado) {
        echo json_encode(['message' => 'Usuario actualizado correctamente']);
    } else {
        echo json_encode(['message' => 'Error al actualizar el usuario']);
    }

    $mysqli->close(); // Cierra la conexión
}

// Verifica si se recibió un ID de usuario para eliminar
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    bajaUsuario($userId); // Llama a la función
}
?>
