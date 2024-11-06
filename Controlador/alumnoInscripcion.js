$(document).ready(function() {

    iniciar();// Se llama a la función iniciar cuando el documento está listo

    function iniciar (){
        buscarCarreras();

        // Al hacer clic en "Buscar alumno", se llama a la función getDatosAlumnos
        $('#buscarAlumno').on('click', getDatosAlumnos);

        // Al hacer clic en "Inscripción a carrera", se llama a la función nuevaInscrip
        $('#nueva-inscrip').on('click', nuevaInscrip);
    }

   
// Función para inscribir a un alumno en una carrera
function nuevaInscrip() {
    let inscripcionCarrera = $('#inscripcionCarrera').serialize();
    let idalumno = $('#idalumno').val();
    let anual = $('#año-inscrip').val();
    let dni = $('#dni').val(); // 
    let mail = $('#mail').val(); // Validación de email
    let idcarrera = $('#idcarrera').val();

    // Validación de campos vacíos
    if (dni === '' || idalumno === '' || anual === '' || idcarrera === '') {
        alert('Por favor, complete todos los campos obligatorios.');
        return;
    }

    // Validación de DNI (solo números)
    if (!/^\d+$/.test(dni)) {
        alert('El campo DNI solo puede contener números.');
        return;
    }

    // Validación del email (formato básico)
    if (mail !== '' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(mail)) {
        alert('Por favor, ingrese un correo electrónico válido.');
        return;
    }

    // Validación del año (debe ser un número de 4 dígitos)
    if (!/^\d{4}$/.test(anual)) {
        alert('Por favor, ingrese un año válido (4 dígitos).');
        return;
    }

    // Imprimir los datos a enviar para depuración
    console.log("Datos a enviar:", inscripcionCarrera);

    // Si todo es correcto, hacer la petición AJAX
    $.ajax({
        type: 'POST',
        url: '../modelo/inscripCarrera.php',
        data: inscripcionCarrera,
        dataType: 'JSON',
        success: function (response) {
            console.log("Respuesta del servidor:", response); // Imprimir respuesta para depuración

            // Manejar la respuesta
            if (response.error) {
                alert(response.error); // Mostrar el error en un alert
            } else {
                alert(response.message); // Mostrar el mensaje de éxito
                limpiarFormulario();
            }
        },
        error: function (xhr, status, error) {
            alert("Ocurrió un error al inscribir al alumno.");
            console.error("Error:", status, error);
        }
    });
}



    // Función que trae información de las carreras disponibles
    function buscarCarreras(){
        $.ajax({
            type: 'POST',
            url: '../Modelo/buscarCarrerasInscrip.php', 
            dataType: 'json', 
            success: function(data) {
                let options = '<option value="" disabled selected>Carreras</option>';
                for (let i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].idcarrera + '">' + data[i].carrera + '</option>';
                }
                $('#idcarrera').html(options);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener las carreras:', error);
            }
        });
    }

    // Función que busca los datos del alumno por su DNI
    function getDatosAlumnos(){
        let dni = $('#dni').val();

        // Validación de campo DNI
        if (dni === '') {
            alert('Por favor, complete el campo DNI');
            return;
        }

        // Validar que el DNI solo contenga números y que tenga una longitud adecuada
        if (!/^\d+$/.test(dni) || dni.length < 7 || dni.length > 8) {
            alert('El DNI ingresado no es válido. Debe contener solo números y tener entre 7 y 8 dígitos.');
            return;
        }

        // Realizar la búsqueda del alumno si pasa las validaciones
        $.ajax({
            type : 'POST',
            data: { dni: dni },
            url  : '../Modelo/buscarAlumnoInscripcion.php',
            dataType : 'JSON',
            success : function(response){
                console.log('Datos recibidos del servidor:', response);
                if(response.error){
                alert(response.error); // Mostrar el error en un alert
            } else if (response.length > 0) {
                let alumno = response[0];
                let nombre = alumno.nombre;
                let apellido = alumno.apellido;
                let idalumno = alumno.idalumno;
                let mail = alumno.mail;
                
                cargaInput(nombre, apellido, dni, idalumno, mail);
                }else{


                    alert('No se encontró alumno con el DNI ingresado');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos del alumno:', error);
                alert('Error al obtener datos del alumno.');
            }
        });
    }

    // Función que carga los datos del alumno en el formulario
   function cargaInput(nombre, apellido, dni, idalumno, mail) {
    console.log('Cargando datos en el formulario:', {
        nombre: nombre,
        apellido: apellido,
        dni: dni,
        idalumno: idalumno,
        mail: mail
    });

    $("#nombre").val(nombre);
    $("#apellido").val(apellido);
    $("#dni2").val(dni);
    $("#idalumno").val(idalumno);
    $("#mail").val(mail);

    // Obtener el año actual y el siguiente
    const añoActual = new Date().getFullYear();
    const añoSiguiente = añoActual + 1;

    // Llenar el desplegable de año
    $("#año-inscrip").empty().append(`
        <option value="" disabled selected>Seleccionar año</option>
        <option value="${añoActual}">${añoActual}</option>
        <option value="${añoSiguiente}">${añoSiguiente}</option>
    `);
    alert('Alumno Encontrado.');
}
});
function limpiarFormulario() {
    // Selecciona el formulario y lo reinicia
    $('#dni').prop('value','');
    document.getElementById('inscripcionCarrera').reset();
    $('#dni').prop('value','');
    // document.getElementById('año-inscrip').value = '';
    // document.getElementById('carreras').selectedIndex = 0; // Deselecciona las opciones del select
}