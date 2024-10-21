<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Mis Capturas</h2>
    
    <div class="mb-3">
        <a href="/user/capturas/new" class="btn btn-primary">Crear Captura</a>
    </div>
    
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
                        <a href="/user/capturas/<?= $captura->id ?>/edit" class="btn btn-warning btn-sm">Editar</a>
                        <form action="/user/capturas/<?= $captura->id ?>" method="post" class="d-inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta captura?');">Eliminar</button>
                        </form>
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
