<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>


<form action="<?= site_url('/user/competiciones') ?>" method="post" enctype="multipart/form-data">

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?= old('nombre') ?>" placeholder="Nombre de la competicion" required>

    <label for="fecha_inicio">Fecha de inicio</label>
    <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" value="<?= old('fecha_inicio') ?>" required>

    <label for="fecha_fin">Fecha de fin</label>
    <input type="datetime-local" name="fecha_fin" id="fecha_fin" value="<?= old('fecha_fin') ?>" required>

    <div class="form-group">
        <label for="provincia">Provincia</label>
        <select name="PROVINCIA" id="provincia" class="form-control" required>
            <option value="" selected></option>
            <option value="A CORUÑA" <?= old('provincia') == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
            <option value="LUGO" <?= old('provincia') == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
            <option value="OURENSE" <?= old('provincia') == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
            <option value="PONTEVEDRA" <?= old('provincia') == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
        </select>
    </div>
    <select name="localidad" id="localidad" class="form-control" required>
        <option value="" selected>Selecciona una localidad</option>
        <!-- Las localidades se cargarán aquí -->
    </select>
    <select name="zonaPesca" id="zonaPesca" class="form-control" required>
        <option value="" selected>Selecciona una zona de pesca</option>
        <!-- Las zona de pesca se cargarán aquí -->
    </select>
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion" placeholder="Descripción de la competicion"><?= old('descripcion') ?></textarea>



    <label for="imagenes">Imágenes de la competicion</label>
    <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" onchange="previewImages()">

    <div id="imagePreview"></div>

    <button type="submit">Crear</button>
</form>










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
                div.className = 'image-item';
                div.style.position = 'relative';
                div.style.display = 'inline-block';
                div.style.margin = '10px';

                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.width = '100px'; // Ajusta el tamaño de la imagen
                img.style.height = 'auto';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Eliminar';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '0';
                removeBtn.style.right = '0';
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