<?php

    require_once __DIR__ . '/config/database.php';

    class UserModel{
        private $conn;

        public function __construct(){
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function createUser($fotoPerfil, $nombres, $apellidos, $descripcion, $correo, $password, $direccionDomicilio, $codigoPostal, $estado){
            $sql = "INSERT INTO users (fotoPerfil, nombres, apellidos, descripcion, correo, password, direccionDomicilio, codigoPostal, fechaRegistro, estado) VALUES (:fotoPerfil, :nombres, :apellidos, :descripcion, :correo, :password, :direccionDomicilio, :codigoPostal, :fechaRegistro, :estado)";
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $date = date('Y-m-d H:i:s');

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':fotoPerfil', $fotoPerfil);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':direccionDomicilio', $direccionDomicilio);
            $stmt->bindParam(':codigoPostal', $codigoPostal);
            $stmt->bindParam(':fechaRegistro', $date);
            $stmt->bindParam(':estado', $estado);

            return $stmt->execute();
        }

        public function getUserByEmail($correo){
            $sql = "SELECT * FROM users WHERE correo = :correo";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function updateUser($id, $fotoPerfil, $nombres, $apellidos, $descripcion, $direccionDomicilio, $codigoPostal, $estado){
            $sql = "UPDATE users SET fotoPerfil = :fotoPerfil, nombres = :nombres, apellidos = :apellidos, descripcion = :descripcion, direccionDomicilio = :direccionDomicilio, codigoPostal = :codigoPostal, estado = :estado WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fotoPerfil', $fotoPerfil);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellidos', $apellidos);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':direccionDomicilio', $direccionDomicilio);
            $stmt->bindParam(':codigoPostal', $codigoPostal);
            $stmt->bindParam(':estado', $estado);

            return $stmt->execute();

        }

        public function updatePassword($id, $newPassword){
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $password_hash);
            
            return $stmt->execute();
        }

        public function deleteUser($id){
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        //VALIDACIONES PARA REGISTRO

        public function emailExists($correo){
            $sql = "SELECT COUNT(*) FROM users WHERE correo = :correo";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            
            return $stmt->fetchColumn() > 0;
        }

        //LOGIN

        
    }
?>