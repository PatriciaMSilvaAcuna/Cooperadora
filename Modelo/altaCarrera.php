<?php
require_once('conexion.php');

// Crear una nueva conexión a la base de datos
$conexion = conexion();
session_start(); // Asegúrate de iniciar la sesión

// Procesar la solicitud POST
 // Verificar si nueva_carrera está definida y no está vacía
    if (isset($_POST['nueva_carrera']) && !empty($_POST['nueva_carrera'])) {
        $nueva_carrera = $_POST['nueva_carrera'];
        
        // Imprimir la carrera ingresada en los logs de PHP
        error_log("Carrera ingresada: " . $nueva_carrera);

    // Verificar si el campo de nueva carrera no está vacío
    if (!empty($nueva_carrera)) {
        // Preparar la consulta SQL para insertar la nueva carrera
        $sql = "INSERT INTO carrera (carrera) VALUES (?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            // Asociar el parámetro a la consulta preparada
            $stmt->bind_param("s", $nueva_carrera);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Enviar respuesta de éxito
                echo json_encode(array("status" => "success", "message" => "Carrera agregada exitosamente."));
            } else {
                // Enviar respuesta de error si la consulta falla
                echo json_encode(array("status" => "error", "message" => "Error al agregar la carrera: " . $stmt->error));
            }

            // Cerrar el statement
            $stmt->close();
        } else {
            // Enviar respuesta de error si la preparación del statement falla
            echo json_encode(array("status" => "error", "message" => "Error al preparar la consulta: " . $conexion->error));
        }
    } else {
        // Enviar respuesta de error si el campo está vacío
        echo json_encode(array("status" => "error", "message" => "Por favor, completa el campo de nueva carrera."));
    }
} else {
    // Enviar respuesta de error si no se usa el método POST
    echo json_encode(array("status" => "error", "message" => "Método no permitido."));
}

?>
