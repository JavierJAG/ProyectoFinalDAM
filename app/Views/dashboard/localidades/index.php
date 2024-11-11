<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <!-- Barra lateral del perfil -->
        <?= view('/user/partials/_menuPerfil') ?>

        <!-- Contenido del perfil -->
        <div class="col-md-9">
            <div class="d-flex justify-content-center align-items-center mb-4">
                <h2 class="text-primary">Gestión de Localidades</h2>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-start mb-3">
                    <a href="/dashboard/localidades/new" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Crear Localidad
                    </a>
                </div>
                <div class="col d-flex justify-content-end mb-3">
                    <a href="javascript:history.back()" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Atrás</a>
                </div>
            </div>

            <!-- Tabla de localidades -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th style="width: 10%;">
                                <a href="?campo=id&orden=<?= $campoOrden === 'id' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                    ID <?= $campoOrden === 'id' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th style="width: 30%;">
                                <a href="?campo=PROVINCIA&orden=<?= $campoOrden === 'PROVINCIA' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                    Provincia <?= $campoOrden === 'PROVINCIA' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th style="width: 35%;">
                                <a href="?campo=nombre&orden=<?= $campoOrden === 'nombre' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                    Localidad <?= $campoOrden === 'nombre' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                                </a>
                            </th>
                            <th style="width: 25%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($localidades)) : ?>
                            <?php foreach ($localidades as $localidad) : ?>
                                <tr>
                                    <td class="text-center"><?= esc($localidad->id) ?></td>
                                    <td><?= esc($localidad->PROVINCIA) ?></td>
                                    <td><?= esc($localidad->nombre) ?></td>
                                    <td class="text-center">
                                        <a href="/dashboard/localidades/<?= $localidad->id ?>/edit" class="btn btn-sm" title="Editar localidad">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="/dashboard/localidades/<?= $localidad->id ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta localidad?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm" title="Eliminar localidad">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted p-4">
                                    <em>No se encontraron localidades.</em>
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
