<?php $this->extend("/user/layout/template") ?>
<?php $this->section('body') ?>
<?= view('/user/partials/_mensaje') ?>
<?= view('/user/partials/_error') ?>

<div class="container mt-5">
    <div class="row">
        <?= view('/user/partials/_menuPerfil') ?>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Cambiar Contraseña</h4>
                </div>
                <div class="card-body">
                    <form action="/user/change-password" method="post">
                        <div class="form-group">
                            <label for="current_password">Contraseña actual</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Introduce tu contraseña actual" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nueva contraseña</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Introduce tu nueva contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirma tu nueva contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-1">Cambiar contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection() ?>
