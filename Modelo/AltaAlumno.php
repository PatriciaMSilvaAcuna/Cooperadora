<?php

include_once('conexion.php');

$mysqli = conexion();
session_start(); // Asegúrate de iniciar la sesión
echo $_SESSION['idusuario']; // Verifica que el ID de usuario esté disponible

function insertAlumno()
{
    $mysqli = conexion();

    // Recibimos los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $deuda = $_POST['deuda'];
    $mail = $_POST['mail'];
    $idUsuario = $_SESSION['idusuario'];  // Asegúrate de que la sesión esté iniciada y el idusuario esté disponible.
    $fechaalta = $_POST['fechaalta'];

    // Validamos que los datos existan
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($mail) || empty($fechaalta)) {
        echo json_encode("Por favor, completa todos los campos obligatorios.");
        return;
    }

    // Insertamos los datos del alumno en la base de datos, incluyendo el idusuario
    $query = "INSERT INTO alumno (nombre, apellido, dni, deuda, mail, idusuario, fechaalta) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssis", $nombre, $apellido, $dni, $deuda, $mail, $idUsuario, $fechaalta);

   

    $stmt->close();
    $mysqli->close();
}

insertAlumno();

?>
