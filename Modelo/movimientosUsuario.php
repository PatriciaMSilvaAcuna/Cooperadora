<?php
require_once 'conexion.php';
require_once 'alumno.php';

header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

// Verificar si se ha recibido el DNI por POST
if (isset($_POST['dni'])) {
    $dni = $_POST['dni'];
    $conexion = conexion();

    $sql = "SELECT usuario.dniusuario, alumno.nombre, alumno.apellido, cargapago.valorabonado, cargapago.fecha, metodopago.metodopago 
            FROM cargapago 
            INNER JOIN alumno ON cargapago.idalumno = alumno.idalumno 
            INNER JOIN usuario ON usuario.idusuario = cargapago.idusuario 
            INNER JOIN metodopago ON cargapago.idmetodopago = metodopago.idmetodopago 
            WHERE usuario.dniusuario = ?";
    
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $alumnos = array();

            while ($row = $result->fetch_assoc()) {
                $alumno = new Alumno($row['nombre'], $row['apellido'], $row['valorabonado'], $row['fecha'], $row['metodopago']);
                $alumnos[] = $alumno->toArray();
            }

            // Devolver los datos como JSON
            echo json_encode($alumnos);
        } else {
            echo json_encode([]); // Devolver un arreglo vacío si no hay resultados
        }
    } else {
        // Error al preparar la consulta
        echo json_encode(['error' => 'Error al preparar la consulta']);
    }
} else {
    // Si no se recibió el DNI por POST
    echo json_encode(['error' => 'No se recibió el DNI']);
}
?>
