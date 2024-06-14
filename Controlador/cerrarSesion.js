cerrarSesion.js
function cerrarSesion() {
    try {
        window.location.href = '../Modelo/cerrarSesion.php';
        }
     catch (error) {
        console.error('Error al cerrar sesión:', error.message);
    }
}
