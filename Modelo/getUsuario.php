<?php

include_once('conexion.php');/*Nombre del archivo donde conecta a la base de datos*/

$dni = isset($_POST['dni']) ? $_POST['dni'] : '';

echo getUsuario($dni);/*Llamamos a la funcion getUsuario*/


function getUsuario($dni)/*Creamos  la funcion getUsuario que va a solicitar los datos al servidor */
{
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/


    $query = "SELECT idusuario, dniusuario, contrasenia, mailusuario, usuarioactivo FROM usuario WHERE dniusuario = ?";
    /*Pedimos los datos de la tabla usuario de la base de datos*/
    
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    $usuario = array();/*Creamos el array el cual va a guarda los datos de los usuarios obtenidos */

    
    while($row = $result->fetch_assoc())
    {/*Recorre la matriz resultado de manera asociativa y se guarda en el array tipo usuario*/
        $usuario[] = $row;
    }
    $stmt->close();
    $mysqli->close();

    return json_encode($usuario);/*convierte los datos a formato json*/

    /*json es un formato liviano para el intercambio de datos, en este caso traemos datos de la base de datos, los convertimos en json y lo enviamos 
    al formulario y lo mostrampos en una tabla*/



    
}