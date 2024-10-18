
<?= $this->extend('/dashboard/layout/template') ?>

<?= $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>
<form action="<?= site_url('/dashboard/especies/' . $especie->id) ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PATCH">

    <label for="nombre_comun">Nombre Común</label>
    <input type="text" id="nombre_comun" name="nombre_comun" value="<?= old('nombre_comun', $especie->nombre_comun) ?>" required>

    <label for="nombre_cientifico">Nombre Científico</label>
    <input type="text" id="nombre_cientifico" name="nombre_cientifico" value="<?= old('nombre_cientifico', $especie->nombre_cientifico) ?>">

    <label for="tamano_minimo">Talla Mínima (cm)</label>
    <input type="number" id="tamano_minimo" name="tamano_minimo" value="<?= old('tamano_minimo', $especie->tamano_minimo) ?>" step="0.1">

    <label for="cupo_maximo">Cupo Máximo</label>
    <input type="number" id="cupo_maximo" name="cupo_maximo" value="<?= old('cupo_maximo', $especie->cupo_maximo) ?>">

    <label for="imagenes">Imágenes de la Especie</label>
    <input type="file" id="imagenes" name="imagenes[]" multiple>

    <button type="submit">Actualizar</button>
</form>

<?php if (!empty($imagenes)): ?>
    <h3>Imágenes Actuales:</h3>
    <ul>
        <?php foreach ($imagenes as $imagen): ?>
            <li>
                <img src="<?= base_url('uploads/especies/' . $imagen->imagen) ?>" alt="Imagen de <?= esc($especie->nombre_comun) ?>" width="100">
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php $this->endSection() ?>