<?php
require_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

$documento = $_POST['documento'];
$contrasena = $_POST['contrasena'];
$conexion = conexion();

// Consulta con parámetros para evitar inyecciones SQL
$query = "SELECT idusuario, idtipousuario FROM usuario WHERE dniusuario = ? AND contrasenia = ? AND usuarioactivo = 1";
$stmt = $conexion->prepare($query);
$stmt->bind_param('ss', $documento, $contrasena);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuarioData = $result->fetch_assoc();
    
    // Iniciar una nueva sesión o reanudar la existente
    session_start();

    // Agregar variables a la sesión
    $_SESSION['usuario'] = $documento;
    $_SESSION['idusuario'] = $usuarioData['idusuario'];  // Asegúrate de usar el campo correcto
    $_SESSION['idtipousuario'] = $usuarioData['idtipousuario'];

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");

    // Redirigir al usuario a la página correspondiente
    if ($usuarioData['idtipousuario'] == 0) {
        header("Location: ../Vista/accesoAceptadoAdmin.html");
    } elseif ($usuarioData['idtipousuario'] == 1) {
        header("Location: ../Vista/accesoAceptadoOperador.html");
    } else {
        header("Location: ../Vista/error.html");
    }
} else {
    header("Location: ../Vista/error.html");
}

$stmt->close();
$conexion->close();
?>
