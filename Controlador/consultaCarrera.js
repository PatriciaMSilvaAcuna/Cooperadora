   /*Cargar carreras y realizar consulta con AJAX */

// Este evento se dispara cuando el DOM está completamente cargado    
document.addEventListener('DOMContentLoaded', function() {
           // Llama a la función para cargar las carreras al inicio
            fetchCarreras();
        });
// Función para obtener las carreras desde el servidor
function fetchCarreras() {
            // Crea una nueva solicitud HTTP usando XMLHttpRequest
            var xhr = new XMLHttpRequest();

             // Configura la solicitud GET para obtener las carreras desde un archivo PHP
            xhr.open('GET', '../Modelo/lista_de_carreras.php', true);

            // Define lo que sucede cuando la solicitud se completa con éxito
            xhr.onload = function() {
                if (this.status === 200) {
                     // Si la respuesta contiene un <option>, se asume que son datos de carrera válidos
                    if (this.responseText.includes('<option')) {
                        // Agrega el contenido de la respuesta al elemento select con id 'carreras'
                        document.getElementById('carreras').innerHTML += this.responseText;
                    } else {
                        // Si la respuesta no es válida, se muestra un mensaje de error
                        console.error('Error al cargar las carreras:', this.responseText);
                        alert('No se pudieron cargar las carreras. Por favor, verifica tu sesión.');
                    }
                } else {
                    // Si la solicitud falla (por ejemplo, problemas con el servidor), se muestra un mensaje de error
                    console.error('Error en la solicitud AJAX:', this.status);
                }
            };
            // Manejo de errores de conexión (por ejemplo, si no se puede acceder al servidor)
            xhr.onerror = function() {
                console.error('Error en la conexión AJAX.');
            };
             // Envía la solicitud
            xhr.send();
}

// Función para consultar la recaudación de una carrera seleccionada
function consultarRecaudacion(carreraSeleccionada) {
            // Si se ha seleccionado una carrera, realiza la consulta AJAX
            if (carreraSeleccionada) {
                var xhr = new XMLHttpRequest();
                 // Envía una solicitud GET con el ID de la carrera seleccionada
                xhr.open('GET', '../Modelo/consultar_recaudacion_carrera.php?idcarrera=' + carreraSeleccionada, true);
                
                // Define lo que ocurre cuando la solicitud se completa con éxito
                xhr.onload = function() {
                    if (this.status === 200) {
                        try {
                             // Intenta parsear la respuesta JSON
                            var respuesta = JSON.parse(this.responseText);
                            
                            // Si la respuesta contiene un error, muestra el error
                            if (respuesta.error) {
                                console.error('Error en la respuesta PHP:', respuesta.error);
                                alert('Error al obtener los datos: ' + respuesta.error);
                                limpiarTabla(); // Limpia la tabla si ocurre un error
                                return;
                            }
                             // Si la respuesta es válida, obtiene los datos de la recaudación
                            var data = respuesta.data;

                            // Llama a la función para actualizar la tabla con los datos recibidos
                            actualizarTabla(data);
                        } catch (e) {
                            // Si ocurre un error al parsear el JSON, muestra un mensaje de error
                            console.error('Error al parsear JSON:', e);
                            console.error('Respuesta recibida:', this.responseText);
                        }
                    }
                };
                // Manejo de errores de conexión
                xhr.onerror = function() {
                    console.error('Error en la conexión AJAX.');
                };
                 // Envía la solicitud
                xhr.send();
            } else {
                // Si no se ha seleccionado ninguna carrera, limpia la tabla
                limpiarTabla();
            }
}

// Función para actualizar la tabla con los datos de la recaudación
function actualizarTabla(data) {
             // Obtiene el cuerpo de la tabla donde se mostrarán los datos
            var tbody = document.querySelector('#recaudacionTabla tbody');
            tbody.innerHTML = ''; // Limpia la tabla antes de actualizar con nuevos datos


            // Si no hay datos, muestra un mensaje indicando que no hay recaudación disponible
            if (data.length === 0) {
                var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.setAttribute('colspan', '2'); // Hace que la celda ocupe dos columnas
                td.classList.add('text-center'); // Centra el texto en la celda
                td.textContent = 'No hay datos disponibles para la carrera seleccionada.';
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }
            // Si hay datos, crea una fila para cada elemento en el arreglo
                data.forEach(function(item) {
                var tr = document.createElement('tr');

                 // Crea la celda para mostrar el ID de la carrera
                var tdIdCarrera = document.createElement('td');
                tdIdCarrera.textContent = item.idcarrera; // Muestra el ID de la carrera seleccionada
                tr.appendChild(tdIdCarrera);

                var tdTotalPagado = document.createElement('td');
                tdTotalPagado.textContent = '$' + parseFloat(item.total_pagado).toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2}); // Muestra siempre dos decimales
                tr.appendChild(tdTotalPagado);

                // Agrega la fila a la tabla
                tbody.appendChild(tr);
            });
 }

// Función para limpiar la tabla (cuando no hay datos o se selecciona una carrera sin datos)
function limpiarTabla() {
            var tbody = document.querySelector('#recaudacionTabla tbody');
            tbody.innerHTML = ''; // Elimina todo el contenido de la tabla
        }

        // Añadir evento onchange al select de carreras
        document.getElementById('carreras').addEventListener('change', function() {
            // Obtiene el ID de la carrera seleccionada
            var carreraSeleccionada = this.value;
            // Llama a la función para consultar la recaudación de la carrera seleccionada
            consultarRecaudacion(carreraSeleccionada);
        

});
