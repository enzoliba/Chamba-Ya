<?php
    function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // 0 = nadie logueado.
    function obtenerIdUsuarioActivo(): int {
        iniciarSesion();
        if (!isset($_SESSION['idUsuario'])) {
            return 0;
        }
        return (int) $_SESSION['idUsuario'];
    }
?>
