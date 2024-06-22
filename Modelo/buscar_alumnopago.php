<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultados de la búsqueda</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dni = $_POST["dni"];

        // Asegurarse de que el campo DNI no esté vacío
        if (!empty($dni)) {
            // Conéctate a la base de datos usando el archivo conexion.php
            require_once('conexion.php');
            $conexion = conexion();

            if ($conexion) {
                // Preparar y ejecutar la consulta con INNER JOIN
                $sql = "SELECT T1.nombre, T1.apellido, T1.dni, T1.deuda, T2.ValorAbonado AS valor_abonado, 
                               T3.Usuario, T4.tipo_de_pago AS metodo_de_pago, T6.carrera 
                        FROM alumno T1
                        INNER JOIN carga_pago T2 ON T1.id_alumno = T2.id_alumno
                        INNER JOIN usuario T3 ON T2.id_usuario = T3.id_usuario
                        INNER JOIN metodo_de_pago T4 ON T2.id_metodoDePago = T4.id_metodoDePago
                        INNER JOIN inscripcion T5 ON T5.id_alumno = T1.id_alumno
                        INNER JOIN carrera T6 ON T6.id_carrera = T5.id_carrera 
                        WHERE T1.dni = ?";
                $stmt = $conexion->prepare($sql);
                
                if ($stmt) {
                    $stmt->bind_param("s", $dni);
                    $stmt->execute();
                    $resultado = $stmt->get_result();

                    // Verificar si se encontraron resultados
                    if ($resultado->num_rows > 0) {
                        // Mostrar los datos del alumno y de la carga de pago
                        echo "<div class='mt-5'>";
                        echo "<h2>Resultados de la búsqueda</h2>";
                        echo "<table class='table table-bordered'>";
                        echo "<thead><tr><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Deuda</th><th>Valor Abonado</th><th>Usuario</th><th>Método de Pago</th><th>Carrera</th></tr></thead>";
                        echo "<tbody>";
                        while ($fila = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fila["nombre"]) . "</td>";
                            echo "<td>" . htmlspecialchars($fila["apellido"]) . "</td>";
                            echo "<td>" . htmlspecialchars($fila["dni"]) . "</td>";
                            echo "<td>" . htmlspecialchars($fila["deuda"]) . "</td>";
                            echo "<td>" . htmlspecialchars($fila["valor_abonado"]) . "</td>";
                            echo "<td>" . htmlspecialchars($fila["Usuario"]) . "</td>";
                            echo "<td>" . htmlspecialchars($fila["metodo_de_pago"]) . "</td>";
                            echo "<td>" . htmlspecialchars($fila["carrera"]) . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        echo "</div>";
                    } else {
                        echo "<div class='mt-5 alert alert-warning'>";
                        echo "<h2>No se encontraron resultados para el DNI: " . htmlspecialchars($dni) . "</h2>";
                        echo "</div>";
                    }

                    // Cerrar la declaración
                    $stmt->close();
                } else {
                    echo "<div class='mt-5 alert alert-danger'>";
                    echo "Error en la preparación de la consulta: " . htmlspecialchars($conexion->error);
                    echo "</div>";
                }

                // Cerrar la conexión
                $conexion->close();
            } else {
                echo "<div class='mt-5 alert alert-danger'>";
                echo "Error de conexión a la base de datos.";
                echo "</div>";
            }
        } else {
            echo "<div class='mt-5 alert alert-warning'>";
            echo "El campo DNI está vacío. Por favor, ingrese un DNI válido.";
            echo "</div>";
        }
    }
    ?>
  </div>

  <!-- Botón para volver a la página de búsqueda -->
  <div class="mt-3">
    <a href="../Vista/consultas.html" class="btn btn-primary">Volver a la búsqueda</a>
  </div>

  <!-- Incluir scripts de Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
