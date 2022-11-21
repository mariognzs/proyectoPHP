<?php 

    class ErrorController{
        /**
         * Funcion que redirige a la vista del error 404
         */
        public static function _404(){
            echo $GLOBALS['twig']->render('error/404.twig',
                [
                    'URL' => URL
                ]
            );
        }
        /**
         * Funcion que redirige a la vista del error 403
         */
        public static function _403(){
            echo $GLOBALS['twig']->render('error/403.twig',
                [
                    'URL' => URL
                ]
            );
        }
        /**
         * Funcion que redirige a la vista del error 500
         */
        public static function _500(){
            echo $GLOBALS['twig']->render('error/500.twig',
                [
                    'URL' => URL
                ]
            );
        }
    }

?>