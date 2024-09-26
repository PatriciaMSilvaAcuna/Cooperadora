<?php
require_once 'conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establecer el encabezado para devolver JSON
header('Content-Type: application/json');

// Verificar si los parámetros necesarios han sido proporcionados
if (isset($_POST['dni'], $_POST['fechaInicio'], $_POST['fechaFin'])) {
    $dni = $_POST['dni'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    // Crear la conexión
    $conexion = conexion();

    // Obtener idusuario a partir de dni
    $sql_idusuario = "SELECT idusuario FROM usuario WHERE dniusuario = ?";
    $stmt_idusuario = $conexion->prepare($sql_idusuario);
    $stmt_idusuario->bind_param("i", $dni);
    $stmt_idusuario->execute();
    $result_idusuario = $stmt_idusuario->get_result();
    
    // Verificar si se encontró el usuario
    if ($row_idusuario = $result_idusuario->fetch_assoc()) {
        $idusuario = $row_idusuario['idusuario'];
    } else {
        echo json_encode(['error' => 'No se encontró el usuario con el DNI proporcionado']);
        exit;
    }

    // Cerrar statement de idusuario
    $stmt_idusuario->close();

    // Crear array de resultados
    $results = ['usuario' => [], 'alumno' => [], 'pagos' => []];

    // Consultar información del usuario
    $sql_usuario = "SELECT 
    usuario.idusuario, 
    usuario.dniusuario, 
    usuario.mailusuario, 
    tipousuario.tipousuario, 
    usuario.usuarioactivo
FROM 
    usuario
INNER JOIN 
    tipousuario 
ON 
    usuario.idtipousuario = tipousuario.idtipousuario
WHERE 
    usuario.idusuario =  ?";
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param("i", $idusuario);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();
    $results['usuario'] = $result_usuario->fetch_all(MYSQLI_ASSOC);
    $stmt_usuario->close();

    // Consultar información del alumno
    $sql_alumno = "SELECT * FROM alumno WHERE idusuario = ?";
    $stmt_alumno = $conexion->prepare($sql_alumno);
    $stmt_alumno->bind_param("i", $idusuario);
    $stmt_alumno->execute();
    $result_alumno = $stmt_alumno->get_result();
    $results['alumno'] = $result_alumno->fetch_all(MYSQLI_ASSOC);
    $stmt_alumno->close();

    // Consultar información de pagos dentro del rango de fechas
    $sql_pagos = "SELECT * FROM cargapago WHERE idusuario = ? AND fecha BETWEEN ? AND ?";
    $stmt_pagos = $conexion->prepare($sql_pagos);
    $stmt_pagos->bind_param("iss", $idusuario, $fechaInicio, $fechaFin);
    $stmt_pagos->execute();
    $result_pagos = $stmt_pagos->get_result();
    $results['pagos'] = $result_pagos->fetch_all(MYSQLI_ASSOC);
    $stmt_pagos->close();

    // Devolver los resultados como JSON
    echo json_encode($results);

    // Cerrar la conexión
    $conexion->close();

} else {
    echo json_encode(['error' => 'No se recibieron los parámetros necesarios']);
}
?>
