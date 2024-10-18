<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<a href="/dashboard/logros/new">Crear Logro</a>
<table>
    <tr>
        <td>Id</td>
        <td>Logro</td>
        <td>Acciones</td>
    </tr>

    <body>
        <?php foreach ($logros as $Logro) : ?>
            <tr>
                <td> <?= $Logro->id ?> </td>
                <td> <?= $Logro->nombre ?> </td>
                <td>
                    <a href="/dashboard/logros/<?= $Logro->id ?>">Detalles</a>
                    <a href="/dashboard/logros/<?= $Logro->id ?>/edit">Editar</a>
                    <form action="/dashboard/logros/<?= $Logro->id ?>" method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
        
</table>
<?= $pager->Links() ?>
<?php $this->endSection() ?>