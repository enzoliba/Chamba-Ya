<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';

class TrabajadorFavoritoModel {
    private $conn;

    public function __construct() {
        $Database = new Database();
        $this->conn = $Database->getConnection();
    }

    public function usuarioExiste($id): bool {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM usuario WHERE idUsuario = ?");
            $stmt->execute([$id]);
            return (bool) $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al verificar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function esFavorito($idCliente, $idTrabajador): bool {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM trabajadoresfavoritos WHERE idUsuarioCliente = ? AND idUsuarioTrabajador = ?");
            $stmt->execute([$idCliente, $idTrabajador]);
            return (bool) $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al verificar trabajador favorito: " . $e->getMessage());
            return false;
        }
    }

    public function agregar($idCliente, $idTrabajador): bool {
        try {
            $stmt = $this->conn->prepare("INSERT INTO trabajadoresfavoritos (idUsuarioCliente, idUsuarioTrabajador) VALUES (?, ?)");
            return $stmt->execute([$idCliente, $idTrabajador]);
        } catch (Exception $e) {
            error_log("Error al agregar trabajador favorito: " . $e->getMessage());
            return false;
        }
    }

    public function quitar($idCliente, $idTrabajador): bool {
        try {
            $stmt = $this->conn->prepare("DELETE FROM trabajadoresfavoritos WHERE idUsuarioCliente = ? AND idUsuarioTrabajador = ?");
            return $stmt->execute([$idCliente, $idTrabajador]);
        } catch (Exception $e) {
            error_log("Error al quitar trabajador favorito: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerFavoritos($idCliente) {
        try {
            $stmt = $this->conn->prepare("
                SELECT t.idUsuarioTrabajador, u.nombres, u.apellidos, u.fotoPerfil, u.telefono, u.descripcionPerfil,
                       ROUND(AVG(c.puntaje), 1) AS promedio
                FROM trabajadoresfavoritos t
                JOIN usuario u ON t.idUsuarioTrabajador = u.idUsuario
                LEFT JOIN calificacion c ON c.idUsuarioCalificado = u.idUsuario
                WHERE t.idUsuarioCliente = ?
                GROUP BY t.idUsuarioTrabajador
                ORDER BY t.fechaGuardado DESC
            ");
            $stmt->execute([$idCliente]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar trabajadores favoritos: " . $e->getMessage());
            return [];
        }
    }
}
?>
