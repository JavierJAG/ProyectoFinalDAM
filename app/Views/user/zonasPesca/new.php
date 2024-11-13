<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<style>
    h2 {
        font-weight: 700;
        color: #2c3e50;
        font-size: 2rem;
    }

    label {
        font-weight: bold;
        color: #34495e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn {
        font-size: 0.9rem;
        padding: 0.5rem 1.2rem;
        border-radius: 5px;
    }

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

    .image-item .btn {
        top: -10px;
        right: -10px;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary"> 
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <h2 class="text-center mb-4">
        <i class="bi bi-geo-alt-fill"></i> Crear Zona de Pesca
    </h2>

    <form action="<?= site_url('/user/zonasPesca') ?>" method="post">
        <div class="form-group mb-3">
            <label for="nombre">
                <i class="bi bi-pen"></i> Nombre
            </label>
            <input type="text" oninput="limitDigits(this, 50)" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="Nombre de la zona" required>
        </div>

        <div class="form-group mb-3">
            <label for="descripcion">
                <i class="bi bi-textarea-t"></i> Descripción
            </label>
            <textarea name="descripcion" oninput="limitDigits(this, 200)" id="descripcion" class="form-control" placeholder="Descripción de la zona"></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="provincia">
                <i class="bi bi-map"></i> Provincia
            </label>
            <select name="PROVINCIA" id="provincia" class="form-control" required>
                <option value="" selected disabled>Selecciona una provincia</option>
                <option value="A CORUÑA" <?= old('provincia') == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
                <option value="LUGO" <?= old('provincia') == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
                <option value="OURENSE" <?= old('provincia') == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
                <option value="PONTEVEDRA" <?= old('provincia') == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
            </select>
        </div>

        <div class="form-group mb-4">
            <label for="localidad">
                <i class="bi bi-pin-map"></i> Localidad
            </label>
            <select name="localidad" id="localidad" class="form-control" required>
                <option value="" selected disabled>Selecciona una localidad</option>
                <!-- Las localidades se cargarán aquí -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            <i class="bi bi-plus-circle"></i> Crear
        </button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#provincia').change(function() {
            var provincia = $(this).val();
            $('#localidad').empty();
            $('#localidad').append('<option value="" selected disabled>Selecciona una localidad</option>');

            if (provincia) {
                $.ajax({
                    url: '<?= site_url("/user/zonasPesca/get_localidades") ?>',
                    type: 'POST',
                    data: { provincia: provincia },
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
    });
</script>
<script>
    function limitDigits(input, maxDigits) {
        if (input.value.length > maxDigits) {
            input.value = input.value.slice(0, maxDigits);
        }
    }
</script>

<?php $this->endSection() ?>
