<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>
<h2>Editar Logro</h2>
<form action="<?= site_url('/dashboard/logros/'.$logro->id) ?>" method="post">
    <input type="hidden" name="_method" value="PATCH">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?= old('nombre',$logro->nombre) ?>" placeholder="nombre" required>

    <label for="descripcion">Descripción</label>
    <input type="text" name="descripcion" id="descripcion" value="<?= old('descripcion',$logro->descripcion) ?>" placeholder="descripcion" required>

    <button type="submit">Actualizar</button>
</form>
<?php $this->endSection() ?>