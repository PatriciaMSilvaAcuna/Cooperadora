$(document).ready(function() {
    iniciar(); // Se llama a la función iniciar cuando el documento se encuentra OK

    function iniciar() {
        $('#buscarAlumno').on('click', function(event) {
            event.preventDefault(); // Previene la recarga de la página
            buscarDatosAlumno();
        });
        $('#actualizarForm').on('submit', function(event) {
            event.preventDefault(); // Evita la recarga de la página
            actualizarAlumno(); // Llama a la función para actualizar el usuario
        });
    }

    function buscarDatosAlumno() {
        let dnialumno = $('#dnialumno').val();
        console.log('DNI del alumno ingresado:', dnialumno); // Verifica el DNI ingresado

        if (dnialumno === '') {
            alert('Por favor, complete el campo DNI');
            return; // Detén el envío si algún campo está vacío
        } else { 
            $.ajax({
                type: 'POST', // El tipo de petición va a ser POST
                data: { dnialumno: dnialumno }, // Pasamos la información del DNI
                url: '../Modelo/buscarAlumno.php', // Petición al archivo PHP
                dataType: 'JSON', // El tipo de información que se espera de respuesta es JSON
                success: function(data) {
                    console.log('Datos recibidos del servidor:', data); // Agrega esto para ver la respuesta del servidor
                    $('#dnialumno').val('');

                    if (data.error) {
                        alert(data.error); // Muestra el mensaje de error si no se encuentra el usuario
                    } else {
                        // Itera sobre los datos obtenidos si no hay error
                        for (let i = 0; i < data.length; i++) {
                            let idalumno = data[i].idalumno;
                            let nombre = data[i].nombre;
                            let apellido = data[i].apellido;
                            let dniAlumno = data[i].dni; // Usar 'dni' si ese es el nombre correcto en el JSON
                            let deuda = data[i].deuda;
                            let mail = data[i].mail;
                            let fechalta = data[i].fechalta;
                            let alumnoactivo = data[i].alumnoactivo;

                            // Llama a la función para cargar los inputs con los datos del usuario
                            cargarInputUsuario(idalumno, nombre, apellido, dniAlumno, deuda, mail, fechalta, alumnoactivo);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos del usuario:', error);
                    alert('Error al obtener los datos del usuario.');
                }
            });
        }
    }

    function cargarInputUsuario(idalumno, nombre, apellido, dniAlumno, deuda, mail, fechalta, alumnoactivo) {
        $('#idalumno').val(idalumno);
        $('#nombre').val(nombre);
        $('#apellido').val(apellido);
        $('#dniActualizar').val(dniAlumno);
        $('#deuda').val(deuda);
        $('#mail').val(mail);
        
        // Corrige la forma de establecer el estado del checkbox
        $('#alumnoactivo').prop('checked', alumnoactivo == 1);
    }

    function actualizarAlumno() {
        let formulario = $('#actualizarForm').serialize(); // Serializamos el formulario
        let idalumno = $('#idalumno').val(); // Asegúrate de que este ID coincida con el campo oculto del formulario
        formulario += "&idalumno=" + idalumno; // Añades el idalumno al formulario

        let mail = $('#mail').val(); // Obtener el email para validar
        // Validación de formato para el campo de email
        if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(mail)) {
            alert('Por favor, introduce un email válido.');
            return;
        }

        console.log("Datos enviados: ", formulario); // Verifica que los datos se están enviando correctamente

        $.ajax({
            type: 'POST',
            url: '../Modelo/actualizarAlumno.php', // Petición a PHP
            data: formulario, // Envío del formulario completo
            dataType: 'JSON',
            success: function(response) {
                // Manejo de la respuesta del servidor
                if (response.success) {
                    alert('Datos actualizados correctamente.');
                    limpiarForm();
                } else {
                    alert(response.message || 'Error al actualizar los datos.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al actualizar el usuario:', status, error);
                alert('Error al actualizar los datos. Estado: ' + status + ', Error: ' + error);
            }
        });
    }

    function limpiarForm() {
        $('#actualizarForm')[0].reset();
    }
});
