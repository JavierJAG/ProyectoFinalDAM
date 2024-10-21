<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Participaciones</h1>

    <div class="list-group">
        <?php if (empty($capturas)): ?>
            <div class="alert alert-warning text-center" role="alert">
                No hay capturas registradas para esta competición.
            </div>
        <?php else: ?>
            <?php foreach ($capturas as $c) : ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= esc($c->nombre) ?></strong><br>
                        <small class="text-muted"><?= esc($c->fecha_captura) ?></small>
                    </div>
                    <a href="<?= base_url("user/capturas/".$c->id) ?>" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                </div>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>

<?php $this->endSection() ?>
