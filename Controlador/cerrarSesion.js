cerrarSesion.js
// Funcion para cerrar sesion
function cerrarSesion() {
    try {
         // Redirige al usuario a la página de cierre de sesión en el servidor
        window.location.href = '../Modelo/cerrarSesion.php';
        
        // Elimina el item "sesionActiva" del sessionStorage, para asegurar 
        //que la sesión se termine en el cliente
        sessionStorage.removeItem("sesionActiva");
        }
     catch (error) {
        // Si ocurre algún error durante el proceso de cierre de sesión, se captura y se muestra en la consola
        console.error('Error al cerrar sesión:', error.message);
    }
}
