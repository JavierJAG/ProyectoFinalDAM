<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">

    <!-- Encabezado de la captura y opciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Información de la Captura</h2>
        <?php if (auth()->user()->id == $autor->id) : ?>
            <a href="/user/capturas/<?= $captura->id ?>/edit" class="btn btn-outline-success btn-sm" title="Editar">
                <i class="bi bi-pencil"></i> Editar captura
            </a>
        <?php endif ?>
    </div>

    <!-- Tarjeta de información de captura -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-center text-secondary mb-4">Detalles de la Captura</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></p>
                    <p><strong>Especie:</strong> <?= esc($captura->nombre) ?></p>
                    <p><strong>Tamaño:</strong> <?= esc($captura->tamano) ?> cm</p>
                    <p><strong>Peso:</strong> <?= esc($captura->peso) ?> kg</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Lugar de Captura:</strong> <a href="/user/zonasPesca/<?= esc($zona->id) ?>"><?= esc($zona->nombre) ?></a> (<?= esc($localidad->nombre) ?>, <?= esc($localidad->PROVINCIA) ?>)</p>
                    <p><strong>Autor:</strong> <a href="/user/perfil/<?= esc($autor->id) ?>"><?= esc($autor->username) ?></a></p>
                    <p><strong>Descripción:</strong> <?= $captura->descripcion ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de imágenes de la captura -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title text-center text-secondary">Imágenes de la Captura</h5>
            <?php if (!empty($imagenes)) : ?>
                <div id="carouselCaptura" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($imagenes as $index => $imagen) : ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= base_url('../uploads/capturas/' . esc($imagen->imagen)) ?>" class="d-block mx-auto rounded" alt="Imagen de <?= esc($captura->nombre) ?>" style="max-height: 250px;">
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
            <?php else : ?>
                <p class="text-center mt-3">No hay imágenes asociadas a esta captura.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Información de la especie -->
    <?php if ($especie != null) : ?>
        <div class="text-center mb-3">
            <button id="verEspecieBtn" class="btn btn-info">Ver información de la Especie</button>
        </div>
        
        <div id="infoEspecie" class="card shadow-sm mb-4" style="display: none;">
            <div class="card-body">
                <h5 class="card-title text-center text-secondary mb-4">Información de la Especie</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre Común:</strong> <?= esc($especie->nombre_comun) ?></p>
                        <p><strong>Nombre Científico:</strong> <?= esc($especie->nombre_cientifico) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Talla Mínima:</strong> <?= esc($especie->tamano_minimo) ?> cm</p>
                        <p><strong>Cupo Máximo:</strong> <?= esc($especie->cupo_maximo) ?></p>
                    </div>
                </div>
                
                <?php if (!empty($imagenes_especie)) : ?>
                    <h5 class="card-title text-start text-secondary">Imágenes de la Especie:</h5>
                    <div id="carouselEspecie" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($imagenes_especie as $index => $imagenEspecie) : ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img src="<?= base_url('../uploads/especies/' . esc($imagenEspecie->imagen)) ?>" class="d-block mx-auto rounded" alt="Imagen de <?= esc($especie->nombre_comun) ?>" style="max-height: 250px;">
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
                <?php else : ?>
                    <p class="text-center mt-3">No hay imágenes asociadas a esta especie.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else : ?>
        <h4 class="text-danger text-center">No se han encontrado detalles de esta especie</h4>
    <?php endif; ?>

    <!-- Botón para regresar -->
    <div class="text-center my-4">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">Volver</a>
    </div>
</div>

<!-- Script para controlar la visibilidad de la información de la especie -->
<script>
    document.getElementById('verEspecieBtn').addEventListener('click', function() {
        var infoEspecie = document.getElementById('infoEspecie');
        if (infoEspecie.style.display === 'none') {
            infoEspecie.style.display = 'block';
            this.textContent = 'Ocultar información de la Especie';
        } else {
            infoEspecie.style.display = 'none';
            this.textContent = 'Ver información de la Especie';
        }
    });
</script>

<?= $this->endSection() ?>
