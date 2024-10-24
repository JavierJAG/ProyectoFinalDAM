<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>


<h1>Mis Logros</h1>

<table class="table">
    <thead>
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
                    <td><?= htmlspecialchars($logro->competicion_nombre) ?></td>
                    <td><?= date('d/m/Y', strtotime($logro->fecha_logro)) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No tienes logros registrados.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $pager->links() ?>
<?= $this->endSection() ?>