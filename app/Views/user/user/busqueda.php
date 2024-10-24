<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>


<div class="container">
    <?php if (!empty($usuarios)): ?>
        <h3>Resultados de la búsqueda:</h3>
        <ul class="list-group">
            <?php foreach ($usuarios as $usuario): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($usuario->username) ?>
                    <a href="/user/perfil/<?= $usuario->id ?>" class="btn btn-info">Ver Perfil</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No se encontraron usuarios.</p>
    <?php endif; ?>
</div>


<?php $this->endSection() ?>