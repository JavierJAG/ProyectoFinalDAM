<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>
        <div class="col-md-9">
   
            <h1 class="text-center mb-4">Participaciones</h1>

            <div class="list-group">
                <?php foreach ($participaciones as $p) : ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Fecha de Inicio:</strong> <?= esc($p->fecha_inicio) ?><br>
                            <strong>Evento: </strong><a href="/user/competiciones/<?= $p->competicion_id ?>"> <?= esc($p->nombre) ?></a>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <?php if ($p->id == auth()->user()->id) : ?>
                                <?php
                                    $fechaInicio = new DateTime($p->fecha_inicio);
                                    $fechaFin = new DateTime($p->fecha_fin);
                                ?>
                                <?php if ($fecha_actual < $fechaInicio) : ?>
                                    <div class="alert alert-info p-1 m-2" role="alert">
                                        El envío de capturas se abre el <?= $fechaInicio->format('d/m/Y') ?>.
                                    </div>
                                <?php elseif ($fecha_actual > $fechaFin) : ?>
                                    <div class="alert alert-warning p-1 m-2" role="alert">
                                        El periodo de envío se ha cerrado el <?= $fechaFin->format('d/m/Y') ?>.
                                    </div>
                                <?php else : ?>
                                    <a href="/user/competiciones/anhadirParticipacion/<?= $p->competicion_id ?>" class="btn btn-primary btn-sm me-2"> <i class="bi bi-plus-circle mx-1"></i> Añadir Captura</a>
                                <?php endif ?>
                            <?php endif ?>

                            <a href="<?= base_url("user/participantes/" . $p->competicion_id . "/" . auth()->user()->id) ?>" class="btn btn-outline-primary btn-sm">  <i class="bi bi-list-task mx-1"></i>Capturas</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($participaciones)) : ?>
                <div class="alert alert-warning text-center mt-4" role="alert">
                    Aún no has participado en ninguna competición.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
