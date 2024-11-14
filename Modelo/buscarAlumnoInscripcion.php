<?php
// Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso
include_once('conexion.php');

// Obtiene el valor de 'dni' desde una solicitud POST, si existe; de lo contrario, asigna null
$dni = isset($_POST['dni']) ? $_POST['dni'] : null;

// Llama a la función getAlumno() pasando el dni y muestra el resultado
echo getAlumno($dni);

/**
 * Función que consulta en la base de datos la información de un alumno en base a su dni.
 * @param string|null $dni El DNI del alumno que se desea consultar.
 * @return string JSON con los datos del alumno o un mensaje de error si no se encuentra.
 */

function getAlumno($dni) {
    $data = array();
    // Inicializa un arreglo para almacenar los datos del alumno
    
    // Verifica si se ha proporcionado un DNI
    if($dni !== null) {
        // Crea una conexión a la base de datos usando la función conexion()
        $mysqli = conexion();
        // Define la consulta SQL para buscar al alumno por DNI
        $query = "SELECT * FROM alumno WHERE dni = ?";
        // Prepara la sentencia para evitar inyecciones SQL
        $stmt = $mysqli->prepare($query); 
        $stmt->bind_param("s", $dni);// Vincula el parámetro DNI a la consulta

        $stmt->execute();// Ejecuta la consulta
        $result = $stmt->get_result();// Obtiene el resultado de la consulta
        // Recorre cada fila del resultado y la agrega al arreglo $data
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        // Cierra la sentencia y la conexión a la base de datos
        $stmt->close();
        $mysqli->close();
    }
    // Verifica si el arreglo $data está vacío (no se encontró al alumno)
    if (empty($data)) {
          // Devuelve un mensaje de error en formato JSON si no hay datos del alumno
        echo json_encode(array("error" => "Alumno no encontrado"));
    } else {
         // Devuelve los datos del alumno en formato JSON si se encontró
        echo json_encode($data);
    }
}
?>
