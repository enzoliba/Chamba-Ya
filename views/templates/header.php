<?php require_once __DIR__ . '/../../assets/css/style_header.php'; ?>
<?php require_once __DIR__ . '/../../core/config/config.php'; ?>
<?php
    $notifNoLeidas = 0;
    if (isset($_SESSION['idUsuario'])) {
        require_once __DIR__ . '/../../models/NotificacionModel.php';
        $notifNoLeidas = (new NotificacionModel())->contarNoLeidas($_SESSION['idUsuario']);
    }
?>

<header>
    <div class="main-header">

        <img src="<?= BASE_URL; ?>assets/img/logo-chamba-ya.png" 
            alt="logo_chambaYa" 
            class="logo_web" 
            width="200px">

        <button class="menu-toggle" aria-label="Abrir menú">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </button>

        <nav class="main-nav">
            <ul class="nav-links">
                <li><a href="<?= BASE_URL; ?>index.php">Inicio</a></li>
                <li><a href="<?= BASE_URL; ?>index.php?action=buscar-trabajo&tipo=trabajo">Ofertas de Trabajo</a></li>
                <li><a href="<?= BASE_URL; ?>index.php?action=buscar-trabajo&tipo=servicio">Ofertas de Servicio</a></li>
            </ul>

            <div class="actions">

            <form class="search_box" method="GET" action="<?= BASE_URL ?>index.php" role="search">
                <input type="hidden" name="action" value="buscar-trabajo">
                <input type="hidden" name="tipo" value="trabajo">
                <input type="text" name="search" placeholder="Buscar..."
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" aria-label="Buscar"
                    style="position:absolute; right:15px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; padding:0; color:#000;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <div class="user_box">

                <?php if(isset($_SESSION['idUsuario'])): ?>

                    <!-- Campana de notificaciones -->
                    <a href="<?= BASE_URL ?>views/user/notificaciones.php"
                       style="position:relative;display:inline-flex;align-items:center;margin-right:14px;font-size:22px;color:#000;text-decoration:none;">
                        <i class="fa-regular fa-bell"></i>
                        <?php if ($notifNoLeidas > 0): ?>
                            <span style="position:absolute;top:-7px;right:-9px;background:#dc2626;color:#fff;font-size:11px;font-weight:700;min-width:17px;height:17px;border-radius:9px;display:flex;align-items:center;justify-content:center;padding:0 4px;"><?= $notifNoLeidas > 9 ? '9+' : $notifNoLeidas ?></span>
                        <?php endif; ?>
                    </a>

                    <!-- Usuario logueado -->
                    <button id="userBtn">
                        <i class="fa-regular fa-user"></i>
                    </button>

                    <div class="user_menu" id="userMenu">
                        <p>
                            Bienvenido
                            <?= htmlspecialchars($_SESSION['nombres']); ?>
                        </p>

                        <a href="<?= BASE_URL ?>controllers/AuthController.php?action=showMisDatos">Mis datos</a>
                        <a href="<?= BASE_URL ?>views/user/mis_postulaciones.php">Mis postulaciones</a>
                        <a href="<?= BASE_URL ?>views/user/postulaciones_recibidas.php">Postulaciones recibidas</a>
                        <a href="<?= BASE_URL ?>views/user/mis_guardados.php">Anuncios guardados</a>
                        <a href="<?= BASE_URL ?>views/user/trabajadores_favoritos.php">Trabajadores guardados</a>
                        <a href="<?= BASE_URL ?>views/user/mis_anuncios.php">Anuncios creados</a>
                        <a href="<?= BASE_URL; ?>views/auth/logout.php">Cerrar sesión</a>
                    </div>

                <?php else: ?>

                    <!-- Usuario NO logueado -->
                    <button id="userBtn">
                        <i class="fa-regular fa-user"></i>
                    </button>

                    <div class="user_menu" id="userMenu">
                        <a href="<?= BASE_URL; ?>views/auth/login.php">
                            Iniciar Sesión
                        </a>

                        <a href="<?= BASE_URL; ?>views/auth/login.php">
                            Registrarse
                        </a>
                    </div>

                <?php endif; ?>

                </div>
            </div>
        </nav>

        
    </div>
</header>

<script src="<?= BASE_URL; ?>assets/js/functions_header.js"></script>