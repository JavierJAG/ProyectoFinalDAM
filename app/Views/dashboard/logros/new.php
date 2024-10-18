<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>
<h2>Crear Logro</h2>
<form action="<?= site_url('/dashboard/logros') ?>" method="post">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?= old('nombre') ?>" placeholder="nombre" required>

    <label for="descripcion">Descripción</label>
    <input type="text" name="descripcion" id="descripcion" value="<?= old('descripcion') ?>" placeholder="descripcion" required>

    <button type="submit">Crear</button>
</form>
<?php $this->endSection() ?>