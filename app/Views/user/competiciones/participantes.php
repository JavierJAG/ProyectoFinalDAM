<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<h1>Participantes</h1>

<ul>
    <?php foreach ($participantes as $p) : ?>
        <?= $p->username ?>
        <a href="<?= base_url("user/participantes/".$competicion_id."/".$p->id) ?>">Ver Participaciones</a>
    <?php endforeach ?>
</ul>


<?php $this->endSection() ?>