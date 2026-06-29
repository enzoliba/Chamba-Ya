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
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
?>

<div style="max-width:720px;margin:30px auto;padding:0 20px;">
    <h1 style="margin-bottom:6px;">Notificaciones</h1>
    <p style="color:#64748b;margin-bottom:20px;">Avisos sobre tus postulaciones, calificaciones y actividad.</p>

    <?php if (empty($notificaciones)): ?>
        <p>No tienes notificaciones por ahora.</p>
    <?php else: ?>
        <div style="display:flex;flex-direction:column;gap:10px;">
            <?php foreach ($notificaciones as $n): ?>
                <div style="border:1px solid #e2e8f0;border-left:4px solid <?= $n['leida'] ? '#cbd5e1' : '#7c3aed' ?>;border-radius:10px;padding:14px 16px;background:<?= $n['leida'] ? '#fff' : '#faf5ff' ?>;">
                    <?php if (!empty($n['link'])): ?>
                        <a href="<?= BASE_URL . htmlspecialchars($n['link']) ?>" style="text-decoration:none;color:#1e293b;font-weight:600;">
                            <?= htmlspecialchars($n['mensaje']) ?>
                        </a>
                    <?php else: ?>
                        <span style="font-weight:600;color:#1e293b;"><?= htmlspecialchars($n['mensaje']) ?></span>
                    <?php endif; ?>
                    <div style="font-size:.8rem;color:#94a3b8;margin-top:4px;"><?= date('d M Y H:i', strtotime($n['fecha'])) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
