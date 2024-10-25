<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <!-- Título principal -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">¡Hola, <?= auth()->user()->username ?>!</h1>
        <p class="text-muted fs-5">¿Qué quieres hacer hoy?</p>
    </div>

    <!-- Opciones de perfil en tarjetas -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
        <!-- Opción 1: Mis Zonas de Pesca -->
        <div class="col">
            <div class="card h-100 shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold text-dark">Mis Zonas de Pesca</h5>
                    <a href="/user/perfil/misZonasPesca" class="btn btn-outline-primary">VER</a>
                </div>
            </div>
        </div>

        <!-- Opción 2: Mis Capturas -->
        <div class="col">
            <div class="card h-100 shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold text-dark">Mis Capturas</h5>
                    <a href="/user/perfil/misCapturas" class="btn btn-outline-success">VER</a>
                </div>
            </div>
        </div>

        <!-- Opción 3: Mis Participaciones en campeonatos -->
        <div class="col">
            <div class="card h-100 shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold text-dark">Mis Participaciones</h5>
                    <a href="/user/perfil/misParticipaciones" class="btn btn-outline-warning">VER</a>
                </div>
            </div>
        </div>

        <!-- Opción 4: Mis Logros -->
        <div class="col">
            <div class="card h-100 shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold text-dark">Mis Logros</h5>
                    <a href="/user/perfil/misLogros" class="btn btn-outline-danger">VER</a>
                </div>
            </div>
        </div>
        <?php if (auth()->user()->inGroup('admin') || auth()->user()->inGroup('superadmin')) : ?>
        <!-- Opción 5: Mis Competiciones -->
        <div class="col">
            <div class="card h-100 shadow border-0">
                <div class="card-body text-center">
                    <h5 class="card-title fw-semibold text-dark">Mis Competiciones</h5>
                    <a href="/user/perfil/misCompeticiones" class="btn btn-outline-info">VER</a>
                </div>
            </div>
        </div>
        <?php endif ?>
    </div>
</div>

<?php $this->endSection() ?>
