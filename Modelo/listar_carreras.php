<?php
require_once('conexion.php');

$conexion = conexion();

$carreras = [];

if ($conexion) {
    // Preparar y ejecutar la consulta
    $sql = "SELECT id_carrera, carrera FROM carrera";
    $resultado = $conexion->query($sql);

    // Verificar si se encontraron resultados
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $carreras[] = $fila;
        }
    }

    // Cerrar la conexión
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../logo.png" type="image/x-icon">
    <title>Lista de Carreras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>
<header>
    <div class="Card">
        <div class="d-flex justify-content-sm-center bg-light">
            <div class="p-2 flex-fill">
                <img src="../logo.jpg" alt="ISFT182" width="4%" class="float-start">
                <button type="button" class="btn btn-outline-primary btn-lg ms-auto float-end" onclick="cerrarSesion()">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </button>
            </div>
        </div>
    </div>
</header>

<body>
    <div class="container mt-3">
        <h2>Lista de Carreras Disponibles</h2>
        <?php if (count($carreras) > 0): ?>
            <div class="mt-3">
                <table class="table table-bordered">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <?php foreach ($carreras as $carrera): ?>
                            <tr>
                               <td><?php echo htmlspecialchars($carrera['carrera']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="mt-3 alert alert-warning">
                <h2>No se encontraron carreras.</h2>
            </div>
        <?php endif; ?>
        <!-- Botón para volver a la página de búsqueda -->
        
            <button type="button" class="btn btn-outline-secondary btn-lg ms-3" onclick="window.location.href='consultas.html'">Volver</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="../Controlador/alumno.js"></script>
</body>
<a href="../index.html" class="btn btn-primary btn-lg float-end">Salir</a>
<footer class="text-center bg-dark text-white py-3 fixed-bottom">
    <p>© 2024 Cooperadora. Todos los derechos reservados.</p>
</footer>
</html>
