<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="col d-flex justify-content-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Volver</a>
    </div>
    <h2 class="text-primary mb-4">Nueva Localidad</h2>

    <form action="<?= site_url('/dashboard/localidades') ?>" method="post" class="bg-light p-4 rounded shadow-sm">

        <!-- Selección de Provincia -->
        <div class="mb-3">
            <label for="provincia" class="form-label">Provincia</label>
            <select name="PROVINCIA" id="provincia" class="form-select" required>
                <option value="A CORUÑA" <?= old('provincia') == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
                <option value="LUGO" <?= old('provincia') == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
                <option value="OURENSE" <?= old('provincia') == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
                <option value="PONTEVEDRA" <?= old('provincia') == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
            </select>
        </div>

        <!-- Campo de Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Localidad</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="Escribe el nombre de la localidad" required>
        </div>

        <!-- Botón de Envío -->
        <button type="submit" class="btn btn-primary">Crear</button>
        <a href="/dashboard/localidades" class="btn btn-secondary">Cancelar</a>

    </form>
</div>

<?php $this->endSection() ?>