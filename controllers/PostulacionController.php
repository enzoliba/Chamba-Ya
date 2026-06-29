<?php
require_once __DIR__ . '/../models/PostulacionModel.php';
require_once __DIR__ . '/../core/config/session.php';
class PostulacionController {
    private PostulacionModel $modelo;

    public function __construct() {
        $this->modelo = new PostulacionModel();
    }

    public function obtenerPostulaciones() {
        $idUsuario = obtenerIdUsuarioActivo();
        return $this->modelo->obtenerPostulaciones($idUsuario);
    }
}
?>
