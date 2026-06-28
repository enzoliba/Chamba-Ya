<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';
class Model_AnuncioGuardado {
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
}
?>
