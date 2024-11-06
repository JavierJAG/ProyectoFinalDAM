<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>

        <!-- Contenido del Perfil -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">Lista de Logros</h2>
                <?php if (auth()->user()->inGroup('superadmin')) : ?>
                    <a href="/dashboard/logros/new" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Crear Logro
                    </a>
                <?php endif; ?>
            </div>

            <!-- Tabla de logros -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary">
                        <tr class="text-center">
                            <th style="width: 10%;">ID</th>
                            <th style="width: 60%;">Nombre del Logro</th>
                            <th style="width: 60%;">Descripción</th>
                            <th style="width: 30%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logros)) : ?>
                            <?php foreach ($logros as $logro) : ?>
                                <tr>
                                    <td class="text-center"><?= esc($logro->id) ?></td>
                                    <td><?= esc($logro->nombre) ?></td>
                                    <td><?= esc($logro->descripcion) ?></td>
                                    <td class="d-flex justify-content-center gap-2">
                                        <a href="/dashboard/logros/<?= $logro->id ?>/edit" class="btn btn-warning btn-sm" title="Editar logro">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="/dashboard/logros/<?= $logro->id ?>" method="post" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este logro?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar logro">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted p-4">
                                    <em>No se encontraron logros.</em>
                                </td>
                            </tr>
                        <?php endif; ?>
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