<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="d-flex justify-content-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <h1 class="text-center mb-4">Capturas de la Competición</h1>

    <?php if (empty($capturas)): ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            <h5 class="alert-heading">No hay capturas registradas.</h5>
            <p>Intenta buscar en otra competición o agregar nuevas capturas.</p>
        </div>
    <?php else: ?>
        <div class="list-group list-group-flush">
            <?php foreach ($capturas as $c) : ?>
                <div class="list-group-item d-flex justify-content-between align-items-center p-3 mb-2 shadow-sm rounded border-light">
                    <div>
                        <h5 class="mb-1"><?= esc($c->nombre) ?></h5>
                        <small class="text-muted">Capturada el <?= esc($c->fecha_captura) ?></small>
                    </div>
                    <a href="<?= base_url("user/capturas/".$c->id) ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-eye"></i> Ver Detalles
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
