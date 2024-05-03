<?php
include_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

// Verificar la conexión
//if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
//}

// Obtener el DNI ingresado por el usuario
$dni = $_POST['dni'];

// Consulta SQL para buscar usuarios por DNI
$sql = "SELECT * FROM usuarios WHERE dni = '$dni'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar los resultados
    while ($row = $result->fetch_assoc()) {
        echo "Nombre: " . $row['nombre'] . "<br>";
        echo "Apellido: " . $row['apellido'] . "<br>";
        // Agrega más campos según tu estructura de tabla

        // Botón para seleccionar este usuario
        echo '<a href="editar_usuario.php?id=' . $row['id'] . '">Seleccionar</a>';
        echo "<hr>";
    }
} else {
    echo "No se encontraron usuarios con ese DNI.";
}
// Cerrar la conexión
$conn->close();
?>
