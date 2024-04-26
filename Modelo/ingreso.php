<?php
require_once('conexion.php'); // Nombre del archivo donde conecta a la base de datos

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $conexion = conexion();

    $query = "SELECT * from usuario WHERE Usuario = '$usuario' AND contrasenia = '$contrasena' AND estado = 1";
    $result = $conexion -> query($query);
    if ($result -> num_rows > 0) {
            session_start();
            header("Location: ../Vista/accesoAceptadoAdmin.html");
        } else {
            header("Location: ../Vista/accesoAceptadoOperador.html");
    } 

   // mysqli_close($mysqli);

?>
