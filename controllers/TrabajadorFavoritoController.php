<?php
require_once __DIR__ . '/../models/TrabajadorFavoritoModel.php';
require_once __DIR__ . '/../core/config/session.php';

class TrabajadorFavoritoController {
    private TrabajadorFavoritoModel $modelo;

    public function __construct() {
        $this->modelo = new TrabajadorFavoritoModel();
    }

    public function obtenerFavoritos() {
        return $this->modelo->obtenerFavoritos(obtenerIdUsuarioActivo());
    }

    public function alternar(): void {
        $idCliente    = obtenerIdUsuarioActivo();
        $idTrabajador = (int) ($_POST['idTrabajador'] ?? 0);

        if ($idTrabajador <= 0 || !$this->modelo->usuarioExiste($idTrabajador)) {
            $this->redirigir('error');
        }
        if ($idTrabajador === $idCliente) {
            $this->redirigir('trab_propio');
        }

        if ($this->modelo->esFavorito($idCliente, $idTrabajador)) {
            $ok = $this->modelo->quitar($idCliente, $idTrabajador);
            $this->redirigir($ok ? 'trab_quitado' : 'error');
        } else {
            $ok = $this->modelo->agregar($idCliente, $idTrabajador);
            $this->redirigir($ok ? 'trab_guardado' : 'error');
        }
    }

    private function redirigir(string $estado): never {
        if (($_POST['origen'] ?? '') === 'lista') {
            header("Location: ../views/user/trabajadores_favoritos.php?estado=" . urlencode($estado));
        } else {
            $idAnuncio = (int) ($_POST['idAnuncio'] ?? 0);
            header("Location: ../index.php?action=detalle-anuncio&id=" . $idAnuncio . "&tipo=servicio&estado=" . urlencode($estado));
        }
        exit();
    }
}

// Pide estar logueado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    iniciarSesion();
    if (!isset($_SESSION['idUsuario'])) {
        header('Location: ../views/auth/login.php');
        exit();
    }
    (new TrabajadorFavoritoController())->alternar();
}
?>
