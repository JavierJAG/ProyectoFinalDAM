<?= $this->extend("/user/layout/template") ?>
<?= $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
<a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
    <h2 class="text-center mb-4">Añadir Participación</h2>

    <form action="<?= site_url('/user/competiciones/anhadirParticipacion/' . $competicion_id) ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="fecha_captura" class="form-label">Fecha de Captura</label>
            <input type="datetime-local" name="fecha_captura" id="fecha_captura" class="form-control" value="<?= old('fecha_captura') ?>" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Especie</label>
            <input type="text" name="nombre" id="nombre_especie" class="form-control" value="<?= old('nombre') ?>" placeholder="Nombre de la especie capturada" required autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la captura" rows="3"><?= old('descripcion') ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tamano" class="form-label">Tamaño (cm)</label>
                <input type="number" step="0.01" name="tamano" id="tamano" class="form-control" value="<?= old('tamano') ?>" placeholder="Tamaño en cm" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="peso" class="form-label">Peso (g)</label>
                <input type="number" name="peso" id="peso" class="form-control" value="<?= old('peso') ?>" placeholder="Peso en g" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="provincia" class="form-label">Provincia</label>
            <select name="provincia" id="provincia" class="form-control" required>
                <option value="" selected>Selecciona una provincia</option>
                <?php foreach (['A CORUÑA', 'LUGO', 'OURENSE', 'PONTEVEDRA'] as $provincia): ?>
                    <option value="<?= $provincia ?>" <?= old('provincia') == $provincia ? 'selected' : '' ?>><?= $provincia ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="localidad" class="form-label">Localidad</label>
            <select name="localidad" id="localidad" class="form-control" required>
                <option value="" selected>Selecciona una localidad</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="zonaPesca" class="form-label">Zona de Pesca</label>
            <select name="zonaPesca" id="zonaPesca" class="form-control" required>
                <option value="" selected>Selecciona una zona de pesca</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="imagenes" class="form-label">Imágenes de la Captura</label>
            <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple accept="image/*" onchange="previewImages()">
        </div>

        <div id="imagePreview" class="d-flex flex-wrap"></div>

        <button type="submit" class="btn btn-primary mt-3">Crear</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script>
    $(document).ready(function() {
        var provincia; // Declaración de la variable

        // Carga localidades al seleccionar una provincia
        $('#provincia').change(function() {
            provincia = $(this).val();
            $('#localidad').empty().append('<option value="" selected>Selecciona una localidad</option>');
            $('#zonaPesca').empty().append('<option value="" selected>Selecciona una zona de pesca</option>');

            if (provincia) {
                $.ajax({
                    url: '<?= site_url("user/zonasPesca/get_localidades") ?>',
                    type: 'POST',
                    data: { provincia },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            data.forEach(localidad => $('#localidad').append(`<option value="${localidad.nombre}">${localidad.nombre}</option>`));
                        } else {
                            $('#localidad').append('<option value="">No hay localidades disponibles</option>');
                        }
                    },
                    error: function() {
                        alert('Error al cargar las localidades');
                    }
                });
            }
        });

        // Carga zonas de pesca al seleccionar una localidad
        $('#localidad').change(function() {
            const localidad = $(this).val();
            $('#zonaPesca').empty().append('<option value="" selected>Selecciona una zona de pesca</option>');

            if (localidad) {
                $.ajax({
                    url: '<?= site_url("/user/competiciones/get_zonasPesca") ?>',
                    type: 'POST',
                    data: { provincia, localidad },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            data.forEach(zona => $('#zonaPesca').append(`<option value="${zona.id}">${zona.nombre}</option>`));
                        } else {
                            $('#zonaPesca').append('<option value="">No hay zonas de pesca disponibles</option>');
                        }
                    },
                    error: function() {
                        alert('Error al cargar las zonas de pesca');
                    }
                });
            }
        });

        // Autocompletado del nombre de especie
        $('#nombre_especie').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?= site_url("/user/capturas/get_especies") ?>',
                    dataType: 'json',
                    data: { term: request.term },
                    success: function(data) {
                        response(data.map(item => ({ label: item.nombre, value: item.nombre })));
                    },
                    error: function() {
                        console.error('Error al obtener nombres de especies');
                    }
                });
            },
            minLength: 2
        });
    });

    // Previsualización de imágenes y eliminación
    function previewImages() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        const files = document.getElementById('imagenes').files;

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'position-relative m-1';
                
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'img-thumbnail';
                img.style.width = '100px';
                
                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                removeBtn.textContent = 'X';
                removeBtn.onclick = e => {
                    e.preventDefault();
                    const input = document.getElementById('imagenes');
                    const dataTransfer = new DataTransfer();
                    Array.from(input.files).forEach((f, i) => { if (i !== index) dataTransfer.items.add(f); });
                    input.files = dataTransfer.files;
                    previewImages();
                };

                div.appendChild(img);
                div.appendChild(removeBtn);
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
</script>

<?php $this->endSection() ?>
