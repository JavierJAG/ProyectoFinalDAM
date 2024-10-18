<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<h2>Actualizar Zona de Pesca</h2>
<form action="<?= site_url('/user/zonasPesca') ?>" method="post">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?= old('nombre', $zonaPesca->nombre) ?>" placeholder="nombre" required>

    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion"placeholder="descripcion"><?= old('descripcion', $zonaPesca->descripcion) ?></textarea>

    <select name="PROVINCIA" id="provincia" required>
        <option value="" selected></option>
        <option value="A CORUÑA" <?= old('provincia', $localidad->PROVINCIA) == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
        <option value="LUGO" <?= old('provincia', $localidad->PROVINCIA) == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
        <option value="OURENSE" <?= old('provincia', $localidad->PROVINCIA) == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
        <option value="PONTEVEDRA" <?= old('provincia', $localidad->PROVINCIA) == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
    </select>
    <label for="localidad">Localidad</label>
    <select name="localidad" id="localidad" required>
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

    <button type="submit">Actualizar</button>
</form>
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
                    url: '<?= site_url("/user/zonasPesca/get_localidades") ?>', // Asegúrate de que esta URL sea correcta
                    type: 'POST',
                    data: {
                        provincia: provincia
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Si hay localidades, añadirlas al select
                        if (data.length > 0) {
                            $.each(data, function(index, localidad) {
                                $('#localidad').append('<option value="' + localidad.id + ' ">' + localidad.nombre + '</option>');
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