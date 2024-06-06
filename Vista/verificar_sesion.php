<?php
// Inicia la sesión si no está iniciada
session_start();

// Verifica si el usuario no está autenticado
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirige a la página de inicio de sesión con un mensaje de error
    header("Location: ../index.html");
    exit(); // Asegura que el script se detenga después de la redirección
}

// Agregar var_dump para verificar las variables de sesión
//var_dump($_SESSION);
?>