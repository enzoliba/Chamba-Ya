<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';
class AnuncioGuardadoModel {
    private $conn;

    public function __construct() {
        $Database = new Database();
        $this->conn = $Database->getConnection();
    }

    public function obtenerAnunciosFavoritos($idUsuario) {
        try {
            $stmt = $this->conn->prepare("
                SELECT a.idAnuncio as id, a.titulo, a.descripcion, a.estado, a.direccionEspecifica, a.pagoReferencia, a.modalidad, a.tipoAnuncio,
                       d.nombre as distrito_nombre, p.nombre as provincia_nombre, dep.nombre as departamento_nombre,
                       GROUP_CONCAT(c.nombre ORDER BY c.idCategoria) as categorias_nombres
                FROM anunciosfavoritos f
                JOIN anuncio a ON f.idAnuncio = a.idAnuncio
                LEFT JOIN distrito d ON a.idDistrito = d.idDistrito
                LEFT JOIN provincia p ON d.idProvincia = p.idProvincia
                LEFT JOIN departamento dep ON p.idDepartamento = dep.idDepartamento
                LEFT JOIN categoriasanuncio ca ON a.idAnuncio = ca.idAnuncio
                LEFT JOIN categoria c ON ca.idCategoria = c.idCategoria
                WHERE f.idUsuario = ?
                GROUP BY a.idAnuncio
                ORDER BY f.fechaGuardado DESC
            ");
            $stmt->execute([$idUsuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar favoritos: " . $e->getMessage());
            return [];
        }
    }

    public function anuncioExiste($idAnuncio): bool {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM anuncio WHERE idAnuncio = ?");
            $stmt->execute([$idAnuncio]);
            return (bool) $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al verificar anuncio: " . $e->getMessage());
            return false;
        }
    }

    public function esFavorito($idUsuario, $idAnuncio): bool {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM anunciosfavoritos WHERE idUsuario = ? AND idAnuncio = ?");
            $stmt->execute([$idUsuario, $idAnuncio]);
            return (bool) $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al verificar favorito: " . $e->getMessage());
            return false;
        }
    }

    public function agregarFavorito($idUsuario, $idAnuncio): bool {
        try {
            $stmt = $this->conn->prepare("INSERT INTO anunciosfavoritos (idUsuario, idAnuncio) VALUES (?, ?)");
            return $stmt->execute([$idUsuario, $idAnuncio]);
        } catch (Exception $e) {
            error_log("Error al agregar favorito: " . $e->getMessage());
            return false;
        }
    }

    public function quitarFavorito($idUsuario, $idAnuncio): bool {
        try {
            $stmt = $this->conn->prepare("DELETE FROM anunciosfavoritos WHERE idUsuario = ? AND idAnuncio = ?");
            return $stmt->execute([$idUsuario, $idAnuncio]);
        } catch (Exception $e) {
            error_log("Error al quitar favorito: " . $e->getMessage());
            return false;
        }
    }
}
?>
