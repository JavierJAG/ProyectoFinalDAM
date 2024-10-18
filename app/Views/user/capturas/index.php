<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<a href="/user/capturas/new">Crear Captura</a>
<table>
    <tr>
        <td>Fecha</td>
        <td>Nombre</td>
        <td>Tamaño</td>
        <td>Peso</td>
        <td>Acciones</td>
    </tr>
    <?php foreach ($capturas as $captura) : ?>
        <tr>
            <td><?= $captura->fecha_captura ?></td>
            <td> <?= $captura->nombre ?></td>
            <td> <?= $captura->nombre_cientificotamano ?></td>
            <td> <?= $captura->peso ?></td>
            <td>
                <a href="/user/capturas/<?= $captura->id ?>">Detalles</a>
                <a href="/user/capturas/<?= $captura->id ?>/edit">Editar</a>
                <form action="/user/capturas/<?= $captura->id ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?php $this->endSection() ?>