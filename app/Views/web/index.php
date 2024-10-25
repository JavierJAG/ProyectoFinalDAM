<?php auth()->loggedIn()? $this->extend("/user/layout/template") : $this->extend("/web/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/web/partials/_mensaje') ?>
<?= view('/web/partials/_error') ?>

<div class="container mt-5">
    <!-- Título principal -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Bienvenido a PescadoresDaRia</h1>
        <p class="text-muted fs-5">Descubre todas las herramientas para mejorar tu experiencia de pesca.</p>
    </div>

    <!-- Opciones en tarjetas -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        <!-- Opción 1: Registrar Capturas -->
        <div class="col">
            <div class="card h-100 shadow border-0 text-center">
                <div class="card-body">
                    <h2 class="card-title text-dark fw-semibold">Registrar Capturas</h2>
                    <p class="card-text text-muted">Documenta tus mejores capturas y mantén un registro de tus aventuras de pesca.</p>
                    <a href="<?= site_url('/user/capturas/new') ?>" class="btn btn-outline-primary">Registrar Captura</a>
                </div>
            </div>
        </div>

        <!-- Opción 2: Planificar Jornadas -->
        <div class="col">
            <div class="card h-100 shadow border-0 text-center">
                <div class="card-body">
                    <h2 class="card-title text-dark fw-semibold">Planificar Jornadas</h2>
                    <p class="card-text text-muted">Organiza tus jornadas de pesca en tus lugares favoritos.</p>
                    <a href="<?= site_url('/user/salidas') ?>" class="btn btn-outline-success">Planificar Jornada</a>
                </div>
            </div>
        </div>

        <!-- Opción 3: Ver Competiciones -->
        <div class="col">
            <div class="card h-100 shadow border-0 text-center">
                <div class="card-body">
                    <h2 class="card-title text-dark fw-semibold">Ver Competiciones</h2>
                    <p class="card-text text-muted">Participa en competiciones de pesca y demuestra tus habilidades en el agua.</p>
                    <a href="<?= site_url('/user/buscarCompeticiones') ?>" class="btn btn-outline-secondary">Ver Competiciones</a> <!-- Cambiado a btn-outline-secondary -->
                </div>
            </div>
        </div>
    </div>

    <!-- Opción extra: Normativa de Pesca -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <div class="card h-100 shadow border-0 text-center">
                <div class="card-body">
                    <h2 class="card-title text-dark fw-semibold">Normativa de Pesca</h2>
                    <p class="card-text text-muted">Infórmate sobre las normativas y regulaciones de pesca para disfrutar de manera responsable.</p>
                    <a href="<?= site_url('/user/normativa') ?>" class="btn btn-outline-info">Ver Normativa</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
