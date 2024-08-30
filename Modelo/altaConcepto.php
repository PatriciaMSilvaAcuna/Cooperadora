<?php

include_once('conexion.php'); // Archivo de conexión a la base de datos

// Verifica si el parámetro 'function' está presente y es válido
if (!isset($_POST['function']) || $_POST['function'] !== 'saveNewConcept') {
    echo json_encode(array("error" => "Acción no reconocida."));
    exit;
}

// Llama a la función para guardar el nuevo concepto
echo saveNewConcept();

function saveNewConcept() {
    // Conectar a la base de datos
    $mysqli = conexion();

    // Verificar si la conexión fue exitosa
    if ($mysqli->connect_error) {
        return json_encode(array("error" => "Error de conexión: " . $mysqli->connect_error));
    }

    // Obtener datos del formulario
    $concepto = $_POST['concepto'];
    $valor = $_POST['valor'];
    $anio = $_POST['anio'];

    // Iniciar una transacción
    $mysqli->begin_transaction();

    try {
        // Llamada a la consulta para insertar en la tabla concepto
        $query_concepto = "INSERT INTO concepto (concepto) VALUES (?)";
        $stmt_concepto = $mysqli->prepare($query_concepto);

        // Verifica si la preparación de la consulta fue exitosa
        if (!$stmt_concepto) {
            throw new Exception("Error en la preparación de la consulta para concepto: " . $mysqli->error);
        }

        // Enlazar el parámetro
        $stmt_concepto->bind_param("s", $concepto);

        // Ejecutar la consulta
        if (!$stmt_concepto->execute()) {
            throw new Exception("Error al insertar en la tabla concepto: " . $stmt_concepto->error);
        }

        // Obtener el idconcepto del último registro insertado
        $idconcepto = $stmt_concepto->insert_id;

        // Cerrar la declaración de concepto
        $stmt_concepto->close();

        // Llamada a la consulta para insertar en la tabla administracion
        $query_admin = "INSERT INTO administracion (valorconcepto, aniovigente, idconcepto) VALUES (?, ?, ?)";
        $stmt_admin = $mysqli->prepare($query_admin);

        // Verifica si la preparación de la consulta fue exitosa
        if (!$stmt_admin) {
            throw new Exception("Error en la preparación de la consulta para administracion: " . $mysqli->error);
        }

        // Enlazar los parámetros
        $stmt_admin->bind_param("sii", $valor, $anio, $idconcepto);

        // Ejecutar la consulta
        if (!$stmt_admin->execute()) {
            throw new Exception("Error al insertar en la tabla administracion: " . $stmt_admin->error);
        }

        // Cerrar la declaración de administracion
        $stmt_admin->close();

        // Confirmar la transacción
        $mysqli->commit();
        
        return json_encode(array("success" => "El Concepto fue dado de alta correctamente."));

    } catch (Exception $e) {
        // En caso de error, realizar un rollback
        $mysqli->rollback();
        return json_encode(array("error" => $e->getMessage()));
    } finally {
        // Cerrar la conexión
        $mysqli->close();
    }
}
