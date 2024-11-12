<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="col d-flex justify-content-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Volver</a>
    </div>
    <h2 class="text-primary mb-4">Nuevo Logro</h2>

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