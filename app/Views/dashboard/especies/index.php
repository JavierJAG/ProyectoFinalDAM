<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>

        <!-- Contenido del Perfil -->
        <div class="col-md-9">
            <h2 class="text-center text-primary mb-4">Lista de Especies</h2>

            <!-- Botón de Crear Especie -->
            <div class="d-flex justify-content-start mb-3">
                <a href="/dashboard/especies/new" class="btn btn-success"><i class="bi bi-plus-circle"></i> Crear Especie</a>
            </div>

            <!-- Tabla de especies -->
            <div class="table-responsive shadow-sm">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th scope="col" style="width: 5%;">ID</th>
                            <th scope="col" style="width: 30%;">Nombre Común</th>
                            <th scope="col" style="width: 35%;">Nombre Científico</th>
                            <th scope="col" style="width: 30%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($especies)) : ?>
                            <?php foreach ($especies as $especie) : ?>
                                <tr>
                                    <td class="text-center"><?= $especie->id ?></td>
                                    <td class="text-center"><?= esc($especie->nombre_comun) ?></td>
                                    <td class="text-center"><?= esc($especie->nombre_cientifico) ?></td>
                                    <td class="text-center">
                                        <a href="/dashboard/especies/<?= $especie->id ?>" class="btn btn-info btn-sm" title="Ver detalles"><i class="bi bi-eye"></i> </a>
                                        <a href="/dashboard/especies/<?= $especie->id ?>/edit" class="btn btn-warning btn-sm" title="Editar especie"><i class="bi bi-pencil-square"></i> </a>
                                        <form action="/dashboard/especies/<?= $especie->id ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta especie?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar especie"><i class="bi bi-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted p-4">
                                    <em>No se encontraron especies</em>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>