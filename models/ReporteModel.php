<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';

class ReporteModel {
    private $conn;

    public function __construct() {
        $Database = new Database();
        $this->conn = $Database->getConnection();
    }

    public function crear($idReporta, $idAnuncio, $idReportado, $motivo, $detalle): bool {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO reporte (idUsuarioReporta, idAnuncio, idUsuarioReportado, motivo, detalle)
                VALUES (?, ?, ?, ?, ?)
            ");
            return $stmt->execute([$idReporta, $idAnuncio ?: null, $idReportado ?: null, $motivo, $detalle]);
        } catch (Exception $e) {
            error_log("Error al crear reporte: " . $e->getMessage());
            return false;
        }
    }

    // Evita que el mismo usuario reporte el mismo anuncio varias veces.
    public function yaReporto($idReporta, $idAnuncio): bool {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM reporte WHERE idUsuarioReporta = ? AND idAnuncio = ?");
            $stmt->execute([$idReporta, $idAnuncio]);
            return (bool) $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al verificar reporte: " . $e->getMessage());
            return false;
        }
    }
}
?>
