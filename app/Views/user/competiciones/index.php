<?= $this->extend("/user/layout/template") ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>
        <div class="col-md-9">
            <h2 class="text-center mb-4">Lista de Competiciones</h2>
            <div class="row">
                <div class="col mb-3">
                    <a href="/user/competiciones/new" class="btn btn-primary">Crear Competición</a>
                </div>
                <div class="col d-flex justify-content-end mb-3">
                    <a href="javascript:history.back()" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Atrás</a>
                </div>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>
                            <a href="?campo=fecha_inicio&orden=<?= $campoOrden === 'fecha_inicio' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                Fecha Inicio 
                                <?= $campoOrden === 'fecha_inicio' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?campo=fecha_fin&orden=<?= $campoOrden === 'fecha_fin' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                Fecha Fin 
                                <?= $campoOrden === 'fecha_fin' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th>
                            <a href="?campo=nombre&orden=<?= $campoOrden === 'nombre' && $direccionOrden === 'asc' ? 'desc' : 'asc' ?>">
                                Nombre 
                                <?= $campoOrden === 'nombre' ? ($direccionOrden === 'asc' ? '▲' : '▼') : '' ?>
                            </a>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($competiciones as $competicion) : ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($competicion->fecha_inicio)) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($competicion->fecha_fin)) ?></td>
                            <td><?= htmlspecialchars($competicion->nombre) ?></td>
                            <td>
                                <a title="Mostrar" href="/user/competiciones/<?= $competicion->id ?>" class="btn btn-sm"><i class="bi bi-eye"></i></a>
                                <a title="Editar" href="/user/competiciones/<?= $competicion->id ?>/edit" class="btn btn-sm"><i class="bi bi-pencil"></i></a>
                                <form action="/user/competiciones/<?= $competicion->id ?>" method="post" style="display:inline;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button title="Eliminar" type="submit" class="btn btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta competición?');"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
