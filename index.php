<?php
    require_once 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
   

    include 'controllers/UsersController.php';

      if(isset($_GET['controller'])){
        $controller = ucfirst($_GET['controller']).'Controller';

        if(class_exists($controller)){
  
          $controller_object = new $controller();
          if(isset($_GET['action'])){

            $action = $_GET['action'];
            $controller_object->$action();

          }
        }else{
          /**
           * Error de que no en cuentra la clase o non existe.
           * ¿Como gestionamos esto?
           * ¿Codigo de error?
           * ¿Vista de error?
           */
        }
      }else{
        /**
         * Si no existe el parametro controller en la URL tengo que hacer algo.
         * Enviar un error
         * Redirigir a alguna vista.
         * 
         * ¿Numero de error que deberia enviar? ¿3XX? ¿4XX? 
         * 
         * ¿Enviar a un controlador por defecto?
         */
      }
?>
