<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Gestión de Localidades</h2>
        <a href="/dashboard/localidades/new" class="btn btn-primary">Crear Localidad</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Id</th>
                    <th>Provincia</th>
                    <th>Localidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($localidades as $localidad) : ?>
                    <tr>
                        <td><?= $localidad->id ?></td>
                        <td><?= $localidad->PROVINCIA ?></td>
                        <td><?= $localidad->nombre ?></td>
                        <td>
                            <a href="/dashboard/localidades/<?= $localidad->id ?>" class="btn btn-info btn-sm">Detalles</a>
                            <a href="/dashboard/localidades/<?= $localidad->id ?>/edit" class="btn btn-warning btn-sm">Editar</a>
                            <form action="/dashboard/localidades/<?= $localidad->id ?>" method="post" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <?= $pager->Links() ?>
    </div>
</div>

<?php $this->endSection() ?>