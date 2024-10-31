<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <div class="d-flex mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
    </div>
    
    <h1 class="text-center mb-4">Participantes</h1>

    <?php if (!empty($participantes)) : ?>
        <div class="list-group shadow-sm">
            <?php foreach ($participantes as $p) : ?>
                <div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-center p-3">
                    <span class="fw-bold"><?= esc($p->username) ?></span>

                    <div class="d-flex align-items-center mt-2 mt-md-0">
                        <?php if ($p->autor_id == auth()->user()->id) : ?>
                            <!-- Otorgar Logro -->
                            <form action="<?= base_url("/user/participantes/otorgarLogro/" . $competicion_id . "/" . $p->id) ?>" method="POST" class="d-flex align-items-center">
                                <select name="logro" class="form-select form-select-sm me-2" required>
                                    <option value="">Seleccionar premio</option>
                                    <?php foreach ($logros as $l) : ?>
                                        <option value="<?= $l->id ?>" 
                                            <?= in_array($l->id, array_column($usuariosLogros, 'logro_id', 'usuario_id')) && $usuariosLogros[$p->id] == $l->id ? 'selected' : '' ?>>
                                            <?= esc($l->nombre) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-award-fill"></i> Conceder premio</button>
                            </form>
                            
                            <!-- Eliminar Logro -->
                            <?php foreach ($usuariosLogros as $usuarioLogro) : ?>
                                <?php if ($usuarioLogro->usuario_id == $p->id) : ?>
                                    <form action="<?= base_url("/user/participantes/eliminarLogro/" . $competicion_id . "/" . $p->id . "/" . $usuarioLogro->logro_id) ?>" method="POST" class="ms-2">
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Quitar "<?= esc($usuarioLogro->nombre) ?>"</button>
                                    </form>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Añadir Participación -->
                        <?php if ($p->id == auth()->user()->id) : ?>
                            <?php if ($mensajeParticipacion) : ?>
                                <div class="alert alert-info ms-2" role="alert"><?= $mensajeParticipacion ?></div>
                            <?php else : ?>
                                <a href="/user/competiciones/anhadirParticipacion/<?= $competicion_id ?>" class="btn btn-primary btn-sm ms-2">
                                    <i class="bi bi-plus-circle"></i> Añadir Participación
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <!-- Ver Participaciones -->
                        <a href="<?= base_url("user/participantes/" . $competicion_id . "/" . $p->id) ?>" class="btn btn-outline-primary btn-sm ms-2">
                            <i class="bi bi-list-task"></i> Ver Participaciones
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            No hay participantes registrados para esta competición.
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>
