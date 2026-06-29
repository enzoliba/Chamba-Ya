<?php
// views/anuncios/detalle_servicio.php
$pageTitle = 'Perfil de Servicio - ' . $anuncio['nombres'];
require_once __DIR__ . '/../../assets/css/style_detalleServicio.php';
require_once __DIR__ . '/../templates/head.php';
require_once __DIR__ . '/../templates/header.php';
?>
<body>

    <?php require_once __DIR__ . '/_banner_estado.php'; ?>

    <div class="container-servicio">
        <div class="wrapper-layout-servicio">
            
            <main class="col-perfil-principal">
                <div class="encabezado-usuario">
                    <?php $foto = !empty($anuncio['fotoPerfil']) ? $anuncio['fotoPerfil'] : 'default.png'; ?>
                    <img src="<?= $base_path ?>assets/uploads/img_perfiles/<?= $foto ?>" 
                        alt="Foto de Perfil" class="foto-perfil-avatar"
                        onerror="this.src='<?= $base_path ?>assets/uploads/img_perfiles/default.png';">
                    
                    <div class="info-usuario-titulo">
                        <h1><?= htmlspecialchars($anuncio['nombres'] . ' ' . $anuncio['apellidos']) ?></h1>
                        <span class="rol-tag">Ofrece Servicio</span>
                    </div>
                </div>

                <div class="seccion-bloque-info">
                    <h3>Sobre mí</h3>
                    <p><?= htmlspecialchars($anuncio['descripcionPerfil'] ?? 'Este usuario no ha añadido una descripción a su perfil todavía.') ?></p>
                </div>

                <div class="seccion-bloque-info">
                    <h3>Descripción del Servicio solicitado</h3>
                    <p><?= htmlspecialchars($anuncio['descripcion']) ?></p>
                </div>

                <div class="seccion-bloque-info">
                    <h3>Categorías</h3>
                    <div class="contenedor-badges">
                        <?php if (!empty($anuncio['categorias_nombres'])): ?>
                            <?php foreach (explode(', ', $anuncio['categorias_nombres']) as $cat): ?>
                                <span class="badge-item categoria"><?= htmlspecialchars($cat) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="badge-item categoria">General</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="seccion-bloque-info">
                    <h3>Habilidades</h3>
                    <div class="contenedor-badges">
                        <span class="badge-item">Puntualidad</span>
                        <span class="badge-item">Eficiencia</span>
                        <span class="badge-item">Trabajo Garantizado</span>
                    </div>
                </div>
            </main>

            <aside class="col-sidebar-datos">
                <div class="precio-box">
                    Precio Estimado
                    <strong><?= htmlspecialchars(formatearPago($anuncio['pagoReferencia'])) ?></strong>
                </div>

                <div class="item-contacto-sidebar">
                    <span>Ubicación</span>
                    <p><?= htmlspecialchars($anuncio['ubicacion_completa']) ?></p>
                </div>

                <div class="item-contacto-sidebar">
                    <span>Detalle:</span>
                    <p><?= htmlspecialchars($anuncio['direccionEspecificas'] ?? $anuncio['direccionEspecifica'] ?? 'No especificada') ?></p>
                </div>

                <div class="item-contacto-sidebar">
                    <span>Teléfono</span>
                    <p><?= htmlspecialchars($anuncio['telefono'] ?? 'No especificado') ?></p>
                </div>

                <div class="item-contacto-sidebar">
                    <span>Correo Electrónico</span>
                    <p style="word-break: break-all;"><?= htmlspecialchars($anuncio['correo']) ?></p>
                </div>

                <div class="item-contacto-sidebar">
                    <span>Modalidad</span>
                    <p><?= htmlspecialchars($anuncio['modalidad']) ?></p>
                </div>

                <form action="<?= BASE_URL ?>controllers/PostulacionController.php" method="POST">
                    <input type="hidden" name="idAnuncio" value="<?= (int) $anuncio['idAnuncio'] ?>">
                    <button class="btn-solicitar-servicio" id="btn-solicitar-service" type="submit">Contratar Servicio</button>
                </form>
                <a class="btn-calificar-servicio" id="btn-calificar-service" href="#form-calificar">Calificar Usuario</a>
            </aside>

        </div>

        <section class="seccion-otros-servicios">
            <h2>Servicios que ofrezco</h2>
            <div class="grid-otros-servicios">
                <?php if (!empty($otrosServicios)): ?>
                    <?php foreach ($otrosServicios as $otro): ?>
                        <div class="tarjeta-mini-servicio">
                            <div>
                                <h4><?= htmlspecialchars($otro['titulo']) ?></h4>
                                <p><?= htmlspecialchars($otro['descripcion']) ?></p>
                            </div>
                            <div class="footer-mini-tarjeta">
                                <span style="font-weight: bold; color: #d8a500;"><?= htmlspecialchars(formatearPago($otro['pagoReferencia'])) ?></span>
                                <a href="<?= BASE_URL ?>index.php?action=detalle-anuncio&id=<?= $otro['idAnuncio'] ?>" class="btn-ver-detalle-mini">
                                    Ver Detalle
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #64748b; font-style: italic;">El ofertante no cuenta con otros servicios activos en este momento.</p>
                <?php endif; ?>
            </div>
        </section>

        <div class="seccion-testimonios">
            <h2>Opiniones de los usuarios</h2>

            <!-- Formulario para dejar una calificación -->
            <style>
                .form-calificar{background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:18px;margin-bottom:22px;max-width:520px;}
                .form-calificar .rating{display:inline-flex;flex-direction:row-reverse;justify-content:flex-end;}
                .form-calificar .rating input{display:none;}
                .form-calificar .rating label{font-size:32px;color:#d1d5db;cursor:pointer;padding:0 2px;transition:color .15s;}
                .form-calificar .rating label:hover,
                .form-calificar .rating label:hover ~ label,
                .form-calificar .rating input:checked ~ label{color:#ffcc00;}
                .form-calificar textarea{width:100%;box-sizing:border-box;margin-top:10px;padding:10px;border:1px solid #cbd5e1;border-radius:8px;resize:vertical;min-height:70px;font-family:inherit;}
                .form-calificar button{margin-top:10px;padding:10px 18px;border:none;border-radius:8px;background:#7c3aed;color:#fff;font-weight:600;cursor:pointer;}
                .form-calificar button:hover{background:#6d28d9;}
            </style>
            <?php if (!isset($_SESSION['idUsuario'])): ?>
                <p id="form-calificar" style="color:#64748b;">
                    <a href="<?= BASE_URL ?>views/auth/login.php">Inicia sesión</a> para dejar tu calificación.
                </p>
            <?php elseif ($_SESSION['idUsuario'] == $anuncio['idUsuario']): ?>
                <p id="form-calificar" style="color:#64748b;">No puedes calificarte a ti mismo.</p>
            <?php else: ?>
                <form id="form-calificar" class="form-calificar" action="<?= BASE_URL ?>controllers/CalificacionController.php" method="POST">
                    <input type="hidden" name="idUsuarioCalificado" value="<?= (int) $anuncio['idUsuario'] ?>">
                    <input type="hidden" name="idAnuncio" value="<?= (int) $anuncio['idAnuncio'] ?>">
                    <strong>Deja tu opinión</strong>
                    <div class="rating">
                        <input type="radio" name="puntaje" id="cal5" value="5" required><label for="cal5" title="Excelente">★</label>
                        <input type="radio" name="puntaje" id="cal4" value="4"><label for="cal4" title="Muy bueno">★</label>
                        <input type="radio" name="puntaje" id="cal3" value="3"><label for="cal3" title="Bueno">★</label>
                        <input type="radio" name="puntaje" id="cal2" value="2"><label for="cal2" title="Regular">★</label>
                        <input type="radio" name="puntaje" id="cal1" value="1"><label for="cal1" title="Malo">★</label>
                    </div>
                    <textarea name="comentario" maxlength="500" placeholder="Cuéntanos tu experiencia (opcional)"></textarea>
                    <button type="submit">Enviar calificación</button>
                </form>
            <?php endif; ?>

            <?php if (!empty($testimonios)): ?>
                <div class="lista-testimonios">
                    <?php foreach ($testimonios as $testimonio): ?>
                        <div class="tarjeta-testimonio">
                            <div class="testimonio-header">
                                <div class="usuario-info">
                                    <strong><?= htmlspecialchars($testimonio['nombres'] . ' ' . $testimonio['apellidos']) ?></strong>
                                    <span class="testimonio-fecha"><?= date('d/m/Y', strtotime($testimonio['fecha'])) ?></span>
                                </div>
                                <div class="estrellas">
                                    <?php 
                                    $puntaje = intval($testimonio['puntaje']);
                                    for ($i = 1; $i <= 5; $i++): 
                                        if ($i <= $puntaje): ?>
                                            <i class="fa-solid fa-star" style="color: #ffcc00;"></i>
                                        <?php else: ?>
                                            <i class="fa-regular fa-star" style="color: #ccc;"></i>
                                        <?php endif; 
                                    endfor; ?>
                                </div>
                            </div>
                            <div class="testimonio-cuerpo">
                                <p><?= htmlspecialchars($testimonio['comentario']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="sin-testimonios">Este perfil de servicio aún no cuenta con calificaciones o testimonios.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>