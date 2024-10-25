<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container">
    <h2>Perfil de <?= htmlspecialchars($usuario->username) ?></h2><br>
    <p><strong>Email:</strong> 
    <a href="mailto:<?= htmlspecialchars($usuario->email) ?>">
        <?= htmlspecialchars($usuario->email) ?>
    </a>
</p>


    <div class="mt-4">
        <a href="/user/buscarLogros/<?= $usuario->id ?>" class="btn btn-primary">Ver Logros</a>
        <a href="/user/buscarCapturas/<?= $usuario->id ?>" class="btn btn-secondary">Ver Capturas</a>
    </div>
</div>

<?php $this->endSection() ?>