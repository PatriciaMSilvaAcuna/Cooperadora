// cerrarSesion.js
function cerrarSesion() {
    console.log('Función cerrarSesion() llamada');
    if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        window.location.href = 'Modelo/cerrar_sesion.php';
    }
}
