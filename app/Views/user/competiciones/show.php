<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Información de la Competición</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Nombre:</strong> <?= esc($competicion->nombre) ?></p>
            <p><strong>Fecha de inicio:</strong> <?= esc($competicion->fecha_inicio) ?></p>
            <p><strong>Fecha de fin:</strong> <?= esc($competicion->fecha_fin) ?></p>
            <p><strong>Lugar:</strong> <a href="<?= base_url("user/zonasPesca/" . $zonaPesca->id) ?>" class="link-primary"><?= esc($zonaPesca->nombre) ?></a></p>
            <p><strong>Descripción:</strong> <?= esc($competicion->descripcion) ?></p>
        </div>
    </div>

    <h3 class="text-center">Imágenes Asociadas</h3>
    <div class="image-gallery d-flex flex-wrap justify-content-center">
        <?php if (!empty($imagenes)): ?>
            <?php foreach ($imagenes as $imagen): ?>
                <div class="image-item mx-2">
                    <img src="<?= base_url('../uploads/competiciones/' . esc($imagen->imagen)) ?>" alt="Imagen de <?= esc($competicion->nombre) ?>" class="img-thumbnail" style="width: 100px; height: auto;">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay imágenes asociadas a esta competición.</p>
        <?php endif; ?>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a href="<?= site_url('/user/participantes/' . $competicion->id) ?>" class="btn btn-info mx-2">Ver la lista de participantes</a>
        <a href="javascript:history.back()" class="btn btn-secondary mx-2">Volver</a>
    </div>
</div>

<?= $this->endSection() ?>
