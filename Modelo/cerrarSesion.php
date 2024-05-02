<?php
session_start(); // Inicia la sesión

// Destruye la sesión
if (session_destroy()) {
    header("Location: ../index.html"); // Redirige al usuario a la página de inicio

    exit;
} else {
    echo "Error al cerrar la sesión. Por favor, inténtalo de nuevo.";
}
exit;
?>
