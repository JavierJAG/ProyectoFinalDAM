<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Información de la Captura</h2>

    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></p>
    <p><strong>Especie:</strong> <?= $captura->nombre ?></p>
    <p><strong>Tamaño:</strong> <?= $captura->tamano ?> cm</p>
    <p><strong>Peso:</strong> <?= $captura->peso ?> kg</p>
    <p><strong>Descripción:</strong> <?= $captura->descripcion ?></p>

    <?php if ($especie != null) : ?>
        <h4 class="mt-4">Información de la Especie</h4>
        <p><strong>Nombre Común:</strong> <?= $especie->nombre_comun ?></p>
        <p><strong>Nombre Científico:</strong> <?= $especie->nombre_cientifico ?></p>
        <p><strong>Talla Mínima:</strong> <?= $especie->tamano_minimo ?> cm</p>
        <p><strong>Cupo Máximo:</strong> <?= $especie->cupo_maximo ?></p>

        <h3 class="mt-4">Imágenes de la Especie</h3>
        <?php if (!empty($imagenes_especie)): ?>
            <div id="carouselEspecie" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($imagenes_especie as $index => $imagenEspecie): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= base_url('../uploads/especies/' . $imagenEspecie->imagen) ?>" class="d-block w-100" alt="Imagen de <?= $especie->nombre_comun ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselEspecie" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselEspecie" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        <?php else: ?>
            <p>No hay imágenes asociadas a esta especie.</p>
        <?php endif; ?>
    <?php else : ?>
        <h4>No se han encontrado detalles de la especie</h4>
    <?php endif ?>

    <h3 class="mt-4">Imágenes de la Captura</h3>
    <?php if (!empty($imagenes)): ?>
        <div id="carouselCaptura" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($imagenes as $index => $imagen): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= base_url('../uploads/capturas/' . $imagen->imagen) ?>" class="d-block w-100" alt="Imagen de <?= $captura->nombre ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaptura" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselCaptura" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    <?php else: ?>
        <p>No hay imágenes asociadas a esta captura.</p>
    <?php endif; ?>

    <div class="mt-4">
        <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
    </div>
</div>

<?= $this->endSection() ?>
