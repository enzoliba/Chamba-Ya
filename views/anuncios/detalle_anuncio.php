<?php
    // views/anuncios/detalle_anuncio.php
    $pageTitle = $anuncio['titulo'] . ' - Chamba Ya';
    require_once __DIR__ . '/../../assets/css/style_detalleTrabajo.php';
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
?>

<body>

    <div class="container-detalle">
        <!-- Rótulo de la Sección -->
        <div class="titulo-seccion-detalle">Detalles del Trabajo</div>
        
        <!-- Título Dinámico del Anuncio -->
        <h1 class="main-titulo-anuncio"><?= htmlspecialchars($anuncio['titulo']) ?></h1>
        
        <div class="layout-flex-detalle">
            
            <!-- SECCIÓN IZQUIERDA: CONTENIDO DEL ANUNCIO -->
            <div class="bloque-izquierdo">
                
                <!-- Fila de Ubicación y Sueldo -->
                <div class="fila-encabezados-mini">
                    <div class="caja-info-mini">
                        <span class="label">Departamento - Provincia - Distrito</span>
                        <?= htmlspecialchars($anuncio['ubicacion_completa']) ?>
                    </div>
                    <div class="caja-info-mini">
                        <span class="label">Pago Referencial:</span><strong>S/. <?= number_format($anuncio['pagoReferencia'], 2) ?> / hora</strong>
                    </div>
                </div>
                
                <!-- Cuerpo de la Tarjeta -->
                <div class="tarjeta-principal-cuerpo">
                    <div class="subtitulo-cuerpo">Descripción:</div>
                    <p class="descripcion-texto"><?= htmlspecialchars($anuncio['descripcion']) ?></p>
                    
                    <hr class="divisor-linea">
                    
                    <!-- Datos Técnicos en Grid -->
                    <div class="grid-detalles-secundarios">
                        <div class="item-secundario">
                            <span class="label">Modalidad:</span>
                            <span class="valor"><?= htmlspecialchars($anuncio['modalidad']) ?></span>
                        </div>
                        <div class="item-secundario">
                            <span class="label">Dirección del trabajo:</span>
                            <span class="valor"><?= htmlspecialchars($anuncio['direccionEspecificas'] ?? $anuncio['direccionEspecifica'] ?? 'Se pone la direccion especifica') ?></span>
                        </div>
                    </div>
                    
                    <hr class="divisor-linea">
                    
                    <div class="grid-detalles-secundarios">
                        <div class="item-secundario">
                            <span class="label">Estado del trabajo:</span>
                            <span class="valor"><?= htmlspecialchars($anuncio['estado']) ?></span>
                        </div>
                    </div>
                    
                    <!-- Bloque de Categorías Embebidas -->
                    <div class="contenedor-tags-categorias">
                        <span class="label">Categorías:</span>
                        <div class="lista-tags">
                            <?php if (!empty($anuncio['categorias_nombres'])): ?>
                                <?php foreach (explode(', ', $anuncio['categorias_nombres']) as $cat_nom): ?>
                                    <span class="tag-categoria"><?= htmlspecialchars($cat_nom) ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="tag-categoria" style="background:#f2f4f4; color:#7f8c8d; border:1px solid #d5dbdb;">General</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Botonera Inferior -->
                    <div class="bloque-acciones">
                        <button class="btn-postular" type="button">Contactar / Postularse</button>
                        <button class="btn-favorito" type="button">Añadir a Favoritos</button>
                    </div>
                </div>
            </div>
            
            <!-- SECCIÓN DERECHA: TARJETA DE PERFIL DEL EMISOR -->
            <aside class="bloque-derecho-perfil">
                <div class="titulo-perfil-card">Publicado por:</div>
                <div class="nombre-usuario-card">
                    <?= htmlspecialchars($anuncio['nombres'] . ' ' . $anuncio['apellidos']) ?>
                </div>
                
                <hr class="divisor-linea">
                
                <div class="datos-contacto-card">
                    <strong>Teléfono:</strong> <?= htmlspecialchars($anuncio['telefono'] ?? 'No especificado') ?>
                </div>
                <div class="datos-contacto-card">
                    <strong>Correo de contacto:</strong> <?= htmlspecialchars($anuncio['correo']) ?>
                </div>
                
                <div class="datos-contacto-card">
                    <strong>Calificación del usuario:</strong>

                    <div class="estrellas">
                        <?php for($i=1; $i<=5; $i++): ?>
                            <?php if($i <= $puntaje): ?>
                                <i class="fa-solid fa-star" style="color:#ffcc00;"></i>
                            <?php else: ?>
                                <i class="fa-regular fa-star" style="color:#ccc;"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span>(<?= number_format($puntaje,1) ?>/5)</span>
                    </div>
                </div>

                <?php 
                    $foto = !empty($anuncio['fotoPerfil']) ? $anuncio['fotoPerfil'] : 'default.png'; 
                ?>
                <div style="margin-top: 15px;">
                    <span class="label">(Foto de Perfil)</span>
                    <img src="<?= $base_path ?>assets/uploads/img_perfiles/<?= $foto ?>" 
                        alt="Foto de Perfil del Reclutador" 
                        class="avatar-perfil-img"
                        onerror="this.src='<?= $base_path ?>assets/uploads/img_perfiles/default.png';">
                </div>
            </aside>
        </div>
    </div>
</body>
</html>