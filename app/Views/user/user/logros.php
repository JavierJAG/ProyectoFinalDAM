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
     
            <h1 class="text-center mb-4">Logros</h1>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <a href="?sort=logro_nombre&order=<?= ($sort === 'logro_nombre' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">
                                    Nombre
                                    <?php if ($sort === 'logro_nombre') : ?>
                                        <?php if ($order === 'asc') : ?>
                                            <i class="bi bi-arrow-up"></i>
                                        <?php else : ?>
                                            <i class="bi bi-arrow-down"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=logro_descripcion&order=<?= ($sort === 'logro_descripcion' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">
                                    Descripción
                                    <?php if ($sort === 'logro_descripcion') : ?>
                                        <?php if ($order === 'asc') : ?>
                                            <i class="bi bi-arrow-up"></i>
                                        <?php else : ?>
                                            <i class="bi bi-arrow-down"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=competicion_nombre&order=<?= ($sort === 'competicion_nombre' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">
                                    Competición
                                    <?php if ($sort === 'competicion_nombre') : ?>
                                        <?php if ($order === 'asc') : ?>
                                            <i class="bi bi-arrow-up"></i>
                                        <?php else : ?>
                                            <i class="bi bi-arrow-down"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=fecha_logro&order=<?= ($sort === 'fecha_logro' && $order === 'asc') ? 'desc' : 'asc' ?>" class="text-decoration-none text-white">
                                    Fecha
                                    <?php if ($sort === 'fecha_logro') : ?>
                                        <?php if ($order === 'asc') : ?>
                                            <i class="bi bi-arrow-up"></i>
                                        <?php else : ?>
                                            <i class="bi bi-arrow-down"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            </th>
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
