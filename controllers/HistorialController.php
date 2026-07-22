<?php
require_once __DIR__ . '/../models/HistorialModel.php';
require_once __DIR__ . '/../core/config/session.php';
class HistorialController {
    private HistorialModel $modelo;

    public function __construct() {
        $this->modelo = new HistorialModel();
    }

    public function obtenerHistorial() {
        $idUsuario = obtenerIdUsuarioActivo();
        return $this->modelo->obtenerHistorialPostulaciones($idUsuario);
    }
}
?>
