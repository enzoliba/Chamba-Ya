<?php
    function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Devuelve 0 si no hay sesión: nunca asume un usuario por defecto.
    function obtenerIdUsuarioActivo(): int {
        iniciarSesion();
        if (!isset($_SESSION['idUsuario'])) {
            return 0;
        }
        return (int) $_SESSION['idUsuario'];
    }
?>
