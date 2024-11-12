<?= $this->extend("/user/layout/template") ?>
<?= $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="col d-flex justify-content-start mb-3">
        <a href="javascript:history.back()" class="btn btn-secondary"> <i class="bi bi-arrow-left"></i> Volver</a>
    </div>
    <h2 class="text-primary mb-4">Nueva Especie</h2>

    <!-- Formulario de creación de especie -->
    <form action="<?= site_url('/dashboard/especies') ?>" method="post" enctype="multipart/form-data" class="bg-light p-4 shadow-sm rounded">
        <!-- Campo: Nombre Común -->
        <div class="mb-3">
            <label for="nombre_comun" class="form-label">Nombre Común</label>
            <input type="text" id="nombre_comun" name="nombre_comun" value="<?= old('nombre_comun') ?>" class="form-control" required>
        </div>

        <!-- Campo: Nombre Científico -->
        <div class="mb-3">
            <label for="nombre_cientifico" class="form-label">Nombre Científico</label>
            <input type="text" id="nombre_cientifico" name="nombre_cientifico" value="<?= old('nombre_cientifico') ?>" class="form-control">
        </div>

        <!-- Campo: Talla Mínima (cm) -->
        <div class="mb-3">
            <label for="talla_minima" class="form-label">Talla Mínima (cm)</label>
            <input type="number" id="talla_minima" name="talla_minima" value="<?= old('talla_minima') ?>" step="0.1" class="form-control">
        </div>

        <!-- Campo: Cupo Máximo -->
        <div class="mb-3">
            <label for="cupo_maximo" class="form-label">Cupo Máximo</label>
            <input type="number" id="cupo_maximo" name="cupo_maximo" value="<?= old('cupo_maximo') ?>" class="form-control">
        </div>

        <!-- Campo: Imágenes de la Especie -->
        <div class="mb-3">
            <label for="imagenes" class="form-label">Imágenes de la Especie</label>
            <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple accept="image/*" onchange="previewImages()">
        </div>

        <!-- Contenedor de previsualización de imágenes -->
        <div id="imagePreview" class="mb-3"></div>

        <!-- Botón de Crear -->
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>

<!-- Script para previsualización y eliminación de imágenes -->
<script>
    function previewImages() {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // Limpia el contenedor de previsualización

        const files = document.getElementById('imagenes').files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'image-item';
                div.style.position = 'relative';
                div.style.display = 'inline-block';
                div.style.margin = '10px';

                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.width = '100px'; // Ajusta el tamaño de la imagen
                img.style.height = 'auto';

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'Eliminar';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '0';
                removeBtn.style.right = '0';
                removeBtn.className = 'btn btn-danger btn-sm'; // Estilo Bootstrap para el botón de eliminar
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    preview.removeChild(div); // Elimina la imagen del contenedor de previsualización
                    const input = document.getElementById('imagenes');
                    const dataTransfer = new DataTransfer(); // Crea un objeto DataTransfer para manejar los archivos
                    for (let j = 0; j < input.files.length; j++) {
                        if (j !== i) { // Mantiene todos los archivos excepto el que fue eliminado
                            dataTransfer.items.add(input.files[j]);
                        }
                    }
                    input.files = dataTransfer.files; // Actualiza la lista de archivos del input
                };

                div.appendChild(img);
                div.appendChild(removeBtn);
                preview.appendChild(div);
            };

            reader.readAsDataURL(file);
        }
    }
</script>

<?= $this->endSection() ?>