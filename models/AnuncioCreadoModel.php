<?php
require_once __DIR__ . '/../core/db/database.php';
require_once __DIR__ . '/../core/config/session.php';
class AnuncioCreadoModel {
    private $conn;

    public function __construct() {
        $Database = new Database();
        $this->conn = $Database->getConnection();
    }

    // Impide que alguien edite/elimine anuncios ajenos (IDOR).
    public function anuncioPerteneceAUsuario($idAnuncio, $idUsuario): bool {
        try {
            $stmt = $this->conn->prepare("SELECT 1 FROM anuncio WHERE idAnuncio = ? AND idUsuario = ?");
            $stmt->execute([$idAnuncio, $idUsuario]);
            return (bool) $stmt->fetchColumn();
        } catch (Exception $e) {
            error_log("Error al verificar propiedad del anuncio: " . $e->getMessage());
            return false;
        }
    }

    public function guardarAnuncio($titulo, $descripcion, $estado, $direccionEspecifica, $idDistrito, $pago, $modalidad, $tipo, $idUsuario) {
        try { 
            $sql = "INSERT INTO anuncio (titulo, descripcion, estado, direccionEspecifica, idDistrito, pagoReferencia, modalidad, tipoAnuncio, idUsuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql); 
            if ($stmt->execute([$titulo, $descripcion, $estado, $direccionEspecifica, $idDistrito, $pago, $modalidad, $tipo, $idUsuario])) {
                return $this->conn->lastInsertId();
            } else {
                throw new Exception("Error al insertar el anuncio");
            }   
        } catch (Exception $e) {
            throw new Exception("Error al guardar: " . $e->getMessage());
        }
    }

    public function actualizarAnuncio($id, $titulo, $descripcion, $estado, $direccionEspecifica, $idDistrito, $pago, $modalidad, $tipo, $idUsuario) {
        try {
            // AND idUsuario=? : solo el dueño puede actualizar (anti-IDOR).
            $sql = "UPDATE anuncio SET titulo=?, descripcion=?, estado=?, direccionEspecifica=?, idDistrito=?, pagoReferencia=?, modalidad=?, tipoAnuncio=? WHERE idAnuncio=? AND idUsuario=?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$titulo, $descripcion, $estado, $direccionEspecifica, $idDistrito, $pago, $modalidad, $tipo, $id, $idUsuario])) {
                return true;
            } else {
                throw new Exception("Error al actualizar el anuncio");
            }
        } catch (Exception $e) {
            throw new Exception("Error al actualizar: " . $e->getMessage());
        }
    }

    public function eliminarAnuncio($id, $idUsuario) {
        try {
            // AND idUsuario=? : solo el dueño puede eliminar (anti-IDOR).
            $sql = "DELETE FROM anuncio WHERE idAnuncio = ? AND idUsuario = ?";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute([$id, $idUsuario])) {
                return true;
            } else {
                throw new Exception("Error al eliminar el anuncio");
            }
        } catch (Exception $e) {
            throw new Exception("Error al eliminar: " . $e->getMessage());
        }
    }

    public function obtenerAnuncios($idUsuario) {
        try {
            $stmt = $this->conn->prepare("
                SELECT a.idAnuncio as id, a.titulo, a.descripcion, a.estado, a.direccionEspecifica, a.pagoReferencia, a.modalidad, a.tipoAnuncio,
                       a.idDistrito, d.idProvincia, p.idDepartamento,
                       d.nombre as distrito_nombre, p.nombre as provincia_nombre, dep.nombre as departamento_nombre,
                       GROUP_CONCAT(c.idCategoria ORDER BY c.idCategoria) as categorias_ids,
                       GROUP_CONCAT(c.nombre ORDER BY c.idCategoria) as categorias_nombres
                FROM anuncio a
                LEFT JOIN distrito d ON a.idDistrito = d.idDistrito
                LEFT JOIN provincia p ON d.idProvincia = p.idProvincia
                LEFT JOIN departamento dep ON p.idDepartamento = dep.idDepartamento
                LEFT JOIN categoriasanuncio ca ON a.idAnuncio = ca.idAnuncio
                LEFT JOIN categoria c ON ca.idCategoria = c.idCategoria
                WHERE a.idUsuario = ?
                GROUP BY a.idAnuncio
                ORDER BY a.fechaPublicacion DESC
            ");
            $stmt->execute([$idUsuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar anuncios: " . $e->getMessage());
            return [];
        }
    }

    public function guardarCategoriasAnuncio($idAnuncio, $idCategorias) {
        try {
            // Primero, eliminar relaciones previas para evitar duplicados
            $sqlDelete = "DELETE FROM categoriasanuncio WHERE idAnuncio = ?";
            $stmtDelete = $this->conn->prepare($sqlDelete);
            $stmtDelete->execute([$idAnuncio]);

            // Insertar nuevas relaciones
            if (!empty($idCategorias)) {
                $sqlInsert = "INSERT INTO categoriasanuncio (idCategoria, idAnuncio) VALUES (?, ?)";
                $stmtInsert = $this->conn->prepare($sqlInsert);
                foreach ($idCategorias as $idCategoria) {
                    if (!empty($idCategoria)) {
                        $stmtInsert->execute([$idCategoria, $idAnuncio]);
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            error_log("Error al guardar categorías de anuncio: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerCategorias() {
        try {
            $stmt = $this->conn->query("SELECT idCategoria, nombre FROM categoria ORDER BY nombre ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar categorias: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerDepartamentos() {
        try {
            $stmt = $this->conn->query("SELECT idDepartamento, nombre FROM departamento ORDER BY nombre ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar departamentos: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerProvinciasPorDepartamento($idDepartamento) {
        try {
            $stmt = $this->conn->prepare("SELECT idProvincia, nombre FROM provincia WHERE idDepartamento = ? ORDER BY nombre ASC");
            $stmt->execute([$idDepartamento]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar provincias: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerDistritosPorProvincia($idProvincia) {
        try {
            $stmt = $this->conn->prepare("SELECT idDistrito, nombre FROM distrito WHERE idProvincia = ? ORDER BY nombre ASC");
            $stmt->execute([$idProvincia]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar distritos: " . $e->getMessage());
            return [];
        }
    }
}
?>
