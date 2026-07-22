<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';

class HabilidadModel {
    private $conn;

    public function __construct() {
        $Database = new Database();
        $this->conn = $Database->getConnection();
    }

    public function obtenerTodas() {
        try {
            $stmt = $this->conn->query("SELECT idHabilidad, nombre FROM habilidad ORDER BY nombre ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar habilidades: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerIdsDeUsuario($idUsuario) {
        try {
            $stmt = $this->conn->prepare("SELECT idHabilidad FROM usuariohabilidad WHERE idUsuario = ?");
            $stmt->execute([$idUsuario]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            error_log("Error al consultar habilidades del usuario: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerNombresDeUsuario($idUsuario) {
        try {
            $stmt = $this->conn->prepare("
                SELECT h.nombre
                FROM usuariohabilidad uh
                JOIN habilidad h ON uh.idHabilidad = h.idHabilidad
                WHERE uh.idUsuario = ?
                ORDER BY h.nombre ASC
            ");
            $stmt->execute([$idUsuario]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (Exception $e) {
            error_log("Error al consultar nombres de habilidades: " . $e->getMessage());
            return [];
        }
    }

    // Reemplaza las habilidades del usuario por la lista recibida.
    public function guardarDeUsuario($idUsuario, $idsHabilidades): bool {
        try {
            $this->conn->beginTransaction();
            $del = $this->conn->prepare("DELETE FROM usuariohabilidad WHERE idUsuario = ?");
            $del->execute([$idUsuario]);

            if (!empty($idsHabilidades)) {
                $ins = $this->conn->prepare("INSERT INTO usuariohabilidad (idUsuario, idHabilidad) VALUES (?, ?)");
                foreach ($idsHabilidades as $idHab) {
                    $idHab = (int) $idHab;
                    if ($idHab > 0) $ins->execute([$idUsuario, $idHab]);
                }
            }
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al guardar habilidades: " . $e->getMessage());
            return false;
        }
    }
}
?>
