<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Editar Especie</h2>

    <!-- Formulario de edición de especie -->
    <form action="<?= site_url('/dashboard/especies/' . $especie->id) ?>" method="post" enctype="multipart/form-data" class="bg-light p-4 shadow-sm rounded">
        <input type="hidden" name="_method" value="PATCH">

        <!-- Campo: Nombre Común -->
        <div class="mb-3">
            <label for="nombre_comun" class="form-label">Nombre Común</label>
            <input type="text" id="nombre_comun" name="nombre_comun" value="<?= old('nombre_comun', $especie->nombre_comun) ?>" class="form-control" required>
        </div>

        <!-- Campo: Nombre Científico -->
        <div class="mb-3">
            <label for="nombre_cientifico" class="form-label">Nombre Científico</label>
            <input type="text" id="nombre_cientifico" name="nombre_cientifico" value="<?= old('nombre_cientifico', $especie->nombre_cientifico) ?>" class="form-control">
        </div>

        <!-- Campo: Talla Mínima (cm) -->
        <div class="mb-3">
            <label for="tamano_minimo" class="form-label">Talla Mínima (cm)</label>
            <input type="number" id="tamano_minimo" name="tamano_minimo" value="<?= old('tamano_minimo', $especie->tamano_minimo) ?>" class="form-control" step="0.1">
        </div>

        <!-- Campo: Cupo Máximo -->
        <div class="mb-3">
            <label for="cupo_maximo" class="form-label">Cupo Máximo</label>
            <input type="number" id="cupo_maximo" name="cupo_maximo" value="<?= old('cupo_maximo', $especie->cupo_maximo) ?>" class="form-control">
        </div>

        <!-- Campo: Imágenes de la Especie -->
        <div class="mb-3">
            <label for="imagenes" class="form-label">Imágenes de la Especie</label>
            <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple>
        </div>

        <!-- Botón de Actualizar -->
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>

    <!-- Sección: Imágenes actuales -->
    <?php if (!empty($imagenes)): ?>
        <h3 class="text-secondary mt-5">Imágenes Actuales:</h3>
        <div class="row mt-3">
            <?php foreach ($imagenes as $imagen): ?>
                <div class="col-md-3 mb-3">
                    <img src="<?= base_url('uploads/especies/' . $imagen->imagen) ?>" alt="Imagen de <?= esc($especie->nombre_comun) ?>" class="img-thumbnail" style="max-width: 100%;">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="<?= site_url('/dashboard/especies') ?>" class="btn btn-secondary mt-3">Volver a la lista de especies</a>
</div>

<?= $this->endSection() ?>
