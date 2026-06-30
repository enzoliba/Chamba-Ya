<?php
// Sidebar del perfil (reutilizable).
// Definir $paginaActual antes de incluirlo para resaltar el ítem correspondiente.
$paginaActual = $paginaActual ?? '';
if (!function_exists('navActiva')) {
    function navActiva($clave, $actual) {
        return $clave === $actual ? 'class="active"' : '';
    }
}
?>
<aside class="profile-sidebar">
    <div class="profile-sidebar-card">
        <div class="sidebar-section">
            <h4>Ajustes</h4>
            <ul class="sidebar-nav">
                <li><a <?= navActiva('mis_datos', $paginaActual) ?> href="<?= BASE_URL ?>controllers/AuthController.php?action=showMisDatos"><i class="fa-solid fa-user"></i> Mis Datos</a></li>
                <li><a <?= navActiva('guardados', $paginaActual) ?> href="<?= BASE_URL ?>views/user/mis_guardados.php"><i class="fa-regular fa-bookmark"></i> Anuncios guardados</a></li>
                <li><a <?= navActiva('trabajadores', $paginaActual) ?> href="<?= BASE_URL ?>views/user/trabajadores_favoritos.php"><i class="fa-regular fa-heart"></i> Trabajadores guardados</a></li>
                <li><a <?= navActiva('anuncios', $paginaActual) ?> href="<?= BASE_URL ?>views/user/mis_anuncios.php"><i class="fa-regular fa-square-plus"></i> Anuncios creados</a></li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h4>Actividad</h4>
            <ul class="sidebar-nav">
                <li><a <?= navActiva('postulaciones', $paginaActual) ?> href="<?= BASE_URL ?>views/user/mis_postulaciones.php"><i class="fa-solid fa-paper-plane"></i> Mis Postulaciones</a></li>
                <li><a <?= navActiva('recibidas', $paginaActual) ?> href="<?= BASE_URL ?>views/user/postulaciones_recibidas.php"><i class="fa-solid fa-inbox"></i> Postulaciones recibidas</a></li>
                <li><a <?= navActiva('notificaciones', $paginaActual) ?> href="<?= BASE_URL ?>views/user/notificaciones.php"><i class="fa-regular fa-bell"></i> Notificaciones</a></li>
                <li><a <?= navActiva('historial', $paginaActual) ?> href="<?= BASE_URL ?>views/user/mi_historial.php"><i class="fa-solid fa-history"></i> Historial</a></li>
            </ul>
        </div>
        <div class="sidebar-section">
            <h4>Seguridad</h4>
            <ul class="sidebar-nav">
                <li><a <?= navActiva('seguridad', $paginaActual) ?> href="<?= BASE_URL ?>controllers/AuthController.php?action=showSeguridad"><i class="fa-solid fa-shield-halved"></i> Seguridad</a></li>
                <li><a <?= navActiva('preferencias', $paginaActual) ?> href="<?= BASE_URL ?>controllers/AuthController.php?action=showPreferencias"><i class="fa-solid fa-sliders"></i> Preferencias</a></li>
            </ul>
        </div>
    </div>
</aside>
