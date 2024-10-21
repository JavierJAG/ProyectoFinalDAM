<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<h1>Participaciones</h1>

<ul>
    <?php foreach ($capturas as $c) : ?>
        <?= $c->fecha_captura ?>
        <?= $c->nombre ?>
        <a href="<?= base_url("user/capturas/".$c->id) ?>">Ver Detalles</a>
    <?php endforeach ?>
</ul>
<?php $this->endSection() ?>