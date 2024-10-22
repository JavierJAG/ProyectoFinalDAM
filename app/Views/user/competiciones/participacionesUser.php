<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Participanciones</h1>

    <div class="list-group">
        <?php foreach ($participaciones as $p) : ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
            <span><?= esc($p->fecha_inicio) ?></span>
            <span><?= esc($p->nombre) ?></span>
                <a href="<?= base_url("user/participantes/".$p->id."/".auth()->user()->id) ?>" class="btn btn-outline-primary btn-sm">Ver Detalles</a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($participaciones)): ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            Aún no se ha participado en ninguna competición.
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
