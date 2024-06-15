<?php
require 'verificar_sesion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Panel de Administración</title>
	<link rel="icon" href="../logoInstituto.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="../Controlador/cerrarSesion.js"></script> 
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">    
</head>
<header>
	  <div class="Card">
         <div class="d-flex justify-content-sm-center bg-light">
            <div class="p-2  flex-fill"><img src="../logo.jpg" alt="ISFT182"width="4%" class="float-start">

            <button type="button" class="btn btn-outline-primary btn-lg ms-auto float-end" onclick="cerrarSesion()">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
            </div>
         </div> 
       </div>   	
</header>	
<body >
	<div class="container-fluid text-center h-100 ">
		
         <div class="card custom-card">
 	        <br>
            <h1 style="color: skyblue;">Panel de Administración</h1>
             <br>
              <button type="button" class="btn btn-outline-primary btn-lg" onclick="window.location.href='configuracionUsuario.html'">Usuarios</button>
             <button type="button" class="btn btn-outline-primary btn-lg" onclick="window.location.href='altaAlumno.html'">Alumnos</button>
             <button type="button" class="btn btn-outline-primary btn-lg" onclick="window.location.href='consultas.html'">Consultas</button>
            
         
    </div>
 </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>   

</body>
<a href="../index.html" class="btn btn-primary btn-lg float-end ">Salir</a>

<footer class="text-center bg-dark text-white py-3 fixed-bottom">
       <p>© 2024 Cooperadora. Todos los derechos reservados.</p>
</footer>	
</html>