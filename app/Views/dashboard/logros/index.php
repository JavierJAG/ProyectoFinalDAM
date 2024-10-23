<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Lista de Logros</h2>
    <?= auth()->user()->inGroup('superadmin') ?
        '<div class="mb-3">
        <a href="/dashboard/logros/new" class="btn btn-primary">Crear Logro</a>
    </div>' : ''
    ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Logro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logros as $logro) : ?>
                <tr>
                    <td><?= $logro->id ?></td>
                    <td><?= esc($logro->nombre) ?></td>
                    <td>
                        <a href="/dashboard/logros/<?= $logro->id ?>" class="btn btn-info btn-sm">Detalles</a>
                        <a href="/dashboard/logros/<?= $logro->id ?>/edit" class="btn btn-warning btn-sm">Editar</a>
                        <form action="/dashboard/logros/<?= $logro->id ?>" method="post" class="d-inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este logro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $pager->links() ?>
</div>

<?php $this->endSection() ?>