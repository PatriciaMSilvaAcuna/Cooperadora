<?php
require_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

$documento = $_POST['documento'];
$contrasena = $_POST['contrasena'];
$conexion = conexion();

$query = "SELECT * FROM usuario WHERE dniusuario = '$documento' AND contrasenia = '$contrasena' AND usuarioactivo = 1";
$result = $conexion->query($query);


if ($result->num_rows > 0) {
    $usuarioData = $result->fetch_assoc();
     $Id_tipoUsuario = $usuarioData['idtipousuario'];
    
    // Iniciar una nueva sesión o reanudar la existente
    session_start();

    // Agregar variables a la sesión
    $_SESSION['dniusuario'] = $documento;
    $_SESSION['idusuario'] = $idUsuario;

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");

    // Redirigir al usuario a la página correspondiente
    if ($Id_tipoUsuario == 0) {
        header("Location: ../Vista/accesoAceptadoAdmin.html");
    } elseif ($Id_tipoUsuario == 1) {
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
