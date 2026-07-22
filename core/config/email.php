<?php
// Envío de email simple.
// NOTA: XAMPP por defecto NO envía correos. Para que funcione de verdad hay que
// configurar un SMTP (sendmail.ini + php.ini, o usar PHPMailer con Gmail). Ver README.
if (!function_exists('enviarEmailNotificacion')) {
    function enviarEmailNotificacion($para, $asunto, $mensaje): bool {
        $headers  = "From: Chamba Ya <no-reply@chambaya.local>\r\n";
        $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
        try {
            return @mail($para, $asunto, $mensaje, $headers);
        } catch (\Throwable $e) {
            error_log("Error al enviar email: " . $e->getMessage());
            return false;
        }
    }
}
?>
