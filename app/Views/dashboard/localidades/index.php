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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">Gestión de Localidades</h2>
                <a href="/dashboard/localidades/new" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Crear Localidad
                </a>
            </div>

            <!-- Tabla de localidades -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th style="width: 5%;">ID</th>
                            <th style="width: 30%;">Provincia</th>
                            <th style="width: 40%;">Localidad</th>
                            <th style="width: 25%;">Acciones</th>
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
                                       
                                        <a href="/dashboard/localidades/<?= $localidad->id ?>/edit" class="btn btn-warning btn-sm" title="Editar localidad">
                                            <i class="bi bi-pencil-square"></i> 
                                        </a>
                                        <form action="/dashboard/localidades/<?= $localidad->id ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta localidad?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar localidad">
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
