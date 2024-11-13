<?php $this->extend('/user/layout/template') ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Capturas globales</h2>
    <!-- Formulario de búsqueda y ordenación -->
    <form method="POST" action="/user/buscarCapturas" class="mb-4">
        <div class="row">
            <!-- Cuadro de búsqueda -->
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre de especie" value="<?= isset($search) ? esc($search) : '' ?>">
            </div>

            <!-- Botón de envío -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>

    <!-- Botón para crear una nueva captura -->
    <div class="mb-3">
        <a href="/user/perfil/misCapturas" class="btn btn-primary">Mis capturas</a>
    </div>

    <!-- Tabla de capturas -->
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th style="width: 40px; text-align: center;"></th>
                <th>
                    <a href="?sort=fecha_captura&order=<?= (isset($sort) && $sort === 'fecha_captura' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-decoration-none text-black">Fecha</a>
                    <?php if (isset($sort) && $sort === 'fecha_captura'): ?>
                        <i class="bi <?= (isset($order) && $order === 'asc') ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                    <?php endif; ?>
                </th>
                <th>
                    <a href="?sort=nombre&order=<?= (isset($sort) && $sort === 'nombre' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-decoration-none text-black">Especie</a>
                    <?php if (isset($sort) && $sort === 'nombre'): ?>
                        <i class="bi <?= (isset($order) && $order === 'asc') ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                    <?php endif; ?>
                </th>
                <th>
                    <a href="?sort=tamano&order=<?= (isset($sort) && $sort === 'tamano' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-decoration-none text-black">Tamaño (cm)</a>
                    <?php if (isset($sort) && $sort === 'tamano'): ?>
                        <i class="bi <?= (isset($order) && $order === 'asc') ? 'bi-arrow-up' : 'bi-arrow-down' ?>"></i>
                    <?php endif; ?>
                </th>
                <th>
                    <a href="?sort=peso&order=<?= (isset($sort) && $sort === 'peso' && isset($order) && $order === 'asc') ? 'desc' : 'asc' ?>&search=<?= isset($search) ? urlencode($search) : '' ?>" class="text-decoration-none text-black">Peso (kg)</a>
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
                        <td>
                            <a href="/user/capturas/<?= $captura->id ?>" class="btn btn-outline-primary btn-sm" title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></td>
                        <td><?= esc($captura->nombre) ?></td>
                        <td><?= esc($captura->tamano) ?></td>
                        <td><?= esc($captura->peso) ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">No se encontraron capturas</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
</div>

<?php $this->endSection() ?>