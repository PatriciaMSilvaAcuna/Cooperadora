<?php
session_start(); // Inicia la sesion
include_once('conexion.php'); //Incluye el archivo de conexión a la base de datos, que contiene las credenciales de acceso

// Crea una conexión a la base de datos usando la función conexion()
$mysqli = conexion();

// Verifica si la variable de sesión 'idusuario' está definida; si no, significa que el usuario no ha iniciado sesión
if (!isset($_SESSION['idusuario'])) {
    // Devuelve un mensaje de error en formato JSON indicando que el usuario no está autenticado
    echo json_encode(['error' => 'Usuario no autenticado']);
    // Finaliza la ejecución del script
    exit();
}
// Obtiene el valor del DNI desde la solicitud POST
$dni = $_POST['dni'];


// Consulta SQL para obtener el ID del alumno cuyo DNI coincide con el proporcionado
$query = "SELECT idalumno FROM alumno WHERE dni = ?";
$stmt = $mysqli->prepare($query); // Prepara la consulta SQL para evitar inyecciones SQL

// Verifica si la preparación de la consulta fue exitosa
if ($stmt) {
    // Vincula el parámetro 'dni' a la consulta preparada
    $stmt->bind_param('s', $dni);
    // Ejecuta la consulta
    $stmt->execute();
      // Vincula el resultado de la consulta a la variable $id_alumno
    $stmt->bind_result($id_alumno);
    // Obtiene el resultado de la consulta (en este caso, el ID del alumno)
    $stmt->fetch();
    
    // Verifica si se encontró un alumno con el DNI proporcionado
    if ($id_alumno) {
        // Si el alumno existe, devuelve el ID en formato JSON
        echo json_encode(['idalumno' => $id_alumno]);
    } else {
        // Si no se encontró el alumno, devuelve un valor nulo en formato JSON
        echo json_encode(['idalumno' => null]);
    }
    // Cierra la consulta preparada
    $stmt->close();
} else {
    // Si hubo un error al preparar la consulta, devuelve un mensaje de error en formato JSON
    echo json_encode(['error' => 'Error al preparar la consulta']);
}


// Cierra la conexion a la BBDD.
$mysqli->close();
?>
