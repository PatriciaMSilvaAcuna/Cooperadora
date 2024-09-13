<?php
// Incluir archivo de conexión a la base de datos
include_once('conexion.php'); 

// Función para obtener el correo del alumno
function obtenerCorreoEstudiante($id_estudiante) {
    // Establecer la conexión con la base de datos
    $mysqli = conexion();

    // Verificar conexión
    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    // Consulta SQL para obtener el correo electrónico del estudiante
    $sql = "SELECT mail FROM alumno WHERE idalumno = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        // Vincular parámetros
        $stmt->bind_param("i", $id_estudiante);
        $stmt->execute();
        // Vincular resultados
        $stmt->bind_result($email);
        
        // Obtener el resultado
        if ($stmt->fetch()) {
            $stmt->close();
            $mysqli->close();
            return $email;
        } else {
            $stmt->close();
            $mysqli->close();
            return null; // O maneja el caso en el que no se encuentra el correo
        }
    } else {
        // Manejar errores en la preparación de la consulta
        $mysqli->close();
        return null; // O maneja el caso de error
    }
}

// Ejemplo de uso (para pruebas)
if (isset($_POST['idalumno'])) {
    $id_estudiante = $_POST['idalumno'];
    $email = obtenerCorreoEstudiante($id_estudiante);
    if ($email) {
        echo json_encode(array('email' => $email));
    } else {
        echo json_encode(array('email' => null));
    }
}
?>
