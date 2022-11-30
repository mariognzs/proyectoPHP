<?php

    class Producto implements Model{
        
        private $id;
        private $nombre;
        private $descripcion;
        private $precio;
        private $stock;
        private $marca;
        private $categoria;
        
        private $idImagen;
        private $imagen;
        private $nombreImagen;
        private $tipo;
        private $tamaño;
        
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

        function getMarca() {
            return $this->marca;
        }

        function getCategoria() {
            return $this->categoria;
        }

        function getIdImagen() {
            return $this->idImagen;
        }

        function getImagen() {
            return $this->imagen;
        }

        function getNombreImagen() {
            return $this->nombreImagen;
        }

        function getTipo() {
            return $this->tipo;
        }

        function getTamaño() {
            return $this->tamaño;
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

        function setMarca($marca) {
            $this->marca = $marca;
        }
        
        function setCategoria($categoria) {
            $this->categoria = $categoria;
        }

        function setIdImagen($idImagen) {
            $this->idImagen = $idImagen;
         }

        function setImagen($imagen) {
            $this->imagen = $imagen;
         }

         function setNombreImagen($nombreImagen) {
            $this->nombreImagen = $nombreImagen;
         }

        function setTipo($tipo) {
            $this->tipo = $tipo;
         }

         function setTamaño($tamaño) {
            $this->tamaño = $tamaño;
         }

        // Me va a devolver todos los elementos
        public function findAll(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM productos;");
            return $findAll;
        }

        public function findCategotiasAll(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM productos INNER JOIN productos_categorias ON productos.id = productos_categorias.id_productos INNER JOIN categorias ON productos_categorias.id_categorias = categorias.idCategorias");
            return $findAll;
        }

        // Me devuelve el elemento filtrado por id
        public function findById(){
            $db = Database::conectar();
            return $db->query("SELECT * FROM productos WHERE id=$this->id")->fetch_object();
        }

        public function findCategotiasId(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM productos INNER JOIN productos_categorias ON productos.id = productos_categorias.id_productos INNER JOIN categorias ON productos_categorias.id_categorias = categorias.idCategorias INNER JOIN productos_imagenes ON productos.id = productos_imagenes.id_productos where productos.id = '$this->id';")->fetch_object();
            return $findAll;
        }

        // Insertar en la base de datos
        public function save(){
            $db = Database::conectar();
            //$save = $db->query("INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) VALUES ('$this->nombre','$this->descripcion', '$this->precio', '$this->stock', '$this->categoria')");
            $this->imagen = mysqli_escape_string($db,$this->imagen);
            $save3 = $db->query("INSERT INTO imagenes (nombreImagen,imagen,tipo,tamaño) VALUES ('$this->nombreImagen','$this->imagen','$this->tipo','$this->tamaño');");
            $idImagen = $db->insert_id;
            $save = $db->query("INSERT INTO productos (nombre, descripcion, precio, stock) VALUES ('$this->nombre','$this->descripcion', '$this->precio', '$this->stock')");
            $idProductos = $db->insert_id;
            $save2 = $db->query("INSERT INTO productos_categorias (id_productos, id_categorias) VALUES ('$idProductos','$this->categoria');");   
            $save4 = $db->query("INSERT INTO productos_imagenes (id_productos, id_imagenes) VALUES ('$idProductos','$idImagen');");   
            
            //$query = "INSERT INTO imagenes (nombre, imagen, tipo, tamaño) values ('".$nombreArchivo."','".$binariosImagen."','".$tipoArchivo."','".$tamanoArchivo."');";


        }

        // Actualizar en la base de datos filtrando por id
        public function update(){
            $db = Database::conectar();
            //$update = $db->query("UPDATE productos SET nombre='$this->nombre', descripcion='$this->descripcion', precio='$this->precio', stock='$this->stock', categoria_id='$this->categoria' WHERE id=$this->id");
            $update = $db->query("UPDATE productos SET nombre='$this->nombre', descripcion='$this->descripcion', precio='$this->precio', stock='$this->stock' WHERE id=$this->id");
            $update2 = $db->query("UPDATE productos_categorias SET id_categorias='$this->categoria' WHERE id_productos = '$this->id'");
            $update3 = $db->query("UPDATE productos_imagenes SET id_imagenes = '$this->idImagen' WHERE id_productos = '$this->id'");



        }

        // Actualizar en la base de datos filtrando por id
        public function updateByCantidad(){
            $db = Database::conectar();
            $update = $db->query("UPDATE productos SET stock=stock-'$this->stock' WHERE id=$this->id");
        }

        // Eliminar en la base de datos filtrando por id
        public function delete(){
            $db = Database::conectar();
            //$delete3 = $db->query("DELETE FROM imagen WHERE idImagenes =     $this->id");
            $delete = $db->query("DELETE FROM productos_categorias WHERE id_productos =$this->id");
            $delete = $db->query("DELETE FROM productos_imagenes WHERE id_productos =$this->id");

            $delete2 = $db->query("DELETE FROM productos WHERE id=$this->id");
        
        }


        
    }
?>