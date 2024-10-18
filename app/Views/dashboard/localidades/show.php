<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>
<h2>Información de la localidad</h2>
<table>
    <tr>
        <td>Id</td>
        <td>Provincia</td>
        <td>Localidad</td>
    </tr>
    <tr>
        <td><?= $localidad->id ?></td>
        <td><?= $localidad->PROVINCIA ?></td>
        <td><?= $localidad->nombre ?></td>
    </tr>
</table>
<a href="<?= site_url('/dashboard/localidades') ?>">Volver a la lista de localidades</a>
<?php $this->endSection() ?>