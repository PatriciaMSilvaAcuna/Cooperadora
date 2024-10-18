   /*Cargar carreras y realizar consulta con AJAX */
    
        document.addEventListener('DOMContentLoaded', function() {
            fetchCarreras();
        });

        function fetchCarreras() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../Modelo/lista_de_carreras.php', true);
            xhr.onload = function() {
                if (this.status === 200) {
                    if (this.responseText.includes('<option')) {
                        document.getElementById('carreras').innerHTML += this.responseText;
                    } else {
                        console.error('Error al cargar las carreras:', this.responseText);
                        alert('No se pudieron cargar las carreras. Por favor, verifica tu sesión.');
                    }
                } else {
                    console.error('Error en la solicitud AJAX:', this.status);
                }
            };
            xhr.onerror = function() {
                console.error('Error en la conexión AJAX.');
            };
            xhr.send();
        }

        function consultarRecaudacion(carreraSeleccionada) {
            if (carreraSeleccionada) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '../Modelo/consultar_recaudacion_carrera.php?idcarrera=' + carreraSeleccionada, true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        try {
                            var respuesta = JSON.parse(this.responseText);
                            
                            if (respuesta.error) {
                                console.error('Error en la respuesta PHP:', respuesta.error);
                                alert('Error al obtener los datos: ' + respuesta.error);
                                limpiarTabla();
                                return;
                            }

                            var data = respuesta.data;
                            actualizarTabla(data);
                        } catch (e) {
                            console.error('Error al parsear JSON:', e);
                            console.error('Respuesta recibida:', this.responseText);
                        }
                    }
                };
                xhr.onerror = function() {
                    console.error('Error en la conexión AJAX.');
                };
                xhr.send();
            } else {
                limpiarTabla();
            }
        }

        function actualizarTabla(data) {
            var tbody = document.querySelector('#recaudacionTabla tbody');
            tbody.innerHTML = ''; // Limpiar la tabla antes de actualizar

            if (data.length === 0) {
                var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.setAttribute('colspan', '2');
                td.classList.add('text-center');
                td.textContent = 'No hay datos disponibles para la carrera seleccionada.';
                tr.appendChild(td);
                tbody.appendChild(tr);
                return;
            }

            data.forEach(function(item) {
                var tr = document.createElement('tr');

                var tdIdAlumno = document.createElement('td');
                tdIdAlumno.textContent = item.idalumno; // Muestra el ID del alumno
                tr.appendChild(tdIdAlumno);

                var tdTotalPagado = document.createElement('td');
                tdTotalPagado.textContent = '$' + parseFloat(item.total_pagado).toLocaleString('es-AR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                tr.appendChild(tdTotalPagado);

                tbody.appendChild(tr);
            });
        }

        function limpiarTabla() {
            var tbody = document.querySelector('#recaudacionTabla tbody');
            tbody.innerHTML = '';
        }

        // Añadir evento onchange al select de carreras
        document.getElementById('carreras').addEventListener('change', function() {
            var carreraSeleccionada = this.value;
            consultarRecaudacion(carreraSeleccionada);
        });
