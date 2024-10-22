<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Participantes</h1>

    <div class="list-group">
        <?php foreach ($participantes as $p) : ?>
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= esc($p->username) ?></span>

                <form action="<?= base_url("/user/participantes/otorgarLogro/" . $competicion_id . "/" . $p->id) ?>" method="POST">
                    <select name="logro" id="logro">
                        <option value="">Seleccionar premio</option>
                        <?php foreach ($logros as $l) : ?>
                            <option value="<?= $l->id ?>"
                                <?php
                                foreach ($usuariosLogros as $usuarioLogro) {
                                    if ($p->id == $usuarioLogro->usuario_id && $l->id == $usuarioLogro->logro_id) {
                                        echo 'selected';
                                        break;
                                    }
                                }
                                ?>><?= $l->nombre ?></option>
                        <?php endforeach ?>
                    </select>
                    <button type="submit">Conceder premio</button>
                </form>
                <form action="<?= base_url("/user/participantes/eliminarLogro/" . $competicion_id . "/" . $p->id . "/" .$l->id)?>" method="post">
                    <button type="submit">Eliminar Premio</button>
                </form>
                <a href="<?= base_url("user/participantes/" . $competicion_id . "/" . $p->id) ?>" class="btn btn-outline-primary btn-sm">Ver Participaciones</a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (empty($participantes)): ?>
        <div class="alert alert-warning text-center mt-4" role="alert">
            No hay participantes registrados para esta competición.
        </div>
    <?php endif; ?>
</div>

<?php $this->endSection() ?>