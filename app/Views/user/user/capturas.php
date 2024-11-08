<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Capturas</h2>

    <!-- Formulario de búsqueda y ordenación -->
    <form method="POST" action="/user/buscarCapturas/<?= $usuario_id ?>" class="mb-4">
        <div class="row">
            <!-- Cuadro de búsqueda -->
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Buscar por nombre de especie" value="<?= isset($search) ? esc($search) : '' ?>">
            </div>

            <!-- Menú desplegable para ordenar -->
            <!-- <div class="col-md-4">
                <select name="order" class="form-select">
                    <option value="fecha" <?= isset($order) && $order === 'fecha' ? 'selected' : '' ?>>Ordenar por Fecha</option>
                    <option value="peso" <?= isset($order) && $order === 'peso' ? 'selected' : '' ?>>Ordenar por Peso</option>
                    <option value="tamano" <?= isset($order) && $order === 'tamano' ? 'selected' : '' ?>>Ordenar por Tamaño</option>
                </select>
            </div> -->

            <!-- Botón de envío -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de capturas -->
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>
                    <a href="?search=<?= isset($search) ? esc($search) : '' ?>&sort=fecha_captura&order=<?= ($sort === 'fecha_captura' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-dark">
                        Fecha
                        <?php if ($sort === 'fecha_captura') : ?>
                            <?php if ($order === 'asc') : ?>
                                <i class="bi bi-arrow-up"></i>
                            <?php else : ?>
                                <i class="bi bi-arrow-down"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    <a href="?search=<?= isset($search) ? esc($search) : '' ?>&sort=nombre&order=<?= ($sort === 'nombre' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-dark">
                        Nombre
                        <?php if ($sort === 'nombre') : ?>
                            <?php if ($order === 'asc') : ?>
                                <i class="bi bi-arrow-up"></i>
                            <?php else : ?>
                                <i class="bi bi-arrow-down"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    <a href="?search=<?= isset($search) ? esc($search) : '' ?>&sort=tamano&order=<?= ($sort === 'tamano' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-dark">
                        Tamaño (cm)
                        <?php if ($sort === 'tamano') : ?>
                            <?php if ($order === 'asc') : ?>
                                <i class="bi bi-arrow-up"></i>
                            <?php else : ?>
                                <i class="bi bi-arrow-down"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    <a href="?search=<?= isset($search) ? esc($search) : '' ?>&sort=peso&order=<?= ($sort === 'peso' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-dark">
                        Peso (kg)
                        <?php if ($sort === 'peso') : ?>
                            <?php if ($order === 'asc') : ?>
                                <i class="bi bi-arrow-up"></i>
                            <?php else : ?>
                                <i class="bi bi-arrow-down"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </th>
                <th></th>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($capturas as $captura) : ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></td>
                    <td><?= esc($captura->nombre) ?></td>
                    <td><?= esc($captura->tamano) ?></td>
                    <td><?= esc($captura->peso) ?></td>
                    <td>
                        <a href="/user/capturas/<?= $captura->id ?>" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
</div>

<?php $this->endSection() ?>