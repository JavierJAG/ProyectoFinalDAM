<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Crear Logro</h2>

    <form action="<?= site_url('/dashboard/logros') ?>" method="post" class="bg-light p-4 shadow-sm rounded">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="nombre" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" class="form-control" value="<?= old('descripcion') ?>" placeholder="descripcion" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>

<?php $this->endSection() ?>
