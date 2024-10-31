<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <?php if (auth()->user()->id == $autor->id) : ?>
        <a href="/user/capturas/<?= $captura->id ?>/edit" class="btn btn-success btn-sm me-1" title="Editar">
            <i class="bi bi-pencil"></i> Editar captura
        </a>
    <?php endif ?>
    <h2 class="text-center mb-4 text-primary">Información de la Captura</h2>

    <!-- Información básica de la captura en una card -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Detalles de la Captura</h5>
            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></p>
            <p><strong>Especie:</strong> <?= esc($captura->nombre) ?></p>
            <p><strong>Tamaño:</strong> <?= esc($captura->tamano) ?> cm</p>
            <p><strong>Peso:</strong> <?= esc($captura->peso) ?> kg</p>
            <p><strong>Lugar de Captura:</strong>
                <a href="/user/zonasPesca/<?= esc($zona->id) ?>"><?= esc($zona->nombre) ?></a>
                (<?= esc($localidad->nombre) ?>, <?= esc($localidad->PROVINCIA) ?>)
            </p>
            <p><strong>Autor:</strong>
                <a href="/user/perfil/<?= esc($autor->id) ?>"><?= esc($autor->username) ?></a>
            </p>
            <p><strong>Descripción:</strong> <?= $captura->descripcion ?></p>
        </div>

        <!-- Sección de imágenes de la captura -->
        <div class="card-body">
            <h3 class="card-title text-center">Imágenes de la Captura</h3>
            <?php if (!empty($imagenes)): ?>
                <div id="carouselCaptura" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($imagenes as $index => $imagen): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= base_url('../uploads/capturas/' . esc($imagen->imagen)) ?>" class="d-block mx-auto" alt="Imagen de <?= esc($captura->nombre) ?>" style="width: 60%; max-height: 300px; object-fit: cover;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaptura" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselCaptura" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            <?php else: ?>
                <p class="text-center mt-3">No hay imágenes asociadas a esta captura.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Botón para mostrar la información de la especie -->
    <?php if ($especie != null) : ?>
        <button id="verEspecieBtn" class="btn btn-info mb-4" aria-expanded="false">Ver información de la Especie</button>

        <!-- Contenido oculto de la especie en una card -->
        <div id="infoEspecie" style="display: none;">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Información de la Especie</h5>
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

                    <!-- Imágenes de la especie -->
                    <h6 class="mt-3">Imágenes de la Especie: </h6>
                    <?php if (!empty($imagenes_especie)): ?>
                        <div id="carouselEspecie" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($imagenes_especie as $index => $imagenEspecie): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="<?= base_url('../uploads/especies/' . esc($imagenEspecie->imagen)) ?>" class="d-block w-90 mx-auto" alt="Imagen de <?= esc($especie->nombre_comun) ?>" style="max-height: 300px; object-fit: cover;">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselEspecie" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselEspecie" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    <?php else: ?>
                        <p>No hay imágenes asociadas a esta especie.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <h4 class="text-danger">No se han encontrado detalles de esta especie</h4>
    <?php endif ?>

    <!-- Botón para regresar -->
    <div class="mt-4 text-center">
        <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
    </div>
</div>

<!-- Script para controlar la visibilidad -->
<script>
    document.getElementById('verEspecieBtn').addEventListener('click', function() {
        var infoEspecie = document.getElementById('infoEspecie');
        if (infoEspecie.style.display === 'none') {
            infoEspecie.style.display = 'block';
            this.textContent = 'Ocultar información de la Especie';
            this.setAttribute('aria-expanded', 'true');
        } else {
            infoEspecie.style.display = 'none';
            this.textContent = 'Ver información de la Especie';
            this.setAttribute('aria-expanded', 'false');
        }
    });
</script>

<?= $this->endSection() ?>