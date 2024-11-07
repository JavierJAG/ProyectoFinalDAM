<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
    <?= view('/user/partials/_menuPerfil') ?>

        <!-- Contenido del Perfil -->
        <div class="col-md-9">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary">Perfil</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    
                    <!-- Datos del usuario -->
                    <div class="mb-3">
                        <strong>Usuario:</strong> <?= esc(auth()->user()->username) ?>
                    </div>
                    <div class="mb-3">
                        <strong>Nombre real:</strong> <?= (auth()->user()->nombre!=null)?auth()->user()->nombre : "<small><em>Aún no has indicado tu nombre</em></small>" ?>
                    </div>
                    <div class="mb-3">
                        <strong>Correo electrónico:</strong> <?= esc(auth()->user()->email) ?>
                    </div>
                  

                    <!-- Botón para habilitar la edición -->
                    <div class="text-end mb-3">
                        <button id="editButton" class="btn btn-outline-primary">
                            <i class="bi bi-pencil"></i> Editar Perfil
                        </button>
                    </div>

                    <!-- Formulario de edición (oculto inicialmente) -->
                    <div id="editForm" style="display: none;">
                        <form action="/user/updateProfile" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nuevo nombre</label>
                                <input type="text" name="name" class="form-control" value="<?= esc(auth()->user()->nombre) ?>" >
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>

                    <!-- Opción para cambiar la contraseña -->
                    <div class="mt-4">
                        <a href="/user/change-password" class="btn btn-secondary">Cambiar Contraseña</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const editButton = document.getElementById('editButton');
        const editForm = document.getElementById('editForm');

        editButton.addEventListener('click', function(e) {
            e.preventDefault();
            editForm.style.display = 'block';  // Muestra el formulario de edición
            editButton.style.display = 'none'; // Oculta el botón de edición
        });
    });
</script>

<?php $this->endSection() ?>
