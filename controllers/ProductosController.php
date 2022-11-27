<?php 
    require_once 'models/Producto.php';
    require_once 'models/Categoria.php';

    class ProductosController{
       
        /**
         * 
         */
        public static function index(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $categoria = new Categoria();
                echo $GLOBALS["twig"]->render(
                    'productos/index.twig', 
                    [
                        'productos' => $producto->findAll(),
                        'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function create(){
            if(isset($_SESSION['identity'])){
                $categoria = new Categoria();
                echo $GLOBALS["twig"]->render(
                    'productos/create.twig',
                    [
                        'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function show(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $categoria = new Categoria();
                $producto->setId($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'productos/show.twig', 
                    [
                        'producto' => $producto->findById(),
                        'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function edit(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $categoria = new Categoria();
                $producto->setId($_GET['id']);
                echo $GLOBALS["twig"]->render(
                    'productos/edit.twig', 
                    [
                        'producto' => $producto->findById(),
                        'categorias' => $categoria->findAll(),
                        'identity' => $_SESSION['identity'],
                        'URL' => URL
                    ]
                );
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function save(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $producto->setNombre($_POST['nombre']);
                $producto->setDescripcion($_POST['descripcion']);
                $producto->setPrecio(str_replace(",",".",$_POST['precio']));
                $producto->setStock($_POST['stock']);
                $producto->setCategoria($_POST['categoria']);
                $producto->save();
                header('Location: '.URL.'?controller=productos&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }

        /**
         * 
         */
        public static function update(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $producto->setId($_POST['id']);
                $producto->setNombre($_POST['nombre']);
                $producto->setDescripcion($_POST['descripcion']);
                $producto->setPrecio(str_replace(",",".",$_POST['precio']));
                $producto->setStock($_POST['stock']);
                $producto->setCategoria($_POST['categoria']);
                $producto->update();
                header('Location: '.URL.'?controller=productos&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }
        /**
         * 
         */
        public static function delete(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                $producto->setId($_GET['id']);
                $producto->delete();
                header('Location: '.URL.'?controller=productos&action=index');
            }else{
                header('Location: '.URL.'?controller=auth&action=login');
            }
        }
    }
?>