<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<a href="/dashboard/localidades/new">Crear Localidad</a>
<table>
    <tr>
        <td>Id</td>
        <td>Provincia</td>
        <td>Localidad</td>
        <td>Acciones</td>
    </tr>

    <body>
        <?php foreach ($localidades as $localidad) : ?>
            <tr>
                <td> <?= $localidad->id ?> </td>
                <td> <?= $localidad->PROVINCIA ?> </td>
                <td> <?= $localidad->nombre ?> </td>
                <td>
                    <a href="/dashboard/localidades/<?= $localidad->id ?>">Detalles</a>
                    <a href="/dashboard/localidades/<?= $localidad->id ?>/edit">Editar</a>
                    <form action="/dashboard/localidades/<?= $localidad->id ?>" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
        
</table>
<?= $pager->Links() ?>
<?php $this->endSection() ?>