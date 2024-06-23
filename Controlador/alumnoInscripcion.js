
$(document).ready(function() {

    iniciar();//se llama a la función iniciar cuando el documento se encuentra OK

    function iniciar (){
        buscarCarreras();
        //cuando se haga click en boton "Buscar alumno" de inscripcionAlumnoCarrera.hmtl se llama a
        // la funcion getDatosAlumnos
        //id = buscarAlumno del formulario = buscarAlumno
        $('#buscarAlumno').on('click', buscarDatosAlumnos);//anda OK

        //cuando presiona el boton "Inscripcion a carrera" de pagina "inscripcionAlumnoCarrera.html"
        //llama a la funcion nuevaInscrip
        $('#nueva-inscrip').on('click', nuevaInscrip);
    }

    function nuevaInscrip (){
        let inscripcionCarrera = $('#inscripcionCarrera').serialize();
        console.log("Respuesta del servidor:", inscripcionCarrera);//imprime informaricon por consola
        //generamos las variables para validaciones de valores de entrada null
        let id_alumno = $('#id-alumno').val();
        let anual = $('#año-inscrip').val();
        //carrera toma el valor del id de carrera
        let carrera = $('#carreras').val();

        //se corrobó con los alert que la informacion llega bien
       //alert ("valor de id ALUMNO " + id_alumno);
       //alert ("valor  DE INSCRIP" + año_inscrip);
       //alert ("que valor ID DE CARRERA me trae" + carrera);
        
        if (dni === '' || nombre === '' || apellido === ''|| id_alumno === '' || anual === '' || carrera ===''){
            alert('Por favor, completar. Falta información');
        } 
        else {
            $.ajax({
                type : 'POST',/*El tipo de peticion va a ser post*/
                url  : '../modelo/inscripCarrera.php',/* peticion al archivo setCliente.php que esta en la carpeta modelo */
                data : inscripcionCarrera,
                dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
                success : function(response){
                    console.log("Nuevo inscripción",response);
                    alert("Alumno inscripto a carrera correctamente");
                    //getCliente();
                    //limpiarForm();
                    
                }
            })

        }
    }

 


    function buscarCarreras(){ //funcion que nos trae informacion de todas las carreras 
        $.ajax({
            type: 'POST',
            url: '../Modelo/buscarCarrerasInscrip.php', 
            dataType: 'json', 
            success: function(data) {
                let options = '<option value="" disabled selected>Carreras</option>'; // Opción predeterminada
                for (let i = 0; i < data.length; i++) {
                    options += '<option value="' + data[i].id_carrera + '">' + data[i].carrera + '</option>';
                }
                $('#carreras').html(options); // Llena el select con las opciones
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los métodos de pago:', error); //Mostrar mensaje de error
            }
        });

    }

    function buscarDatosAlumnos(){
        let dni = $('#dni').val();
        if (dni === '') {
            alert('Por favor, complete el campo DNI');
            return; // Detén el envío si algún campo está vacío
        }
        else  {
                //generamos una variable que va tomar el valor del formulario "buscarAlumno"
                
                $.ajax ({
                    type : 'POST',/*El tipo de peticion va a ser post*/
                    data: { dni: dni }, //pasamos la informacion del DNI que se capturó del formulario
                    url  : '../Modelo/buscarAlumnoInscripcion.php',/* peticion al archivo getCliente.php que esta en la carpeta modelo */
                    dataType : 'JSON',/*El tipo de informacion que se espera de respuesta es JSON*/
                    success : function(data){
                        //let tabla = "<tr><th>Nombre</th><th>Apellido</th><th>DNI</th></tr>";
                        for (let i = 0; i < data.length; i++) {
                            let nombre = data[i].nombre;
                            let apellido = data[i].apellido;
                            let dni = data[i].dni;
                            let id_alumno = data[i].id_alumno;
                            //tabla += "<tr>" +
                              //  "<td>" + nombre + "</td>" +
                                //"<td>" + apellido + "</td>" +
                                //"<td>" + dni + "</td>" +
                                //"</tr>";
                                //llamamos otra funcion para cargar los input por pantalla
                                cargaInput(nombre, apellido, dni, id_alumno);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener los datos del alumno:', error); //Mostrar mensaje de error
                    }
                });
        }


function cargaInput (nombre, apellido, dni, id_alumno){
    var hoy = new Date().getFullYear();
    document.getElementById("nombre").value = nombre;
    document.getElementById("apellido").value = apellido;
    document.getElementById("dni2").value = dni;
    document.getElementById("id-alumno").value = id_alumno;
    document.getElementById("año-inscrip").value = hoy;

    
}




        
        
    }
})



