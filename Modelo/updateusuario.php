<?php
// update_usuario.php

include_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

echo updateUsuario(); // Llamamos a la función updateUsuario

function updateUsuario()
{
    $mysqli = conexion(); // Conexión a la base de datos desde el archivo conexión

    $id = $_POST['id'];

    // Consulta para actualizar el estado del usuario a 0
    $query = "UPDATE usuario SET estado = 0 WHERE id = $id";

    if (!$mysqli->query($query)) {
        return json_encode("No se pudo actualizar el estado del usuario");
    } else {
        return json_encode("Estado del usuario actualizado correctamente");
    }
}
?>
