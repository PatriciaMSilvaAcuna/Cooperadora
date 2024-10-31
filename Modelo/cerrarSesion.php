<?php
// Inicializar la sesión
session_start();

session_unset();
// Añadir los encabezados para evitar el almacenamiento en caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
// Destruir todas las variables de sesión
foreach ($_SESSION as $key => $value) {
    $_SESSION[$key] = NULL;
}

// destruir la sesión completamente,y también borrar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Destruir todas las variables de sesión
$_SESSION = array();




// Finalmente, destruir la sesión
session_destroy();

// Redirige al usuario a la página de inicio
header("Location: ../index.html");

exit;
?>
