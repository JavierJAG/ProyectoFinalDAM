<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>

        <!-- Contenido del Perfil -->
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">Panel de Administración</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="/dashboard/usuarios" class="list-group-item list-group-item-action">
                                    Administrar Usuarios
                                </a>
                                <a href="/dashboard/especies" class="list-group-item list-group-item-action">
                                    Gestionar Especies
                                </a>
                                <a href="/dashboard/localidades" class="list-group-item list-group-item-action">
                                    Gestionar Localidades
                                </a>
                                <a href="/dashboard/logros" class="list-group-item list-group-item-action">
                                    Gestionar Logros
                                </a>
                                <!-- <a href="/user/zonasPesca" class="list-group-item list-group-item-action">
                                    Gestionar Zonas de Pesca
                                </a>
                                <a href="/user/capturas" class="list-group-item list-group-item-action">
                                    Gestionar Capturas
                                </a> -->
                                <a href="/user/competiciones" class="list-group-item list-group-item-action">
                                    Gestionar Competiciones
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>