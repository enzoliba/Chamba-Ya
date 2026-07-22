<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';
class HistorialModel {
    private $conn;

    public function __construct() {
        $Database = new Database();
        $this->conn = $Database->getConnection();
    }

    public function obtenerHistorialPostulaciones($idUsuario) {
        try {
            $stmt = $this->conn->prepare("
                SELECT p.idPostulacion, p.estado, p.fecha, a.titulo AS puesto
                FROM postulacion p
                JOIN anuncio a ON p.idAnuncio = a.idAnuncio
                WHERE p.idUsuario = ?
                  AND p.estado IN ('Aceptado', 'Rechazado')
                  AND p.fecha < DATE_SUB(NOW(), INTERVAL 3 MONTH)
                ORDER BY p.fecha DESC
            ");
            $stmt->execute([$idUsuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar historial: " . $e->getMessage());
            return [];
        }
    }
}
?>
