<?php

include_once('conexion.php'); // Contiene los datos de conexión de la base de datos

$nombrecarrera = isset($_POST['nombrecarrera']) ? $_POST['nombrecarrera'] : null; // Información que se usa del formulario

echo getCarrera($nombrecarrera); // Llama a la función y pasa por parámetro el nombre de la carrera

function getCarrera($nombrecarrera) {
    if ($nombrecarrera !== null) {
        $mysqli = conexion(); // Conecta a la base de datos
        
        // Ajusta la consulta SQL
        $query = "SELECT * FROM carrera WHERE carrera LIKE ?";
        $stmt = $mysqli->prepare($query);

        // Agrega los comodines '%' para búsqueda parcial
        $param = '%' . $nombrecarrera . '%';
        $stmt->bind_param("s", $param);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        $mysqli->close();

        if (count($data) > 0) {
            return json_encode($data);
        } else {
            // Retorna un mensaje de error si no se encuentran resultados
            return json_encode(array('error' => 'No se encontró carrera con ese nombre.'));
        }
    }
}
?>
