<?php

    class Producto implements Model{
        
        private $id;
        private $nombre;
        private $descripcion;
        private $precio;
        private $stock;
        private $categoria;
        
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
    
        function getDescripcion() {
            return $this->descripcion;
        }
    
        function getPrecio() {
            return $this->precio;
        }
    
        function getStock() {
            return $this->stock;
        }

        function getCategoria() {
            return $this->categoria;
        }
    
        function setId($id) {
            $this->id = $id;
        }
    
        function setNombre($nombre) {
            $this->nombre = $nombre;
        }
    
        function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }
    
        function setPrecio($precio) {
            $this->precio = $precio;
        }
    
        function setStock($stock) {
           $this->stock = $stock;
        }

        function setCategoria($categoria) {
            $this->categoria = $categoria;
         }

        // Me va a devolver todos los elementos
        public function findAll(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM productos;");
            return $findAll;
        }

        // Me devuelve el elemento filtrado por id
        public function findById(){
            $db = Database::conectar();
            return $db->query("SELECT * FROM productos WHERE id=$this->id")->fetch_object();
        }

        // Insertar en la base de datos
        public function save(){
            $db = Database::conectar();
            $save = $db->query("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) VALUES ('$this->nombre','$this->descripcion', '$this->precio', '$this->stock', '$this->categoria')");
        }

        // Actualizar en la base de datos filtrando por id
        public function update(){
            $db = Database::conectar();
            $update = $db->query("UPDATE productos SET nombre='$this->nombre', descripcion='$this->descripcion', precio='$this->precio', stock='$this->stock', categoria_id='$this->categoria' WHERE id=$this->id");
        }

        // Actualizar en la base de datos filtrando por id
        public function updateByCantidad(){
            $db = Database::conectar();
            $update = $db->query("UPDATE productos SET stock=stock-'$this->stock' WHERE id=$this->id");
        }

        // Eliminar en la base de datos filtrando por id
        public function delete(){
            $db = Database::conectar();
            $delete = $db->query("DELETE FROM productos WHERE id=$this->id");
        }
    }
?>