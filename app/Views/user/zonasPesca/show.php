<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>
<h2>Información de la Zona de Pesca </h2>
<table>
    <tr>
        <td>Id</td>
        <td>Nombre</td>
        <td>Descripción</td>
        <td>Provincia</td>
        <td>Localidad</td>
        <!-- <td>Coordenadas</td> -->
    </tr>
    <tr>
        <td><?= $zonaPesca->id ?></td>
        <td><?= $zonaPesca->nombre ?></td>
        <td><?= $zonaPesca->descripcion ?></td>
        <td><?= $localidad->PROVINCIA ?></td>
        <td><?= $localidad->nombre ?></td>
        <!-- <td><?= $zonaPesca->coordenadas ?></td> -->
    </tr>
</table>
<a href="<?= site_url('/user/zonasPesca') ?>">Volver a la lista de Zonas de Pesca </a>
<?php $this->endSection() ?>