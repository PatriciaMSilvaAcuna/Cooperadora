<?php

require_once 'conexion.php';

echo insertAlumno();

function insertAlumno()
{
    $mysqli = conexion();

    // Recibimos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    //$deuda = $_POST['deuda'];

    // Preparamos la consulta SQL (usando statement preparados para evitar SQL injection)
    $query = "INSERT INTO alumno (nombre, apellido, dni) VALUES (?, ?, ?)";
    
    // Preparamos la consulta
    $stmt = $mysqli->prepare($query);
    
    // Asignamos los parámetros y ejecutamos la consulta
    $stmt->bind_param("sss", $nombre, $apellido, $dni);
    $stmt->execute();
    
    // Verificamos si se ejecutó correctamente
    if ($stmt->affected_rows > 0) {
        return json_encode("Se ha ingresado un nuevo alumno");
    } else {
        return json_encode("No se pudo dar de alta el alumno");
    }
}
?>
