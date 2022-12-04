<?php

    class Pedido implements Model{
        
        private $id;
        private $usuario;
        private $fecha;
        private $unidades;
        private $precioPedido;
        
        /**
         * Class constructor.
         */
        public function __construct() {
            
        }

        function getId() {
            return $this->id;
        }
    
        function getUsuario() {
            return $this->usuario;
        }
    
        function getFecha() {
            return $this->fecha;
        }

        function getUnidades() {
            return $this->unidades;
        }

        function getPrecioPedido() {
            return $this->precioPedido;
        }
    
        function setId($id) {
            $this->id = $id;
        }
    
        function setUsuario($usuario) {
            $this->usuario = $usuario;
        }
    
        function setFecha($fecha) {
            $this->fecha = $fecha;
        }

        function setUnidades($unidades) {
            $this->unidades = $unidades;
        }

        function setPrecioPedido($precioPedido) {
            $this->precioPedido = $precioPedido;
        }

        // Me va a devolver todos los elementos
        public function findAll(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM pedidos;");
            return $findAll;
            
        }

        public function findProductAll(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM pedidos INNER JOIN pedidos_productos ON pedidos.idPedidos = pedidos_productos.pedido_id INNER JOIN productos ON pedidos_productos.producto_id = productos.id;");
            return $findAll;

        }


        public function findById(){
            $db = Database::conectar();
            $findAll = $db->query("SELECT * FROM pedidos INNER JOIN pedidos_productos ON pedidos.idPedidos = pedidos_productos.pedido_id INNER JOIN productos ON pedidos_productos.producto_id = productos.id WHERE pedidos_productos.pedido_id = '$this->id'; ")->fetch_object();
            return $findAll;
        }

        // Me devuelve el elemento filtrado por usuario
        public function findByUser(){

        }

        // Insertar en la base de datos
        public function save(){
            $db = Database::conectar();
            $save = $db->query("INSERT INTO pedidos (usuarios_id, fecha) VALUES ('$this->usuario', CURDATE());");
            $this->precioPedido = $this->precioPedido *$this->unidades;
            $save2 = $db->query("INSERT INTO pedidos_productos (pedido_id,producto_id, unidades,precioPedido) VALUES ('$db->insert_id', '$this->id','$this->unidades','$this->precioPedido');");


            return $db->insert_id;
        }

        // Actualizar en la base de datos filtrando por id
        public function update(){
        
        }

        // Eliminar en la base de datos filtrando por id
        public function delete(){
            $db = Database::conectar();
            $delete = $db->query("DELETE FROM pedidos_productos WHERE pedido_id ='$this->id';");
            $delete2 = $db->query("DELETE FROM pedidos WHERE idPedidos = '$this->id';");
        }
    }
?>