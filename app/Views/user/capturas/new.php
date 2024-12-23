<?= $this->extend("/user/layout/template") ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<style>
    /* Aplica una altura mínima al área editable del CKEditor */
    .ck-editor__editable[role="textbox"] {
        min-height: 200px;

        /* Cambia a la altura deseada, por ejemplo, 300px */

    }

    #character-counter {
        font-size: 0.9rem;
        color: #555;
        margin-top: 5px;
        text-align: right;
    }
</style>
<style>
    /* Estiliza el título principal */
    h2 {
        font-weight: 700;
        color: #2c3e50;
        font-size: 2rem;
    }

    /* Estiliza los labels */
    label.form-label {
        font-weight: bold;
        color: #34495e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }



    /* Estiliza los botones */
    .btn {
        font-size: 0.9rem;
        padding: 0.5rem 1.2rem;
        border-radius: 5px;
    }

    /* Mejora la apariencia de la vista previa de imágenes */
    .image-item {
        position: relative;
        display: inline-block;
        margin-right: 1rem;
    }

    .img-thumbnail {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-danger {
        padding: 0.2rem 0.5rem;
        font-size: 0.8rem;
    }

    /* Ajusta la posición de los botones de eliminar */
    .image-item .btn {
        top: -10px;
        right: -10px;
    }
</style>



<div class="container mt-4">
    <div class="d-flex justify-content-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Volver</a>
    </div>

    <h2 class="text-center mb-4">Nueva Captura</h2>

    <form action="<?= site_url('/user/capturas') ?>" method="post" enctype="multipart/form-data">
        <!-- Fecha de Captura y Nombre de la Especie -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label for="fecha_captura" class="form-label">
                    <i class="bi bi-calendar"></i> Fecha de Captura
                </label>
                <input type="datetime-local" name="fecha_captura" id="fecha_captura" class="form-control " value="<?= old('fecha_captura') ?>" required>
            </div>

            <div class="col-md-6">
                <label for="nombre_especie" class="form-label">
                    <i class="bi bi-clipboard"></i> Especie
                </label>
                <input type="text" name="nombre" id="nombre_especie" class="form-control " value="<?= old('nombre') ?>" placeholder="Nombre de la especie capturada" required>
            </div>
        </div>

        <!-- Tamaño y Peso -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Datos de la Captura</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tamano" class="form-label">
                            <i class="bi bi-rulers"></i> Tamaño (cm)
                        </label>
                        <input oninput="limitDigits(this, 8)" type="number" step="1" name="tamano" id="tamano" class="form-control form-control-sm" value="<?= old('tamano') ?>" placeholder="Tamaño en cm" required>
                    </div>
                    <div class="col-md-6">
                        <label for="peso" class="form-label">
                            <i class="bi bi-basket"></i> Peso (Kg)
                        </label>
                        <input oninput="limitDigits(this, 8)" type="number" step="0.01" name="peso" id="peso" class="form-control form-control-sm" value="<?= old('peso') ?>" placeholder="Peso en kg" required>
                    </div>
                </div>
            </div>
        </div>


        <!-- Agrupación de Provincia, Localidad y Zona de Pesca -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Ubicación y Zona de Pesca</h5>

                <div class="row g-3">
                    <!-- Provincia -->
                    <div class="col-md-4">
                        <label for="provincia" class="form-label">
                            <i class="bi bi-geo-alt"></i> Provincia
                        </label>
                        <select name="provincia" id="provincia" class="form-control form-control-sm" required>
                            <option value="" selected>Selecciona una provincia</option>
                            <option value="A CORUÑA">A CORUÑA</option>
                            <option value="LUGO">LUGO</option>
                            <option value="OURENSE">OURENSE</option>
                            <option value="PONTEVEDRA">PONTEVEDRA</option>
                        </select>
                    </div>

                    <!-- Localidad -->
                    <div class="col-md-4">
                        <label for="localidad" class="form-label">
                            <i class="bi bi-building"></i> Localidad
                        </label>
                        <select name="localidad" id="localidad" class="form-control form-control-sm" required>
                            <option value="" selected>Selecciona una localidad</option>
                        </select>
                    </div>

                    <!-- Zona de Pesca -->
                    <div class="col-md-4">
                        <label for="zonaPesca" class="form-label">
                            <i class="bi bi-geo"></i> Zona de Pesca
                        </label>
                        <select name="zonaPesca" id="zonaPesca" class="form-control form-control-sm" required>
                            <option value="" selected>Selecciona una zona de pesca</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <!-- Descripción con CKEditor -->
        <div class="mb-3">
            <div id="editor-container">
                <label for="descripcion" class="form-label">
                    <i class="bi bi-textarea-t"></i> Detalles
                </label>
                <textarea name="descripcion" id="descripcion" class="form-control  w-75" placeholder="Descripción de la captura"><?= old('descripcion') ?></textarea>
                <div id="character-counter"></div>
            </div>
        </div>
        <!-- Subida de Imágenes con Vista Previa -->
        <div class="mb-3">
            <label for="imagenes" class="form-label">
                <i class="bi bi-image"></i> Imágenes de la Captura
            </label>
            <input type="file" id="imagenes" name="imagenes[]" class="form-control form-control-sm w-50" multiple accept="image/*" onchange="previewImages()">
        </div>
        <div id="imagePreview" class="d-flex flex-wrap"></div>

        <button type="submit" class="btn btn-primary mt-3">Crear</button>
    </form>
</div>
<br>

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<!-- Script de CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: {
                items: [
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'
                ],
            },
            placeholder: 'Descripción del momento de la captura, detalles de la jornada, condiciones...',
        })
        .then(editor => {
            const maxCharacters = 4000;
            const counterElement = document.getElementById('character-counter');
            const showRemainingAfter = 3500; // Número de caracteres restantes después del cual mostrar el contador

            // Función para actualizar el contador de caracteres
            function updateCharacterCount(content) {
                const remainingCharacters = maxCharacters - content.length;

                // Solo mostrar los caracteres restantes si son menores que el valor definido
                if (remainingCharacters <= showRemainingAfter) {
                    counterElement.textContent = `${remainingCharacters} caracteres restantes`;

                    // Cambiar el color del contador si se alcanza o excede el límite
                    if (remainingCharacters <= 0) {
                        counterElement.style.color = 'red'; // Resaltar en rojo cuando se excede el límite
                    } else {
                        counterElement.style.color = '#555'; // Color normal
                    }
                } else {
                    counterElement.textContent = ''; // Ocultar el contador si hay más caracteres disponibles que el límite
                }
            }

            // Actualizar el contador y permitir seguir escribiendo
            editor.model.document.on('change:data', () => {
                let content = editor.getData();

                // Si el contenido excede el máximo, recorta el exceso sobrescribiendo al último carácter
                if (content.length > maxCharacters) {
                    content = content.slice(0, maxCharacters); // Recortar el contenido
                    editor.setData(content); // Actualizar el editor con el contenido recortado
                }

                updateCharacterCount(content); // Actualiza el contador con el contenido actual
            });
        })
        .catch(error => {
            console.error(error);
        });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
    $(document).ready(function() {
        var provincia; // Declara la variable para la provincia

        // Cuando se selecciona una provincia, cargar las localidades correspondientes
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
                        console.log(data); // Para depurar la respuesta
                        if (data.length > 0) {
                            $.each(data, function(index, localidad) {
                                $('#localidad').append('<option value="' + localidad.nombre + '">' + localidad.nombre + '</option>');
                            });
                        } else {
                            $('#localidad').append('<option value="">No hay localidades disponibles</option>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
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
    $(document).ready(function() {
        // Implementación del autocompletado usando jQuery UI
        $('#nombre_especie').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?= site_url("/user/capturas/get_especies") ?>',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nombre,
                                value: item.nombre
                            };
                        }));
                    },
                    error: function() {
                        console.log('Error al obtener los nombres de las especies');
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $('#nombre_especie').val(ui.item.value);
            }
        });
    });
</script>

<script>
    function previewImages() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // Limpia el contenedor de previsualización

        const files = document.getElementById('imagenes').files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'image-item position-relative me-3 mb-2';

                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.width = '100px'; // Ajusta el tamaño de la imagen
                img.style.height = 'auto';
                img.className = 'img-thumbnail';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Eliminar';
                removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    preview.removeChild(div); // Elimina la imagen del contenedor de previsualización
                    const input = document.getElementById('imagenes');
                    const dataTransfer = new DataTransfer(); // Crea un objeto DataTransfer para manejar los archivos
                    for (let j = 0; j < input.files.length; j++) {
                        if (j !== i) { // Mantiene todos los archivos excepto el que fue eliminado
                            dataTransfer.items.add(input.files[j]);
                        }
                    }
                    input.files = dataTransfer.files; // Actualiza la lista de archivos del input
                };

                div.appendChild(img);
                div.appendChild(removeBtn);
                preview.appendChild(div);
            };

            reader.readAsDataURL(file);
        }
    }
</script>
<script>
    function limitDigits(input, maxDigits) {
        if (input.value.length > maxDigits) {
            input.value = input.value.slice(0, maxDigits);
        }
    }
</script>

<?php $this->endSection() ?>