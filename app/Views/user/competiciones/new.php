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
    <div class="col d-flex justify-content-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Volver</a>
    </div>
    <h2 class="col text-center mb-4"> Nueva Competición</h2>


    <form action="<?= site_url('/user/competiciones') ?>" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="nombre" class="form-label"><i class="bi bi-clipboard"></i>Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="Nombre de la competición" required>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label for="fecha_inicio" class="form-label"> <i class="bi bi-calendar"></i>Fecha de Inicio</label>
                <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?= old('fecha_inicio') ?>" required>
            </div>

            <div class="mb-3 col">
                <label for="fecha_fin" class="form-label"> <i class="bi bi-calendar"></i>Fecha de Fin</label>
                <input type="datetime-local" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= old('fecha_fin') ?>" required>
            </div>
        </div>


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

        <div class="mb-3">
            <label for="descripcion" class="form-label"><i class="bi bi-textarea-t"></i> Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la competición"><?= old('descripcion') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="imagenes" class="form-label"> <i class="bi bi-image"></i> Imágenes de la Competición</label>
            <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple accept="image/*" onchange="previewImages()">
        </div>

        <div id="imagePreview" class="d-flex flex-wrap mb-3"></div>

        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
            toolbar: {
                items: [
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'
                ],
            },
            placeholder: 'Descripción del evento...',
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

<?php $this->endSection() ?>