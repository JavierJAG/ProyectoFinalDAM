<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>
<h2>Información del logro</h2>
<table>
    <tr>
        <td>Id</td>
        <td>Nombre</td>
        <td>Descripción</td>
    </tr>
    <tr>
        <td><?= $logro->id ?></td>
        <td><?= $logro->nombre ?></td>
        <td><?= $logro->descripcion ?></td>
    </tr>
</table>
<a href="<?= site_url('/dashboard/logros') ?>">Volver a la lista de logros</a>
<?php $this->endSection() ?>