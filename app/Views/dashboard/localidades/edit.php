<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Editar Localidad</h2>

    <form action="<?= site_url('/dashboard/localidades/'.$localidad->id) ?>" method="post" class="bg-light p-4 rounded shadow-sm">
        <input type="hidden" name="_method" value="PATCH">

        <!-- Selección de Provincia -->
        <div class="mb-3">
            <label for="provincia" class="form-label">Provincia</label>
            <select name="PROVINCIA" id="provincia" class="form-select" required>
                <option value="A CORUÑA" <?= old('provincia',$localidad->PROVINCIA) == 'A CORUÑA' ? 'selected' : '' ?>>A CORUÑA</option>
                <option value="LUGO" <?= old('provincia',$localidad->PROVINCIA) == 'LUGO' ? 'selected' : '' ?>>LUGO</option>
                <option value="OURENSE" <?= old('provincia',$localidad->PROVINCIA) == 'OURENSE' ? 'selected' : '' ?>>OURENSE</option>
                <option value="PONTEVEDRA" <?= old('provincia',$localidad->PROVINCIA) == 'PONTEVEDRA' ? 'selected' : '' ?>>PONTEVEDRA</option>
            </select>
        </div>

        <!-- Campo de Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Localidad</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre',$localidad->nombre) ?>" placeholder="Escribe el nombre de la localidad" required>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="/dashboard/localidades" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php $this->endSection() ?>
