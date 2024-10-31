cerrarSesion.js
function cerrarSesion() {
    try {
        window.location.href = '../Modelo/cerrarSesion.php';
        sessionStorage.removeItem("sesionActiva");
        }
     catch (error) {
        console.error('Error al cerrar sesión:', error.message);
    }
}
