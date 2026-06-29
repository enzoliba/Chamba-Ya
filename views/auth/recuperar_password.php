<?php
    require_once __DIR__ . '/../../core/config/config.php';
    require_once '../../assets/css/style.php';
    require_once '../../assets/css/styles.php';
    require_once '../../assets/css/style_lr.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Recuperar contraseña - Chamba Ya</title>
</head>

<body>
    <div class="container" style="min-height:100vh;display:flex;align-items:center;justify-content:center;">
        <div class="form_box" style="position:relative;width:100%;max-width:420px;padding:30px;">
            <form action="<?= BASE_URL ?>controllers/AuthController.php?action=recuperarPassword" method="POST">
                <h1>Recuperar contraseña</h1>

                <?php if(isset($_GET['rec_status'])): ?>
                    <?php
                        $recMsgs = [
                            'empty'     => 'Completa todos los campos.',
                            'mismatch'  => 'Las contraseñas no coinciden.',
                            'short'     => 'La contraseña debe tener al menos 8 caracteres.',
                            'not_match' => 'El correo y el teléfono no coinciden con ninguna cuenta.',
                            'error'     => 'No se pudo actualizar la contraseña.',
                        ];
                        $msg = $recMsgs[$_GET['rec_status']] ?? 'Ocurrió un error.';
                    ?>
                    <p class="form_msg form_msg_error" style="color:#dc2626;"><?= htmlspecialchars($msg) ?></p>
                <?php endif; ?>

                <p style="font-size:.9rem;color:#555;margin-bottom:10px;">
                    Para verificar tu identidad, ingresa el <strong>correo</strong> y el <strong>teléfono</strong> con los que te registraste.
                </p>

                <div class="input_box">
                    <input type="email" placeholder="Correo registrado" required name="emailInput">
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input_box">
                    <input type="text" placeholder="Teléfono registrado" required name="telefonoInput">
                    <i class='bx bxs-phone'></i>
                </div>
                <div class="input_box">
                    <input type="password" placeholder="Nueva contraseña" required name="newPassword" minlength="8">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input_box">
                    <input type="password" placeholder="Confirmar nueva contraseña" required name="confirmPassword" minlength="8">
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <button type="submit" class="btn_link">Actualizar contraseña</button>
                <p style="margin-top:14px;text-align:center;">
                    <a href="<?= BASE_URL ?>views/auth/login.php">Volver a iniciar sesión</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
