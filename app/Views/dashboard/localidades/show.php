<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Información de la Localidad</h2>

    <!-- Tabla de información de la localidad -->
    <table class="table table-bordered bg-light shadow-sm">
        <thead class="table-primary">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Provincia</th>
                <th scope="col">Localidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $localidad->id ?></td>
                <td><?= $localidad->PROVINCIA ?></td>
                <td><?= $localidad->nombre ?></td>
            </tr>
        </tbody>
    </table>

    <!-- Botón de volver -->
    <a href="<?= site_url('/dashboard/localidades') ?>" class="btn btn-primary mt-3">Volver a la lista de localidades</a>
</div>

<?php $this->endSection() ?>
