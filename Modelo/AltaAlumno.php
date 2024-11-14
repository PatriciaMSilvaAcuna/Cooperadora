<?php

include_once('conexion.php');

$mysqli = conexion();
session_start(); //  inicio la sesión

// Verifica si el idusuario está disponible
if (!isset($_SESSION['idusuario'])) {
    echo json_encode(["error" => "No se ha iniciado sesión correctamente."]);
    exit;
}

// Recibimos los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$mail = $_POST['mail'];
$idUsuario = $_SESSION['idusuario'];  // Obtenemos el idusuario de la sesión
$fechaalta = $_POST['fechaalta'];

// Validamos que los datos existan
if (empty($nombre) || empty($apellido) || empty($dni) || empty($mail) || empty($fechaalta)) {
    echo json_encode(["error" => "Por favor, completa todos los campos obligatorios."]);
    exit;
}

// Verifica si el DNI ya existe en la base de datos
$query = "SELECT * FROM alumno WHERE dni = '$dni'";
$result = mysqli_query($mysqli, $query);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(["error" => "El DNI ya existe en la base de datos."]);
    exit;
}

// Preparamos la consulta para insertar los datos del alumno
$query = "INSERT INTO alumno (nombre, apellido, dni, mail, idusuario, fechaalta, alumnoactivo) 
          VALUES ('$nombre', '$apellido', '$dni', '$mail', '$idUsuario', '$fechaalta', 1)";

$result = mysqli_query($mysqli, $query);

if ($result) {
    echo json_encode(["message" => "Alumno dado de alta correctamente"]);
} else {
    echo json_encode(["error" => "Error al insertar los datos del alumno."]);
}

?>
