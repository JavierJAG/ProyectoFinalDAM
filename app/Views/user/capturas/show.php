<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<h2>Información de la Captura</h2>

<p><strong>Fecha</strong> <?= $captura->nombre_comun ?></p>
<p><strong>Especie</strong> <?= $captura->nombre_cientifico ?></p>
<p><strong>Descripcion</strong> <?= $captura->tamano_minimo ?> cm</p>
<p><strong>Tamaño</strong> <?= $captura->cupo_maximo ?></p>
<p><strong>Peso</strong> <?= $captura->cupo_maximo ?></p>

<h3>Imágenes Asociadas</h3>
<div class="image-gallery">
    <?php if (!empty($imagenes)): ?>
        <?php foreach ($imagenes as $imagen): ?>
            <div class="image-item">
                <img src="<?= base_url('../uploads/capturas/' . $imagen->imagen) ?>" alt="Imagen de <?= $captura->nombre_comun ?>" style="width: 100px; height: auto;">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay imágenes asociadas a esta captura.</p>
    <?php endif; ?>
</div>

<a href="<?= site_url('/user/capturas') ?>">Volver a la lista de capturas</a>

<?= $this->endSection() ?>
