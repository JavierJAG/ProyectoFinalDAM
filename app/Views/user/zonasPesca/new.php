<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<h2>Crear Zona de Pesca</h2>
<form action="<?= site_url('/user/zonasPesca') ?>" method="post">
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="nombre" required>
    </div>

    <div class="form-group">
        <label for="descripcion" placeholder="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
    </div>

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

    <div class="form-group">
        <label for="localidad">Localidad</label>
        <select name="localidad" id="localidad" class="form-control" required>
            <option value="" selected>Selecciona una localidad</option>
            <!-- Las localidades se cargarán aquí -->
        </select>
    </div>

    <label for="coordenadas">Coordenadas (latitud,longitud):</label>
    <input type="text" name="coordenadas" placeholder="Ej. 42.2417300047165, -8.72028910343247">

    <button type="submit" class="btn btn-primary">Crear</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#provincia').change(function() {
            var provincia = $(this).val();
            $('#localidad').empty(); // Limpiar el select de localidades
            $('#localidad').append('<option value="" selected>Selecciona una localidad</option>');

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
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        alert('Error al cargar las localidades');
                    }
                });
            }
        });
    });
</script>
<?php $this->endSection() ?>