<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<a href="/user/zonasPesca/new">Crear Zona de Pesca</a>
<table>
    <tr>
        <td>Id</td>
        <td>Zona de Pesca</td>
        <td>Acciones</td>
    </tr>

    <body>
        <?php foreach ($zonasPesca as $zonaPesca) : ?>
            <tr>
                <td> <?= $zonaPesca->id ?> </td>
                <td> <?= $zonaPesca->nombre ?> </td>
                <td>
                    <a href="/user/zonasPesca/<?= $zonaPesca->id ?>">Detalles</a>
                    <a href="/user/zonasPesca/<?= $zonaPesca->id ?>/edit">Editar</a>
                    <form action="/user/zonasPesca/<?= $zonaPesca->id ?>" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>

</table>
<?= $pager->Links() ?>
<?php $this->endSection() ?>