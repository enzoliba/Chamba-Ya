<?php
require_once __DIR__ . '/../models/NotificacionModel.php';
require_once __DIR__ . '/../core/config/session.php';

class NotificacionController {
    public function marcarLeidas(): void {
        $idUsuario = obtenerIdUsuarioActivo();
        $ok = (new NotificacionModel())->marcarTodasLeidas($idUsuario);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok]);
    }
}

// Pide estar logueado y método POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    iniciarSesion();
    if (!isset($_SESSION['idUsuario'])) {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false]);
        exit();
    }
    (new NotificacionController())->marcarLeidas();
}
?>
