<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<h2>Información de la Competicion</h2>

<p><strong>Nombre: </strong> <?= $competicion->nombre ?></p>
<p><strong>Fecha inicio: </strong> <?= $competicion->fecha_inicio ?></p>
<p><strong>Fecha fin: </strong> <?= $competicion->fecha_fin ?></p>
<p><strong>Lugar</strong> <a href="<?=base_url("user/zonasPesca/".$zonaPesca->id)?>"><?= $zonaPesca->nombre ?></a>
<p><strong>Descripcion</strong> <?= $competicion->descripcion ?> </p>

<h3>Imágenes Asociadas</h3>
<div class="image-gallery">
    <?php if (!empty($imagenes)): ?>
        <?php foreach ($imagenes as $imagen): ?>
            <div class="image-item">
                <img src="<?= base_url('../uploads/competiciones/' . $imagen->imagen) ?>" alt="Imagen de <?= $competicion->nombre ?>" style="width: 100px; height: auto;">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay imágenes asociadas a esta especie.</p>
    <?php endif; ?>
</div>
<a href="<?= site_url('/user/participantes/'.$competicion->id) ?>">Ver la lista de participantes</a>
<br>
<a href="<?= site_url('/user/capturas') ?>">Volver a la lista de capturas</a>

<?= $this->endSection() ?>