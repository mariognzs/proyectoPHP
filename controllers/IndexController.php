<?php
    class IndexController{
        public static function index(){
            echo $GLOBALS['twig']->render('index.twig');
        }

        // public static function shop(){
        //     echo $GLOBALS['twig']->render('shop.twig');
        // }

        public static function shop(){
            if(isset($_SESSION['identity'])){
                $producto = new Producto();
                echo $GLOBALS['twig']->render('shop.twig', 
                        [
                            'productos' => $producto->findAll(),
                            //'categorias' => $categoria->findAll(),
                            'identity' => $_SESSION['identity'],
                            'URL' => URL
                        ]
                    );
            }else{
                header('Location: '.URL.'?controller=index&action=index');
            }
        }

        // public function productos(){
        //     echo $GLOBALS['twig']->render('productos.twig');
        // }
    }
?>