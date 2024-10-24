<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Zonas de Pesca</h2>
    <div class="mb-3">
        <a href="/user/zonasPesca/new" class="btn btn-success">Crear Zona de Pesca</a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Zona de Pesca</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($zonasPesca as $zonaPesca) : ?>
                <tr>
                    <td><?= $zonaPesca->id ?></td>
                    <td><?= $zonaPesca->nombre ?></td>
                    <td>
                        <a href="/user/zonasPesca/<?= $zonaPesca->id ?>" class="btn btn-info btn-sm">Detalles</a>
                       
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?= $pager->Links() ?>
    </div>
</div>

<?php $this->endSection() ?>
