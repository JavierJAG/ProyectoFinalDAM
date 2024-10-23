<?php auth()->loggedIn()? $this->extend("/user/layout/template") : $this->extend("/web/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/web/partials/_mensaje') ?>
<?= view('/web/partials/_error') ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Bienvenido a Tu Portal de Pesca</h1>
    <div class="row">
        <div class="col-md-4 mb-4 text-center">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Registrar Capturas</h2>
                    <p class="card-text">Documenta tus mejores capturas y mantén un registro de tus aventuras de pesca.</p>
                    <a href="<?= site_url('/user/capturas/new') ?>" class="btn btn-primary">Registrar Captura</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 text-center">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Planificar Jornadas</h2>
                    <p class="card-text">Organiza tus jornadas de pesca en tus lugares favoritos.</p>
                    <a href="<?= site_url('/user/salidas') ?>" class="btn btn-primary">Planificar Jornada</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 text-center">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Ver Competiciones</h2>
                    <p class="card-text">Participa en competiciones de pesca y demuestra tus habilidades en el agua.</p>
                    <a href="<?= site_url('/user/buscarCompeticiones') ?>" class="btn btn-primary">Ver Competiciones</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title">Normativa de Pesca</h2>
                    <p class="card-text">Infórmate sobre las normativas y regulaciones de pesca para disfrutar de manera responsable.</p>
                    <a href="<?= site_url('/user/normativa') ?>" class="btn btn-primary">Ver Normativa</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
