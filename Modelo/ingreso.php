<?php
$conexion=mysqli_connect("localhost","root","","cooperadora") or
    die("Problemas con la conexión");

$registros=mysqli_query($conexion,"select id_usuario,
                        Usuario,contrasenia,Id_tipodeusuario,estado from usuario where Usuario ='$_REQUEST[usuario]' and contrasenia = '$_REQUEST[contrasena]'") or
  die ("problemas en el select:".mysqli_error($conexion));
session_start();
if ($reg=mysqli_fetch_array($registros))
{

    if ($reg ['estado'] == 1){
         $_SESSION['usuario'] = $reg['usuario'];
         $_SESSION['Id_tipodeusuario'] = $reg ['Id_tipodeusuario'];
          $_SESSION['id_usuario'] = $reg ['id_usuario']; // Almaceno id_usuario
            if ($reg['Id_tipodeusuario']==1){
                $_SESSION['usuario'];
                    header('location: ..\Vista\accesoAceptadoAdmin.html');
                }
                else {
                    $_SESSION['usuario'];
                    header('location: ..\Vista\accesoAceptadoVendedor.html');
                }
    }
    else {
        echo "No tiene permiso de acceso";
    }
    
  }

else
{
  echo "No existe usuario.";
}
mysqli_close($conexion);
?>
