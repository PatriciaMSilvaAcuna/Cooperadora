<?php
// update_usuario.php

include_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

echo updateUsuario(); // Llama a la función updateUsuario y muestra su resultado.

function updateUsuario()
{
    // Establece la conexión con la base de datos utilizando la función conexion() del archivo de conexión.
    $mysqli = conexion(); // Conexión a la base de datos desde el archivo conexión

    $id = $_POST['id'];

    // Obtiene el ID del usuario que se enviará mediante el método POST desde el formulario.
    $query = "UPDATE usuario SET estado = 0 WHERE id = $id";

    if (!$mysqli->query($query)) {
        // Si la consulta falla, devuelve un mensaje de error en formato JSON.
        return json_encode("No se pudo actualizar el estado del usuario");
    } else {
        // Si la consulta es exitosa, devuelve un mensaje de éxito en formato JSON.
        return json_encode("Estado del usuario actualizado correctamente");
    }
}
?>
