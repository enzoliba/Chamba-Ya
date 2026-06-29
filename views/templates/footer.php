<?php require_once __DIR__ . '/../../core/config/config.php'; ?>
<?php require_once __DIR__ . '/../../assets/css/style_footer.php'; ?>

<footer class="footer">
    <div class="footer_container">
        <div class="footer_row">
            <div class="footer_links">
                <h4>Nosotros</h4>
                <div class="footer_content">
                    <ul>
                        <li><a href="<?= BASE_URL ?>views/footer-views/quienes_somos.php">Quienes Somos</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer_links">
                <h4>Información Legal</h4>
                <div class="footer_content">
                    <ul>
                        <li><a href="<?= BASE_URL ?>views/footer-views/terminos_y_condiciones.php">Terminos y Condiciones</a></li>
                        <li><a href="<?= BASE_URL ?>views/footer-views/preguntas_frecuentes.php">Preguntas frecuentes</a></li>
                        <li><a href="<?= BASE_URL ?>views/footer-views/politicas_privacidad.php">Politicas de Privacidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer_links" id="footer-redes">
                <h4>Siguenos</h4>
                <div class="footer_content">
                    <div class="social_links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
