<?php
    require_once __DIR__ . '/../../core/config/session.php';
    iniciarSesion();
    
    if(!isset($_SESSION['idUsuario'])){
        header('Location: ../auth/login.php');
        exit();
    }
    
    require_once __DIR__ . '/../../controllers/Con_AnuncioGuardado.php';
    $conGuardado = new Con_AnuncioGuardado();
    $anuncios_favoritos = $conGuardado->obtenerAnunciosFavoritos();

    require_once __DIR__ . '/../../assets/css/style.php';
    require_once __DIR__ . '/../../assets/css/styles.php';
    require_once __DIR__ . '/../../assets/css/style_profile.php';
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
    require_once __DIR__ . '/../../assets/css/styles_anuncios.php'
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<div class="profile-page">

    <!-- Hero -->
    <section class="profile-hero">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>index.php">Inicio</a> &nbsp;/&nbsp; Mi Perfil
        </div>
        <h1>Anuncios Guardados</h1>
        <p>Tus ofertas y servicios favoritos.</p>
    </section>

    <!-- Layout -->
    <div class="profile-layout">

        <!-- Sidebar -->
        <aside class="profile-sidebar">
            <div class="profile-sidebar-card">
                <div class="sidebar-section">
                    <h4>Ajustes</h4>
                    <ul class="sidebar-nav">
                        <li><a href="<?= BASE_URL ?>controllers/AuthController.php?action=showMisDatos"><i class="fa-solid fa-user"></i> Mis Datos</a></li>
                        <li><a href="<?= BASE_URL ?>views/user/mis_guardados.php" class="active"><i class="fa-regular fa-bookmark"></i> Anuncios guardados</a></li>
                        <li><a href="<?= BASE_URL ?>views/user/mis_anuncios.php"><i class="fa-regular fa-square-plus"></i> Anuncios creados</a></li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h4>Actividad</h4>
                    <ul class="sidebar-nav">
                        <li><a href="<?= BASE_URL ?>views/user/mis_postulaciones.php"><i class="fa-solid fa-paper-plane"></i> Mis Postulaciones</a></li>
                        <li><a href="<?= BASE_URL ?>views/user/mi_historial.php"><i class="fa-solid fa-history"></i> Historial</a></li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h4>Seguridad</h4>
                    <ul class="sidebar-nav">
                        <li><a href="<?= BASE_URL ?>controllers/AuthController.php?action=showSeguridad"><i class="fa-solid fa-shield-halved"></i> Seguridad</a></li>
                        <li><a href="<?= BASE_URL ?>controllers/AuthController.php?action=showPreferencias"><i class="fa-solid fa-sliders"></i> Preferencias</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <main class="profile-content">
            <!-- SECCIÓN: GUARDADOS -->
            <section id="seccion-guardados" class="vista-seccion activo" style="display: block;">
                <div class="encabezado-seccion"><h2>Anuncios Guardados</h2></div>
                <div id="lista-anuncios-guardados">
                    <?php if (empty($anuncios_favoritos)): ?>
                        <p>Actualmente no tienes anuncios guardados</p>
                    <?php else: ?>
                        <?php foreach ($anuncios_favoritos as $fav): ?>
                            <div class="tarjeta-horizontal">
                                <div class="imagen-tarjeta"><i class="fas fa-bookmark fa-2x" style="color: var(--purpura-principal);"></i></div>
                                <div class="cuerpo-tarjeta">
                                    <h3><?php echo htmlspecialchars($fav['titulo']); ?></h3>
                                    <p><?php echo htmlspecialchars($fav['descripcion']); ?></p>
                                    <span class="etiqueta-estado estado-<?php echo str_replace(' ', '', $fav['estado']); ?>">
                                        <?php echo ucfirst($fav['estado']); ?>
                                    </span>
                                    <?php if (!empty($fav['categorias_nombres'])): ?>
                                        <div style="margin-top: 8px; display: flex; gap: 5px; flex-wrap: wrap;">
                                            <?php foreach (explode(',', $fav['categorias_nombres']) as $cat_nom): ?>
                                                <span class="etiqueta-estado estado-info" style="font-size: 0.7rem; padding: 2px 8px;">
                                                    <?php echo htmlspecialchars($cat_nom); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</div>

<script src="<?= BASE_URL ?>assets/js/script_Anuncios.js?v=<?php echo time(); ?>"></script>

</body>
</html>
