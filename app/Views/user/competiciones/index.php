<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<a href="/user/competiciones/new">Crear Competicion</a>

<!--  TODO API CALENDARIO  -->
<table>
    <tr>
        <td>Fecha inicio</td>
        <td>Fecha fin</td>
        <td>Nombre</td>
        <td>Acciones</td>
    </tr>
    <?php foreach ($competiciones as $competicion) : ?>
        <tr>
            <td><?= $competicion->fecha_inicio ?></td>
            <td><?= $competicion->fecha_fin ?></td>
            <td> <?= $competicion->nombre ?></td>
            <td>
                <a href="/user/competiciones/<?= $competicion->id ?>">Detalles</a>
                <a href="/user/competiciones/<?= $competicion->id ?>/edit">Editar</a>
                <form action="/user/competiciones/<?= $competicion->id ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?php $this->endSection() ?>