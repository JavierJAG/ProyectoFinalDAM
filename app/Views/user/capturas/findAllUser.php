<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Capturas</h2>
    
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
