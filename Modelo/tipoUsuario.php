<?php
session_start(); // Inicio de Sesión para el manejo de las variables.
require_once('conexion.php'); // Incluye el archivo de conexion a la BBDD.

// Verifica si el usuario ha iniciado sesión.
if (!isset($_SESSION['usuario'])) {
    // Si el usuario no está autenticado, devuelve un mensaje de error en formato JSON y termina la ejecución del script.
    echo json_encode(array('error' => 'No autenticado'));
    exit();
}
// Obtiene la conexión a la base de datos
$conexion = conexion();
$usuario = $_SESSION['usuario'];// Obtiene el nombre de usuario desde la sesión

// Consulta para obtener el tipo de usuario según el DNI del usuario
$query = "SELECT idtipousuario FROM usuario WHERE dniusuario = ?";
$stmt = $conexion->prepare($query);// Prepara la consulta SQL
$stmt->bind_param("s", $usuario);// Vincula el parámetro de la consulta (DNI del usuario) para evitar inyecciones SQL
$stmt->execute();// Ejecuta la consulta SQL
$result = $stmt->get_result(); //Obtine el resultado de la consulta.

// Verifica si se encontró algún resultado
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();  // Obtiene los datos del usuario como un arreglo asociativo
    echo json_encode(array('tipoUsuario' => $data['idtipousuario']));
} else {
     // Si no se encontró el usuario, devuelve un mensaje de error en formato JSON
    echo json_encode(array('error' => 'Usuario no encontrado'));
}
// Cierra la declaración y la conexión a la base de datos
$stmt->close();
$conexion->close();
?>
