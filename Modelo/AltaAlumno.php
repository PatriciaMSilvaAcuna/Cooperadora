<?php

include_once('conexion.php');

$mysqli = conexion();
session_start(); // Asegúrate de iniciar la sesión

// Verifica si el idusuario está disponible
if (!isset($_SESSION['idusuario'])) {
    echo json_encode(["error" => "No se ha iniciado sesión correctamente."]);
    exit;
}

// Recibimos los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$deuda = $_POST['deuda'];
$mail = $_POST['mail'];
$idUsuario = $_SESSION['idusuario'];  // Obtenemos el idusuario de la sesión
$fechaalta = $_POST['fechaalta'];
$deuda = 0;
// Validamos que los datos existan
if (empty($nombre) || empty($apellido) || empty($dni) || empty($mail) || empty($fechaalta)) {
    echo json_encode(["error" => "Por favor, completa todos los campos obligatorios."]);
    exit;
}

// Preparamos la consulta para insertar los datos del alumno
$query = "INSERT INTO alumno (nombre, apellido, dni, deuda, mail, idusuario, fechaalta) 
          VALUES ('$nombre', '$apellido', '$dni', '$deuda', '$mail', '$idUsuario', '$fechaalta')";

$result = mysqli_query($mysqli, $query);

if ($result) {
    echo json_encode(["message" => "Alumno dado de alta correctamente"]);
} else {
    echo json_encode(["error" => "Error al insertar los datos del alumno."]);
}

?>
