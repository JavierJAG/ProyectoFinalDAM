<?= $this->extend('/dashboard/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>

<h2>Información de la Especie</h2>

<p><strong>Nombre Común:</strong> <?= $especie->nombre_comun ?></p>
<p><strong>Nombre Científico:</strong> <?= $especie->nombre_cientifico ?></p>
<p><strong>Talla Mínima:</strong> <?= $especie->tamano_minimo ?> cm</p>
<p><strong>Cupo Máximo:</strong> <?= $especie->cupo_maximo ?></p>

<h3>Imágenes Asociadas</h3>
<div class="image-gallery">
    <?php if (!empty($imagenes)): ?>
        <?php foreach ($imagenes as $imagen): ?>
            <div class="image-item">
                <img src="<?= base_url('../uploads/especies/' . $imagen->imagen) ?>" alt="Imagen de <?= $especie->nombre_comun ?>" style="width: 100px; height: auto;">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay imágenes asociadas a esta especie.</p>
    <?php endif; ?>
</div>

<a href="<?= site_url('/dashboard/especies') ?>">Volver a la lista de especies</a>

<?= $this->endSection() ?>
