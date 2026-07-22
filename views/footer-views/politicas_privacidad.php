<?php
    $empresa = isset($empresa) ? $empresa : "CHAMBA YA";
    $anio = isset($anio) ? $anio : date("Y");

    require_once __DIR__ . '/../../assets/css/style_politicas_privacidad.php';
    require_once __DIR__ . '/../templates/head.php';
    require_once __DIR__ . '/../templates/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<body>

<section class="banner">
    <div class="banner-contenido">
        <h1>Políticas de Privacidad</h1>
        <p>
            En <?= htmlspecialchars($empresa) ?> nos comprometemos a proteger la privacidad,
            seguridad y confidencialidad de la información de todos nuestros usuarios.
        </p>
    </div>
</section>

<div class="contenedor">
    
    <aside class="sidebar">
        <h3>Contenido</h3>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item active" data-target="seccion-1"><a href="#seccion-1">1. Introducción</a></li>
            <li class="sidebar-nav-item" data-target="seccion-2"><a href="#seccion-2">2. Información Recopilada</a></li>
            <li class="sidebar-nav-item" data-target="seccion-3"><a href="#seccion-3">3. Uso de la Información</a></li>
            <li class="sidebar-nav-item" data-target="seccion-4"><a href="#seccion-4">4. Seguridad de los Datos</a></li>
            <li class="sidebar-nav-item" data-target="seccion-5"><a href="#seccion-5">5. Compartición de Datos</a></li>
            <li class="sidebar-nav-item" data-target="seccion-6"><a href="#seccion-6">6. Derechos de Usuarios</a></li>
            <li class="sidebar-nav-item" data-target="seccion-7"><a href="#seccion-7">7. Responsabilidad</a></li>
            <li class="sidebar-nav-item" data-target="seccion-8"><a href="#seccion-8">8. Cambios de Política</a></li>
            <li class="sidebar-nav-item" data-target="seccion-9"><a href="#seccion-9">9. Contacto</a></li>
        </ul>
    </aside>

    <main class="contenido-principal">
        
        <article id="seccion-1" class="card">
            <h2>1. Introducción</h2>
            <p>
                <?= htmlspecialchars($empresa) ?> es una plataforma diseñada para conectar personas que
                necesitan encontrar empleo rápidamente con personas o empresas
                que requieren trabajadores para distintas actividades.
            </p>
            <p>
                Al utilizar nuestros servicios, aceptas las condiciones
                establecidas en esta Política de Privacidad de manera plena e informada.
            </p>
        </article>

        <article id="seccion-2" class="card">
            <h2>2. Información recopilada</h2>
            <p>
                Podemos recopilar información proporcionada voluntariamente
                por nuestros usuarios al momento de registrarse o publicar
                una oferta laboral en la plataforma:
            </p>
            <ul>
                <li>Nombre y apellidos completos.</li>
                <li>Número telefónico activo.</li>
                <li>Dirección de correo electrónico.</li>
                <li>Información y antecedentes laborales.</li>
                <li>Ubicación aproximada del dispositivo.</li>
                <li>Datos generales de contacto comercial.</li>
            </ul>
        </article>

        <article id="seccion-3" class="card">
            <h2>3. Uso de la información</h2>
            <p>
                La información recopilada será utilizada para mejorar la
                experiencia de los usuarios dentro de la plataforma y proveer el servicio de manera eficiente:
            </p>
            <ul>
                <li>Facilitar el contacto directo entre empleadores y trabajadores.</li>
                <li>Publicar ofertas laborales de manera geolocalizada.</li>
                <li>Enviar notificaciones y avisos de empleo relevantes.</li>
                <li>Mejorar continuamente nuestros servicios y la interfaz.</li>
                <li>Garantizar la seguridad, integridad y confianza de la plataforma.</li>
                <li>Detectar y mitigar actividades sospechosas o conductas fraudulentas.</li>
            </ul>
        </article>

        <article id="seccion-4" class="card">
            <h2>4. Seguridad de los datos</h2>
            <p>
                En <?= htmlspecialchars($empresa) ?> implementamos medidas técnicas, administrativas y físicas
                destinadas a proteger la información de los usuarios contra accesos no autorizados,
                pérdidas accidentales o alteraciones no autorizadas.
            </p>
            <p>
                Aunque realizamos esfuerzos constantes para proteger los
                datos y usamos protocolos de comunicación encriptados, ningún sistema de transmisión o almacenamiento en internet puede garantizar una seguridad absoluta.
            </p>
        </article>

        <article id="seccion-5" class="card">
            <h2>5. Compartición de información</h2>
            <p>
                No vendemos, alquilamos ni compartimos información de identificación personal con terceros
                para fines comerciales independientes sin tu consentimiento explícito.
            </p>
            <p>
                Únicamente se compartirá información con otros usuarios cuando sea estrictamente necesario
                para facilitar la comunicación entre trabajadores y empleadores en el contexto laboral,
                o cuando exista una obligación o mandato legal emitido por autoridad competente.
            </p>
        </article>

        <article id="seccion-6" class="card">
            <h2>6. Derechos de los usuarios</h2>
            <p>
                Los usuarios gozan de derechos de acceso, actualización, rectificación y eliminación de sus datos personales. Para ejercerlos, pueden gestionarlo desde su perfil o contactar a soporte.
            </p>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Derecho</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Acceso</strong></td>
                            <td>Consultar la información personal almacenada en nuestros servidores.</td>
                        </tr>
                        <tr>
                            <td><strong>Corrección</strong></td>
                            <td>Solicitar la modificación o rectificación de información incorrecta o incompleta.</td>
                        </tr>
                        <tr>
                            <td><strong>Eliminación</strong></td>
                            <td>Solicitar el borrado de sus datos y la cancelación de su cuenta.</td>
                        </tr>
                        <tr>
                            <td><strong>Actualización</strong></td>
                            <td>Mantener los datos de contacto y laborales al día para mejores oportunidades.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </article>

    
        <article id="seccion-7" class="card">
            <h2>7. Responsabilidad del usuario</h2>
            <p>
                Los usuarios son responsables exclusivos de proporcionar información verídica, actualizada y exacta,
                así como de resguardar la confidencialidad de sus datos de acceso.
            </p>
            <p>
                <?= htmlspecialchars($empresa) ?> se reserva el derecho de suspender o dar de baja aquellas cuentas
                que presenten actividades sospechosas, fraudulentas o información flagrantemente falsa.
            </p>
        </article>

  
        <article id="seccion-8" class="card">
            <h2>8. Cambios en las políticas</h2>
            <p>
                Nos reservamos el derecho de actualizar o modificar estas políticas de privacidad en cualquier momento
                para adaptarnos a cambios tecnológicos, legislativos o mejoras sustanciales en el funcionamiento del servicio.
            </p>
            <p>
                Recomendamos revisar esta sección periódicamente para mantenerse al tanto de las actualizaciones.
            </p>
        </article>

   
        <article id="seccion-9" class="card">
            <h2>9. Contacto</h2>
            <p>
                Si tienes inquietudes, preguntas o sugerencias respecto a nuestras políticas de privacidad o el tratamiento de tus datos,
                puedes comunicarte con nuestro equipo técnico y de soporte legal mediante nuestros canales oficiales en la plataforma.
            </p>
        </article>

    </main>

</div>

<?php require_once __DIR__ . '/../templates/footer.php'?>
</body>
</html>
