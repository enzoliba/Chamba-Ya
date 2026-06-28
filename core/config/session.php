<?php
    // Inicia la sesión una sola vez de forma segura.
    // Evita el "Notice: session already active" cuando varios archivos
    // (index.php, controladores, vistas) intentan arrancarla.
    function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
