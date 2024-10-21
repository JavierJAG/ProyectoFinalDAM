<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<h2>Información de la Captura</h2>

<p><strong>Fecha</strong> <?= $captura->fecha_captura ?></p>
<p><strong>Especie</strong> <?= $captura->nombre ?></p>
<p><strong>Descripcion</strong> <?= $captura->tamano ?> cm</p>
<p><strong>Tamaño</strong> <?= $captura->peso ?></p>
<p><strong>Peso</strong> <?= $captura->descripcion ?></p>
<?php if ($especie != null) : ?>
    <h4>Información de la especie</h4>
    <p><strong>Nombre Común:</strong> <?= $especie->nombre_comun ?></p>
    <p><strong>Nombre Científico:</strong> <?= $especie->nombre_cientifico ?></p>
    <p><strong>Talla Mínima:</strong> <?= $especie->tamano_minimo ?> cm</p>
    <p><strong>Cupo Máximo:</strong> <?= $especie->cupo_maximo ?></p>

    <h3>Imágenes Asociadas</h3>
    <div class="image-gallery">
        <?php if (!empty($imagenes_especie)): ?>
            <?php foreach ($imagenes_especie as $imagenEspecie): ?>
                <div class="image-item">
                    <img src="<?= base_url('../uploads/especies/' . $imagenEspecie->imagen) ?>" alt="Imagen de <?= $especie->nombre_comun ?>" style="width: 100px; height: auto;">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay imágenes asociadas a esta especie.</p>
        <?php endif; ?>
    </div>
<?php else : ?>
    <h4>No se han encontrado detalles de la especie</h4>
<?php endif ?>

<h3>Imágenes Asociadas</h3>
<div class="image-gallery">
    <?php if (!empty($imagenes)): ?>
        <?php foreach ($imagenes as $imagen): ?>
            <div class="image-item">
                <img src="<?= base_url('../uploads/capturas/' . $imagen->imagen) ?>" alt="Imagen de <?= $captura->nombre ?>" style="width: 100px; height: auto;">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay imágenes asociadas a esta captura.</p>
    <?php endif; ?>
</div>

<a href="<?= site_url('/user/capturas') ?>">Volver a la lista de capturas</a>

<?= $this->endSection() ?>