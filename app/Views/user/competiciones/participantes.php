<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Participantes</h1>

    <div class="list-group">
        <?php foreach ($participantes as $p) : ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= esc($p->username) ?></span>
                <a href="<?= base_url("user/participantes/".$competicion_id."/".$p->id) ?>" class="btn btn-outline-primary btn-sm">Ver Participaciones</a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($participantes)): ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            No hay participantes registrados para esta competición.
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
