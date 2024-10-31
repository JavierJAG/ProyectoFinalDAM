<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Perfil de <?= htmlspecialchars($usuario->username) ?></h2>

    <div class="card shadow-lg">
        <div class="card-body">
            <h5 class="card-title">Información de contacto</h5>
            <p class="card-text">
                <strong>Email:</strong>
                <a href="mailto:<?= htmlspecialchars($usuario->email) ?>" class="text-decoration-none">
                    <?= htmlspecialchars($usuario->email) ?>
                </a>
            </p>

            <hr class="my-4"> 

            <div class="mt-2">
                <a href="/user/buscarLogros/<?= $usuario->id ?>" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-trophy-fill"></i> Ver Logros
                </a>
                <a href="/user/buscarCapturas/<?= $usuario->id ?>" class="btn btn-secondary btn-lg">
                    <i class="bi bi-fish"></i> Ver Capturas
                </a>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
