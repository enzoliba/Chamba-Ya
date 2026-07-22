<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';
require_once __DIR__ . '/../core/config/email.php';

class NotificacionModel {
    private $conn;

    public function __construct() {
        $Database = new Database();
        $this->conn = $Database->getConnection();
    }

    public function crear($idUsuario, $mensaje, $link = null): bool {
        try {
            $stmt = $this->conn->prepare("INSERT INTO notificacion (idUsuario, mensaje, link) VALUES (?, ?, ?)");
            return $stmt->execute([$idUsuario, $mensaje, $link]);
        } catch (Exception $e) {
            error_log("Error al crear notificacion: " . $e->getMessage());
            return false;
        }
    }

    // Crea la notificación in-app y, si el usuario acepta avisos, intenta enviar email.
    public function notificar($idUsuario, $mensaje, $link, $asuntoEmail): void {
        $this->crear($idUsuario, $mensaje, $link);
        try {
            $stmt = $this->conn->prepare("SELECT correo, notif_ofertas FROM usuario WHERE idUsuario = ?");
            $stmt->execute([$idUsuario]);
            $u = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($u && (int) ($u['notif_ofertas'] ?? 0) === 1 && !empty($u['correo'])) {
                enviarEmailNotificacion($u['correo'], $asuntoEmail, $mensaje);
            }
        } catch (Exception $e) {
            error_log("Error al notificar por email: " . $e->getMessage());
        }
    }

    public function obtenerDeUsuario($idUsuario, $limite = 30) {
        try {
            $limite = (int) $limite;
            $stmt = $this->conn->prepare("SELECT idNotificacion, mensaje, link, leida, fecha FROM notificacion WHERE idUsuario = ? ORDER BY fecha DESC LIMIT $limite");
            $stmt->execute([$idUsuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar notificaciones: " . $e->getMessage());
            return [];
        }
    }

    public function contarNoLeidas($idUsuario): int {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM notificacion WHERE idUsuario = ? AND leida = 0");
            $stmt->execute([$idUsuario]);
            return (int) $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al contar notificaciones: " . $e->getMessage());
            return 0;
        }
    }

    public function marcarTodasLeidas($idUsuario): bool {
        try {
            $stmt = $this->conn->prepare("UPDATE notificacion SET leida = 1 WHERE idUsuario = ? AND leida = 0");
            return $stmt->execute([$idUsuario]);
        } catch (Exception $e) {
            error_log("Error al marcar notificaciones: " . $e->getMessage());
            return false;
        }
    }
}
?>
