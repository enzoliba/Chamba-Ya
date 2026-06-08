<?php
    require_once __DIR__ . '/../models/userModel.php';

    class UserController{

        private $userModel;

        public function __construct(){
            $this->userModel = new UserModel();
        }

        public function registerFirst(){
            session_start();

            $email = $_POST['emailInput'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            if($this->userModel->emailExists($email)){
                die('El correo ya está registrado');
            }

            if($password !== $confirmPassword){
                die('Las contraseñas no coinciden');
            }

            $_SESSION['registro_email'] = $email;
            $_SESSION['registro_password'] = password_hash($password, PASSWORD_DEFAULT); 

            header('Location: form_datos_user.php');
        }

        public function login(){
            session_start();

            $correo = $_POST['emailInput'] ?? '';
            $password = $_POST['passwordInput'] ?? '';
            $usuario = $this->userModel->getUserByEmail($correo);

            if(!$usuario){
                die('Usuario no registrado');
            }

            if(password_verify($password, $usuario['password'])){
                $_SESSION['idUsuario'] = $usuario['idUsuario'];
                $_SESSION['emailUsuario'] = $usuario['correo'];
                header('Location: ../index.php');
            } else {
                die('Contraseña incorrecta');
            }
        }

    }
?>