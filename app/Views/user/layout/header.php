<header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand" href="/web">PescadoresDaRia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/web">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/buscarCapturas">Capturas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/salidas">Planificar Salida</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/normativa">Normativa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/buscarCompeticiones">Competiciones</a>
                </li>

            </ul>


            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-light" placeholder="Buscar usuario..." aria-label="Search">
            </form>


            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Mi Perfil
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= base_url("/user/perfil") ?>">Ver Perfil</a></li>
                    <?php if (auth()->user()->inGroup('superadmin')) : ?>
                        <li><a class="dropdown-item" href="<?= base_url("/dashboard/administracion") ?>">Administrar</a></li>
                    <?php endif ?>
                    <li><a class="dropdown-item" href="/logout">Salir</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>