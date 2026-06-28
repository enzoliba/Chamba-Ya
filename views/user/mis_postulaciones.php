<?php
    require_once __DIR__ . '/../../core/config/session.php';
    iniciarSesion();
    
    if(!isset($_SESSION['idUsuario'])){
        header('Location: ../auth/login.php');
        exit();
    }
    
    require_once __DIR__ . '/../../controllers/Con_Postulacion.php';
    $conPostulacion = new Con_Postulacion();
    $mis_postulaciones = $conPostulacion->obtenerPostulaciones();

    require_once __DIR__ . '/../../assets/css/style.php';
    require_once __DIR__ . '/../../assets/css/styles.php';
    require_once __DIR__ . '/../../assets/css/style_profile.php';
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/estilos_Anuncios.css">

<div class="profile-page">

    <!-- Hero -->
    <section class="profile-hero">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>index.php">Inicio</a> &nbsp;/&nbsp; Mi Perfil
        </div>
        <h1>Mis Postulaciones</h1>
        <p>Revisa el estado de los trabajos a los que has aplicado.</p>
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
                        <li><a href="<?= BASE_URL ?>views/user/mis_guardados.php"><i class="fa-regular fa-bookmark"></i> Anuncios guardados</a></li>
                        <li><a href="<?= BASE_URL ?>views/user/mis_anuncios.php"><i class="fa-regular fa-square-plus"></i> Anuncios creados</a></li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h4>Actividad</h4>
                    <ul class="sidebar-nav">
                        <li><a href="<?= BASE_URL ?>views/user/mis_postulaciones.php" class="active"><i class="fa-solid fa-paper-plane"></i> Mis Postulaciones</a></li>
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
            <!-- SECCIÓN: MIS POSTULACIONES -->
            <section id="seccion-postulaciones" class="vista-seccion activo" style="display: block;">
                <div class="encabezado-seccion"><h2>Mis Postulaciones</h2></div>
                <div id="lista-postulaciones">
                    <?php if (empty($mis_postulaciones)): ?>
                            <p>No tienes postulaciones activas.</p>
                    <?php else: ?>
                        <?php foreach ($mis_postulaciones as $postulacion): ?>
                            <div class="tarjeta-horizontal">
                                <div class="imagen-tarjeta"><i class="fas fa-briefcase"></i></div>
                                <div class="cuerpo-tarjeta">
                                    <h3><?php echo htmlspecialchars($postulacion['puesto']); ?></h3>
                                    <p>Postulado el <?php echo date('d M Y', strtotime($postulacion['fecha'])); ?></p>
                                    <span class="etiqueta-estado estado-<?php echo $postulacion['estado']; ?>">
                                        <?php echo ucfirst($postulacion['estado']); ?>
                                    </span>
                                </div>
                                <div class="acciones-tarjeta">
                                    <button class="boton-accion" onclick="alert('Abriendo chat...')"><i class="fas fa-comment"></i> Chat</button>
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
