<?php
$conexion=mysqli_connect("localhost","root","","cooperadora") or
    die("Problemas con la conexión");

$registros=mysqli_query($conexion,"select *,id_Empleado,
                        usuario, contrasena, id_Tipo_de_usuario from empleado where usuario ='$_REQUEST[usuario]' and contrasena = '$_REQUEST[contrasena]'") or
  die ("problemas en el select:".mysqli_error($conexion));
session_start();
if ($reg=mysqli_fetch_array($registros))
{

    if ($reg ['estado'] == 1){
         $_SESSION['usuario'] = $reg['usuario'];
         $_SESSION['id_Tipo_de_usuario'] = $reg ['id_Tipo_de_usuario'];
          $_SESSION['id_Empleado'] = $reg ['id_Empleado']; // Almaceno id_Empleado
            if ($reg['id_Tipo_de_usuario']==1){
                $_SESSION['usuario'];
                    header('location: ..\Modelo\accesoAceptadoAdmin.php');
                }
                else {
                    $_SESSION['usuario'];
                    header('location: ..\Modelo\accesoAceptadoVendedor.php');
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
