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
    <h2 class="text-center mb-4">Editar Competición</h2>


    <form action="<?= site_url('/user/competiciones/' . $competicion->id) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PATCH">

        <div class="mb-3">
            <label for="nombre" class="form-label"><i class="bi bi-clipboard"></i>Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= old('nombre', $competicion->nombre) ?>" class="form-control" placeholder="Nombre de la competición" required>
        </div>
        <div class="row">
        <div class="mb-3 col">
            <label for="fecha_inicio" class="form-label"><i class="bi bi-calendar"></i>Fecha de inicio</label>
            <input type="datetime-local" name="fecha_inicio" id="fecha_inicio" value="<?= old('fecha_inicio', $competicion->fecha_inicio) ?>" class="form-control" required>
        </div>

        <div class="mb-3 col">
            <label for="fecha_fin" class="form-label"><i class="bi bi-calendar"></i>Fecha de fin</label>
            <input type="datetime-local" name="fecha_fin" id="fecha_fin" value="<?= old('fecha_fin', $competicion->fecha_fin) ?>" class="form-control" required>
        </div>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label for="provincia" class="form-label">  <i class="bi bi-geo-alt"></i>Provincia</label>
                <select name="PROVINCIA" id="provincia" class="form-control form-control-sm" required>
                    <option value="" selected></option>
                    <option value="A CORUÑA" <?= old('provincia', $localidad->PROVINCIA) == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
                    <option value="LUGO" <?= old('provincia', $localidad->PROVINCIA) == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
                    <option value="OURENSE" <?= old('provincia', $localidad->PROVINCIA) == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
                    <option value="PONTEVEDRA" <?= old('provincia', $localidad->PROVINCIA) == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="localidad" class="form-label"><i class="bi bi-building"></i> Localidad</label>
                <select name="localidad" id="localidad" class="form-control form-control-sm" required>
                    <option value="" selected>Selecciona una localidad</option>
                    <?php if (isset($localidad)) : ?>
                        <?php foreach ($localidades as $l) : ?>
                            <option value="<?= $l->nombre ?>" <?= ($l->nombre == $localidad->nombre) ? 'selected' : '' ?>>
                                <?= $l->nombre ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="zonaPesca" class="form-label"> <i class="bi bi-geo"></i>Zona de Pesca</label>
                <select name="zonaPesca" id="zonaPesca" class="form-control form-control-sm" required>
                    <option value="" selected>Selecciona una zona de pesca</option>
                    <?php if (isset($zonaPesca)) : ?>
                        <?php foreach ($zonasPesca as $zona) : ?>
                            <option value="<?= $zona->id ?>" <?= ($zona->id == $zonaPesca->id) ? 'selected' : '' ?>>
                                <?= $zona->nombre ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>


         <div class="mb-3">
            <label for="descripcion" class="form-label"><i class="bi bi-textarea-t"></i> Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de la competición"><?= old('descripcion', $competicion->descripcion) ?></textarea>
        </div>

         <div class="mb-3">
            <label for="imagenes" class="form-label"><i class="bi bi-image"></i> Imágenes de la competición</label>
            <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" class="form-control" onchange="previewImages()">
        </div>

        <?php if (!empty($imagenes)): ?>
            <h3>Imágenes Actuales:</h3>
            <ul class="list-unstyled">
                <?php foreach ($imagenes as $imagen): ?>
                    <li>
                        <img src="<?= base_url('uploads/competiciones/' . $imagen->imagen) ?>" alt="Imagen de <?= esc($competicion->nombre) ?>" width="100" class="img-thumbnail">
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div id="imagePreview" class="d-flex flex-wrap"></div>

        <button type="submit" class="btn btn-success mt-2">Actualizar</button>
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
        var provincia;

        $('#provincia').change(function() {
            provincia = $(this).val();
            $('#localidad').empty();
            $('#localidad').append('<option value="" selected>Selecciona una localidad</option>');
            $('#zonaPesca').empty();
            $('#zonaPesca').append('<option value="" selected>Selecciona una zona de pesca</option>');

            if (provincia) {
                $.ajax({
                    url: '<?= site_url("user/zonasPesca/get_localidades") ?>',
                    type: 'POST',
                    data: {
                        provincia: provincia
                    },
                    dataType: 'json',
                    success: function(data) {
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

        $('#localidad').change(function() {
            var localidad = $(this).val();
            $('#zonaPesca').empty();
            $('#zonaPesca').append('<option value="" selected>Selecciona una zona de pesca</option>');

            if (localidad) {
                $.ajax({
                    url: '<?= site_url("/user/competiciones/get_zonasPesca") ?>',
                    type: 'POST',
                    data: {
                        provincia: provincia,
                        localidad: localidad
                    },
                    dataType: 'json',
                    success: function(data) {
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
        preview.innerHTML = '';

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
                img.style.width = '100px';
                img.style.height = 'auto';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Eliminar';
                removeBtn.className = 'btn btn-danger btn-sm';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '0';
                removeBtn.style.right = '0';
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    preview.removeChild(div);
                    const input = document.getElementById('imagenes');
                    const dataTransfer = new DataTransfer();
                    for (let j = 0; j < input.files.length; j++) {
                        if (j !== i) {
                            dataTransfer.items.add(input.files[j]);
                        }
                    }
                    input.files = dataTransfer.files;
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