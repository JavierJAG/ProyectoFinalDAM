<?= $this->extend("/user/layout/template") ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
<div class="row">
    <?= view('/user/partials/_menuPerfil') ?>
    <div class="col-md-9">
    <h2 class="text-center mb-4">Lista de Competiciones</h2>

    <div class="mb-3">
        <a href="/user/competiciones/new" class="btn btn-primary">Crear Competición</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($competiciones as $competicion) : ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($competicion->fecha_inicio)) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($competicion->fecha_fin)) ?></td>
                    <td><?= htmlspecialchars($competicion->nombre) ?></td>
                    <td>
                        <a title="Mostrar" href="/user/competiciones/<?= $competicion->id ?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                        <a title="Editar" href="/user/competiciones/<?= $competicion->id ?>/edit" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="/user/competiciones/<?= $competicion->id ?>" method="post" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button title="Eliminar" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta competición?');"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</div>

<?php $this->endSection() ?>
