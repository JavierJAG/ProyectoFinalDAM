<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Estilos personalizados -->
<style>
    #calendar {
        max-width: 1000px;
        min-width: 800px;
        /* Ancho mínimo del calendario */
        height: 600px;
        /* Altura del calendario */
        margin: 20px auto;
        /* Centrando horizontalmente y con margen vertical de 20px */
    }

    #eventModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 1000;
        width: 350px;
        /* Ancho fijo para el modal */
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }
</style>

<div id="calendar"></div>

<div class="overlay" id="overlay"></div> <!-- Overlay para el modal -->
<div id="eventModal" class="p-4 border rounded shadow-lg bg-light">
    <h5 class="modal-title">Nueva Salida</h5>
    <form id="eventForm">
        <div class="mb-3">
            <label for="title" class="form-label">Objetivo de la salida:</label>
            <input type="text" oninput="limitDigits(this, 30)" class="form-control" name="title" id="title" required>
        </div>

        <div class="mb-3">
            <label for="provincia" class="form-label">Provincia</label>
            <select name="provincia" id="provincia" class="form-select" required>
                <option value="" selected></option>
                <option value="A CORUÑA" <?= old('provincia') == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
                <option value="LUGO" <?= old('provincia') == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
                <option value="OURENSE" <?= old('provincia') == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
                <option value="PONTEVEDRA" <?= old('provincia') == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="localidad" class="form-label">Localidad</label>
            <select name="localidad" id="localidad" class="form-select" required>
                <option value="" selected>Selecciona una localidad</option>
                <!-- Las localidades se cargarán aquí -->
            </select>
        </div>

        <div class="mb-3">
            <label for="zonaPesca" class="form-label">Zona de Pesca</label>
            <select name="zonaPesca" id="zonaPesca" class="form-select" required>
                <option value="" selected>Selecciona una zona de pesca</option>
                <!-- Las zonas de pesca se cargarán aquí -->
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar Evento</button>
        <button type="button" class="btn btn-secondary" id="closeModal">Cerrar</button>
    </form>
</div>

