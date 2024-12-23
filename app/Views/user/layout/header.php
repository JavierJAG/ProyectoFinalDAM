<header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light container">
    <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="/web">
            <img src="<?= base_url("faviconv2.ico")?>" alt="Logo" width="40" height="40" class="me-2"> <!-- Logo opcional -->
            <span style="font-size: 1.5rem;">Pescadores<span class="text-success">DaRia</span></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?= base_url("/user/perfil") ?>">Mi perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/buscarCapturas">Capturas globales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/salidas">Planificar Salida</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/user/buscarCompeticiones">Competiciones</a>
                </li>
                <!-- Menú desplegable para Normativa -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="normativaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Normativa
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="normativaDropdown">
                        <li><a class="dropdown-item" href="/user/normativa">Zonas</a></li>
                        <li><a class="dropdown-item" href="/user/especies">Especies</a></li>
                    </ul>
                </li>

            </ul>

            <form action="/user/buscar" method="GET" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" name="buscar" class="form-control form-control-light" placeholder="Buscar usuario..." aria-label="Search">
            </form>

            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= auth()->user()->username ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= base_url("/user/perfil") ?>">Ver Perfil</a></li>

                    <li><a class="dropdown-item" href="/user/perfil/misZonasPesca">Mis Zonas</a></li>
                    <li><a class="dropdown-item" href="/user/perfil/misCapturas">Mis Capturas</a></li>
                    <li><a class="dropdown-item" href="/user/perfil/misParticipaciones">Mis Participaciones</a></li>
                    <li><a class="dropdown-item" href="/user/perfil/misLogros">Mis Logros</a></li>
                    <?php if (auth()->user()->inGroup('admin') || auth()->user()->inGroup('superadmin')) : ?>
                        <li><a class="dropdown-item" href="/user/perfil/misCompeticiones">Mis Competiciones</a></li>
                    <?php endif ?>
                    <?php if (auth()->user()->inGroup('superadmin')) : ?>
                        <li><a class="dropdown-item" href="<?= base_url("/dashboard/administracion") ?>">Administrar</a></li>
                    <?php endif ?>
                    <li><a class="dropdown-item" href="/logout">Salir</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>