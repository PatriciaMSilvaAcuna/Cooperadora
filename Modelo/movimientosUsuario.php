<?php
// Requiere el archivo de conexión para establecer la conexión con la base de datos
require_once 'conexion.php';

// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establecer el encabezado para indicar que la respuesta será en formato JSON
header('Content-Type: application/json');

// Verificar si los parámetros 'dni', 'fechaInicio' y 'fechaFin' han sido proporcionados
if (isset($_POST['dni'], $_POST['fechaInicio'], $_POST['fechaFin'])) {
    // Obtener los valores de los parámetros enviados en la solicitud POST
    $dni = $_POST['dni'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

       // Establecer la conexión con la base de datos
    $conexion = conexion();

    // Consultar el idusuario a partir del dni proporcionado
    $sql_idusuario = "SELECT idusuario FROM usuario WHERE dniusuario = ?";
    $stmt_idusuario = $conexion->prepare($sql_idusuario);
    $stmt_idusuario->bind_param("i", $dni);
    $stmt_idusuario->execute();
    $result_idusuario = $stmt_idusuario->get_result();
    
     // Verificar si se encontró un usuario con el DNI proporcionado
    if ($row_idusuario = $result_idusuario->fetch_assoc()) {
        $idusuario = $row_idusuario['idusuario'];// Almacenar el idusuario obtenido
    } else {
         // Si no se encuentra el usuario, devuelve un error en formato JSON y detiene la ejecución
        echo json_encode(['error' => 'No se encontró el usuario con el DNI proporcionado']);
        exit;
    }

    // Cerrar statement de idusuario
    $stmt_idusuario->close();

     // Crear un array para almacenar los resultados de las consultas
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
    tipousuario ON usuario.idtipousuario = tipousuario.idtipousuario
WHERE 
    usuario.idusuario = ?";
     
     // Preparar y ejecutar la consulta para obtener la información del usuario
    $stmt_usuario = $conexion->prepare($sql_usuario);
    $stmt_usuario->bind_param("i", $idusuario); // Vincula el idusuario
    $stmt_usuario->execute(); // Ejecuta la consulta
    $result_usuario = $stmt_usuario->get_result(); // Obtiene los resultados
    $results['usuario'] = $result_usuario->fetch_all(MYSQLI_ASSOC); // Almacena los resultado en el array.
    $stmt_usuario->close(); // Cierra la consulta preparada

    // Consultar información del alumno
    $sql_alumno = "SELECT 
    a.idalumno,
    a.nombre,
    a.apellido,
    a.mail,
    a.deuda,
    a.fechaalta
    
FROM 
    alumno a 
WHERE 
    a.idusuario = ? AND a.fechaalta BETWEEN ? AND ?;
";
    $stmt_alumno = $conexion->prepare($sql_alumno);
    $stmt_alumno->bind_param("iss", $idusuario, $fechaInicio, $fechaFin);
    $stmt_alumno->execute();
    $result_alumno = $stmt_alumno->get_result();
    $results['alumno'] = $result_alumno->fetch_all(MYSQLI_ASSOC);
    $stmt_alumno->close();

    // Consultar información de pagos dentro del rango de fechas
    $sql_pagos = "SELECT 
    cp.idcargapago,
    cp.fecha,
    cp.valorabonado,
    c.concepto as concepto,
    a.idalumno,
    mp.metodopago AS metodo_pago
FROM 
    cargapago cp
JOIN 
    usuario u ON cp.idusuario = u.idusuario
JOIN 
    metodopago mp ON cp.idmetodopago = mp.idmetodopago
JOIN    
    alumno a ON cp.idalumno = a.idalumno
JOIN 
    concepto c ON cp.idconcepto = c.idconcepto    
WHERE 
    u.idusuario = ? AND cp.fecha BETWEEN ? AND ?;
";
    $stmt_pagos = $conexion->prepare($sql_pagos);
    $stmt_pagos->bind_param("iss", $idusuario, $fechaInicio, $fechaFin); // Vincula los parametros
    $stmt_pagos->execute(); // Ejecuta la consulta
    $result_pagos = $stmt_pagos->get_result(); // Obtiene los resultados
    $results['pagos'] = $result_pagos->fetch_all(MYSQLI_ASSOC); // Almacena o gurda los resultados en el array
    $stmt_pagos->close(); // Cierra el Statement.

    // Devolver los resultados como JSON
    echo json_encode($results);

    // Cerrar la conexión
    $conexion->close();

} else {
    echo json_encode(['error' => 'No se recibieron los parámetros necesarios']);
}
?>
