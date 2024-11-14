<?php

include_once('conexion.php');/*Nombre del archivo donde conecta a la base de datos*/

echo getTipoUsuario();/*Llamamos a la funcion getUsuario*/


function getTipoUsuario()/*Creamos  la funcion getUsuario que va a solicitar los datos al servidor */
{
    $mysqli = conexion();/*conexion a la base de datos. desde el archivo conexion, que esta adentro de la carpeta modelo*/


    $query = "SELECT * FROM tipousuario";/*Pedimos los datos de la tabla categoria de la base de datos*/

    $result = $mysqli->query($query);/*Guarda la matriz resultado en base de la que pedimos*/

    $tipoUsuario = array();/*Creamos el array el cual va a guarda los datos de los tipo de usuarios obtenidos */

    while($row = $result->fetch_assoc())
    {/*Recorre la matriz resultado de manera asociativa y se guarda en el array tipo usuario*/
        $tipoUsuario[] = $row;
    }
    
    // Cierra la conexion a la BBDD.
    $mysqli->close();

    return json_encode($tipoUsuario);/*convierte los datos a formato json*/
    
    /*json es un formato liviano para el intercambio de datos, en este caso traemos datos de la base de datos, los convertimos en json y lo enviamos 
    al formulario y lo mostrampos en una tabla*/
    
}

