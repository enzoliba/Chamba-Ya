<?php
    require_once __DIR__ . '/../../core/config/session.php';
    iniciarSesion();

    if(!isset($_SESSION['idUsuario'])){
        header('Location: ../auth/login.php');
        exit();
    }

    require_once __DIR__ . '/../../models/NotificacionModel.php';
    $nm = new NotificacionModel();
    // Se traen antes de marcarlas, para resaltar las que estaban sin leer.
    $notificaciones = $nm->obtenerDeUsuario($_SESSION['idUsuario']);
    $nm->marcarTodasLeidas($_SESSION['idUsuario']);

    require_once __DIR__ . '/../../assets/css/style.php';
    require_once __DIR__ . '/../../assets/css/styles.php';
    require_once __DIR__ . '/../../assets/css/style_profile.php';
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
    require_once __DIR__ . '/../../assets/css/styles_anuncios.php'
?>

<div class="profile-page">

    <section class="profile-hero">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>index.php">Inicio</a> &nbsp;/&nbsp; Mi Perfil
        </div>
        <h1>Notificaciones</h1>
        <p>Avisos sobre tus postulaciones, calificaciones y actividad.</p>
    </section>

    <div class="profile-layout">

        <?php $paginaActual = 'notificaciones'; require_once __DIR__ . '/../templates/profile_sidebar.php'; ?>

        <main class="profile-content">
            <section class="vista-seccion activo" style="display:block;">
                <div class="encabezado-seccion"><h2>Mis Notificaciones</h2></div>
                <div id="lista-notificaciones">
                    <?php if (empty($notificaciones)): ?>
                        <p>No tienes notificaciones por ahora.</p>
                    <?php else: ?>
                        <?php foreach ($notificaciones as $n): ?>
                            <div class="tarjeta-horizontal"<?= $n['leida'] ? '' : ' style="border-left:4px solid var(--purpura-principal);"' ?>>
                                <div class="imagen-tarjeta"><i class="fa-regular fa-bell" style="color: var(--purpura-principal);"></i></div>
                                <div class="cuerpo-tarjeta">
                                    <?php if (!empty($n['link'])): ?>
                                        <h3 style="margin:0;"><a href="<?= BASE_URL . htmlspecialchars($n['link']) ?>" style="text-decoration:none;color:inherit;"><?= htmlspecialchars($n['mensaje']) ?></a></h3>
                                    <?php else: ?>
                                        <h3 style="margin:0;"><?= htmlspecialchars($n['mensaje']) ?></h3>
                                    <?php endif; ?>
                                    <p style="font-size:.8rem;color:#94a3b8;margin-top:4px;"><?= date('d M Y H:i', strtotime($n['fecha'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</div>

</body>
</html>
