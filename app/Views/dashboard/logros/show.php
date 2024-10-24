<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Información del Logro</h2>

    <div class="bg-light p-4 shadow-sm rounded mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= esc($logro->id) ?></td>
                    <td><?= esc($logro->nombre) ?></td>
                    <td><?= esc($logro->descripcion) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="<?= site_url('/dashboard/logros') ?>" class="btn btn-primary mt-3">Volver a la lista de logros</a>
</div>

<?php $this->endSection() ?>
