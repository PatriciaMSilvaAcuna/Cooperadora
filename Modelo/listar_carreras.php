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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Carreras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
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
        <div class="mt-3">
            <a href="consultas.html" class="btn btn-primary">Volver al índice</a>
        </div>
    </div>

    <!-- Incluir scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>