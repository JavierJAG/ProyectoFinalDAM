<header class="bg-light shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light container py-3">
        <!-- Logo y Nombre del Sitio -->
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
            <img src="<?= base_url("faviconv2.ico")?>" alt="Logo" width="40" height="40" class="me-2"> <!-- Logo opcional -->
            <span style="font-size: 1.5rem;">Pescadores<span class="text-success">DaRia</span></span>
        </a>

        <!-- Botón de menú móvil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Enlaces de Navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Aquí puedes agregar más enlaces de navegación -->
            </ul>
            <!-- Perfil de Usuario o Acceso -->
            <div class="user-profile">
                <a class="nav-link text-primary fw-semibold" href="<?= site_url('/login') ?>">Acceder</a>
            </div>
        </div>
    </nav>
</header>
