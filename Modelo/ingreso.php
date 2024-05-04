<?php
require_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$conexion = conexion();

$query = "SELECT * FROM usuario WHERE Usuario = '$usuario' AND contrasenia = '$contrasena' AND Usuario_activo = 1";
$result = $conexion->query($query);

if ($result->num_rows > 0) {
    $usuarioData = $result->fetch_assoc();
    $idUsuario = $usuarioData['Id_usuario'];
    
    // Iniciar una nueva sesión o reanudar la existente
    session_start();

    // Agregar variables a la sesión
    $_SESSION['usuario'] = $usuario;
    $_SESSION['id_Usuario'] = $idUsuario;

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");

    // Redirigir al usuario a la página correspondiente
    if ($idUsuario == 1) {
        header("Location: ../Vista/accesoAceptadoAdmin.html");
    } elseif ($idUsuario == 2) {
        header("Location: ../Vista/accesoAceptadoOperador.html");
    } else {
        // Redirigir a una página de error o manejar otro caso
        // Por ejemplo:
         header("Location: ../Vista/error.html");
    }
} else {
    // Redirigir a una página de error o manejar otro caso
    // Por ejemplo:
    header("Location: ../Vista/error.html");
}

?>
