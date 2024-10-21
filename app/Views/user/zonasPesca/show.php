<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Información de la Zona de Pesca</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Provincia</th>
                <th>Localidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $zonaPesca->id ?></td>
                <td><?= $zonaPesca->nombre ?></td>
                <td><?= $zonaPesca->descripcion ?></td>
                <td><?= $localidad->PROVINCIA ?></td>
                <td><?= $localidad->nombre ?></td>
            </tr>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
    </div>
</div>

<?php $this->endSection() ?>