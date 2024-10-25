<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Información de la Captura</h2>

    <!-- Información básica de la captura -->
    <div class="row mb-4">
        <div class="col-md-6">
            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></p>
            <p><strong>Especie:</strong> <?= $captura->nombre ?></p>
            <p><strong>Tamaño:</strong> <?= $captura->tamano ?> cm</p>
            <p><strong>Peso:</strong> <?= $captura->peso ?> kg</p>
            <p><strong>Lugar de Captura:</strong> <a href="/user/zonasPesca/<?= $zona->id ?>"> <?= $zona->nombre ?> </a> <?= ' (' . $localidad->nombre . ', ' . $localidad->PROVINCIA . ')' ?></p>
            <p><strong>Autor:</strong> <a href="/user/perfil/<?= $autor->id ?>"><?= $autor->username ?></a></p>
        </div>
        <div class="col-md-6">
            <p><strong>Descripción:</strong> <?= $captura->descripcion ?></p>
        </div>
    </div>

    <!-- Botón para mostrar la información de la especie -->
    <?php if ($especie != null) : ?>
        <button id="verEspecieBtn" class="btn btn-info mb-4">Ver especie</button>

        <!-- Contenido oculto de la especie -->
        <div id="infoEspecie" style="display: none;">
            <h4 class="mt-4">Información de la Especie</h4>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nombre Común:</strong> <?= $especie->nombre_comun ?></p>
                    <p><strong>Nombre Científico:</strong> <?= $especie->nombre_cientifico ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Talla Mínima:</strong> <?= $especie->tamano_minimo ?> cm</p>
                    <p><strong>Cupo Máximo:</strong> <?= $especie->cupo_maximo ?></p>

                </div>

            </div>

            <!-- Imágenes de la especie -->
            <h5 class="mt-4">Imágenes de la Especie</h5>
            <?php if (!empty($imagenes_especie)): ?>
                <div id="carouselEspecie" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($imagenes_especie as $index => $imagenEspecie): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= base_url('../uploads/especies/' . $imagenEspecie->imagen) ?>" class="d-block w-50 mx-auto" alt="Imagen de <?= $especie->nombre_comun ?>">
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
        </div>
    <?php else : ?>
        <h4>No se han encontrado detalles de la especie</h4>
    <?php endif ?>

<!-- Sección de imágenes de la captura -->
<h5 class="mt-4 text-center">Imágenes de la Captura</h5>
<?php if (!empty($imagenes)): ?>
    <div id="carouselCaptura" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($imagenes as $index => $imagen): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <img src="<?= base_url('../uploads/capturas/' . $imagen->imagen) ?>" class="d-block mx-auto" alt="Imagen de <?= htmlspecialchars($captura->nombre) ?>" style="width: 60%; max-height: 300px; object-fit: cover;">
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


    <!-- Botón para regresar -->
    <div class="mt-4">
        <a href="javascript:history.back()" class="btn btn-secondary">Volver</a>
    </div>
</div>

<!-- Script para controlar la visibilidad -->
<script>
    document.getElementById('verEspecieBtn').addEventListener('click', function() {
        var infoEspecie = document.getElementById('infoEspecie');
        if (infoEspecie.style.display === 'none') {
            infoEspecie.style.display = 'block';
            this.textContent = 'Ocultar especie';
        } else {
            infoEspecie.style.display = 'none';
            this.textContent = 'Ver especie';
        }
    });
</script>

<?= $this->endSection() ?>