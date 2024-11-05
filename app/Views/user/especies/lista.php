<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<div class="container mt-5">
    <h2 class="text-primary mb-4">Lista de Especies</h2>

    <!-- Tabla de especies -->
    <table class="table table-bordered bg-light shadow-sm text-center">
        <thead class="table-primary">
            <tr>
                <th scope="col" style="width: 40px; text-align: center;"></th>
                <th scope="col">ID</th>
                <th scope="col">Nombre Común</th>
                <th scope="col">Nombre Científico</th>
                <th scope="col">Talla mínima(cm)</th>
                <th scope="col">Cupo máximo</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($especies as $especie) : ?>
                <tr>
                    <td>
                        <a title="Detalles" href="/user/especies/<?= $especie->id ?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i> </a>

                    </td>
                    <td><?= $especie->id ?></td>
                    <td><?= $especie->nombre_comun ?></td>
                    <td><?= $especie->nombre_cientifico ?></td>
                    <td><?= $especie->tamano_minimo != 0 ? $especie->tamano_minimo . ' cm' : 'No se ha registrado' ?></td>
                    <td><?= $especie->cupo_maximo != 0 ? $especie->cupo_maximo : 'No se ha registrado' ?></td>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php $this->endSection() ?>