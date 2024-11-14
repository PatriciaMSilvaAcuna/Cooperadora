<?php

include_once('conexion.php');// Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

// Verifica si se ha enviado el parámetro 'dni' a través de una solicitud POST y lo asigna a la variable; si no, lo deja vacío
$dni = isset($_POST['dni']) ? $_POST['dni'] : '';

// Llama a la función 'getAlumno' pasando el DNI y muestra el resultado como una respuesta JSON
echo getAlumno($dni);

/**
 * Función que obtiene los datos de un alumno desde la base de datos utilizando su DNI.
 *
 * @param string $dni El DNI del alumno que se desea buscar
 * @return string Los datos del alumno en formato JSON
 */

function getAlumno($dni) {
    // Obtiene una nueva conexión a la base de datos
    $mysqli = conexion();
    
    // Consulta SQL para seleccionar los datos del alumno con el DNI especificado
    $query = "SELECT idalumno, nombre, apellido, dni, deuda FROM alumno WHERE dni = ?";
     // Prepara la consulta para evitar inyecciones SQL
    $stmt = $mysqli->prepare($query);
    // Vincula el parámetro 'dni' a la consulta preparada
    $stmt->bind_param("s", $dni);
    // Ejecuta la consulta
    $stmt->execute();
    // Obtiene el resultado de la consulta.
    $result = $stmt->get_result();
     
     // Inicializa un arreglo para almacenar los datos del alumno
    $alumno = array();
    // Itera sobre los resultados y agrega cada fila al arreglo $alumno
    while ($row = $result->fetch_assoc()) {
        $alumno[] = $row;
    }
      // Cierra la consulta preparada
    $stmt->close();
     // Cierra la conexion a la BBDD.
    $mysqli->close();
    // Convierte el arreglo $alumno a formato JSON y lo devuelve
    return json_encode($alumno);
}
?>
