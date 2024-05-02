cerrarSesion.js
function cerrarSesion() {
    try {
        if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
            window.location.href = '../Modelo/cerrarSesion.php';
        }
    } catch (error) {
        console.error('Error al cerrar sesión:', error.message);
    }
}
