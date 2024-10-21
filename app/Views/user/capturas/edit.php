<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>


<form action="<?= site_url('/user/capturas/'.$captura->id) ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PATCH">

    <label for="fecha_captura">Fecha de Captura</label>
    <input type="datetime-local" name="fecha_captura" id="fecha_captura" value="<?= old('fecha_captura',$captura->fecha_captura) ?>" required>

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre_especie" value="<?= old('nombre',$captura->nombre) ?>" placeholder="Nombre de la especie capturada" required>

    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion" placeholder="Descripción de la captura"><?= old('descripcion',$captura->descripcion) ?></textarea>

    <label for="tamano">Tamaño (cm)</label>
    <input type="number" step="0.01" name="tamano" id="tamano" value="<?= old('tamano',$captura->tamano) ?>" placeholder="Tamaño en cm" required>

    <label for="peso">Peso (g)</label>
    <input type="number" name="peso" id="peso" value="<?= old('peso',$captura->peso) ?>" placeholder="Peso en g" required>

    <label for="imagenes">Imágenes de la Captura</label>
    <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" onchange="previewImages()">

    <?php if (!empty($imagenes)): ?>
    <h3>Imágenes Actuales:</h3>
    <ul>
        <?php foreach ($imagenes as $imagen): ?>
            <li>
                <img src="<?= base_url('uploads/capturas/' . $imagen->imagen) ?>" alt="Imagen de <?= esc($captura->nombre) ?>" width="100">
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

    <div id="imagePreview"></div>

    <button type="submit">Actualizar</button>
</form>










<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
    $(document).ready(function() {
        // Implementación del autocompletado usando jQuery UI
        $('#nombre_especie').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '<?= site_url("/user/capturas/get_especies") ?>', // URL que maneja la petición
                    dataType: 'json',
                    data: {
                        term: request.term // Lo que el usuario escribe
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nombre, // Lo que se muestra en la lista
                                value: item.nombre // El valor que se rellena en el campo de texto
                            };
                        }));
                    },
                    error: function() {
                        console.log('Error al obtener los nombres de las especies');
                    }
                });
            },
            minLength: 2, // Número mínimo de caracteres antes de que se haga la petición
            select: function(event, ui) {
                $('#nombre_especie').val(ui.item.value); // Cuando el usuario selecciona un valor
            }
        });
    });
</script>

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