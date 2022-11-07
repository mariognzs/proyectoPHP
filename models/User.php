<?php
    require 'config/Database.php';
    require 'Model.php';

    class User implements Model{
        private $id;
        private $nombre;
        private $apellidos;
        private $email;
        private $password;
        
        /**
         * Class constructor.
         */
        public function __construct() {
            
        }

        function getId() {
            return $this->id;
        }
    
        function getNombre() {
            return $this->nombre;
        }
    
        function getApellidos() {
            return $this->apellidos;
        }
    
        function getEmail() {
            return $this->email;
        }
    
        function getPassword() {
            return $this->password;
        }
    
        function setId($id) {
            $this->id = $id;
        }
    
        function setNombre($nombre) {
            $this->nombre = $nombre;
        }
    
        function setApellidos($apellidos) {
            $this->apellidos = $apellidos;
        }
    
        function setEmail($email) {
            $this->email = $email;
        }
    
        function setPassword($password) {
            $this->password = password_hash($password, PASSWORD_BCRYPT, ['cont' => 4]) ;
        }

        // Me va a devolver todos los elementos
        public function findAll(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM users;");
            return $findAll;
        }

        // Me devuelve el elemento filtrado por id
        public function findById(){
            $db = Database::conectar();
            return $db->query("SELECT * FROM users WHERE id=$this->id");
        }

        // Insertar en la base de datos
        public function save(){
            $db = Database::conectar();
            $save = $db->query("INSERT INTO users (nombre, apellidos, email, password) VALUES ('$this->nombre','$this->apellidos', '$this->email', '$this->password')");
        }

        // Actualizar en la base de datos filtrando por id
        public function update(){
            $db = Database::conectar();
            $update = $db->query("UPDATE users SET nombre='$this->nombre', apellidos='$this->apellidos', email='$this->email', password='$this->password'");
        }

        // Eliminar en la base de datos filtrando por id
        public function delete(){
            $db = Database::conectar();
            $delete = $db->query("DELETE FROM users WHERE id=$this->id");
        }
    }
?>