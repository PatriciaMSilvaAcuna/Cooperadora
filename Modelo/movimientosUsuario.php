<?php
require_once 'conexion.php';
require_once 'Alumno.php'; 
// Verificar si se ha recibido el DNI por POST
if (isset($_POST['dni'])) {
    $dni = $_POST['dni'];
   // require_once 'conexion.php'; // Incluir el archivo que contiene la función de conexión
    //require_once 'Alumno.php'; // Asegúrate de incluir la clase Alumno si es necesario
    $conexion = conexion();
    // Consulta SQL con INNER JOIN para obtener los movimientos del alumno por DNI
    $sql = "SELECT usuario.Dni_usuario, alumno.nombre, alumno.apellido, carga_pago.valorAbonado, carga_pago.fecha, metodo_de_pago.tipo_de_Pago 
    FROM carga_pago 
    INNER JOIN alumno ON carga_pago.id_alumno = alumno.id_alumno 
    INNER JOIN usuario ON usuario.Id_Usuario = carga_pago.id_usuario 
    INNER JOIN metodo_de_pago ON carga_pago.id_metodoDePago = metodo_de_pago.id_metodoDePago 
    WHERE usuario.Dni_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $alumnos = array();

        while ($row = $result->fetch_assoc()) {
            // Crear objeto Alumno y almacenarlo en un arreglo
            $alumno = new Alumno($row['nombre'], $row['apellido'], $row['valorAbonado'], $row['fecha'], $row['tipo_de_Pago']);
            $alumnos[] = $alumno->toArray();
        }

        // Devolver los datos como JSON para que jQuery los maneje
        echo json_encode($alumnos);
    } else {
        // Si no hay resultados, devolver un arreglo vacío
        echo json_encode([]);
    }

} else {
    // Si no se recibió el DNI por POST, devolver un mensaje de error
    echo json_encode(['error' => 'No se recibió el DNI']);
}
?>
