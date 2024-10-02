<?php
session_start();
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
                $_SESSION['message'] = "Carrera agregada exitosamente.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Error al agregar la carrera.";
                $_SESSION['message_type'] = "danger";
            }
        }
    } elseif (isset($_POST['baja'])) {
        $id_carrera = $_POST['id_carrera'];
        if (!empty($id_carrera)) {
            $sql = "DELETE FROM carrera WHERE idcarrera = ?";
            $stmt = $conexion->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $id_carrera);
                $stmt->execute();
                $stmt->close();
                $_SESSION['message'] = "Carrera eliminada exitosamente.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Error al eliminar la carrera.";
                $_SESSION['message_type'] = "danger";
            }
        }
    }
    header("Location: listar_carreras.php");
    exit();
}

// Obtener la lista de carreras
$carreras = [];
if ($conexion) {
    $sql = "SELECT idcarrera, carrera FROM carrera";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-custom {
            border-radius: 20px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .form-container {
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background-color: white;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Lista de Carreras Disponibles</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (count($carreras) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID Carrera</th>
                            <th>Carrera</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carreras as $carrera): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($carrera['idcarrera']); ?></td>
                                <td><?php echo htmlspecialchars($carrera['carrera']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                <h4>No se encontraron carreras.</h4>
            </div>
        <?php endif; ?>

       <!--   <div class="row mt-5">
           Formulario para alta de carrera 
            <div class="col-md-6">
                <div class="form-container">
                    <h5 class="text-center">Alta de Carrera</h5>
                    <form action="listar_carreras.php" method="post">
                        <div class="form-group">
                            <label for="nueva_carrera">Nueva Carrera:</label>
                            <input type="text" class="form-control" id="nueva_carrera" name="nueva_carrera" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-custom mt-3 w-100" name="alta">
                            <i class="fas fa-plus"></i> Alta
                        </button>
                    </form>
                </div>
            </div>-->

        <!-- Formulario para baja de carrera 
            <div class="col-md-6">
                <div class="form-container">
                    <h5 class="text-center">Baja de Carrera</h5>
                    <form action="listar_carreras.php" method="post">
                        <div class="form-group">
                            <label for="id_carrera">ID de Carrera a eliminar:</label>
                            <input type="number" class="form-control" id="id_carrera" name="id_carrera" required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-custom mt-3 w-100" name="baja">
                            <i class="fas fa-trash-alt"></i> Baja
                        </button>
                    </form>
                </div>
            </div>
        </div>-->

        <!-- Botón para volver al índice -->
        <div class="text-center mt-4">
            <a href="../Vista/gestionarCarreras.html" class="btn btn-primary btn-custom">
                <i class="fas fa-arrow-left"></i> Volver al índice
            </a>
        </div>
    </div>

    <!-- Incluir scripts de Bootstrap y Font Awesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
