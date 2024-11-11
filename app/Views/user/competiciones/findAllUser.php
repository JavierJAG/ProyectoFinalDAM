<?= $this->extend("/user/layout/template") ?>
<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-left mb-4">Lista de Competiciones</h2>

    <div class="d-flex justify-content-between mb-3">
        <?php if (auth()->user()->inGroup('admin') || auth()->user()->inGroup('superadmin')) : ?>
            <a href="/user/competiciones/new" class="btn btn-primary d-flex align-items-center">Crear Competición</a>
        <?php endif; ?>
        <form action="/user/buscarCompeticiones" method="get" class="d-flex">
            <div class="me-3">
                <label for="provincia" class="form-label">Provincia</label>
                <select name="PROVINCIA" id="provincia" class="form-select">
                    <option value="" selected disabled>Selecciona una provincia</option>
                    <?php foreach ($todasProvincias as $prov) : ?>
                        <option value="<?= $prov ?>" <?= old('provincia', $provinciaSeleccionada) == $prov ? 'selected' : '' ?>>
                            <?= $prov ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="me-3">
                <label for="localidad" class="form-label">Localidad</label>
                <select name="localidad" id="localidad" class="form-select">
                    <option value="" selected disabled>Selecciona una localidad</option>
                    <?php if (!empty($localidades)) : ?>
                        <?php foreach ($localidades as $l) : ?>
                            <option value="<?= $l->nombre ?>" <?= old('localidad', $localidadSeleccionada) == $l->nombre ? 'selected' : '' ?>>
                                <?= $l->nombre ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="align-self-end">
                <button type="submit" class="btn btn-success">Buscar</button>
            </div>
        </form>
    </div>

    <!-- Competiciones Activas -->
    <h3 class="mt-4">Competiciones Activas</h3>
    <table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th class="text-center">
                <a href="<?= current_url() . '?PROVINCIA=' . $provinciaSeleccionada . '&localidad=' . $localidadSeleccionada . '&sort=fecha_inicio&order=' . ($sort == 'fecha_inicio' && $order == 'asc' ? 'desc' : 'asc') ?>" class="text-decoration-none text-white">
                    Fecha Inicio
                    <?= $sort == 'fecha_inicio' ? ($order == 'asc' ? '↑' : '↓') : '' ?>
                </a>
            </th>
            <th class="text-center">
                <a href="<?= current_url() . '?PROVINCIA=' . $provinciaSeleccionada . '&localidad=' . $localidadSeleccionada . '&sort=fecha_fin&order=' . ($sort == 'fecha_fin' && $order == 'asc' ? 'desc' : 'asc') ?>" class="text-decoration-none text-white">
                    Fecha Fin
                    <?= $sort == 'fecha_fin' ? ($order == 'asc' ? '↑' : '↓') : '' ?>
                </a>
            </th>
            <th class="text-center">
                <a href="<?= current_url() . '?PROVINCIA=' . $provinciaSeleccionada . '&localidad=' . $localidadSeleccionada . '&sort=nombre&order=' . ($sort == 'nombre' && $order == 'asc' ? 'desc' : 'asc') ?>" class="text-decoration-none text-white">
                    Nombre
                    <?= $sort == 'nombre' ? ($order == 'asc' ? '↑' : '↓') : '' ?>
                </a>
            </th>
            <th class="text-center"></th>
        </tr>
    </thead>
        <tbody>
            <?php if (count($competicionesActivas) > 0) : ?>
                <?php foreach ($competicionesActivas as $competicion) : ?>
                    <tr>
                        <td class="text-center"><?= date('d/m/Y H:i', strtotime($competicion->fecha_inicio)) ?></td>
                        <td class="text-center"><?= date('d/m/Y H:i', strtotime($competicion->fecha_fin)) ?></td>
                        <td class="text-center"><?= htmlspecialchars($competicion->nombre) ?></td>
                        <td class="text-center">
                            <a href="/user/competiciones/<?= $competicion->id ?>" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text-center">No hay competiciones activas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Competiciones Finalizadas -->
    <h3 class="mt-4">Competiciones Finalizadas</h3>
    <table class="table table-striped table-hover">
    <table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th class="text-center">
                <a href="<?= current_url() . '?PROVINCIA=' . $provinciaSeleccionada . '&localidad=' . $localidadSeleccionada . '&sort=fecha_inicio&order=' . ($sort == 'fecha_inicio' && $order == 'asc' ? 'desc' : 'asc') ?>" class="text-decoration-none text-white">
                    Fecha Inicio
                    <?= $sort == 'fecha_inicio' ? ($order == 'asc' ? '↑' : '↓') : '' ?>
                </a>
            </th>
            <th class="text-center">
                <a href="<?= current_url() . '?PROVINCIA=' . $provinciaSeleccionada . '&localidad=' . $localidadSeleccionada . '&sort=fecha_fin&order=' . ($sort == 'fecha_fin' && $order == 'asc' ? 'desc' : 'asc') ?>" class="text-decoration-none text-white">
                    Fecha Fin
                    <?= $sort == 'fecha_fin' ? ($order == 'asc' ? '↑' : '↓') : '' ?>
                </a>
            </th>
            <th class="text-center">
                <a href="<?= current_url() . '?PROVINCIA=' . $provinciaSeleccionada . '&localidad=' . $localidadSeleccionada . '&sort=nombre&order=' . ($sort == 'nombre' && $order == 'asc' ? 'desc' : 'asc') ?>" class="text-decoration-none text-white">
                    Nombre
                    <?= $sort == 'nombre' ? ($order == 'asc' ? '↑' : '↓') : '' ?>
                </a>
            </th>
            <th class="text-center"></th>
        </tr>
    </thead>
        <tbody>
            <?php if (count($competicionesFinalizadas) > 0) : ?>
                <?php foreach ($competicionesFinalizadas as $competicion) : ?>
                    <tr>
                        <td class="text-center"><?= date('d/m/Y H:i', strtotime($competicion->fecha_inicio)) ?></td>
                        <td class="text-center"><?= date('d/m/Y H:i', strtotime($competicion->fecha_fin)) ?></td>
                        <td class="text-center"><?= htmlspecialchars($competicion->nombre) ?></td>
                        <td class="text-center">
                            <a href="/user/competiciones/<?= $competicion->id ?>" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="text-center">No hay competiciones finalizadas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Cargar localidades si hay una provincia seleccionada previamente
        var provinciaSeleccionada = '<?= $provinciaSeleccionada ?>';
        var localidadSeleccionada = '<?= $localidadSeleccionada ?>';

        if (provinciaSeleccionada) {
            cargarLocalidades(provinciaSeleccionada, localidadSeleccionada);
        }

        // Evento al cambiar de provincia
        $('#provincia').change(function() {
            var provincia = $(this).val();
            cargarLocalidades(provincia);
        });

        function cargarLocalidades(provincia, localidadSeleccionada = null) {
            $('#localidad').empty(); // Limpiar el select de localidades
            $('#localidad').append('<option value="" selected disabled>Selecciona una localidad</option>'); // Opción predeterminada

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
                            // Primero añadir la localidad seleccionada, si existe en los datos
                            if (localidadSeleccionada) {
                                // Comprobar si la localidad seleccionada está en los datos
                                var localidadEncontrada = data.find(localidad => localidad.nombre === localidadSeleccionada);
                                if (localidadEncontrada) {
                                    $('#localidad').append('<option value="' + localidadEncontrada.nombre + '" selected>' + localidadEncontrada.nombre + '</option>');
                                    // Filtrar las localidades para excluir la seleccionada ya que ya se añadió
                                    data = data.filter(localidad => localidad.nombre !== localidadSeleccionada);
                                }
                            }

                            // Añadir las demás localidades
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
        }
    });
</script>


<?= $this->endSection() ?>