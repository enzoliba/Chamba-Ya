<?php
require_once __DIR__ . '/../models/Model_Historial.php';
require_once __DIR__ . '/../core/config/session.php';
class Con_Historial {
    private Model_Historial $modelo;

    public function __construct() {
        $this->modelo = new Model_Historial();
    }

    public function obtenerHistorial() {
        $idUsuario = obtenerIdUsuarioActivo();
        return $this->modelo->obtenerHistorialPostulaciones($idUsuario);
    }
}
?>
