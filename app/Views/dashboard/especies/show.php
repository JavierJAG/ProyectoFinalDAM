<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Información de la Especie</h2>

    <div class="bg-light p-4 shadow-sm rounded mb-4">
        <p><strong>Nombre Común:</strong> <?= esc($especie->nombre_comun) ?></p>
        <p><strong>Nombre Científico:</strong> <?= esc($especie->nombre_cientifico) ?></p>
        <p><strong>Talla Mínima:</strong> <?= esc($especie->tamano_minimo) ?> cm</p>
        <p><strong>Cupo Máximo:</strong> <?= esc($especie->cupo_maximo) ?></p>
    </div>

    <h3 class="text-primary">Imágenes Asociadas</h3>
    <div class="image-gallery d-flex flex-wrap">
        <?php if (!empty($imagenes)): ?>
            <?php foreach ($imagenes as $imagen): ?>
                <div class="image-item m-2">
                    <img src="<?= base_url('../uploads/especies/' . $imagen->imagen) ?>" alt="Imagen de <?= esc($especie->nombre_comun) ?>" class="img-thumbnail" style="width: 100px; height: auto;">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay imágenes asociadas a esta especie.</p>
        <?php endif; ?>
    </div>

    <a href="<?= site_url('/dashboard/especies') ?>" class="btn btn-primary mt-3">Volver a la lista de especies</a>
</div>

<?= $this->endSection() ?>
