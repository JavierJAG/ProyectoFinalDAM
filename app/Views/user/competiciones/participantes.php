<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-left">
        <a href="javascript:history.back()" class="btn btn-secondary mx-2">Volver</a>
    </div>
    <h1 class="text-center mb-4">Participantes</h1>

    <div class="list-group">
        <?php foreach ($participantes as $p) : ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= esc($p->username) ?></span>

                <?php if ($p->autor_id == auth()->user()->id) : ?>
                    <!-- Formulario para otorgar logros -->
                    <form action="<?= base_url("/user/participantes/otorgarLogro/" . $competicion_id . "/" . $p->id) ?>" method="POST" class="d-flex align-items-center">
                        <select name="logro" id="logro" class="form-select form-select-sm me-2" required>
                            <option value="">Seleccionar premio</option>
                            <?php foreach ($logros as $l) : ?>
                                <option value="<?= $l->id ?>"
                                    <?php
                                    // Marcar como seleccionado si el usuario ya tiene el logro
                                    foreach ($usuariosLogros as $usuarioLogro) {
                                        if ($p->id == $usuarioLogro->usuario_id && $l->id == $usuarioLogro->logro_id) {
                                            echo 'selected';
                                            break;
                                        }
                                    }
                                    ?>><?= esc($l->nombre) ?></option>
                            <?php endforeach ?>
                        </select>
                        <button type="submit" class="btn btn-success btn-sm">Conceder premio</button>
                    </form>

                    <!-- Formularios para eliminar logros -->
                    <?php foreach ($logros as $l) : ?>
                        <?php foreach ($usuariosLogros as $usuarioLogro) : ?>
                            <?php if ($p->id == $usuarioLogro->usuario_id && $l->id == $usuarioLogro->logro_id) : ?>
                                <form action="<?= base_url("/user/participantes/eliminarLogro/" . $competicion_id . "/" . $p->id . "/" . $l->id) ?>" method="POST" class="d-inline ms-2">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar Premio "<?= esc($l->nombre) ?>"</button>
                                </form>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                <?php endif ?>


                <?php if ($p->id == auth()->user()->id) : ?>
                    <?php if ($mensajeParticipacion): ?>
                        <div class="alert alert-info" role="alert">
                            <?= $mensajeParticipacion ?>
                        </div>
                    <?php else: ?>
                        <a href="/user/competiciones/anhadirParticipacion/<?= $competicion_id ?>" class="btn btn-primary me-2">Añadir Participación</a>
                    <?php endif ?>
                <?php endif ?>

                <!-- Botón para ver participaciones -->
                <a href="<?= base_url("user/participantes/" . $competicion_id . "/" . $p->id) ?>" class="btn btn-outline-primary btn-sm ms-2">Ver Participaciones</a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Mensaje si no hay participantes -->
    <?php if (empty($participantes)) : ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            No hay participantes registrados para esta competición.
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>