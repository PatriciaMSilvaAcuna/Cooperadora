<?php

include_once('conexion.php');/*Nombre del archivo donde conecta a la base de datos*/

$function = $_POST['function'];

if($function == 1) {echo saveNewConcept();}
else if($function == 2) {echo getConcept();}
else if($function == 3) {echo updateConcept();}


function saveNewConcept()/*Creamos  la funcion que va a guardar nuevos datos a la tabla*/
{
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/

    $concepto = $_POST['concepto'];
    $valor = $_POST['valor'];
    
   // Llamada al procedimiento almacenado
    $stmt = $mysqli->prepare("INSERT INTO concepto(Nombre_Cocepto) values (?)");
    $stmt->bind_param("s", $concepto);
    
    if ($stmt->execute()) {
        return json_encode("El Concepto fue dado de alta correctamente");
    } else {
        return json_encode("Hubo un fallo al dar de alta del Concepto");
    }
}
