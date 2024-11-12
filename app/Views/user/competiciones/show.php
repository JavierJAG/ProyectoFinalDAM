<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Información de la Competición</h2>

    <!-- Información de la Competición -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3"><?= esc($competicion->nombre) ?></h4>
            <p><strong>Fecha de inicio:</strong> <?= esc(date('d/m/Y', strtotime($competicion->fecha_inicio))) ?></p>
            <p><strong>Fecha de fin:</strong> <?= esc(date('d/m/Y', strtotime($competicion->fecha_fin))) ?></p>
            <p><strong>Lugar:</strong>
                <a href="<?= base_url("user/zonasPesca/" . $zonaPesca->id) ?>" class="link-primary"><?= esc($zonaPesca->nombre) ?></a>
            </p>
            <p><strong>Organizador: </strong><a href="/user/perfil/<?= $competicion->usuario_id ?>"><?= $organizador->username ?></a></p>
            <p><strong>Descripción:</strong> <?= $competicion->descripcion ?></p>
        </div>
    </div>

    <!-- Lista de Logros -->
    <?php if (!empty($logros)) : ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-3 text-center">🏅 Lista de Premiados</h4>

                <div class="row">
                    <?php foreach ($logros as $logro) : ?>
                        <div class="col-md-6 mb-3">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-3">
                                        <!-- Icono para destacar el logro -->
                                        <span class="badge bg-success fs-5">
                                            <i class="fas fa-trophy"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1"><?= esc($logro->logro_nombre) ?></h5>
                                        <p class="mb-0 text-muted">
                                            <i class="fas fa-user"></i>
                                            <a href="/user/perfil/<?= esc($logro->user_id) ?>" class="link-primary">
                                                <?= esc($logro->user_username) ?>
                                            </a>
                                        </p>
                                        <small class="text-muted">Fecha de obtención: <?= date('d/m/Y', strtotime($logro->fecha_obtencion)) ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No hay premiados registrados para esta competición.</div>
    <?php endif; ?>


    <!-- Galería de Imágenes -->
    <h3 class="text-center mb-4">Imágenes Asociadas</h3>
    <div class="d-flex flex-wrap justify-content-center mb-4">
        <?php if (!empty($imagenes)): ?>
            <?php foreach ($imagenes as $imagen): ?>
                <div class="image-item mx-2 mb-3">
                    <img src="<?= base_url('../uploads/competiciones/' . esc($imagen->imagen)) ?>" alt="Imagen de <?= esc($competicion->nombre) ?>" class="img-thumbnail shadow-sm" style="width: 150px; height: auto;">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No hay imágenes asociadas a esta competición.</p>
        <?php endif; ?>
    </div>

    <!-- Botones de Acción o Mensaje de Finalización -->
    <div class="d-flex justify-content-center mt-4">

        <?php if ($competicionFinalizada) : ?>
            <!-- Contenedor con ancho completo para el alert y el botón -->
            <div class="w-100 d-flex justify-content-center align-items-center gap-3">
                <!-- Mostrar mensaje de evento finalizado -->
                <div class="alert alert-warning text-center w-auto" role="alert">
                    <strong>Esta competición ha finalizado.</strong>
                </div>
                <a href="<?= site_url('/user/participantes/' . $competicion->id) ?>" class="btn btn-info mx-2 mb-2">
                    <i class="fas fa-users"></i> Ver la lista de participantes
                </a>
                <!-- Botón de volver con el mismo ancho que el alert -->
                <a href="javascript:history.back()" class="btn btn-secondary mb-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>



        <?php else : ?>
            <!-- Mostrar botones de acción para participar o no participar -->
            <div class="d-flex justify-content-center flex-wrap">
                <?php if ($participa) : ?>
                    <form action="<?= site_url('/user/competiciones/eliminarParticipacionCompeticion/' . $competicion->id) ?>" method="post">
                        <button type="submit" class="btn btn-danger mx-2 mb-2">
                            <i class="fas fa-times-circle"></i> No participar
                        </button>
                    </form>
                <?php else : ?>
                    <form action="<?= site_url('/user/competiciones/participarCompeticion/' . $competicion->id) ?>" method="post">
                        <button type="submit" class="btn btn-success mx-2 mb-2">
                            <i class="fas fa-check-circle"></i> Participar
                        </button>
                    </form>
                <?php endif; ?>

                <a href="<?= site_url('/user/participantes/' . $competicion->id) ?>" class="btn btn-info mx-2 mb-2">
                    <i class="fas fa-users"></i> Ver la lista de participantes
                </a>

                <!-- Botón para volver -->
                <a href="javascript:history.back()" class="btn btn-secondary mx-2 mb-2">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        <?php endif; ?>
    </div>


</div>

<?= $this->endSection() ?>