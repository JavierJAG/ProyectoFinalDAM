<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<div class="container mt-5">
    <h2 class="text-primary mb-4">Lista de Especies</h2>

    <!-- Tabla de especies -->
    <table class="table table-bordered bg-light shadow-sm">
        <thead class="table-primary">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre Común</th>
                <th scope="col">Nombre Científico</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($especies as $especie) : ?>
                <tr>
                    <td><?= $especie->id ?></td>
                    <td><?= $especie->nombre_comun ?></td>
                    <td><?= $especie->nombre_cientifico ?></td>
                    <td>
                        <a href="/user/especies/<?= $especie->id ?>" class="btn btn-info btn-sm">Detalles</a>

                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php $this->endSection() ?>