<?php
    // Inicia la sesión una sola vez de forma segura.
    // Evita el "Notice: session already active" cuando varios archivos
    // (index.php, controladores, vistas) intentan arrancarla.
    function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Retorna el ID del usuario activo en la sesión.
    // Devuelve 0 cuando NO hay sesión iniciada. Nunca asume un usuario por
    // defecto: quien llame debe exigir login antes de operar con datos.
    function obtenerIdUsuarioActivo(): int {
        iniciarSesion();
        if (!isset($_SESSION['idUsuario'])) {
            return 0;
        }
        return (int) $_SESSION['idUsuario'];
    }
?>
