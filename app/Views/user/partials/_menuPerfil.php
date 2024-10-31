<!-- Menú Lateral -->
<div class="col-md-3">
    <div class="sticky-top" style="top: 20px;">
        <h3 class="text-primary mb-3">Navegación</h3>
        <ul class="list-group">
            <li class="list-group-item">
                <a href="<?= base_url("/user/perfil") ?>" class="text-decoration-none text-dark d-block p-3">Ver Perfil</a>
            </li>
            <li class="list-group-item">
                <a href="/user/perfil/misZonasPesca" class="text-decoration-none text-dark d-block p-3">Mis Zonas</a>
            </li>
            <li class="list-group-item">
                <a href="/user/perfil/misCapturas" class="text-decoration-none text-dark d-block p-3">Mis Capturas</a>
            </li>
            <li class="list-group-item">
                <a href="/user/perfil/misParticipaciones" class="text-decoration-none text-dark d-block p-3">Mis Participaciones</a>
            </li>
            <li class="list-group-item">
                <a href="/user/perfil/misLogros" class="text-decoration-none text-dark d-block p-3">Mis Logros</a>
            </li>
            <?php if (auth()->user()->inGroup('admin') || auth()->user()->inGroup('superadmin')) : ?>
                <li class="list-group-item">
                    <a href="/user/perfil/misCompeticiones" class="text-decoration-none text-dark d-block p-3">Mis Competiciones</a>
                </li>
            <?php endif ?>
            <?php if (auth()->user()->inGroup('superadmin')) : ?>
                <li class="list-group-item">
                    <a href="<?= base_url("/dashboard/administracion") ?>" class="text-decoration-none text-dark d-block p-3">Administrar</a>
                </li>
            <?php endif ?>
            <li class="list-group-item">
                <a href="/logout" class="text-danger text-decoration-none d-block p-3" onclick="return confirm('¿Estás seguro de que deseas salir?');">Salir</a>
            </li>
        </ul>
    </div>
</div>

<!-- Estilos CSS -->
<style>
    .list-group-item {
        cursor: pointer;
        /* Cambia el cursor a una mano cuando se pasa sobre el li */
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        /* Cambia el color de fondo al pasar el ratón */
    }

    .list-group-item a {
        display: block;
        /* Hace que el enlace ocupe todo el espacio del li */
        height: 100%;
        /* Asegura que el enlace cubra toda la altura del li */
    }
</style>