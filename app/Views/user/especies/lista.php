<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4 text-center">Lista de Especies</h2>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="/user/especies" class="mb-4 d-flex justify-content-center">
        <div class="input-group" style="width: 400px;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Buscar por nombre" value="<?= esc($search ?? '') ?>">
            <button class="btn btn-primary btn-sm" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de especies -->
    <div class="table-responsive">
        <table class="table table-bordered bg-light shadow-sm text-center">
            <thead class="table-primary">
                <tr>
                    <th scope="col" style="width: 40px; text-align: center;"></th>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre Común</th>
                    <th scope="col">Nombre Científico</th>
                    <th scope="col">Talla mínima (cm)</th>
                    <th scope="col">Cupo máximo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($especies)) : ?>
                    <?php foreach ($especies as $especie) : ?>
                        <tr>
                            <td>
                                <a title="Detalles" href="/user/especies/<?= $especie->id ?>" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                            <td><?= esc($especie->id) ?></td>
                            <td><?= esc($especie->nombre_comun) ?></td>
                            <td><?= esc($especie->nombre_cientifico) ?></td>
                            <td><?= $especie->tamano_minimo != 0 ? esc($especie->tamano_minimo) . ' cm' : 'No se ha registrado' ?></td>
                            <td><?= $especie->cupo_maximo != 0 ? esc($especie->cupo_maximo) : 'No se ha registrado' ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted p-4">
                            <em>No se encontraron especies.</em>
                        </td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->endSection() ?>
