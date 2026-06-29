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

    public function alternarFavorito(): void {
        $idUsuario = obtenerIdUsuarioActivo();
        $idAnuncio = (int) ($_POST['idAnuncio'] ?? 0);

        if ($idAnuncio <= 0 || !$this->modelo->anuncioExiste($idAnuncio)) {
            $this->redirigir($idAnuncio, 'error');
        }

        if ($this->modelo->esFavorito($idUsuario, $idAnuncio)) {
            $ok = $this->modelo->quitarFavorito($idUsuario, $idAnuncio);
            $this->redirigir($idAnuncio, $ok ? 'fav_quitado' : 'error');
        } else {
            $ok = $this->modelo->agregarFavorito($idUsuario, $idAnuncio);
            $this->redirigir($idAnuncio, $ok ? 'fav_guardado' : 'error');
        }
    }

    private function redirigir(int $idAnuncio, string $estado): never {
        header("Location: ../index.php?action=detalle-anuncio&id=" . $idAnuncio . "&estado=" . urlencode($estado));
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
    (new AnuncioGuardadoController())->alternarFavorito();
}
?>
