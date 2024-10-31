<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold">Zonas de Pesca</h2>
                <div>
                    <a href="/user/zonasPesca/new" class="btn btn-success me-2">
                        <i class="bi bi-plus-circle"></i> Crear Zona de Pesca
                    </a>
                    <a href="javascript:history.back()" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th class="col-md-3">Zona de Pesca</th>
                        <th class="col-md-5">Lista de Especies Capturadas</th>
                        <th class="col-md-2">Capturas Totales</th>
                        <th class="col-md-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($zonasPesca as $zonaPesca) : ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($zonaPesca->nombre) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($zonaPesca->descripcion) ?></small>
                            </td>
                            <td>
                                <?php
                                $capturasTotales = 0;
                                $tieneCapturas = false;

                                foreach ($capturas as $captura) {
                                    if ($captura->zona_id == $zonaPesca->id) {
                                        $capturasTotales++;
                                        $tieneCapturas = true;
                                    }
                                }

                                if (!$tieneCapturas) : ?>
                                    <span class="text-muted">No se han registrado capturas en esta zona</span>
                                <?php else : ?>
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#capturas-<?= $zonaPesca->id ?>" aria-expanded="false">
                                        <i class="bi bi-chevron-down"></i> Ver Capturas
                                    </button>
                                    <div class="collapse mt-2" id="capturas-<?= $zonaPesca->id ?>">
                                        <div class="card card-body bg-light border">
                                            <ul class="list-unstyled">
                                                <?php foreach ($capturas as $captura) :
                                                    if ($captura->zona_id == $zonaPesca->id) : ?>
                                                        <li class="mb-2">
                                                            <a href="/user/capturas/<?= $captura->id ?>" class="fw-bold text-decoration-none"><?= htmlspecialchars($captura->nombre) ?></a><br>
                                                            <small class="text-muted">Fecha: <?= date('d/m/Y H:i', strtotime($captura->fecha_captura)) ?></small><br>
                                                            <small class="text-muted">Tamaño: <?= htmlspecialchars($captura->tamano) ?> cm</small><br>
                                                            <small class="text-muted">Peso: <?= htmlspecialchars($captura->peso) ?> kg</small>
                                                        </li>
                                                <?php endif; endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center fw-bold"><?= $capturasTotales; ?></td>
                            <td class="text-center">
                                <a href="/user/zonasPesca/<?= $zonaPesca->id ?>/edit" class="btn btn-warning btn-sm me-1" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/user/zonasPesca/<?= $zonaPesca->id ?>" method="post" class="d-inline" style="display:inline;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar esta zona de pesca?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
