<style>
    :root {
    --fondo-principal: #F8F9FA;
    --fondo-lateral: #FFFFFF;
    --purpura-principal: #8B5CF6;
    --purpura-oscuro: #7C3AED;
    --texto-principal: #1F2937;
    --texto-secundario: #6B7280;
    --borde-color: #E5E7EB;
    --exito: #10B981;
    --advertencia: #F59E0B;
    --info: #3B82F6;
    --error: #EF4444;
    --sombra: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* --- ÁREA DINÁMICA --- */
main.contenido {
    margin-left: 260px;
    flex-grow: 1;
    padding: 40px;
}

.profile-content{
    background: white;
    border-radius: 8px;
    padding: 30px;
}

.vista-seccion {
    display: none; /* Oculto por defecto */
    animation: aparecer 0.4s ease-in-out;
}

.vista-seccion.activo { display: block; }

@keyframes aparecer {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* --- COMPONENTES --- */
.encabezado-seccion{
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    gap: 20px;
}

.encabezado-seccion h2{
    margin: 0;
    font-size: 1.8rem;
}

.boton-crear{
    background: var(--purpura-principal);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    cursor: pointer;
    transition: .3s;
    margin: 0; /* Quitar el auto */
    white-space: nowrap;
}

.boton-crear:hover{
    background: var(--purpura-oscuro);
}
/* Tarjetas Horizontales */
.tarjeta-horizontal {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
    box-shadow: var(--sombra);
    border: 1px solid var(--borde-color);
}

.imagen-tarjeta {
    width: 120px;
    height: 80px;
    background: #E5E7EB;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9CA3AF;
}

.cuerpo-tarjeta { flex-grow: 1; }
.cuerpo-tarjeta h3 { font-size: 1.1rem; margin-bottom: 5px; }
.cuerpo-tarjeta p { color: var(--texto-secundario); font-size: 0.9rem; }

.etiqueta-estado {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
}

.estado-Disponible { background: #D1FAE5; color: var(--exito); }
.estado-Cancelado { background: #FEE2E2; color: var(--error); }
.estado-EnProceso { background: #DBEAFE; color: var(--info); }
.estado-Finalizado { background: #E5E7EB; color: var(--texto-secundario); }
.estado-info { background: #DBEAFE; color: var(--info); }
.estado-Pendiente, .estado-pendiente { background: #FEF3C7; color: var(--advertencia); }
.estado-Aceptado, .estado-aceptado { background: #D1FAE5; color: var(--exito); }
.estado-Rechazado, .estado-rechazado { background: #FEE2E2; color: var(--error); }

.acciones-tarjeta { display: flex; gap: 10px; }
.boton-accion {
    background: none;
    border: 1px solid var(--borde-color);
    padding: 8px;
    border-radius: 6px;
    cursor: pointer;
    color: var(--texto-secundario);
    transition: all 0.2s;
}
.boton-accion:hover { border-color: var(--purpura-principal); color: var(--purpura-principal); }

/* --- VENTANAS MODALES --- */
.superposicion-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
}

.contenido-modal {
    background: white;
    width: 90%;
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;

    padding: 30px;
    border-radius: 15px;
    position: relative;
    box-shadow: var(--sombra);
}

.superposicion-modal.activo { 
    display: flex; 
}
.superposicion-modal.activo .contenido-modal { 
    transform: scale(1); 
}

.cerrar-modal { 
    position: absolute; 
    top: 15px; 
    right: 20px; 
    font-size: 1.5rem; 
    cursor: pointer; 
    color: var(--texto-secundario); 
}

.grupo-formulario { 
    margin-bottom: 15px; 
}
.grupo-formulario label { 
    display: block;
    margin-bottom: 5px; 
    font-weight: 600; 
    font-size: 0.9rem; }
.grupo-formulario input, .grupo-formulario textarea, .grupo-formulario select {
    width: 100%; 
    padding: 10px; 
    border: 1px solid var(--borde-color); 
    border-radius: 8px; 
    outline: none;
}

.grupo-formulario textarea{
    resize: none;
}
.grupo-formulario.error input { 
    border-color: var(--error); 
}

.form-eliminar { 
    display: inline; 
}

.contador-derecha { 
    float: right; 
}

.fila-formulario { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 15px; 
}

.boton-ancho-total { 
    width: 100%; 
    margin: 10px 0; 
}

/* Sistema de Etiquetas (Tags) */
.selector-etiquetas { 
    display: flex; 
    flex-wrap: wrap; 
    gap: 8px; 
    margin-top: 10px;
}
.opcion-etiqueta { 
    padding: 6px 12px; 
    border: 1px solid var(--borde-color); 
    border-radius: 20px; 
    font-size: 0.8rem; 
    cursor: pointer; 
    transition: 0.2s; 
}
.opcion-etiqueta:hover { 
    border-color: var(--purpura-principal); 
    color: var(--purpura-principal); 
}
.etiqueta-seleccionada { 
    background: var(--purpura-principal); 
    color: white; 
    padding: 4px 10px; 
    border-radius: 15px; 
    font-size: 0.8rem; 
    display: flex; 
    align-items: center;
    gap: 5px; 
}

/* Notificaciones (Toasts) */
#contenedor-notificaciones {
    position: fixed; 
    top: 20px; 
    right: 20px; 
    z-index: 2000; }
.notificacion {
    background: white; 
    border-left: 4px solid var(--exito); 
    padding: 15px 25px;
    border-radius: 8px; 
    box-shadow: var(--sombra); 
    margin-bottom: 10px;
    animation: deslizarDerecha 0.3s ease-out;
}
@keyframes deslizarDerecha { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    @media (max-width: 1024px) {
        aside.barra-lateral {
            width: 200px;
        }
        main.contenido {
            margin-left: 200px;
            padding: 25px 20px;
        }
        nav.navegacion-superior {
            gap: 15px;
        }
        nav.navegacion-superior a {
            font-size: 0.9rem;
        }
    }

    /* --- Móvil (≤ 768px) --- */
    @media (max-width: 768px) {

        /* HEADER: Simplificar, ocultar nav de escritorio */
        header.cabecera {
            padding: 0 15px;
            height: 60px;
            flex-wrap: wrap;
        }
        nav.navegacion-superior {
            display: none; /* El menú lateral reemplaza la nav en móvil */
        }
        .cabecera-derecha {
            gap: 10px;
        }
        .barra-busqueda input {
            width: 130px;
        }
        .perfil-usuario span {
            display: none; /* Solo mostrar avatar en móvil */
        }

        /* LAYOUT PRINCIPAL: Contenido ocupa todo el ancho */
        .contenedor-principal {
            flex-direction: column;
            margin-top: 60px;
            min-height: calc(100vh - 60px - 65px); /* espacio para nav inferior */
        }

        /* BARRA LATERAL: Se convierte en nav inferior fija */
        aside.barra-lateral {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 65px;
            padding: 0;
            border-right: none;
            border-top: 1px solid var(--borde-color);
            display: flex;
            flex-direction: row;
            align-items: center;
            overflow-x: auto;
            z-index: 90;
            background: white;
        }
        /* Ocultar secciones/encabezados del sidebar en móvil */
        .seccion-lateral {
            display: flex;
            flex-direction: row;
            margin: 0;
            align-items: center;
        }
        .seccion-lateral h4 {
            display: none;
        }
        .item-lateral {
            flex-direction: column;
            padding: 6px 14px;
            gap: 3px;
            font-size: 0.65rem;
            border-radius: 0;
            margin-bottom: 0;
            min-width: 70px;
            text-align: center;
            justify-content: center;
        }
        .item-lateral i {
            font-size: 1.1rem;
        }
        .item-lateral:hover, .item-lateral.activo {
            background: #F5F3FF;
        }

        /* CONTENIDO PRINCIPAL */
        main.contenido {
            margin-left: 0;
            padding: 20px 15px;
            padding-bottom: 80px; /* espacio para la nav inferior */
        }

        .encabezado-seccion{
            flex-direction: column;
            align-items: flex-start;
        }

        .boton-crear{
            width: 100%;
        }    

        /* TARJETAS HORIZONTALES → verticales en móvil */
        .tarjeta-horizontal {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            padding: 15px;
        }
        .imagen-tarjeta {
            width: 100%;
            height: 60px;
            border-radius: 6px;
        }
        .acciones-tarjeta {
            width: 100%;
            justify-content: flex-end;
        }

        /* BOTÓN CREAR */
        .boton-crear {
            width: 100%;
            text-align: center;
        }

        /* FORMULARIO: 2 columnas → 1 columna en móvil */
        .fila-formulario {
            grid-template-columns: 1fr;
            gap: 0;
        }

        /* MODAL: Ocupa casi toda la pantalla */
        .contenido-modal {
            width: 95%;
            max-width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 20px 15px;
        }

        /* NOTIFICACIONES: Posición ajustada */
        #contenedor-notificaciones {
            top: 70px;
            right: 10px;
            left: 10px;
        }
        .notificacion {
            padding: 12px 15px;
            font-size: 0.9rem;
        }
}
</style>