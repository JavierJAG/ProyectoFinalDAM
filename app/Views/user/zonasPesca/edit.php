<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Actualizar Zona de Pesca</h2>
    <form action="<?= site_url('/user/zonasPesca/'.$zonaPesca->id) ?>" method="post">
    <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre', $zonaPesca->nombre) ?>" placeholder="Nombre" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción"><?= old('descripcion', $zonaPesca->descripcion) ?></textarea>
        </div>

        <div class="form-group">
            <label for="provincia">Provincia</label>
            <select name="PROVINCIA" id="provincia" class="form-control" required>
                <option value="" selected></option>
                <option value="A CORUÑA" <?= old('provincia', $localidad->PROVINCIA) == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
                <option value="LUGO" <?= old('provincia', $localidad->PROVINCIA) == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
                <option value="OURENSE" <?= old('provincia', $localidad->PROVINCIA) == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
                <option value="PONTEVEDRA" <?= old('provincia', $localidad->PROVINCIA) == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
            </select>
        </div>

        <div class="form-group">
            <label for="localidad">Localidad</label>
            <select name="localidad" id="localidad" class="form-control" required>
                <option value="" selected>Selecciona una localidad</option>
                <!-- Las localidades se cargarán aquí -->
                <?php if (isset($localidades)) : ?>
                    <?php foreach ($localidades as $l) : ?>
                        <option value="<?= $l->nombre ?>" <?= ($l->nombre == $localidad->nombre) ? 'selected' : '' ?>>
                            <?= $l->nombre ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#provincia').change(function() {
            var provincia = $(this).val();
            $('#localidad').empty(); // Limpiar el select de localidades
            $('#localidad').append('<option value="" selected>Selecciona una localidad</option>'); // Añadir opción predeterminada

            if (provincia) {
                // Hacer una petición AJAX
                $.ajax({
                    url: '<?= site_url("/user/zonasPesca/get_localidades") ?>',
                    type: 'POST',
                    data: {
                        provincia: provincia
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Si hay localidades, añadirlas al select
                        if (data.length > 0) {
                            $.each(data, function(index, localidad) {
                                $('#localidad').append('<option value="' + localidad.nombre + '">' + localidad.nombre + '</option>');
                            });
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
    });
</script>

<?php $this->endSection() ?>
