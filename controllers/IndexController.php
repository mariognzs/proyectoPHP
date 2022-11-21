<?php
    class IndexController{
        public static function index(){
            echo $GLOBALS['twig']->render('index.twig');
        }

        // public function productos(){
        //     echo $GLOBALS['twig']->render('productos.twig');
        // }
    }
?>