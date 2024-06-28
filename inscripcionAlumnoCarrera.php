<?php
// Incluir el archivo de conexión a la base de datos
require_once('conexion.php');

// Verificar si se recibió el parámetro dni
if (isset($_GET['dni'])) {
    // Obtener el DNI del alumno desde la URL
    $dni = $_GET['dni'];
    $conexion = conexion();

    // Query para buscar la información del alumno
    $query_alumno = "SELECT * FROM alumno WHERE dni = $dni";
    $result_alumno = mysqli_query($conexion, $query_alumno);

    if (!$result_alumno) {
        die("Error en la consulta de alumno: " . mysqli_error($conexion));
    }

    // Preparar la respuesta en formato JSON
    $response = array();

    if (mysqli_num_rows($result_alumno) > 0) {
        $row = mysqli_fetch_assoc($result_alumno);
        $response['success'] = true;
        $response['alumno'] = $row;

        // Query para obtener todas las carreras
        $query_carreras = "SELECT * FROM carrera";
        $result_carreras = mysqli_query($conexion, $query_carreras);

        if ($result_carreras && mysqli_num_rows($result_carreras) > 0) {
            $carreras = array();
            while ($row_carrera = mysqli_fetch_assoc($result_carreras)) {
                $carreras[] = $row_carrera;
            }
            $response['carreras'] = $carreras;
        } else {
            $response['carreras'] = array(); // Si no hay carreras, enviar un array vacío
        }

    } else {
        $response['success'] = false;
        $response['message'] = "Alumno no encontrado para DNI: $dni";
    }

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);

    // Cerrar la conexión
    mysqli_close($conexion);
} else if (isset($_POST['id_alumno'], $_POST['id_carrera'])) {
    // Si se recibieron los parámetros necesarios para la inscripción

    $id_alumno = $_POST['id_alumno'];
    $id_carrera = $_POST['id_carrera'];
    $conexion = conexion();

    // Query para insertar la inscripción en la tabla
    $query_inscripcion = "INSERT INTO inscripcion (id_alumno, id_carrera) VALUES ($id_alumno, $id_carrera)";
    $result_inscripcion = mysqli_query($conexion, $query_inscripcion);

    if ($result_inscripcion) {
        $response['success'] = true;
        $response['message'] = "Inscripción realizada correctamente";
    } else {
        $response['success'] = false;
        $response['message'] = "Error al realizar la inscripción: " . mysqli_error($conexion);
    }

    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    // Si no se recibe el parámetro dni, devolver un mensaje de error
    $response['success'] = false;
    $response['message'] = "No se recibió el parámetro DNI";
    echo json_encode($response);
}
?>
