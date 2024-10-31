<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Resultados de la Búsqueda</h2>

    <?php if (!empty($usuarios)): ?>
        <div class="list-group mx-auto" style="max-width: 700px;">
            <?php foreach ($usuarios as $usuario): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded ">
                    <div>
                        <h5 class="mb-1"><?= htmlspecialchars($usuario->username) ?></h5>
                    </div>
                    <a href="/user/perfil/<?= $usuario->id ?>" class="btn btn-outline-primary">
                        Ver Perfil
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            <h5 class="alert-heading">No se encontraron usuarios.</h5>
            <p>Intenta ajustar tu búsqueda o verifica la información ingresada.</p>
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
