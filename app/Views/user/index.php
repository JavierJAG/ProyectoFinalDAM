<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <!-- Título principal -->
    <div class="text-center">
        <h1 class="display-4">Hola, <?= auth()->user()->username ?>!</h1>
        <h4 class="text-muted mb-4">¿Qué quieres hacer?</h4>
    </div>

    <!-- Opciones de perfil en tarjetas -->
    <div class="row g-4">
        <!-- Opción 1:  Mis Zonas de Pesca -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"> Mis Zonas de Pesca</h5>
                    <a href="/user/perfil/misZonasPesca" class="btn btn-primary">VER</a>
                </div>
            </div>
        </div>

        <!-- Opción 2:  Mis Capturas -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"> Mis Capturas</h5>
                    <a href="/user/perfil/misCapturas" class="btn btn-success">VER</a>
                </div>
            </div>
        </div>

        <!-- Opción 3:  Mis Participaciones en campeonatos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"> Mis Participaciones</h5>
                    <a href="/user/perfil/misParticipaciones" class="btn btn-warning">VER</a>
                </div>
            </div>
        </div>

        <!-- Opción 4:  Mis Logros -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"> Mis Logros</h5>
                    <a href="/user/perfil/misLogros" class="btn btn-danger">VER</a>
                </div>
            </div>
        </div>

        <!-- Opción 5:  Mis Competiciones -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title"> Mis Competiciones</h5>
                    <a href="/user/perfil/misCompeticiones" class="btn btn-info">VER</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>