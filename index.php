<?php
    require_once __DIR__ . '/core/config/session.php';
    iniciarSesion();

    // Capturamos la acción solicitada
    $action = $_GET['action'] ?? 'home';

    if ($action === 'buscar-trabajo') {
        // Derivamos el control a la arquitectura limpia
        require_once 'controllers/AnuncioController.php';
        $controller = new AnuncioController();
        $controller->explorar();
        exit();
    }

    // NUEVA INCLUSIÓN: Capturar el clic de "Ver más"
    if ($action === 'detalle-anuncio') {
        require_once 'controllers/AnuncioController.php';
        $controller = new AnuncioController();
        $controller->verDetalle(); // Reutilizamos el mismo controlador
        exit();
    }

    require_once 'core/config/autoload.php';
    require_once 'core/config/config.php';
    require_once 'models/anuncioModel.php';
    $model = new AnuncioModel();
    $categoriasBD = $model->obtenerCategorias();

    // Últimos avisos publicados (para la sección "Avisos recientes")
    $anunciosRecientes = array_slice($model->obtenerAnuncios([]), 0, 4);

    require_once 'assets/css/style.php';
    require_once 'assets/css/styles.php';
    require_once 'views/templates/head.php';
    require_once 'views/templates/header.php';
?>

    <body>
        <!-- ===================== HERO: el split, tu firma ===================== -->
        <div class="container_halfs">
            <div class="left_half">
                <span class="hero_eyebrow"><i class="fa-solid fa-helmet-safety"></i> Soy trabajador</span>
                <h1>Encuentra tu chamba al toque</h1>
                <p>Ofertas cerca de ti, sin CV y con contacto directo. Postula en segundos.</p>
                <img src="<?= BASE_URL ?>assets/img/imagen_left.png" alt="Trabajador listo para la chamba">
                <button class="btn_left_first" onclick="window.location.href='<?= BASE_URL ?>index.php?action=buscar-trabajo&tipo=trabajo'">Ver ofertas de trabajo</button>
                <button class="btn_left_second" onclick="window.location.href='<?= BASE_URL ?>views/user/mis_anuncios.php'">Publicar mi perfil</button>
            </div>
            <div class="right_half">
                <span class="hero_eyebrow"><i class="fa-solid fa-handshake-angle"></i> Necesito ayuda</span>
                <h1>Contrata a alguien ahora</h1>
                <p>Gasfiteros, electricistas, limpieza, jardinería y más. Encuéntralos o publica tu necesidad.</p>
                <img src="<?= BASE_URL ?>assets/img/imagen_right.png" alt="Persona buscando un trabajador">
                <button class="btn_right_first" onclick="window.location.href='<?= BASE_URL ?>index.php?action=buscar-trabajo&tipo=servicio'">Buscar trabajadores</button>
                <button class="btn_right_second" onclick="window.location.href='<?= BASE_URL ?>views/user/mis_anuncios.php'">Publicar una oferta</button>
            </div>
        </div>

        <!-- ===================== BUSCADOR (firma: cinta de peligro) ===================== -->
        <div class="search_band">
            <div class="search_card">
                <h2>¿Qué chamba buscas?</h2>
                <p class="search_sub">Escribe un oficio o servicio y encuéntralo cerca de ti.</p>
                <form class="search_form" method="GET" action="<?= BASE_URL ?>index.php" role="search">
                    <input type="hidden" name="action" value="buscar-trabajo">
                    <input type="hidden" name="tipo" value="trabajo">
                    <div class="field">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" placeholder="Ej. gasfitero, limpieza, electricista..." aria-label="Buscar chamba">
                    </div>
                    <button type="submit" class="btn_buscar">Buscar</button>
                </form>
                <div class="search_tags">
                    <span class="label">Populares:</span>
                    <a href="<?= BASE_URL ?>index.php?action=buscar-trabajo&tipo=servicio&search=limpieza">Limpieza</a>
                    <a href="<?= BASE_URL ?>index.php?action=buscar-trabajo&tipo=servicio&search=electricista">Electricista</a>
                    <a href="<?= BASE_URL ?>index.php?action=buscar-trabajo&tipo=servicio&search=gasfitero">Gasfitero</a>
                    <a href="<?= BASE_URL ?>index.php?action=buscar-trabajo&tipo=servicio&search=jardineria">Jardinería</a>
                </div>
            </div>
        </div>

        <!-- ===================== TIRA DE CONFIANZA ===================== -->
        <div class="trust_strip">
            <span class="trust_item"><i class="fa-solid fa-id-card-clip"></i> Sin CV</span>
            <span class="trust_item"><i class="fa-brands fa-whatsapp"></i> Contacto directo</span>
            <span class="trust_item"><i class="fa-solid fa-shield-halved"></i> Perfiles con reseñas</span>
            <span class="trust_item"><i class="fa-solid fa-bolt"></i> Publicar es gratis</span>
        </div>

    <div class="categories">
        <div class="section_head">
            <span class="section_eyebrow">Explora</span>
            <h2>Categorías</h2>
        </div>
        <div class="categories_carousel">
            <button class="carousel_btn prev" onclick="scrollCarousel(-1)">&#10094;</button>
            <div class="carousel_wrapper" id="carouselWrapper">
                <?php if (!empty($categoriasBD)): ?>
                    <?php foreach ($categoriasBD as $cat):
                        // 1) Si la categoría tiene una imagen asignada en la BD, se usa esa.
                        if (!empty($cat['imagen'])) {
                            $archivoImagen = $cat['imagen'];
                        } else {
                            // 2) Respaldo: deriva el nombre del archivo a partir del nombre
                            //    de la categoría (minúsculas, sin tildes ni espacios).
                            $nombreLimpio = strtolower(trim($cat['nombre']));
                            $buscar = array('á', 'é', 'í', 'ó', 'ú', 'ñ', ' ');
                            $reemplazar = array('a', 'e', 'i', 'o', 'u', 'n', '_');
                            $archivoImagen = str_replace($buscar, $reemplazar, $nombreLimpio) . ".png";
                        }
                    ?>
                        <a href="index.php?action=buscar-trabajo&tipo=trabajo&categoria[]=<?= urlencode($cat['idCategoria']) ?>" class="categories_card">
                            <img src="<?= BASE_URL ?>assets/img/<?= $archivoImagen ?>" alt="<?= htmlspecialchars($cat['nombre']) ?>" onerror="this.src='<?= BASE_URL ?>assets/img/servicios_varios.png';">
                            <h3><?= htmlspecialchars($cat['nombre']) ?></h3>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="" class="categories_card">
                        <img src="<?= BASE_URL ?>assets/img/servicios_varios.png" alt="Sin categorías">
                        <h3>No hay categorías registradas</h3>
                    </a>
                <?php endif; ?>
            </div>
            <button class="carousel_btn next" onclick="scrollCarousel(1)">&#10095;</button>
        </div>
    </div>

    <!-- ===================== AVISOS RECIENTES (datos reales) ===================== -->
    <div class="recientes">
        <div class="recientes_head">
            <div class="section_head" style="margin-bottom:0;">
                <span class="section_eyebrow">Recién publicados</span>
                <h2>Avisos recientes</h2>
            </div>
            <a class="ver_todos" href="<?= BASE_URL ?>index.php?action=buscar-trabajo&tipo=trabajo">Ver todos &rarr;</a>
        </div>
        <div class="recientes_grid">
            <?php if (!empty($anunciosRecientes)): ?>
                <?php foreach ($anunciosRecientes as $av):
                    $tipo = ($av['tipoAnuncio'] ?? 'trabajo') === 'servicio' ? 'servicio' : 'trabajo';
                    $prom = (int) round($av['promedio'] ?? 0);
                ?>
                    <a class="aviso_card" href="<?= BASE_URL ?>index.php?action=detalle-anuncio&id=<?= (int)$av['idAnuncio'] ?>&tipo=<?= $tipo ?>">
                        <div class="aviso_top">
                            <span class="aviso_tipo <?= $tipo ?>"><?= $tipo === 'servicio' ? 'Servicio' : 'Trabajo' ?></span>
                            <?php if ($prom > 0): ?>
                                <span class="aviso_estrellas"><?php for($i=1;$i<=5;$i++){ echo $i <= $prom ? '★':'☆'; } ?></span>
                            <?php endif; ?>
                        </div>
                        <h3><?= htmlspecialchars($av['titulo']) ?></h3>
                        <p class="aviso_meta"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($av['ubicacion'] ?? 'No especificado') ?></p>
                        <?php if (!empty($av['pagoReferencia'])): ?>
                            <span class="aviso_pago"><?= htmlspecialchars(formatearPago($av['pagoReferencia'])) ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="recientes_empty">Aún no hay avisos publicados. ¡Sé el primero en publicar tu chamba!</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ===================== POR QUÉ CHAMBA YA ===================== -->
    <div class="why_chamba_ya">
        <span class="section_eyebrow">La diferencia</span>
        <h2>¿Por qué Chamba Ya?</h2>
        <div class="why_cards_container">
            <div class="why_card">
                <div class="why_icon"><i class="fa-solid fa-id-card-clip"></i></div>
                <h3>Sin CV</h3>
                <p>Olvídate del currículum. Muestra lo que sabes hacer y consigue chamba.</p>
            </div>
            <div class="why_card">
                <div class="why_icon"><i class="fa-solid fa-comments"></i></div>
                <h3>Contacto directo</h3>
                <p>Habla de frente con quien publica, sin intermediarios ni comisiones.</p>
            </div>
            <div class="why_card">
                <div class="why_icon"><i class="fa-solid fa-bolt"></i></div>
                <h3>Trabajos rápidos</h3>
                <p>Encuentra y empieza al toque, según tus habilidades y tu zona.</p>
            </div>
        </div>
    </div>
    <?php require_once __DIR__ . '/views/templates/footer.php'; ?>
    </body>
    <script src="<?= BASE_URL ?>assets/js/index.js"></script>
    </html>