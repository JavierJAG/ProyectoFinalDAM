<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Zonas de Pesca</h2>

    <div class="mb-3 text-end">
        <a href="/user/zonasPesca/new" class="btn btn-success">Crear Zona de Pesca</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Zona de Pesca</th>
                <th>Acciones</th>
                <th>Capturas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($zonasPesca as $zonaPesca) : ?>
                <tr>
                    <td><?= $zonaPesca->id ?></td>
                    <td><?= htmlspecialchars($zonaPesca->nombre) ?></td>
                    <td>
                        <a href="/user/zonasPesca/<?= $zonaPesca->id ?>" class="btn btn-info btn-sm">Detalles</a>
                        <a href="/user/zonasPesca/<?= $zonaPesca->id ?>/edit" class="btn btn-warning btn-sm">Editar</a>
                        <form action="/user/zonasPesca/<?= $zonaPesca->id ?>" method="post" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta zona de pesca?');">Eliminar</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#capturas-<?= $zonaPesca->id ?>" aria-expanded="false" aria-controls="capturas-<?= $zonaPesca->id ?>">
                            Ver Capturas
                        </button>
                        <div class="collapse" id="capturas-<?= $zonaPesca->id ?>">
                            <div class="card card-body mt-2">
                                <ul class="list-unstyled">
                                    <?php
                                    $hayCapturas = false; // Variable para controlar si hay capturas
                                    foreach ($capturas as $captura) :
                                        if ($captura->zona_id == $zonaPesca->id) :
                                            $hayCapturas = true; // Hay al menos una captura
                                    ?>
                                            <li class="mb-3">
                                                <a href="/user/capturas/<?= $captura->id ?>" class="text-decoration-none fw-bold"><?= htmlspecialchars($captura->nombre) ?></a>
                                                <div>
                                                    <small class="text-muted">Pescado el: <?= htmlspecialchars($captura->fecha_captura) ?></small><br>
                                                    <small class="text-muted">Tamaño: <?= htmlspecialchars($captura->tamano) ?> cm</small><br>
                                                    <small class="text-muted">Peso: <?= htmlspecialchars($captura->peso) ?> kg</small>
                                                </div>
                                            </li>
                                        <?php
                                        endif;
                                    endforeach;
                                    if (!$hayCapturas) : // Mensaje si no hay capturas
                                        ?>
                                        <li class="text-muted">No hay capturas registradas para esta zona.</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    <?= $pager->links() ?>
</div>
</div>

<?php $this->endSection() ?>