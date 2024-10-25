<?= $this->extend("/user/layout/template") ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<div class="container mt-4">
    <h2 class="text-center mb-4">Crear Nueva Competición</h2>

    <form action="<?= site_url('/user/competiciones') ?>" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="Nombre de la competición" required>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
            <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?= old('fecha_inicio') ?>" required>
        </div>

        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
            <input type="datetime-local" name="fecha_fin" id="fecha_fin" class="form-control" value="<?= old('fecha_fin') ?>" required>
        </div>

        <div class="mb-3">
            <label for="provincia" class="form-label">Provincia</label>
            <select name="provincia" id="provincia" class="form-control" required>
                <option value="" selected></option>
                <option value="A CORUÑA" <?= old('provincia') == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
                <option value="LUGO" <?= old('provincia') == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
                <option value="OURENSE" <?= old('provincia') == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
                <option value="PONTEVEDRA" <?= old('provincia') == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="localidad" class="form-label">Localidad</label>
            <select name="localidad" id="localidad" class="form-control" required>
                <option value="" selected>Selecciona una localidad</option>
                <!-- Las localidades se cargarán aquí -->
            </select>
        </div>

        <div class="mb-3">
            <label for="zonaPesca" class="form-label">Zona de Pesca</label>
            <select name="zonaPesca" id="zonaPesca" class="form-control" required>
                <option value="" selected>Selecciona una zona de pesca</option>
                <!-- Las zonas de pesca se cargarán aquí -->
            </select>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la competición"><?= old('descripcion') ?></textarea>
        </div>

        <div class="mb-3">
            <label for="imagenes" class="form-label">Imágenes de la Competición</label>
            <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple accept="image/*" onchange="previewImages()">
        </div>

        <div id="imagePreview" class="d-flex flex-wrap mb-3"></div>

        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#descripcion'))
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
