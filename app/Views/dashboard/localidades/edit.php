<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>
<h2>Editar Localidad</h2>
<form action="<?= site_url('/dashboard/localidades/'.$localidad->id) ?>" method="post">
    <input type="hidden" name="_method" value="PATCH">
    <label for="provincia">Provincia</label>
    <select name="PROVINCIA" id="provincia">
        <option value="A CORUÑA" <?= old('provincia',$localidad->PROVINCIA) == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
        <option value="LUGO" <?= old('provincia',$localidad->PROVINCIA) == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
        <option value="OURENSE" <?= old('provincia',$localidad->PROVINCIA) == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
        <option value="PONTEVEDRA" <?= old('provincia',$localidad->PROVINCIA) == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
    </select>

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?= old('nombre',$localidad->nombre) ?>" placeholder="localidad" required>

    <button type="submit">Actualizar</button>
</form>
<?php $this->endSection() ?>