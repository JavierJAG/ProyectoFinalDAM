<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

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
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
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
                    <!-- Menú desplegable para ordenar -->
                    <div class="col-md-4">
                        <select name="order" class="form-select">
                            <option value="fecha" <?= isset($order) && $order === 'fecha' ? 'selected' : '' ?>>Ordenar por Fecha</option>
                            <option value="peso" <?= isset($order) && $order === 'peso' ? 'selected' : '' ?>>Ordenar por Peso</option>
                            <option value="tamano" <?= isset($order) && $order === 'tamano' ? 'selected' : '' ?>>Ordenar por Tamaño</option>
                        </select>
                    </div>
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
                            <th>Fecha</th>
                            <th>Especie</th>
                            <th>Tamaño (cm)</th>
                            <th>Peso (kg)</th>
                            <th>Lugar de captura</th>
                            <th>Acciones</th>
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
                                        <?php foreach ($zonasPesca as $zonaPesca) : ?>
                                            <?php if($zonaPesca->id==$captura->zona_id) :?>
                                                <a href="/user/zonasPesca/<?= esc($zonaPesca->id) ?>"> <?= $zonaPesca->nombre ?>
                                                <?php endif ?>
                                        <?php endforeach ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="/user/capturas/<?= $captura->id ?>" class="btn btn-info btn-sm me-1" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/user/capturas/<?= $captura->id ?>/edit" class="btn btn-warning btn-sm me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="/user/capturas/<?= $captura->id ?>" method="post" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta captura?');">
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

<?php $this->endSection() ?>