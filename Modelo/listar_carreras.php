<?php
require_once('conexion.php');

$conexion = conexion();

// Procesar solicitudes de alta y baja
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['alta'])) {
        $nueva_carrera = $_POST['nueva_carrera'];
        if (!empty($nueva_carrera)) {
            $sql = "INSERT INTO carrera (carrera) VALUES (?)";
            $stmt = $conexion->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $nueva_carrera);
                $stmt->execute();
                $stmt->close();
            }
        }
    } elseif (isset($_POST['baja'])) {
        $id_carrera = $_POST['id_carrera'];
        if (!empty($id_carrera)) {
            $sql = "DELETE FROM carrera WHERE id_carrera = ?";
            $stmt = $conexion->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $id_carrera);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

// Obtener la lista de carreras
$carreras = [];
if ($conexion) {
    $sql = "SELECT id_carrera, carrera FROM carrera";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $carreras[] = $fila;
        }
    }
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
        <h2 class="text-center">Lista de Carreras Disponibles</h2>
        <?php if (count($carreras) > 0): ?>
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Carrera</th>
                            <th>Carrera</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carreras as $carrera): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($carrera['id_carrera']); ?></td>
                                <td><?php echo htmlspecialchars($carrera['carrera']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="mt-4 alert alert-warning text-center">
                <h4>No se encontraron carreras.</h4>
            </div>
        <?php endif; ?>

        <div class="row mt-5">
            <!-- Formulario para alta de carrera -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Alta de Carrera</h5>
                        <form action="listar_carreras.php" method="post">
                            <div class="form-group">
                                <label for="nueva_carrera">Nueva Carrera:</label>
                                <input type="text" class="form-control" id="nueva_carrera" name="nueva_carrera" required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3" name="alta">Alta</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Formulario para baja de carrera -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Baja de Carrera</h5>
                        <form action="listar_carreras.php" method="post">
                            <div class="form-group">
                                <label for="id_carrera">ID de Carrera a eliminar:</label>
                                <input type="number" class="form-control" id="id_carrera" name="id_carrera" required>
                            </div>
                            <button type="submit" class="btn btn-danger mt-3" name="baja">Baja</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para volver al índice -->
        <div class="text-center mt-4">
            <a href="../Vista/consultas.html" class="btn btn-primary">Volver al índice</a>
        </div>
    </div>

    <!-- Incluir scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>