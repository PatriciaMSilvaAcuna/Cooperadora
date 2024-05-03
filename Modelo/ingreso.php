<?php
require_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$conexion = conexion();

$query = "SELECT * FROM usuario WHERE Usuario = '$usuario' AND contrasenia = '$contrasena' AND Usuario_activo = 1 AND Id_tipoUsuario = 1";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
    // Iniciar una nueva sesión o reanudar la existente
    session_start();

    // Agregar variables a la sesión
    $_SESSION['usuario'] = $usuario;
    $_SESSION['id_Usuario'] = $result->fetch_assoc()['Id_usuario'];

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");

    // Redirigir al usuario a la página correspondiente
    header("Location: ../Vista/accesoAceptadoAdmin.html");
} else {
    header("Location: ../Vista/accesoAceptadoOperador.html");
}
?>
