<?php
require_once __DIR__ . '/../models/Model_AnuncioGuardado.php';
require_once __DIR__ . '/../core/config/session.php';
class Con_AnuncioGuardado {
    private Model_AnuncioGuardado $modelo;

    public function __construct() {
        $this->modelo = new Model_AnuncioGuardado();
    }

    public function obtenerAnunciosFavoritos() {
        $idUsuario = obtenerIdUsuarioActivo();
        return $this->modelo->obtenerAnunciosFavoritos($idUsuario);
    }
}
?>
