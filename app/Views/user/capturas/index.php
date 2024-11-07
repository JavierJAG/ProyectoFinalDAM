<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<style>

    .modal-content {
        border-radius: 25px;
    }
</style>
<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">Mis Capturas</h2>
                <div>
                    <a href="/user/capturas/new" class="btn btn-success me-2">
                        <i class="bi bi-plus-circle"></i> Añadir Captura
                    </a>

                </div>
            </div>

            <!-- Formulario de búsqueda y ordenación -->
            <form method="POST" action="/user/perfil/misCapturas" class="mb-4 p-3 border rounded shadow-sm bg-light">
                <div class="row g-2 align-items-center">
                    <!-- Cuadro de búsqueda -->
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre de especie" value="<?= isset($search) ? esc($search) : '' ?>">
                    </div>
                    <!-- Menú desplegable para ordenar
                    <div class="col-md-4">
                        <select name="orden" class="form-select">
                            <option value="fecha" <?= isset($orden) && $orden === 'fecha' ? 'selected' : '' ?>>Ordenar por Fecha</option>
                            <option value="peso" <?= isset($orden) && $orden === 'peso' ? 'selected' : '' ?>>Ordenar por Peso</option>
                            <option value="tamano" <?= isset($orden) && $orden === 'tamano' ? 'selected' : '' ?>>Ordenar por Tamaño</option>
                        </select>
                    </div> -->
                    <!-- Menú desplegable para buscar por zona -->
                    <div class="col-md-4">
                        <select name="zona" class="form-select">
                            <option value="" <?= isset($zona) && $zona == '' ? 'selected' : '' ?>>Todas las zonas</option>
                            <?php foreach ($zonasPesca as $zonaPesca) : ?>
                                <option value="<?= esc($zonaPesca->id) ?>" <?= isset($zona) && $zona == $zonaPesca->id ? 'selected' : '' ?>><?= esc($zonaPesca->nombre) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <!-- Botón de envío -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>
                                <a href="?sort=fecha_captura&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'fecha_captura' && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">Fecha</a>
                                <?php if (isset($_GET['sort']) && $_GET['sort'] === 'fecha_captura' && isset($_GET['order']) && $_GET['order'] === 'asc'): ?>
                                    <i class="bi bi-arrow-up"></i>
                                <?php elseif (isset($_GET['sort']) && $_GET['sort'] === 'fecha_captura' && isset($_GET['order']) && $_GET['order'] === 'desc'): ?>
                                    <i class="bi bi-arrow-down"></i>
                                <?php endif; ?>
                            </th>
                            <th>
                                <a href="?sort=nombre&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'nombre' && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">Especie</a>
                                <?php if (isset($_GET['sort']) && $_GET['sort'] === 'nombre' && isset($_GET['order']) && $_GET['order'] === 'asc'): ?>
                                    <i class="bi bi-arrow-up"></i>
                                <?php elseif (isset($_GET['sort']) && $_GET['sort'] === 'nombre' && isset($_GET['order']) && $_GET['order'] === 'desc'): ?>
                                    <i class="bi bi-arrow-down"></i>
                                <?php endif; ?>
                            </th>
                            <th>
                                <a href="?sort=tamano&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'tamano' && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">Tamaño (cm)</a>
                                <?php if (isset($_GET['sort']) && $_GET['sort'] === 'tamano' && isset($_GET['order']) && $_GET['order'] === 'asc'): ?>
                                    <i class="bi bi-arrow-up"></i>
                                <?php elseif (isset($_GET['sort']) && $_GET['sort'] === 'tamano' && isset($_GET['order']) && $_GET['order'] === 'desc'): ?>
                                    <i class="bi bi-arrow-down"></i>
                                <?php endif; ?>
                            </th>
                            <th>
                                <a href="?sort=peso&order=<?= (isset($_GET['sort']) && $_GET['sort'] === 'peso' && $_GET['order'] === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">Peso (kg)</a>
                                <?php if (isset($_GET['sort']) && $_GET['sort'] === 'peso' && isset($_GET['order']) && $_GET['order'] === 'asc'): ?>
                                    <i class="bi bi-arrow-up"></i>
                                <?php elseif (isset($_GET['sort']) && $_GET['sort'] === 'peso' && isset($_GET['order']) && $_GET['order'] === 'desc'): ?>
                                    <i class="bi bi-arrow-down"></i>
                                <?php endif; ?>
                            </th>

                            <th>
                                <a href="?sort=zona&order=<?= isset($_GET['sort']) && $_GET['sort'] === 'zona' && $_GET['order'] === 'asc' ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">Lugar de captura</a>
                                <?php if (isset($_GET['sort']) && $_GET['sort'] === 'zona' && $_GET['order'] === 'asc'): ?>
                                    <i class="bi bi-arrow-up"></i>
                                <?php elseif (isset($_GET['sort']) && $_GET['sort'] === 'zona' && $_GET['order'] === 'desc'): ?>
                                    <i class="bi bi-arrow-down"></i>
                                <?php endif; ?>
                            </th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($capturas)) : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No se han registrado capturas.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($capturas as $captura) : ?>
                                <tr>
                                    <td class="text-center"><?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($captura->nombre) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($captura->tamano) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($captura->peso) ?></td>
                                    <td class="text-center">
                                        <?php
                                        $zonaEncontrada = false;
                                        foreach ($zonasPesca as $zonaPesca) :
                                            if ($zonaPesca->id == $captura->zona_id) :
                                                $zonaEncontrada = true;
                                        ?>
                                                <a href="javascript:void(0);" class="btn btn-link" onclick="mostrarZona(<?= esc($zonaPesca->id) ?>)">
                                                    <?= esc($zonaPesca->nombre) ?>
                                                </a>

                                                <?php break; ?>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>

                                        <?php if (!$zonaEncontrada) :
                                        ?>
                                            <p>No hay información del lugar</p>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <a href="/user/capturas/<?= $captura->id ?>" class="btn btn-sm me-1" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/user/capturas/<?= $captura->id ?>/edit" class="btn btn-sm me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/user/capturas/<?= $captura->id ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm" title="Eliminar" onclick="return confirm('Se va a eliminar <?= $captura->nombre ?> ¿Estás seguro de que deseas eliminar esta captura?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Zona de Pesca -->
<div class="modal fade" id="zonaModal" tabindex="-1" aria-labelledby="zonaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="zonaModalLabel">Información del lugar seleccionado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargará la información de la zona con AJAX -->
                <h4 id="zonaNombre" class="fw-bold"></h4>
                <p id="zonaDescripcion" class="text-muted"></p>
                <p id="provincia"><strong>Provincia: </strong></p>
                <p id="localidad"><strong>Localidad: </strong></p>
                <!-- Puedes agregar más campos según la información de la zona -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarZona(zonaId) {
        // Hacer la solicitud AJAX para obtener la información de la zona
        fetch('/user/verModalZonaPesca/' + zonaId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Llenar los campos del modal con la información de la zona
                    document.getElementById('zonaNombre').textContent = data.zona.nombre;
                    document.getElementById('zonaDescripcion').textContent = data.zona.descripcion;
                    document.getElementById('provincia').textContent = 'Provincia: ' + data.zona.provincia;
                    document.getElementById('localidad').textContent = 'Localidad: ' + data.zona.localidad;

                    // Mostrar el modal
                    var myModal = new bootstrap.Modal(document.getElementById('zonaModal'));
                    myModal.show();
                } else {
                    alert('Error al cargar la información de la zona');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar la información');
            });
    }
</script>

<?php $this->endSection() ?>