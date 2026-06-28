<?php
    require_once __DIR__ . '/../../core/config/session.php';
    iniciarSesion();
    
    if(!isset($_SESSION['idUsuario'])){
        header('Location: ../auth/login.php');
        exit();
    }
    
    require_once __DIR__ . '/../../controllers/Con_AnuncioCreado.php';
    $conAnuncio = new Con_AnuncioCreado();
    $mis_anuncios = $conAnuncio->obtenerAnuncios();
    $categorias = $conAnuncio->obtenerCategorias();
    $departamentos = $conAnuncio->obtenerDepartamentos();

    require_once __DIR__ . '/../../assets/css/style.php';
    require_once __DIR__ . '/../../assets/css/styles.php';
    require_once __DIR__ . '/../../assets/css/style_profile.php';
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/estilos_Anuncios.css">

<div class="profile-page">

    <!-- Hero -->
    <section class="profile-hero">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>index.php">Inicio</a> &nbsp;/&nbsp; Mi Perfil
        </div>
        <h1>Mis Anuncios</h1>
        <p>Administra los anuncios y servicios que has publicado.</p>
    </section>

    <!-- Layout -->
    <div class="profile-layout">

        <!-- Sidebar -->
        <aside class="profile-sidebar">
            <div class="profile-sidebar-card">
                <div class="sidebar-section">
                    <h4>Ajustes</h4>
                    <ul class="sidebar-nav">
                        <li><a href="<?= BASE_URL ?>controllers/AuthController.php?action=showMisDatos"><i class="fa-solid fa-user"></i> Mis Datos</a></li>
                        <li><a href="<?= BASE_URL ?>views/user/mis_guardados.php"><i class="fa-regular fa-bookmark"></i> Anuncios guardados</a></li>
                        <li><a href="<?= BASE_URL ?>views/user/mis_anuncios.php" class="active"><i class="fa-regular fa-square-plus"></i> Anuncios creados</a></li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h4>Actividad</h4>
                    <ul class="sidebar-nav">
                        <li><a href="<?= BASE_URL ?>views/user/mis_postulaciones.php"><i class="fa-solid fa-paper-plane"></i> Mis Postulaciones</a></li>
                        <li><a href="<?= BASE_URL ?>views/user/mi_historial.php"><i class="fa-solid fa-history"></i> Historial</a></li>
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h4>Seguridad</h4>
                    <ul class="sidebar-nav">
                        <li><a href="<?= BASE_URL ?>controllers/AuthController.php?action=showSeguridad"><i class="fa-solid fa-shield-halved"></i> Seguridad</a></li>
                        <li><a href="<?= BASE_URL ?>controllers/AuthController.php?action=showPreferencias"><i class="fa-solid fa-sliders"></i> Preferencias</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Content -->
        <main class="profile-content">
            <!-- SECCIÓN: ANUNCIOS CREADOS -->
            <section id="seccion-anuncios" class="vista-seccion activo" style="display: block;">
                <button class="boton-crear" onclick="prepararCreacion()"><i class="fas fa-plus"></i> Crear Nuevo Anuncio</button>
                <div class="encabezado-seccion">
                    <h2>Anuncios Activos</h2>    
                </div>
                <div id="lista-anuncios">
                    <?php if (empty($mis_anuncios)): ?>
                        <p>No tienes anuncios creados todavía.</p>
                    <?php else: ?>
                        <?php foreach ($mis_anuncios as $anuncio): ?>
                            <div class="tarjeta-horizontal">
                                <div class="imagen-tarjeta"><i class="fas fa-image fa-2x"></i></div>
                                <div class="cuerpo-tarjeta">
                                    <h3><?php echo htmlspecialchars($anuncio['titulo']); ?></h3>
                                    <p><?php echo htmlspecialchars($anuncio['descripcion']); ?></p>
                                    <?php if (!empty($anuncio['distrito_nombre'])): ?>
                                        <p style="font-size: 0.85rem; color: #666; margin-top: 4px; display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-map-marker-alt" style="color: var(--purpura-principal);"></i> 
                                            <?php 
                                                $loc = htmlspecialchars($anuncio['distrito_nombre']);
                                                if (!empty($anuncio['provincia_nombre'])) $loc .= ', ' . htmlspecialchars($anuncio['provincia_nombre']);
                                                if (!empty($anuncio['departamento_nombre'])) $loc .= ' - ' . htmlspecialchars($anuncio['departamento_nombre']);
                                                if (!empty($anuncio['direccionEspecifica'])) $loc .= ' (' . htmlspecialchars($anuncio['direccionEspecifica']) . ')';
                                                echo $loc;
                                            ?>
                                        </p>
                                    <?php endif; ?>
                                    <span class="etiqueta-estado estado-<?php echo str_replace(' ', '', $anuncio['estado']); ?>">
                                        <?php echo ucfirst($anuncio['estado']); ?>
                                    </span>
                                </div>
                                <div class="acciones-tarjeta">
                                    <button class="boton-accion" title="Editar" onclick="abrirEdicion(this)"
                                            data-id="<?php echo $anuncio['id']; ?>"
                                            data-titulo="<?php echo htmlspecialchars($anuncio['titulo'], ENT_QUOTES, 'UTF-8'); ?>"
                                            data-descripcion="<?php echo htmlspecialchars($anuncio['descripcion'], ENT_QUOTES, 'UTF-8'); ?>"
                                            data-estado="<?php echo $anuncio['estado']; ?>"
                                            data-departamento_id="<?php echo $anuncio['idDepartamento'] ?? ''; ?>"
                                            data-provincia_id="<?php echo $anuncio['idProvincia'] ?? ''; ?>"
                                            data-distrito_id="<?php echo $anuncio['idDistrito'] ?? ''; ?>"
                                            data-direccion_especifica="<?php echo htmlspecialchars($anuncio['direccionEspecifica'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                            data-pago="<?php echo $anuncio['pagoReferencia']; ?>"
                                            data-modalidad="<?php echo $anuncio['modalidad']; ?>"
                                            data-tipo="<?php echo $anuncio['tipoAnuncio']; ?>"
                                            data-categorias_ids="<?php echo htmlspecialchars($anuncio['categorias_ids'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                            data-categorias_nombres="<?php echo htmlspecialchars($anuncio['categorias_nombres'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="<?= BASE_URL ?>controllers/Con_AnuncioCreado.php" method="POST" class="form-eliminar">
                                        <input type="hidden" name="id" value="<?php echo $anuncio['id']; ?>">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <button class="boton-accion" type="submit" onclick="return confirm('¿Estás seguro de que quieres eliminar este anuncio?');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div> 
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div>
</div>

<!-- MODAL: CREAR ANUNCIO -->
<div id="modal-crear" class="superposicion-modal">
    <div class="contenido-modal">
        <span class="cerrar-modal" onclick="cerrarModal('modal-crear')">&times;</span>
        <h3>Publicar Nueva Chamba</h3>
        <form id="formulario-anuncio" action="<?= BASE_URL ?>controllers/Con_AnuncioCreado.php" method="POST">
            <input type="hidden" name="id" id="form-id-anuncio">
            <div class="grupo-formulario">
                <label>Título del Anuncio</label>
                <input type="text" name="titulo" id="titulo-chamba" placeholder="Ej: Ayudante de cocina" required>
            </div>
            <div class="grupo-formulario">
                <label>Descripción detallada</label>
                <textarea name="descripcion" id="desc-chamba" rows="3" maxlength="200" oninput="actualizarContador(this)"></textarea>
                <small id="contador-chars" class="contador-derecha">0/200</small>
            </div>
            <div class="fila-formulario">
                <div class="grupo-formulario">
                    <label>Departamento</label>
                    <select name="departamento_id" id="departamento-chamba">
                        <option value="">Seleccione Departamento</option>
                        <?php foreach ($departamentos as $dep): ?>
                            <option value="<?php echo $dep['idDepartamento']; ?>">
                                <?php echo htmlspecialchars($dep['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grupo-formulario">
                    <label>Provincia</label>
                    <select name="provincia_id" id="provincia-chamba" disabled>
                        <option value="">Seleccione Provincia</option>
                    </select>
                </div>
            </div>
            <div class="fila-formulario">
                <div class="grupo-formulario">
                    <label>Distrito</label>
                    <select name="distrito_id" id="distrito-chamba" disabled required>
                        <option value="">Seleccione Distrito</option>
                    </select>
                </div>
                <div class="grupo-formulario">
                    <label>Dirección Específica</label>
                    <input type="text" name="direccion_especifica" id="direccion-especifica-chamba" placeholder="Ej: Av. Larco 123">
                </div>
            </div>
            <div class="fila-formulario">
                <div class="grupo-formulario">
                    <label>Pago Referencial (S/.)</label>
                    <input type="number" name="pago" id="pago-chamba" placeholder="0.00">
                </div>
                <div class="grupo-formulario">
                    <label>Modalidad</label>
                    <select name="modalidad" id="modalidad-chamba">
                        <option value="Presencial">Presencial</option>
                        <option value="Virtual">Virtual</option>
                    </select>
                </div>
            </div>
            <div class="fila-formulario">
                <div class="grupo-formulario">
                    <label>Tipo de Anuncio</label>
                    <select name="tipo" id="tipo-chamba">
                        <option value="Trabajo">Busco Empleado (Trabajo)</option>
                        <option value="Servicio">Ofrezco mis servicios</option>
                    </select>
                </div>
            </div>
            <div class="grupo-formulario">
                <label>Estado</label>
                <select name="estado" id="estado-chamba">
                    <option value="activo">Activo</option>
                    <option value="oculto">Oculto</option>
                </select>
            </div>
            <div class="grupo-formulario">
                <label>Categorías</label>
                <div class="selector-etiquetas">
                    <?php foreach ($categorias as $cat): ?>
                        <span class="opcion-etiqueta" onclick="agregarEtiqueta('<?php echo htmlspecialchars($cat['nombre'], ENT_QUOTES, 'UTF-8'); ?>', <?php echo $cat['idCategoria']; ?>)">
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
                <div id="contenedor-etiquetas" class="selector-etiquetas"></div>
                <input type="hidden" name="categorias_ids" id="categorias-ids" value="">
            </div>
            <button type="submit" class="boton-crear boton-ancho-total">Publicar Ahora</button>
        </form>
    </div>
</div>

<div id="contenedor-notificaciones"></div>

<script src="<?= BASE_URL ?>assets/js/script_Anuncios.js?v=<?php echo time(); ?>"></script>
<?php if (isset($_GET['mensaje'])): ?>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let msg = "";
        const m = "<?php echo htmlspecialchars($_GET['mensaje'], ENT_QUOTES, 'UTF-8'); ?>";
        if (m === "guardado") msg = "¡Anuncio publicado con éxito!";
        else if (m === "actualizado") msg = "¡Anuncio actualizado con éxito!";
        else if (m === "eliminado") msg = "¡Anuncio eliminado con éxito!";
        else if (m === "error_campos") msg = "Error: Por favor completa todos los campos obligatorios.";
        else if (m === "error_guardar") msg = "Error: No se pudo guardar el anuncio en la base de datos.";
        else if (m === "error_eliminar") msg = "Error: No se pudo eliminar el anuncio.";
        if (msg) mostrarNotificacion(msg);
    });
</script>
<?php endif; ?>

</body>
</html>
