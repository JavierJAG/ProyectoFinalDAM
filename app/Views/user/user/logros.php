<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <?php if ($usuario_id == auth()->user()->id) : ?>
            <?= view('/user/partials/_menuPerfil') ?>
        <?php endif; ?>
        <div class="col-md-9">
     
            <h1 class="text-center mb-4">Mis Logros</h1>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Competición</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logros)): ?>
                            <?php foreach ($logros as $logro): ?>
                                <tr>
                                    <td><?= htmlspecialchars($logro->logro_nombre) ?></td>
                                    <td><?= htmlspecialchars($logro->logro_descripcion) ?></td>
                                    <td><a href="/user/competiciones/<?= $logro->competicion_id ?>"><?= htmlspecialchars($logro->competicion_nombre) ?></a></td>
                                    <td><?= date('d/m/Y', strtotime($logro->fecha_logro)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No se han obtenido logros.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>