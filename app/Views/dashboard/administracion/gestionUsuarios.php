<?= $this->extend('/user/layout/template') ?>

<?= $this->section('body') ?>

<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Gestionar Usuarios</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($usuarios as $u) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= htmlspecialchars($u->username) ?></span>

                                <div class="form-check">
                                    <input type="checkbox" name="permiso[]" id="permiso-<?= $u->id ?>"
                                        class="form-check-input" <?= in_array('admin', $u->getGroups()) ? 'checked' : '' ?>
                                        onchange="toggleAdmin(<?= $u->id ?>, this.checked)">
                                    <label class="form-check-label" for="permiso-<?= $u->id ?>">Admin</label>
                                </div>

                                <a href="/user/perfil/<?= $u->id ?>" class="btn btn-sm btn-info">Ver Datos</a>
                                <form action="/dashboard/usuario/eliminar/<?= $u->id ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </li>
                        <?php endforeach ?>
                    </ul>


                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAdmin(userId, isChecked) {
        // Añadir userId a la URL
        const url = isChecked ? `/dashboard/usuario/addAdmin/${userId}` : `/dashboard/usuario/removeAdmin/${userId}`;

        const formData = new FormData();
        formData.append('userId', userId); // Aunque lo incluimos en la URL, aún se puede enviar como form-data si es necesario

        fetch(url, {
                method: 'POST',
                body: formData // Enviamos el objeto FormData como cuerpo de la solicitud
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Usuario ${isChecked ? 'añadido a' : 'eliminado de'} grupo admin.`);
                } else {
                    alert('Hubo un error al actualizar los permisos.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error en la conexión.');
            });
    }
</script>




<?= $this->endSection() ?>