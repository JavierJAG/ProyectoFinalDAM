<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<a href="/dashboard/especies/new">Crear Especie</a>
<table>
    <tr>
        <td>Id</td>
        <td>Nombre Común</td>
        <td>Nombre Científico</td>
        <td>Acciones</td>
    </tr>
    <?php foreach ($especies as $especie) : ?>
        <tr>
            <td><?= $especie->id ?></td>
            <td> <?= $especie->nombre_comun ?></td>
            <td> <?= $especie->nombre_cientifico ?></td>
            <td>
                <a href="/dashboard/especies/<?= $especie->id ?>">Detalles</a>
                <a href="/dashboard/especies/<?= $especie->id ?>/edit">Editar</a>
                <form action="/dashboard/especies/<?= $especie->id ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?php $this->endSection() ?>