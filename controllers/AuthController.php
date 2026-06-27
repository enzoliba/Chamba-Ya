<?php
    require_once __DIR__ . '/../core/config/autoload.php';
    require_once __DIR__ . '/../core/config/config.php';
    require_once __DIR__ . '/../core/config/session.php';

    class AuthController{

        private $userModel;

        public function __construct(){
            $this->userModel = new UserModel();
        }

        public function registerFirst(){
            iniciarSesion();

            $email = $_POST['emailInput'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            if($this->userModel->emailExists($email)){
                header('Location: ' . BASE_URL . 'views/auth/login.php?reg_status=email_exists');
                exit();
            }

            if($password !== $confirmPassword){
                header('Location: ' . BASE_URL . 'views/auth/login.php?reg_status=mismatch');
                exit();
            }

            $_SESSION['registro_email'] = $email;
            $_SESSION['registro_password'] = $password;

            header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showFormDatos');
            exit();
        }

        public function showDatosForm(){
            iniciarSesion();

            if(!isset($_SESSION['registro_email']) || !isset($_SESSION['registro_password'])){
                header('Location: ' . BASE_URL . 'views/auth/login.php');
                exit();
            }

            $departamentos = $this->userModel->getDepartamentos();

            global $base_path;
            require_once __DIR__ . '/../views/auth/form_datos_user.php';
        }

        public function login(){
            iniciarSesion();

            $correo = $_POST['emailInput'] ?? '';
            $password = $_POST['passwordInput'] ?? '';

            $usuario = $this->userModel->getUserByEmail($correo);

            if(!$usuario){
                header('Location: ' . BASE_URL . 'views/auth/login.php?login_status=not_found');
                exit();
            }

            if(password_verify($password, $usuario['password'])){
                $_SESSION['nombres'] = $usuario['nombres'];
                $_SESSION['idUsuario'] = $usuario['idUsuario'];
                $_SESSION['emailUsuario'] = $usuario['correo'];
                header('Location: ' . BASE_URL . 'index.php');
                exit();
            } else {
                header('Location: ' . BASE_URL . 'views/auth/login.php?login_status=wrong_password');
                exit();
            }
        }

        public function completeRegister(){
            iniciarSesion();

            if(!isset($_SESSION['registro_email']) || !isset($_SESSION['registro_password'])){
                header('Location: ' . BASE_URL . 'views/auth/login.php');
                exit();
            }

            $correo = $_SESSION['registro_email'];
            $password = $_SESSION['registro_password'];

            $fotoPerfil = $_FILES['fotoPerfil'] ?? null;
            $descripcionPerfil = $_POST['descripcionPerfil'] ?? '';
            $nombres = $_POST['nombres'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $direccionDomicilio = $_POST['direccionDomicilio'] ?? '';
            $codigoPostal = $_POST['codigoPostal'] ?? '';
            $fechaRegistro = date('Y-m-d H:i:s');
            $estado = 'Activo';
            $idDistrito = $_POST['distrito'] ?? '';

            $nombreFoto = 'default.png';

            if(isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === 0){
                $extension = pathinfo($_FILES['fotoPerfil']['name'], PATHINFO_EXTENSION);
                $permitidos = ['jpg', 'jpeg', 'png'];

                if(!in_array(strtolower($extension), $permitidos)){
                    header('Location: AuthController.php?action=showFormDatos&reg_status=bad_format');
                    exit();
                }

                // Validación del archivo: tamaño máximo y tipo MIME real
                $maxBytes = 2 * 1024 * 1024; // 2 MB
                if($_FILES['fotoPerfil']['size'] > $maxBytes){
                    header('Location: AuthController.php?action=showFormDatos&reg_status=too_big');
                    exit();
                }
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeReal = finfo_file($finfo, $_FILES['fotoPerfil']['tmp_name']);
                finfo_close($finfo);
                $mimesPermitidos = ['image/jpeg', 'image/png'];
                if(!in_array($mimeReal, $mimesPermitidos)){
                    header('Location: AuthController.php?action=showFormDatos&reg_status=bad_format');
                    exit();
                }

                $nombreFoto = uniqid() . '.' . $extension;
                $rutaDestino = __DIR__ . '/../assets/uploads/img_perfiles/' . $nombreFoto;
                move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $rutaDestino);

                $resultado = $this->userModel->createUser(
                    $nombreFoto, $nombres, $apellidos, $descripcionPerfil,
                    $telefono, $correo, $password, $direccionDomicilio,
                    $codigoPostal, $fechaRegistro, $estado, $idDistrito
                );

                if($resultado){
                    $usuario = $this->userModel->getUserByEmail($correo);
                    $_SESSION['idUsuario'] = $usuario['idUsuario'];
                    $_SESSION['nombres'] = $usuario['nombres'];
                    $_SESSION['emailUsuario'] = $usuario['correo'];
                    unset($_SESSION['registro_email']);
                    unset($_SESSION['registro_password']);
                    header('Location: ' . BASE_URL . 'index.php');
                    exit();
                } else {
                    header('Location: AuthController.php?action=showFormDatos&reg_status=error');
                    exit();
                }
            }
        }

        public function showMisDatos(){
            iniciarSesion();
            if(!isset($_SESSION['idUsuario'])){
                header('Location: ' . BASE_URL . 'views/auth/login.php');
                exit();
            }

            $usuario = $this->userModel->getUserById($_SESSION['idUsuario']);

            $ubicacionText = 'No registrado';
            $loc = null;
            if(!empty($usuario['idDistrito'])){
                $loc = $this->userModel->getFullLocationByIdDistrito($usuario['idDistrito']);
                if($loc){
                    $ubicacionText = $loc['departamento'] . ' / ' . $loc['provincia'] . ' / ' . $loc['distrito'];
                }
            }

            $departamentos = $this->userModel->getDepartamentos();

            global $base_path;
            require_once __DIR__ . '/../views/user/mis_datos.php';
        }

        public function showSeguridad(){
            iniciarSesion();
            if(!isset($_SESSION['idUsuario'])){
                header('Location: ' . BASE_URL . 'views/auth/login.php');
                exit();
            }
            global $base_path;
            require_once __DIR__ . '/../views/user/seguridad.php';
        }

        public function showPreferencias(){
            iniciarSesion();
            if(!isset($_SESSION['idUsuario'])){
                header('Location: ' . BASE_URL . 'views/auth/login.php');
                exit();
            }
            global $base_path;
            require_once __DIR__ . '/../views/user/preferencias.php';
        }

        public function updateMisDatos(){
            iniciarSesion();
            if(!isset($_SESSION['idUsuario'])){
                die('No autorizado');
            }

            $idUsuario = $_SESSION['idUsuario'];
            $nombres = $_POST['nombres'] ?? '';
            $apellidos = $_POST['apellidos'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $direccionDomicilio = $_POST['direccionDomicilio'] ?? '';
            $codigoPostal = $_POST['codigoPostal'] ?? '';
            $idDistrito = !empty($_POST['distrito']) ? $_POST['distrito'] : null;
            
            $fotoPerfilData = null;
            if(isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] == UPLOAD_ERR_OK){
                $extension = strtolower(pathinfo($_FILES['fotoPerfil']['name'], PATHINFO_EXTENSION));
                $permitidos = ['jpg', 'jpeg', 'png', 'webp'];
                if(!in_array($extension, $permitidos)){
                    header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showMisDatos&status=error'); exit();
                }

                // Validación del archivo: tamaño máximo y tipo MIME real
                $maxBytes = 2 * 1024 * 1024; // 2 MB
                if($_FILES['fotoPerfil']['size'] > $maxBytes){
                    header('Location: AuthController.php?action=showMisDatos&status=error'); exit();
                }
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeReal = finfo_file($finfo, $_FILES['fotoPerfil']['tmp_name']);
                finfo_close($finfo);
                $mimesPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
                if(!in_array($mimeReal, $mimesPermitidos)){
                    header('Location: AuthController.php?action=showMisDatos&status=error'); exit();
                }

                $nombreFoto = uniqid('pfp_') . '.' . $extension;
                $rutaDestino = __DIR__ . '/../assets/uploads/img_perfiles/' . $nombreFoto;
                if(move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $rutaDestino)){
                    $fotoPerfilData = $nombreFoto;
                }
            }

            $success = $this->userModel->updateUserProfileData(
                $idUsuario, 
                $nombres, 
                $apellidos, 
                $correo, 
                $telefono, 
                $direccionDomicilio, 
                $codigoPostal,
                $idDistrito,
                $fotoPerfilData
            );

            if($success){
                $_SESSION['nombres'] = $nombres;
                $_SESSION['emailUsuario'] = $correo;
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showMisDatos&status=success');
            }else{
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showMisDatos&status=error');
            }
        }

        public function changePassword(){
            iniciarSesion();
            if(!isset($_SESSION['idUsuario'])){
                die('No autorizado');
            }

            $idUsuario = $_SESSION['idUsuario'];
            $currentPassword = $_POST['currentPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            if(empty($currentPassword) || empty($newPassword) || empty($confirmPassword)){
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showSeguridad&pass_status=empty'); exit();
            }
            if($newPassword !== $confirmPassword){
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showSeguridad&pass_status=mismatch'); exit();
            }
            if(strlen($newPassword) < 8){
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showSeguridad&pass_status=short'); exit();
            }

            $usuario = $this->userModel->getUserById($idUsuario);
            if(!$usuario || !password_verify($currentPassword, $usuario['password'])){
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showSeguridad&pass_status=wrong'); exit();
            }

            $success = $this->userModel->updatePassword($idUsuario, $newPassword);
            if($success){
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showSeguridad&pass_status=success');
            } else {
                header('Location: ' . BASE_URL . 'controllers/AuthController.php?action=showSeguridad&pass_status=error');
            }
        }
    }

    $controller = new AuthController();

    $action = $_GET['action'] ?? '';

    switch($action){
        case 'registerFirst':
            $controller->registerFirst();
            break;
        case 'showFormDatos':
            $controller->showDatosForm();
            break;
        case 'login':
            $controller->login();
            break;
        case 'completeRegister':
            $controller->completeRegister();
            break;
        case 'showMisDatos':
            $controller->showMisDatos();
            break;
        case 'showSeguridad':
            $controller->showSeguridad();
            break;
        case 'showPreferencias':
            $controller->showPreferencias();
            break;
        case 'updateMisDatos':
            $controller->updateMisDatos();
            break;
        case 'changePassword':
            $controller->changePassword();
            break;
        default:
            die('Acción no válida');
    }
?>