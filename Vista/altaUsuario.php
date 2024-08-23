<?php
require 'verificar_sesion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" href="../oldlogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../Vista/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Alta Usuario</title>
</head>
<header>
      <div class="Card">
         <div class="d-flex justify-content-sm-center bg-light">
            <div class="p-2  flex-fill"><img src="../oldlogo.png" alt="ISFT182"width="4%" class="float-start">

            <button type="button" class="btn btn-outline-primary btn-lg ms-auto float-end" onclick="cerrarSesion()">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
            </div>
         </div> 
       </div>       
</header>   
<body>
    <div class="container-fluid vh-60">
        <div class="row">
            <div class="col-md-6 main-content">
                <form id="formulario">
                    <fieldset>
                        <b><legend class="text-primary">Datos del Usuario</legend></b>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" class="form-control" id="usuario" name="usuario"/>
                        </div>

                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="text" class="form-control" id="dni" name="dni">
                        </div>
                        <div class="mb-3">

                            <label for="contrasenia" class="form-label">Contraseña:</label>
                            <input type="text" class="form-control" id="contrasenia" name="contrasenia">
                        </div>
                        <div class="mb-3">

                            <fieldset>
    <legend class="tipoUsuario">Tipo de Usuario:</legend>
  <select class="input100" name="tipoUsuario"id="tipoUsuario"></select> 
                            </fieldset> 
                          
                         </div>   
                    <button type="button" class="btn btn-primary" id="darAlta">Dar de Alta</button>
                    
                </form>
            </div>
        </div>
    </div>
 <br>
    <table id = "usuarios" border = "3"></table>
     
<script src = "https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src = "../Controlador/usuario.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<footer class="text-center bg-dark text-white py-3 position-fixed fixed-bottom">
       <p>© 2024 Cooperadora. Todos los derechos reservados.</p>
</footer>   

</body>
</html>
