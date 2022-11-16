<?php
    class IndexController{
        public function index(){
            echo $GLOBALS['twig']->render('index.twig');
        }

        // public function productos(){
        //     echo $GLOBALS['twig']->render('productos.twig');
        // }
    }
?>