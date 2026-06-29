<?php
require_once __DIR__ . '/../models/AnuncioGuardadoModel.php';
require_once __DIR__ . '/../core/config/session.php';
class AnuncioGuardadoController {
    private AnuncioGuardadoModel $modelo;

    public function __construct() {
        $this->modelo = new AnuncioGuardadoModel();
    }

    public function obtenerAnunciosFavoritos() {
        $idUsuario = obtenerIdUsuarioActivo();
        return $this->modelo->obtenerAnunciosFavoritos($idUsuario);
    }
}
?>
