<?php $this->extend("/dashboard/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/dashboard/partials/_mensaje') ?>
<?= view('/dashboard/partials/_error') ?>


<form action="<?= site_url('/dashboard/especies') ?>" method="post" enctype="multipart/form-data">
   
    <label for="nombre_comun">Nombre Común</label>
    <input type="text" id="nombre_comun" name="nombre_comun" value="<?= old('nombre_comun') ?>" required>

    <label for="nombre_cientifico">Nombre Científico</label>
    <input type="text" id="nombre_cientifico" name="nombre_cientifico" value="<?= old('nombre_cientifico') ?>">

    <label for="talla_minima">Talla Mínima (cm)</label>
    <input type="number" id="talla_minima" name="talla_minima" value="<?= old('talla_minima') ?>" step="0.1">

    <label for="cupo_maximo">Cupo Máximo</label>
    <input type="number" id="cupo_maximo" name="cupo_maximo" value="<?= old('cupo_maximo') ?>">

    <label for="imagenes">Imágenes de la Especie</label>
    <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" onchange="previewImages()">

    <div id="imagePreview"></div>

    <button type="submit">Crear</button>
</form>
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

<?php $this->endSection() ?>