<?php $this->extend('/user/layout/template') ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <!-- Título de la sección -->
    <div class="text-center mb-4">
        <h2 class="display-6 fw-bold text-primary">Capturas Globales</h2>
        <p class="text-muted">Desde todos los rincones de Galicia</p>
    </div>
   <!-- Botón de "Mis Capturas" alineado a la derecha -->
   <div class="d-flex justify-content-end mb-3">
        <a href="/user/perfil/misCapturas" class="btn btn-success">Mis Capturas</a>
    </div>
    <!-- Barra de búsqueda centrada -->
    <div class="d-flex justify-content-center mb-4">
        <form method="POST" action="/user/buscarCapturas" class="input-group w-75 w-md-50">
            <input type="text" name="search" class="form-control" placeholder="Buscar por especie" value="<?= isset($search) ? esc($search) : '' ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>

 

    <!-- Tabla de capturas -->
    <div class="table-responsive shadow-sm">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 50px;"></th>
                    <th>
                        <a href="?sort=fecha_captura&order=<?= (isset($sort) && $sort === 'fecha_captura' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-dark">Fecha</a>
                        <?php if (isset($sort) && $sort === 'fecha_captura'): ?>
                            <i class="bi <?= (isset($order) && $order === 'asc') ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                        <?php endif; ?>
                    </th>
                    <th>
                        <a href="?sort=nombre&order=<?= (isset($sort) && $sort === 'nombre' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-dark">Especie</a>
                        <?php if (isset($sort) && $sort === 'nombre'): ?>
                            <i class="bi <?= (isset($order) && $order === 'asc') ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                        <?php endif; ?>
                    </th>
                    <th>
                        <a href="?sort=tamano&order=<?= (isset($sort) && $sort === 'tamano' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-dark">Tamaño (cm)</a>
                        <?php if (isset($sort) && $sort === 'tamano'): ?>
                            <i class="bi <?= (isset($order) && $order === 'asc') ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                        <?php endif; ?>
                    </th>
                    <th>
                        <a href="?sort=peso&order=<?= (isset($sort) && $sort === 'peso' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-dark">Peso (kg)</a>
                        <?php if (isset($sort) && $sort === 'peso'): ?>
                            <i class="bi <?= (isset($order) && $order === 'asc') ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                        <?php endif; ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($capturas)) : ?>
                    <?php foreach ($capturas as $captura) : ?>
                        <tr>
                            <td class="text-center">
                                <a href="/user/capturas/<?= $captura->id ?>" class="btn btn-outline-primary btn-sm" title="Ver detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                            <td class="text-center"><?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></td>
                            <td><?= esc($captura->nombre) ?></td>
                            <td class="text-center"><?= esc($captura->tamano) ?></td>
                            <td class="text-center"><?= esc($captura->peso) ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No se encontraron capturas</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        <?= $pager->links() ?>
    </div>
</div>

<?php $this->endSection() ?>
