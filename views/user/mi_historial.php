<?php
    require_once __DIR__ . '/../../core/config/session.php';
    iniciarSesion();
    
    if(!isset($_SESSION['idUsuario'])){
        header('Location: ../auth/login.php');
        exit();
    }
    
    require_once __DIR__ . '/../../controllers/HistorialController.php';
    $conHistorial = new HistorialController();
    $historial_postulaciones = $conHistorial->obtenerHistorial();

    require_once __DIR__ . '/../../assets/css/style.php';
    require_once __DIR__ . '/../../assets/css/styles.php';
    require_once __DIR__ . '/../../assets/css/style_profile.php';
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
    require_once __DIR__ . '/../../assets/css/styles_anuncios.php'
?>

<div class="profile-page">

    <!-- Hero -->
    <section class="profile-hero">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>index.php">Inicio</a> &nbsp;/&nbsp; Mi Perfil
        </div>
        <h1>Historial de Postulaciones</h1>
        <p>Revisa tus postulaciones antiguas.</p>
    </section>

    <!-- Layout -->
    <div class="profile-layout">

        <!-- Sidebar -->
        <?php $paginaActual = 'historial'; require_once __DIR__ . '/../templates/profile_sidebar.php'; ?>

        <!-- Content -->
        <main class="profile-content">
            <!-- SECCIÓN: HISTORIAL -->
            <section id="seccion-historial" class="vista-seccion activo" style="display: block;">
                <div class="encabezado-seccion"><h2>Historial de Postulaciones</h2></div>
                <p style="margin-bottom: 20px; color: var(--texto-secundario); font-size: 0.9rem;">
                    Aquí se muestran las postulaciones aceptadas y rechazadas con más de 3 meses de antigüedad.
                </p>
                <div id="lista-historial">
                    <?php if (empty($historial_postulaciones)): ?>
                        <p>No tienes postulaciones antiguas en tu historial (más de 3 meses de antigüedad).</p>
                    <?php else: ?>
                        <?php foreach ($historial_postulaciones as $postulacion): ?>
                            <div class="tarjeta-horizontal">
                                <div class="imagen-tarjeta"><i class="fas fa-history" style="color: var(--texto-secundario);"></i></div>
                                <div class="cuerpo-tarjeta">
                                    <h3><?php echo htmlspecialchars($postulacion['puesto']); ?></h3>
                                    <p>Postulado el <?php echo date('d M Y', strtotime($postulacion['fecha'])); ?></p>
                                    <span class="etiqueta-estado estado-<?php echo strtolower($postulacion['estado']); ?>">
                                        <?php echo ucfirst($postulacion['estado']); ?>
                                    </span>
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
