<?php
    require 'config/Database.php';
    require 'Model.php';

    class User implements Model{
        private $id;
        private $nombre;
        private $apellidos;
        private $email;
        private $password;
        private $rol;
        
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

        function getRol() {
            return $this->rol;
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
           $this->password = $password;
        }

        function setRol($rol) {
            $this->rol = $rol;
         }

        //Detectar rol de usuario
        public function findIdRol(){
            $db = Database::conectar();
            //$findRol = $db->query("SELECT * FROM proyectophp.users INNER JOIN proyectophp.users_rol ON proyectophp.users.id = proyectophp.users_rol.user_id  where proyectophp.users.id = $this->id;");
            $findRol = $db->query("SELECT * FROM users INNER JOIN users_rol ON users.id = users_rol.user_id INNER JOIN rol ON users_rol.rol_id = rol.idRol where users.id = '$this->id';")->fetch_object();
            return $findRol;
        }

        public function findAllRol(){ //saca el rol del usuario
            $db = Database::conectar();
            echo $this->id;
            $findRol = $db->query("SELECT * FROM users INNER JOIN users_rol ON users.id = users_rol.user_id INNER JOIN rol ON users_rol.rol_id = rol.idRol;");
            return $findRol;
        }

        // Me va a devolver todos los elementos
        public function findAll(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM users INNER JOIN users_rol ON users.id = users_rol.user_id;");
            return $findAll;
        }

        // Me devuelve el elemento filtrado por id
        public function findById(){
            $db = Database::conectar();
            return $db->query("SELECT * FROM users WHERE id=$this->id")->fetch_object();
        }

        // Insertar en la base de datos
        public function save(){
            $db = Database::conectar();
            if($this->password != null){
                $save = $db->query("INSERT INTO users (nombre, apellidos, email, password) VALUES ('$this->nombre','$this->apellidos', '$this->email', '$this->password');");
                $save = $db->query("INSERT INTO users_rol (user_id, rol_id) VALUES ('$db->insert_id','2');");
            }
        }

        // Actualizar en la base de datos filtrando por id
        public function update(){
            $db = Database::conectar();
                if($this->password != null){
                    $update = $db->query("UPDATE users SET nombre='$this->nombre', apellidos='$this->apellidos', email='$this->email', password='$this->password' WHERE id='$this->id';");
                    $update2 = $db->query("UPDATE users_rol SET rol_id='$this->rol' WHERE user_id= '$this->id';");
                                         //UPDATE users_rol SET rol_id=     1       WHERE user_id=      2;
                }else{
                    $update = $db->query("UPDATE users SET nombre='$this->nombre', apellidos='$this->apellidos', email='$this->email'  WHERE id='$this->id';");
                    $update2 = $db->query("UPDATE users_rol SET rol_id='$this->rol' WHERE user_id= '$this->id';");
                }
            }
        

        // Eliminar en la base de datos filtrando por id
        public function delete(){
            $db = Database::conectar();
            $delete = $db->query("DELETE FROM users_rol WHERE user_id=$this->id");
            $delete2 = $db->query("DELETE FROM users WHERE id=$this->id");
        }

        /**
         * Funcion login realiza la comprobacion de los campos introducidos.
         * En caso correcto devuelve el usuario
         * En caso incorrecto devuelve false
         */
        public function login(){
            $db = Database::conectar();
            $sql = "SELECT * FROM users WHERE email = '$this->email'";
            
            /**
             * En $user tengo el usuario que contiene el email recogido en mi formulario
             */
            $user = $db->query($sql);
            // Si user existe y solamente tiene una coincidencia de email
            if($user && $user->num_rows == 1){
                /**
                 * El metodo fetch_object() me devuelve los valores
                 * recogidos de mi BD en un formato de objeto
                 */
                $user = $user->fetch_object();
               
                /**
                 * password_verify comprueba un string con otro encriptado.
                 * En este caso lo utilizo para comprobar mi password con el de BD
                 */
                $verify = password_verify($this->password, $user->password); //THIS HACE REFERENCIA A USER

                if($verify){
                    // El password coincide y debo realizar el login
                    if($this->isAdmin($user->id)){
                        // Distinguir si es administrador o cliente
                        $_SESSION['admin'] = true;
                    }
                    return $user;
                }else{
                    return false;
                }
            }
        }

        /**
         * Funcion que comprueba si el usuario que se esta logueando es administrador o cliente
         * Si es Admin, el id del rol es 1
         * Si es Cliente, el id del rol es 2
         */
        
        public static function isAdmin($id){
            $db = Database::conectar();
            $tipo = $db->query("SELECT rol_id FROM users_rol WHERE user_id=$id")->fetch_object();
            if($tipo->rol_id == 1){
                return true;
            }else{
                return false;
            }
        }

    }
?>