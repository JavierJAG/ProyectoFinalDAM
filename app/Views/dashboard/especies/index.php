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
            <div class="row">
                <div class="col d-flex justify-content-start mb-3">
                    <a href="/dashboard/especies/new" class="btn btn-success"><i class="bi bi-plus-circle"></i> Crear Especie</a>
                </div>
                <div class="col d-flex justify-content-end mb-3">
                    <a href="javascript:history.back()" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Atrás</a>
                </div>
            </div>


            <!-- Tabla de especies -->
            <div class="table-responsive shadow-sm">
                <table class="table table-hover table-striped align-middle">
                <thead class="table-primary">
                        <tr class="text-center">
                            <th scope="col" style="width: 10%;">
                                <a href="?campo=id&orden=<?= $campoOrden === 'id' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                    ID <?= $campoOrden === 'id' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th scope="col" style="width: 30%;">
                                <a href="?campo=nombre_comun&orden=<?= $campoOrden === 'nombre_comun' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                    Nombre Común <?= $campoOrden === 'nombre_comun' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th scope="col" style="width: 30%;">
                                <a href="?campo=nombre_cientifico&orden=<?= $campoOrden === 'nombre_cientifico' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                    Nombre Científico <?= $campoOrden === 'nombre_cientifico' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th scope="col" style="width: 30%;"></th>
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
                                        <a href="/dashboard/especies/<?= $especie->id ?>" class="btn  btn-sm" title="Ver detalles"><i class="bi bi-eye"></i> </a>
                                        <a href="/dashboard/especies/<?= $especie->id ?>/edit" class="btn  btn-sm" title="Editar especie"><i class="bi bi-pencil-square"></i> </a>
                                        <form action="/dashboard/especies/<?= $especie->id ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta especie?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn  btn-sm" title="Eliminar especie"><i class="bi bi-trash"></i> </button>
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