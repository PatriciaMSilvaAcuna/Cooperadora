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
    // Conecta a la base de datos
    $mysqli = conexion();

    // Verifica si la conexión fue exitosa
    if ($mysqli->connect_error) {
        return json_encode(array("error" => "Error de conexión: " . $mysqli->connect_error));
    }

    // Obtengo datos del formulario
    $concepto = $_POST['concepto'];
    $valor = $_POST['valor'];
    $anio = $_POST['anio'];

    // Inicio una transacción
    $mysqli->begin_transaction();

    try {
        // Llamada a la consulta para insertar en la tabla concepto
        $query_concepto = "INSERT INTO concepto (concepto) VALUES (?)";
        $stmt_concepto = $mysqli->prepare($query_concepto);

        // Verifica si la preparación de la consulta fue exitosa
        if (!$stmt_concepto) {
            throw new Exception("Error en la preparación de la consulta para concepto: " . $mysqli->error);
        }

        // Enlaza el parámetro
        $stmt_concepto->bind_param("s", $concepto);

        // Ejecuta la consulta
        if (!$stmt_concepto->execute()) {
            throw new Exception("Error al insertar en la tabla concepto: " . $stmt_concepto->error);
        }

        // Obtengo el idconcepto del último registro insertado
        $idconcepto = $stmt_concepto->insert_id;

        // Cierro la declaración de concepto
        $stmt_concepto->close();

        // Llamada a la consulta para insertar en la tabla administracion
        $query_admin = "INSERT INTO administracion (valorconcepto, aniovigente, idconcepto) VALUES (?, ?, ?)";
        $stmt_admin = $mysqli->prepare($query_admin);

        // Verifica si la preparación de la consulta fue exitosa
        if (!$stmt_admin) {
            throw new Exception("Error en la preparación de la consulta para administracion: " . $mysqli->error);
        }

        // Enlaza los parámetros
        $stmt_admin->bind_param("sii", $valor, $anio, $idconcepto);

        // Ejecuta la consulta
        if (!$stmt_admin->execute()) {
            throw new Exception("Error al insertar en la tabla administracion: " . $stmt_admin->error);
        }

        // Cierra la declaración de administracion
        $stmt_admin->close();

        // Confirma la transacción
        $mysqli->commit();
        
        return json_encode(array("success" => "El Concepto fue dado de alta correctamente."));

    } catch (Exception $e) {
        // En caso de error, realizar un rollback
        $mysqli->rollback();
        return json_encode(array("error" => $e->getMessage()));
    } finally {
        // Cierra la conexión
        $mysqli->close();
    }
}
