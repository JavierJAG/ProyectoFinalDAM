<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>
<h2>Crear Localidad</h2>
<form action="<?= site_url('/dashboard/localidades') ?>" method="post">
    <label for="provincia">Provincia</label>
    <select name="PROVINCIA" id="provincia">
    <option value="A CORUÑA" <?= old('provincia') == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
        <option value="LUGO" <?= old('provincia') == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
        <option value="OURENSE" <?= old('provincia') == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
        <option value="PONTEVEDRA" <?= old('provincia') == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
    </select>

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?= old('nombre') ?>" placeholder="localidad" required>

    <button type="submit">Crear</button>
</form>
<?php $this->endSection() ?>