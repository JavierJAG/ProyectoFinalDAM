<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Capturas</h2>

    <!-- Formulario de búsqueda y ordenación -->
    <form method="POST" action="/user/perfil/misCapturas" class="mb-4">
        <div class="row">
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

            <!-- Botón de envío -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Fecha</th>
                <th>Nombre</th>
                <th>Tamaño (cm)</th>
                <th>Peso (kg)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($capturas as $captura) : ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></td>
                    <td><?= $captura->nombre ?></td>
                    <td><?= $captura->tamano ?></td>
                    <td><?= $captura->peso ?></td>
                    <td>
                        <a href="/user/capturas/<?= $captura->id ?>" class="btn btn-info btn-sm">Detalles</a>
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