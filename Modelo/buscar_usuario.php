<?php
// buscar_usuario.php

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén el DNI ingresado por el usuario
    $dni = $_POST['dni'];

    // Realiza la búsqueda en la base de datos (debes configurar tus propios datos de conexión)
    $servername = "localhost";
    $username = "tu_usuario";
    $password = "tu_contraseña";
    $dbname = "nombre_de_la_base_de_datos";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consulta para buscar el usuario por DNI
    $sql = "SELECT id, nombre, email FROM usuarios WHERE dni = '$dni'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario fue encontrado
        $row = $result->fetch_assoc();
        $idUsuario = $row['id'];
        $nombreUsuario = $row['nombre'];
        $emailUsuario = $row['email'];

        echo "Usuario encontrado:<br>";
        echo "ID: $idUsuario<br>";
        echo "Nombre: $nombreUsuario<br>";
        echo "Email: $emailUsuario<br>";
    } else {
        echo "Usuario no encontrado.";
    }

    $conn->close();
}
?>