<!-- Modal para Detalles del Evento -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsLabel">Detalles de la salida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="eventDetails"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteEvent">Eliminar Salida</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            firstDay: 1,
            selectable: true,
            buttonText: {
                today: 'Hoy' // Cambia el texto del botón "Today" a "Hoy"
            },
            events: '<?= base_url('/user/salidas/events') ?>', // URL para obtener los eventos

            eventClick: function(info) {
                // Mostrar detalles del evento en el modal
                var event = info.event;
                var zonaLink = '<a href="/user/zonasPesca/' + event.extendedProps.zonaId + '" target="_blank">' + event.extendedProps.zonaNombre + '</a>';

                $('#eventDetails').html(
                    'Objetivo: ' + event.title + '<br>' +
                    'Fecha: ' + event.start.toISOString().slice(0, 10) + '<br>' +
                    'Zona de Pesca: ' + zonaLink // Cambiado para incluir el enlace
                );
                $('#deleteEvent').data('eventId', event.id); // Guarda el ID del evento en el botón de borrar
                var myModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
                myModal.show();
            },

            select: function(info) {
                // Verificar si la fecha seleccionada es anterior a hoy
                var today = new Date().toISOString().split('T')[0]; // Obtener fecha en formato YYYY-MM-DD
                if (info.startStr < today) {
                    alert('No puedes seleccionar fechas pasadas.');
                    return; // No hace nada si la fecha es pasada
                }

                let date = info.startStr;
                document.getElementById('eventModal').style.display = 'block'; // Muestra el modal
                document.getElementById('overlay').style.display = 'block'; // Muestra el overlay

                // Limpiar el formulario antes de mostrarlo
                document.getElementById('eventForm').reset();

                // Añadir un evento para el envío del formulario
                document.getElementById('eventForm').onsubmit = function(e) {
                    e.preventDefault();

                    // Obtener valores del formulario
                    let title = document.getElementById('title').value; // Título del evento
                    let provincia = document.getElementById('provincia').value; // Provincia seleccionada
                    let localidad = document.getElementById('localidad').value; // Localidad seleccionada
                    let zoneId = document.getElementById('zonaPesca').value; // Zona de pesca seleccionada

                    // Hacer la solicitud AJAX
                    $.ajax({
                        url: '<?= base_url('/user/salidas/saveEvent') ?>',
                        type: 'POST',
                        data: {
                            fecha: date, // Asegúrate de que esto sea el formato que espera tu controlador
                            titulo: title,
                            zona_id: zoneId,
                            provincia: provincia, // Si es necesario enviar la provincia
                            localidad: localidad // Si es necesario enviar la localidad
                        },
                        success: function(response) {
                            // Añadir el evento al calendario
                            calendar.addEvent({
                                id: response.id, // Asegúrate de que el servidor devuelve el ID del evento creado
                                title: title,
                                start: date,
                                extendedProps: {
                                    zonaId: zoneId,
                                    provincia: provincia,
                                    localidad: localidad
                                }
                            });
                            alert("Evento guardado exitosamente.");
                            document.getElementById('eventModal').style.display = 'none'; // Oculta el modal
                            document.getElementById('overlay').style.display = 'none'; // Oculta el overlay
                        },
                        error: function() {
                            alert("No se ha podido guardar el evento. Introduce un título y una zona de pesca válida.");
                        }
                    });
                };
            }
        });

        calendar.render();

        // Manejador para cerrar el modal
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('eventModal').style.display = 'none'; // Oculta el modal
            document.getElementById('overlay').style.display = 'none'; // Oculta el overlay
        };

        // Manejador para eliminar el evento
        document.getElementById('deleteEvent').onclick = function() {
            var eventId = $(this).data('eventId'); // Obtén el ID del evento a eliminar

            // Solicitud AJAX para eliminar el evento
            $.ajax({
                url: '<?= base_url('/user/salidas/deleteEvent') ?>',
                type: 'POST',
                data: {
                    id: eventId
                },
                success: function(response) {
                    calendar.getEventById(eventId).remove(); // Elimina el evento del calendario
                    alert("Evento eliminado exitosamente.");
                    var myModal = bootstrap.Modal.getInstance(document.getElementById('eventDetailsModal'));
                    myModal.hide(); // Cierra el modal de detalles
                },
                error: function() {
                    alert("Error al eliminar el evento.");
                }
            });
        };

        // Carga las localidades y zonas de pesca al seleccionar provincia
        $('#provincia').change(function() {
            provincia = $(this).val(); // Asigna el valor seleccionado a la variable
            $('#localidad').empty(); // Limpiar el select de localidades
            $('#localidad').append('<option value="" selected>Selecciona una localidad</option>');
            $('#zonaPesca').empty(); // Limpiar el select de zonas de pesca
            $('#zonaPesca').append('<option value="" selected>Selecciona una zona de pesca</option>');

            if (provincia) {
                // Petición AJAX para obtener localidades
                $.ajax({
                    url: '<?= site_url("user/zonasPesca/get_localidades") ?>',
                    type: 'POST',
                    data: {
                        provincia: provincia
                    },
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data); // Para depurar la respuesta
                        if (data.length > 0) {
                            $.each(data, function(index, localidad) {
                                $('#localidad').append('<option value="' + localidad.nombre + '">' + localidad.nombre + '</option>');
                            });
                        } else {
                            $('#localidad').append('<option value="">No hay localidades disponibles</option>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // console.error('Error:', textStatus, errorThrown);
                        alert('Error al cargar las localidades');
                    }
                });
            }
        });

        // Cuando se selecciona una localidad, cargar las zonas de pesca correspondientes
        $('#localidad').change(function() {
            var localidad = $(this).val();
            $('#zonaPesca').empty(); // Limpiar el select de zonas de pesca
            $('#zonaPesca').append('<option value="" selected>Selecciona una zona de pesca</option>');

            if (localidad) {
                // Petición AJAX para obtener zonas de pesca
                $.ajax({
                    url: '<?= site_url("/user/competiciones/get_zonasPesca") ?>',
                    type: 'POST',
                    data: {
                        provincia: provincia, // Usa la variable aquí
                        localidad: localidad
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data); // Para depurar la respuesta
                        if (data.length > 0) {
                            $.each(data, function(index, zonaPesca) {
                                $('#zonaPesca').append('<option value="' + zonaPesca.id + '">' + zonaPesca.nombre + '</option>');
                            });
                        } else {
                            $('#zonaPesca').append('<option value="">No hay zonas de pesca disponibles</option>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        alert('Error al cargar las zonas de pesca');
                    }
                });
            }
        });
    });
</script>
<script>
    function limitDigits(input, maxDigits) {
        if (input.value.length > maxDigits) {
            input.value = input.value.slice(0, maxDigits);
        }
    }
</script>
<!-- Carga de Bootstrap CSS y JS al final del cuerpo para que funcione el menú desplegable de Normativa-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<?php $this->endSection() ?>