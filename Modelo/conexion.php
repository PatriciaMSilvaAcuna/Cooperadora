<?php
/**
 * Función que establece una conexión a la base de datos 'cooperadora'.
 * @return mysqli Objeto de conexión a la base de datos.
 */

function conexion()/*creamos la funcion conexion para que conecte la pagina con la base de datos*/
{    // Datos de configuración de la base de datos
    $host = "localhost";// Dirección del servidor de base de datos
    $db   = "cooperadora"; /*nombre de la BD*/   
    $usr  = "root";// Nombre de usuario para acceder a la base de datos
    $pass = ""; /*contraseña en este caso no tiene*/
    
    // Crea una nueva conexión MySQL con los datos de configuración
    $mysqli = new mysqli($host,$usr,$pass,$db);/*guarda los datos en la variable mysqli*/
    // Verifica si hubo algún error al intentar conectar
    if($mysqli->connect_errno)
    {/*en el caso que la conexio falle va a salir la leyenda "fallo la conexion"*/
        die("Fallo la conexión" . $mysqli->connect_errno);    
    }
    
    // Si la conexión es exitosa, retorna el objeto de conexión $mysqli
    return $mysqli;
}